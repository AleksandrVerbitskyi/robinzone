<?php

function synchronizeApi() {
    $db = new DatabaseAdapter('robinz01_db', 'robinz01.mysql.tools', 'robinz01_db', '66gydLCb');
    $db->install();

    $api_name = getApiName($db);
    $api_password = getApiPassword($db);
    if (empty($api_name) || empty($api_password)) {
        die("Error: You must fill API's name and password fields for synchronization!!!");
    }
    $access_token = authentication($api_name, $api_password);
    $data = getData($access_token);
    saveData($data, $db);

//    echo '<pre>';
//    print_r($data);
//    die($access_token);
//    echo '<pre>';
//    print_r($warehouses);
//    die($api_key);
    $db = null;
    die('Success');
}

function saveData($data, $db) {
    $db->clear('oc_autolux_api_cities');
    $db->clear('oc_autolux_api_cities_description');
    $db->clear('oc_autolux_api_warehouses');
    $db->clear('oc_autolux_api_warehouses_description');

    $languages = getLanguages($db);

    foreach ($data as $city) {
        saveCity($city, $db, $languages);
    }
}

function getAreaIdByKoatuu($koatuu, $db) {
    $koatuu = koatuuNormalization($koatuu);
    $sql = "SELECT * FROM `oc_autolux_api_areas` WHERE code = " . substr($koatuu, 0, 2);
    $city = $db->select($sql);
    return isset($city[0]['area_id']) ? $city[0]['area_id'] : 0;
}

function koatuuNormalization($koatuu) {
    $koatuu = (string)$koatuu;
    if (strlen($koatuu) < 10) {
        $koatuu = str_repeat('0', 10 - strlen($koatuu)) . $koatuu;
    }
    return $koatuu;
}

function saveCity($city, $db, $languages) {
    $sql = "INSERT INTO `oc_autolux_api_cities` SET";
    $sql .= " `area_id` = '" . getAreaIdByKoatuu($city['id'], $db) . "',";
    $sql .= " `code` = '" . $city['id'] . "';";
    $db->query($sql);

    $city_id = $db->getLastId();

    foreach ($languages as $language) {
        if ($language['code'] == 'ru-ru') {
            $name = $city['name_ru'];
        } else if ($language['code'] == 'ua-uk') {
            $name = $city['name_ua'];
        }
        $sql = "INSERT INTO `oc_autolux_api_cities_description` SET";
        $sql .= " `city_id` = '" . $city_id . "',";
        $sql .= " `language_id` = " . $language['language_id'] . ",";
        $sql .= " `name` = '" . addslashes($name) . "';";
        $db->query($sql);
    }

    if (isset($city['offices']) && !empty($city['offices'])) {
        foreach ($city['offices'] as $warehouse) {
            saveWarehouse($warehouse, $db, $languages, $city_id);
        }

    }
}

function saveWarehouse($warehouse, $db, $languages, $city_id) {
    $sql = "INSERT INTO `oc_autolux_api_warehouses` SET";
    $sql .= " `city_id` = '" . $city_id . "',";
    $sql .= " `code` = '" . $warehouse['id'] . "';";
    $db->query($sql);

    $warehouse_id = $db->getLastId();

    foreach ($languages as $language) {
        if ($language['code'] == 'ru-ru') {
            $address = $warehouse['address_ru'];
        } else if ($language['code'] == 'ua-uk') {
            $address = $warehouse['address_ua'];
        }
        $name = $warehouse['company_name'];
        $sql = "INSERT INTO `oc_autolux_api_warehouses_description` SET";
        $sql .= " `warehouse_id` = '" . $warehouse_id . "',";
        $sql .= " `language_id` = " . $language['language_id'] . ",";
        $sql .= " `name` = '" . addslashes($name) . "',";
        $sql .= " `address` = '" . addslashes($address) . "';";
        $db->query($sql);
    }
}

function getApiName($db) {
    $sql = "SELECT * FROM `oc_setting` WHERE `code` = 'autolux' AND `key` = 'autolux_api_name';";
    $api_name = $db->select($sql);
    return !isset($api_name[0]['value']) ? null : $api_name[0]['value'];
}

