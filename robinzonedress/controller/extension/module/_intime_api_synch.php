<?php

function synchronizeApi() {
    ini_set('memory_limit', '512M');
    $db = new DatabaseAdapter('robinz01_db', 'robinz01.mysql.tools', 'robinz01_db', '66gydLCb');
    $db->install();
    $api_key = getApiKey($db);
    $languages = getLanguages($db);
    $areas = getAreas($api_key);
    saveAreas($db, $areas, $languages);
    $cities = getCities($api_key);
    saveCities($db, $cities, $languages);
    $warehouses = getWarehouses($api_key);
    saveWarehouses($db, $warehouses, $languages);
//    echo '<pre>';
//    print_r($warehouses);
//    die($api_key);
    $db = null;
    die('Success');
}

function getApiKey($db) {
    $sql = "SELECT * FROM `oc_setting` WHERE `code` = 'intime' AND `key` = 'intime_api_code';";
    $api_key = $db->select($sql);
    return $api_key[0]['value'];
}

function getLanguages($db) {
    $sql = "SELECT * FROM `oc_language` ORDER BY `sort_order`, `name`;";
    $languages = $db->select($sql);
    return $languages;
}

function getAreas($api_key) {
    $soap_request = 'get_area_filtered';
    $request = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dat="http://ws.wso2.org/dataservice">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <dat:' . $soap_request . '>
                            <dat:api_key>' . $api_key . '</dat:api_key>
                            <dat:id></dat:id>
                            <dat:country_id>215</dat:country_id>
                            <dat:area_name></dat:area_name>
                        </dat:' . $soap_request . '>
                    </soapenv:Body>
                </soapenv:Envelope>';
    return sendCurlRequest($request, $soap_request);
}

function saveAreas($db, $areas, $languages) {
    $db->clear('oc_intime_api_areas');
    $db->clear('oc_intime_api_areas_description');
    foreach ($areas as $area) {
        $sql = "INSERT INTO `oc_intime_api_areas` SET";
        $sql .= " `area_id` = '" . $area['id'] . "',";
        $sql .= " `country_id` = '" . $area['country_id'] . "',";
        $sql .= " `code` = '" . $area['area_code'] . "',";
        $sql .= " `status` = '" . $area['status'] . "';";
        $db->query($sql);

        foreach ($languages as $language) {
            if ($language['code'] == 'ru-ru') {
                $name = $area['area_name_ru'];
                $short_name = $area['short_area_name_ru'];
            } else if ($language['code'] == 'ua-uk') {
                $name = $area['area_name_ua'];
                $short_name = $area['short_area_name_ua'];
            }
            $sql = "INSERT INTO `oc_intime_api_areas_description` SET";
            $sql .= " `area_id` = '" . $area['id'] . "',";
            $sql .= " `language_id` = " . $language['language_id'] . ",";
            $sql .= " `name` = '" . addslashes($name) . "',";
            $sql .= " `short_name` = '" . addslashes($short_name) . "';";
            $db->query($sql);
        }
    }
    $sql = "SELECT * FROM `oc_intime_api_cities`;";
    $cities = $db->select($sql);
    return $cities;
}

function getCities($api_key) {
    $soap_request = 'get_locality_all';
    $request = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dat="http://ws.wso2.org/dataservice">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <dat:' . $soap_request . '>
                            <dat:api_key>' . $api_key . '</dat:api_key>
                            <dat:id></dat:id>
                            <dat:country_id>215</dat:country_id>
                            <dat:area_name></dat:area_name>
                        </dat:' . $soap_request . '>
                    </soapenv:Body>
                </soapenv:Envelope>';
    return sendCurlRequest($request, $soap_request);
}

function saveCities($db, $cities, $languages) {
    $db->clear('oc_intime_api_cities');
    $db->clear('oc_intime_api_cities_description');
    foreach ($cities as $city) {
        $sql = "INSERT INTO `oc_intime_api_cities` SET";
        $sql .= " `city_id` = '" . $city['Id'] . "',";
        $sql .= " `area_id` = '" . $city['Area_Id'] . "',";
        $sql .= " `code` = '" . $city['Locality_Code'] . "',";
        $sql .= " `type` = '" . $city['Locality_Type_Id'] . "',";
        $sql .= " `status` = '" . $city['Status'] . "';";
        $db->query($sql);

        foreach ($languages as $language) {
            if ($language['code'] == 'ru-ru') {
                $name = $city['Locality_Name_Ru'];
                $short_name = $city['Locality_Short_Name_Ru'];
            } else if ($language['code'] == 'ua-uk') {
                $name = $city['Locality_Name_Ua'];
                $short_name = $city['Locality_Short_Name_Ua'];
            }
            $sql = "INSERT INTO `oc_intime_api_cities_description` SET";
            $sql .= " `city_id` = '" . $city['Id'] . "',";
            $sql .= " `language_id` = " . $language['language_id'] . ",";
            $sql .= " `name` = '" . addslashes($name) . "',";
            $sql .= " `short_name` = '" . addslashes($short_name) . "';";
            $db->query($sql);
        }
    }
//    $sql = "SELECT * FROM `oc_intime_api_cities`;";
//    $cities = $db->select($sql);
//    return $cities;
}

