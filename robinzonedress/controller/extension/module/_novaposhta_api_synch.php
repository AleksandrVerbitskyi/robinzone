<?php

function synchronizeApi() {
    $db = new DatabaseAdapter('robinz01_db', 'robinz01.mysql.tools', 'robinz01_db', '66gydLCb');
    $api_key = getApiKey($db);
    $languages = getLanguages($db);
    $areas = getAreas($api_key);
    saveAreas($db, $areas);
    $cities = getCities($api_key);
    $cities = saveCities($db, $cities, $languages);
    $db->clear('oc_novaposhta_api_warehouses');
    $db->clear('oc_novaposhta_api_warehouses_description');
    foreach ($cities as $city) {
        $warehouses = getWarehouses($api_key, $city['ref']);
        saveWarehouses($db, $warehouses, $city['city_id'], $languages);
    }
    $db = null;
    die('Success');
}

function getApiKey($db) {
    $sql = "SELECT * FROM `oc_setting` WHERE `code` = 'novaposhta' AND `key` = 'novaposhta_api_code';";
    $api_key = $db->select($sql);
    return $api_key[0]['value'];
}

function getLanguages($db) {
    $sql = "SELECT * FROM `oc_language` ORDER BY `sort_order`, `name`;";
    $languages = $db->select($sql);
    return $languages;
}

function getAreas($api_key) {
    $request = '{
        "apiKey": "' . $api_key . '",
        "modelName": "Address",
        "calledMethod": "getAreas",
        "methodProperties": {}
    }';
    return sendCurlRequest($request);
}

function saveAreas($db, $areas) {
    $db->clear('oc_novaposhta_api_areas');
    foreach ($areas as $area) {
        $sql = "INSERT INTO `oc_novaposhta_api_areas` SET";
        $sql .= " `ref` = '" . $area->Ref . "',";
        $sql .= " `description` = '" . $area->Description . "';";
        $db->query($sql);
    }
}

function getCities($api_key) {
    $request = '{
        "apiKey": "' . $api_key . '",
        "modelName": "Address",
        "calledMethod": "getCities",
        "methodProperties": {}
    }';
    return sendCurlRequest($request);
}

function saveCities($db, $cities, $languages) {
    $db->clear('oc_novaposhta_api_cities');
    $db->clear('oc_novaposhta_api_cities_description');
    foreach ($cities as $city) {
        $area_id = getAreaIdByRef($db, $city->Area);
        $sql = "INSERT INTO `oc_novaposhta_api_cities` SET";
        $sql .= " `area_id` = '" . $area_id . "',";
        $sql .= " `ref` = '" . $city->Ref . "',";
        $sql .= " `area` = '" . $city->Area . "';";
        $db->query($sql);

        $city_id = $db->getLastId();
        foreach ($languages as $language) {
            if ($language['code'] == 'ru-ru') {
                $description = $city->DescriptionRu;
                $settlement_type = $city->SettlementTypeDescriptionRu;
            } else {
                $description = $city->Description;
                $settlement_type = $city->SettlementTypeDescription;
            }
            $sql = "INSERT INTO `oc_novaposhta_api_cities_description` SET";
            $sql .= " `city_id` = '" . $city_id . "',";
            $sql .= " `language_id` = " . $language['language_id'] . ",";
            $sql .= " `description` = '" . addslashes($description) . "',";
            $sql .= " `settlement_type` = '" . addslashes($settlement_type) . "';";
            $db->query($sql);
        }
    }
    $sql = "SELECT * FROM `oc_novaposhta_api_cities`;";
    $cities = $db->select($sql);
    return $cities;
}

function getAreaIdByRef($db, $ref) {
    $sql = "SELECT * FROM `oc_novaposhta_api_areas` WHERE `ref` = '" . $ref . "';";
    $area = $db->select($sql);
    return $area[0]['area_id'];
}

function getWarehouses($api_key, $city_ref) {
    $request = '{
        "apiKey": "' . $api_key . '",
        "modelName": "AddressGeneral",
        "calledMethod": "getWarehouses",
        "methodProperties": {"CityRef": "' . $city_ref . '"}
    }';
    return sendCurlRequest($request);
}

function saveWarehouses($db, $warehouses, $city_id, $languages) {
    foreach ($warehouses as $warehouse) {
        $sql = "INSERT INTO `oc_novaposhta_api_warehouses` SET";
        $sql .= " `city_id` = '" . (int)$city_id . "',";
        $sql .= " `ref` = '" . $warehouse->Ref . "',";
        $sql .= " `site_key` = '" . $warehouse->SiteKey . "',";
        $sql .= " `city_ref` = '" . $warehouse->CityRef . "',";
        $sql .= " `number` = '" . $warehouse->Number . "',";
        $sql .= " `longitude` = '" . $warehouse->Longitude . "',";
        $sql .= " `latitude` = '" . $warehouse->Latitude . "';";
        $db->query($sql);

        $warehouse_id = $db->getLastId();
        foreach ($languages as $language) {
            if ($language['code'] == 'ru-ru') {
                $description = $warehouse->DescriptionRu;
            } else {
                $description = $warehouse->Description;
            }
            $sql = "INSERT INTO `oc_novaposhta_api_warehouses_description` SET";
            $sql .= " `warehouse_id` = '" . $warehouse_id . "',";
            $sql .= " `language_id` = " . $language['language_id'] . ",";
            $sql .= " `description` = '" . addslashes($description) . "',";
            $sql .= " `warehouse_type` = '" . $warehouse->TypeOfWarehouse . "';";
            $db->query($sql);
        }
    }
}

function sendCurlRequest($request) {
    $result = ['error'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
        CURLOPT_RETURNTRANSFER => True,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => array("content-type: application/json",),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $result = json_decode($response);
        $result = (array)$result;
        $result = $result['data'];
    }
    return $result;
}

class DatabaseAdapter
{
    private $connection;
    private static $dbName;
    private static $host;
    private static $username;
    private static $password;

    public function __construct($dbName, $host, $username, $password)
    {
        self::$dbName = $dbName;
        self::$host = $host;
        self::$username = $username;
        self::$password = $password;

        $this->connection = new \PDO("mysql:dbname=$dbName;host=$host", $username, $password,
            array(\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'));
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function clear($table) {
        $query = $this->connection->prepare("DELETE FROM " . $table . ";");
        $query->execute();
        $query = $this->connection->prepare("ALTER TABLE " . $table . " AUTO_INCREMENT = 1;");
        $query->execute();
    }

    public function select($sql) {
        $query = $this->connection->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function query($sql) {
        $query = $this->connection->prepare($sql);
        $query->execute();
        if ($query->rowCount()){
            return true;
        } else{
            return false;
        }
    }

    public function getLastId() {
        return $this->connection->lastInsertId();
    }
}