function getApiPassword($db) {
    $sql = "SELECT * FROM `oc_setting` WHERE `code` = 'autolux' AND `key` = 'autolux_api_password';";
    $api_password = $db->select($sql);
    return !isset($api_password[0]['value']) ? null : $api_password[0]['value'];
}

function getLanguages($db) {
    $sql = "SELECT * FROM `oc_language` ORDER BY `sort_order`, `name`;";
    $languages = $db->select($sql);
    return $languages;
}

function getData($access_token) {
    $action = 'office/offices_by_territorial_units';
    return sendCurlRequest($access_token, $action);
}

function saveAreas($db, $areas, $languages) {

    foreach ($areas as $area) {
        $sql = "INSERT INTO `oc_autolux_api_areas` SET";
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
            $sql = "INSERT INTO `oc_autolux_api_areas_description` SET";
            $sql .= " `area_id` = '" . $area['id'] . "',";
            $sql .= " `language_id` = " . $language['language_id'] . ",";
            $sql .= " `name` = '" . addslashes($name) . "',";
            $sql .= " `short_name` = '" . addslashes($short_name) . "';";
            $db->query($sql);
        }
    }
    $sql = "SELECT * FROM `oc_autolux_api_cities`;";
    $cities = $db->select($sql);
    return $cities;
}

function authentication($email, $password) {
    $request = 'email=' . $email . '&password=' . $password;
    return sendCurlRequest('', '', $request, true);
}