function getAreaIdByRef($db, $ref) {
    $sql = "SELECT * FROM `oc_intime_api_areas` WHERE `ref` = '" . $ref . "';";
    $area = $db->select($sql);
    return $area[0]['area_id'];
}

function getWarehouses($api_key) {
    $soap_request = 'get_branch_filtered';
    $request = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dat="http://ws.wso2.org/dataservice">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <dat:' . $soap_request . '>
                            <dat:api_key>' . $api_key . '</dat:api_key>
                            <dat:id></dat:id>
                            <dat:country_id>215</dat:country_id>
                            <dat:area_id></dat:area_id>
                            <dat:district_id></dat:district_id>
                            <dat:locality_id></dat:locality_id>
                            <dat:branch_name></dat:branch_name>
                        </dat:' . $soap_request . '>
                    </soapenv:Body>
                </soapenv:Envelope>';
    return sendCurlRequest($request, $soap_request);
}

function saveWarehouses($db, $warehouses, $languages) {
    $db->clear('oc_intime_api_warehouses');
    $db->clear('oc_intime_api_warehouses_description');
    foreach ($warehouses as $warehouse) {
        $sql = "INSERT INTO `oc_intime_api_warehouses` SET";
        $sql .= " `warehouse_id` = '" . (int)$warehouse['id'] . "',";
        $sql .= " `city_id` = '" . (int)$warehouse['locality_id'] . "',";
        $sql .= " `type` = '" . $warehouse['branch_type_id'] . "',";
        $sql .= " `number` = '" . $warehouse['branch_number'] . "',";
        $sql .= " `status` = '" . $warehouse['status'] . "',";
        $sql .= " `longitude` = '" . $warehouse['latitude'] . "',";
        $sql .= " `latitude` = '" . $warehouse['longitude'] . "';";
        $db->query($sql);

        foreach ($languages as $language) {
            if ($language['code'] == 'ru-ru') {
                $name = $warehouse['branch_name_ru'];
                $short_name = $warehouse['branch_short_name_ru'];
                $address = $warehouse['address_ru'];
            } else if ($language['code'] == 'ua-uk') {
                $name = $warehouse['branch_name_ua'];
                $short_name = $warehouse['branch_short_name_ua'];
                $address = $warehouse['address_ua'];
            }
            $sql = "INSERT INTO `oc_intime_api_warehouses_description` SET";
            $sql .= " `warehouse_id` = '" . (int)$warehouse['id'] . "',";
            $sql .= " `language_id` = " . $language['language_id'] . ",";
            $sql .= " `address` = '" . addslashes($address) . "',";
            $sql .= " `name` = '" . addslashes($name) . "',";
            $sql .= " `short_name` = '" . addslashes($short_name) . "';";
            $db->query($sql);
        }
    }
}

function sendCurlRequest($request, $soap_request = '') {
    $result = [];
    $headers = array(
        "Content-type: text/xml",
        "SOAPAction: $soap_request",
    );
//    $url = "http://195.13.178.5/services/intime_api_3.0?wsdl";
    $url = "http://esb.intime.ua:8080/services/intime_api_3.0?wsdl";
//    $url = "https://esb.intime.ua:4443/services/intime_api_3.0?wsdl";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
//        header('Content-Type: application/xml');
//        echo $response;
        $xml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$2$3', $response);
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $responseArray = json_decode($json,true);
        if (!isset($responseArray['soapenvBody']['Entries_' . $soap_request])) {
            return [];
        }
        $result = $responseArray['soapenvBody']['Entries_' . $soap_request]['Entry_' . $soap_request];
        if (!isset($result[0]) && !empty($result)) {
            $new_result = [];
            $new_result[] = $result;
            $result = $new_result;
        }
//        echo '<pre>';
//        print_r($result);
    }
//    echo '<pre>';
//    print_r($response);
//    die();
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

    public function install() {
        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "intime_api_areas`(";
        $query .= "`area_id` INT(11) NOT NULL,";
        $query .= "`country_id` INT(11) NOT NULL,";
        $query .= "`code` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`area_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "intime_api_areas_description`(";
        $query .= "`description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`area_id` INT(11) NOT NULL,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`short_name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "intime_api_cities`(";
        $query .= "`city_id` INT(11) NOT NULL,";
        $query .= "`area_id` INT(11) NOT NULL,";
        $query .= "`code` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`area` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`type` TINYINT(1) NOT NULL,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`city_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "intime_api_cities_description`(";
        $query .= "`description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`city_id` INT(11) NOT NULL,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`short_name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "intime_api_warehouses`(";
        $query .= "`warehouse_id` INT(11) NOT NULL,";
        $query .= "`city_id` INT(11) NOT NULL,";
        $query .= "`number` VARCHAR(50) NOT NULL DEFAULT '',";
        $query .= "`longitude` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`latitude` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`type` TINYINT(1) NOT NULL,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`warehouse_id`, `city_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "intime_api_warehouses_description`(";
        $query .= "`description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`warehouse_id` INT(11) NOT NULL,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`short_name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`address` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);
    }

    public function uninstall() {
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "intime_api_areas`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "intime_api_areas_description`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "intime_api_cities`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "intime_api_cities_description`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "intime_api_warehouses`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "intime_api_warehouses_description`;");
    }
}