function sendCurlRequest($access_token = '', $action = '', $request = '', $authentication = false) {
    $result = [];
    $headers = array(
        "Content-type: application/x-www-form-urlencoded",
        'Content-Length: ' . strlen($request)
    );

    $ch = curl_init();

    if ($authentication) {
        $url = "http://api.autolux.ua/authentication/login";
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    } else {
        $url = "http://api.autolux.ua/$action/?access_token=$access_token";
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $result = json_decode($response, true);
        if ($authentication) {
            $result = $result['access_token'];
        }
//        echo '<pre>';
//        print_r($result);
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

    public function install() {
        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "autolux_api_areas`(";
        $query .= "`area_id` INT(11) NOT NULL,";
        $query .= "`code` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`area_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "autolux_api_areas_description`(";
        $query .= "`description_id` INT(11) NOT NULL,";
        $query .= "`area_id` INT(11) NOT NULL,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "autolux_api_cities`(";
        $query .= "`city_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`area_id` INT(11) NOT NULL,";
        $query .= "`code` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`city_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "autolux_api_cities_description`(";
        $query .= "`description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`city_id` INT(11) NOT NULL,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "autolux_api_warehouses`(";
        $query .= "`warehouse_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`city_id` INT(11) NOT NULL,";
        $query .= "`code` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`warehouse_id`, `city_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "autolux_api_warehouses_description`(";
        $query .= "`description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`warehouse_id` INT(11) NOT NULL,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`address` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
        $this->query($query);

        $ua_id = 0; $ru_id = 0;
        $languages = getLanguages($this);
        foreach ($languages as $language) {
            if ($language['code'] == 'ua-uk') {
                $ua_id = $language['language_id'];
            } else if ($language['code'] == 'ru-ru') {
                $ru_id = $language['language_id'];
            }
        }

        $this->fillAreasTable($ua_id, $ru_id);
    }

    public function fillAreasTable($ua_id, $ru_id) {
        $qty = $this->select("SELECT COUNT(area_id) as qty FROM `"  . DB_PREFIX . "autolux_api_areas`");
        if ((int)$qty[0]['qty'] > 0) return false;

        $query = "INSERT INTO `" . DB_PREFIX . "autolux_api_areas` VALUES";
        $query .= " (1,'01'),";
        $query .= " (2,'05'),";
        $query .= " (3,'07'),";
        $query .= " (4,'12'),";
        $query .= " (5,'14'),";
        $query .= " (6,'18'),";
        $query .= " (7,'21'),";
        $query .= " (8,'23'),";
        $query .= " (9,'26'),";
        $query .= " (10,'32'),";
        $query .= " (11,'35'),";
        $query .= " (12,'44'),";
        $query .= " (13,'46'),";
        $query .= " (14,'48'),";
        $query .= " (15,'51'),";
        $query .= " (16,'53'),";
        $query .= " (17,'56'),";
        $query .= " (18,'59'),";
        $query .= " (19,'61'),";
        $query .= " (20,'63'),";
        $query .= " (21,'65'),";
        $query .= " (22,'68'),";
        $query .= " (23,'71'),";
        $query .= " (24,'73'),";
        $query .= " (25,'74');";
        $this->query($query);

        $query = "INSERT INTO `" . DB_PREFIX . "autolux_api_areas_description` VALUES";
        $query .= " (1,1,$ua_id,'Автономна Республіка Крим'),";
        $query .= " (2,1,$ru_id,'Автономная Республика Крым'),";
        $query .= " (3,2,$ua_id,'Вінницька область'),";
        $query .= " (4,2,$ru_id,'Винницкая область'),";
        $query .= " (5,3,$ua_id,'Волинська область'),";
        $query .= " (6,3,$ru_id,'Волынская область'),";
        $query .= " (7,4,$ua_id,'Дніпропетровська область'),";
        $query .= " (8,4,$ru_id,'Днепропетровская область'),";

        $query .= " (9,5,$ua_id,'Донецька область'),";
        $query .= " (10,5,$ru_id,'Донецкая область'),";
        $query .= " (11,6,$ua_id,'Житомирська область'),";
        $query .= " (12,6,$ru_id,'Житомирская область'),";
        $query .= " (13,7,$ua_id,'Закарпатська область'),";
        $query .= " (14,7,$ru_id,'Закарпатская область'),";
        $query .= " (15,8,$ua_id,'Запорізька область'),";
        $query .= " (16,8,$ru_id,'Запорожская область'),";

        $query .= " (17,9,$ua_id,'Івано-Франківська область'),";
        $query .= " (18,9,$ru_id,'Ивано-Франковская область'),";
        $query .= " (19,10,$ua_id,'Київська область'),";
        $query .= " (20,10,$ru_id,'Киевская область'),";
        $query .= " (21,11,$ua_id,'Кіровоградська область'),";
        $query .= " (22,11,$ru_id,'Кировоградская область'),";
        $query .= " (23,12,$ua_id,'Луганська область'),";
        $query .= " (24,12,$ru_id,'Луганская область'),";

        $query .= " (25,13,$ua_id,'Львівська область'),";
        $query .= " (26,13,$ru_id,'Львовская область'),";
        $query .= " (27,14,$ua_id,'Миколаївська область'),";
        $query .= " (28,14,$ru_id,'Николаевская область'),";
        $query .= " (29,15,$ua_id,'Одеська область'),";
        $query .= " (30,15,$ru_id,'Одесская область'),";
        $query .= " (31,16,$ua_id,'Полтавська область'),";
        $query .= " (32,16,$ru_id,'Полтавская область'),";

        $query .= " (33,17,$ua_id,'Рівненська область'),";
        $query .= " (34,17,$ru_id,'Ровенская область'),";
        $query .= " (35,18,$ua_id,'Сумська область'),";
        $query .= " (36,18,$ru_id,'Сумская область'),";
        $query .= " (37,19,$ua_id,'Тернопільська область'),";
        $query .= " (38,19,$ru_id,'Тернопольская область'),";
        $query .= " (39,20,$ua_id,'Харківська область'),";
        $query .= " (40,20,$ru_id,'Харьковская область'),";

        $query .= " (41,21,$ua_id,'Херсонська область'),";
        $query .= " (42,21,$ru_id,'Херсонская область'),";
        $query .= " (43,22,$ua_id,'Хмельницька область'),";
        $query .= " (44,22,$ru_id,'Хмельницкая область'),";
        $query .= " (45,23,$ua_id,'Черкаська область'),";
        $query .= " (46,23,$ru_id,'Черкасская область'),";
        $query .= " (47,24,$ua_id,'Чернівецька область'),";
        $query .= " (48,24,$ru_id,'Черновицкая область'),";

        $query .= " (49,25,$ua_id,'Чернігівська область'),";
        $query .= " (50,25,$ru_id,'Черниговская область');";


        $this->query($query);
    }

    public function uninstall() {
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "autolux_api_areas`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "autolux_api_areas_description`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "autolux_api_cities`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "autolux_api_cities_description`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "autolux_api_warehouses`;");
        $this->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "autolux_api_warehouses_description`;");
    }
}