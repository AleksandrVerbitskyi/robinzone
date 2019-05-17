<?php
class ModelExtensionModuleNovaposhtaApi extends Model {

    public function getAllAreas($data) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "novaposhta_api_areas";
        $this->sortAndPagination($sql, $data);
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalAreas() {
        $sql = "SELECT COUNT(area_id) as total FROM "  . DB_PREFIX . "novaposhta_api_areas";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getAreaName($area_id) {
        $sql = "SELECT description FROM "  . DB_PREFIX . "novaposhta_api_areas WHERE area_id = " . (int)$area_id;
        $query = $this->db->query($sql);
        return $query->row['description'];
    }

    public function getAreaIdByCity($city_id) {
        $sql = "SELECT area_id FROM "  . DB_PREFIX . "novaposhta_api_cities WHERE city_id = " . (int)$city_id;
        $query = $this->db->query($sql);
        return $query->row['area_id'];
    }

    public function getCityName($city_id) {
        $sql = "SELECT d.description as city_name FROM "  . DB_PREFIX . "novaposhta_api_cities c";
        $sql .= " LEFT JOIN "  . DB_PREFIX . "novaposhta_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= "  WHERE c.city_id  = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $query = $this->db->query($sql);
        return $query->row['city_name'];
    }

    public function getAllCities($data, $area_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "novaposhta_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.area_id = " . (int)$area_id . " AND language_id = " . $this->config->get('config_language_id');
        $this->sortAndPagination($sql, $data);
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalCities($area_id) {
        $sql = "SELECT COUNT(c.city_id) as total FROM "  . DB_PREFIX . "novaposhta_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.area_id = " . (int)$area_id . " AND language_id = " . $this->config->get('config_language_id');
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getAllWarehouses($data, $city_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "novaposhta_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $this->sortAndPagination($sql, $data);
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalWarehouses($city_id) {
        $sql = "SELECT COUNT(w.warehouse_id) as total FROM "  . DB_PREFIX . "novaposhta_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function sortAndPagination(&$sql, $data, $field = 'description') {
        $sort_data = array($field);
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY $field";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
    }

public function install() {
    $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "novaposhta_api_areas`(";
    $query .= "`area_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $query .= "`ref` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`description` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "PRIMARY KEY (`area_id`)) DEFAULT CHARSET=utf8;";
    $this->db->query($query);

    $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "novaposhta_api_cities`(";
    $query .= "`city_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $query .= "`area_id` INT(11) NOT NULL,";
    $query .= "`ref` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`area` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "PRIMARY KEY (`city_id`)) DEFAULT CHARSET=utf8;";
    $this->db->query($query);

    $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "novaposhta_api_cities_description`(";
    $query .= "`description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $query .= "`city_id` INT(11) NOT NULL,";
    $query .= "`language_id` INT(11) NOT NULL,";
    $query .= "`description` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`settlement_type` VARCHAR(100) NOT NULL DEFAULT '',";
    $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
    $this->db->query($query);

    $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "novaposhta_api_warehouses`(";
    $query .= "`warehouse_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $query .= "`city_id` INT(11) NOT NULL,";
    $query .= "`ref` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`site_key` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`city_ref` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`number` VARCHAR(50) NOT NULL DEFAULT '',";
    $query .= "`longitude` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`latitude` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "PRIMARY KEY (`warehouse_id`)) DEFAULT CHARSET=utf8;";
    $this->db->query($query);

    $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "novaposhta_api_warehouses_description`(";
    $query .= "`description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
    $query .= "`warehouse_id` INT(11) NOT NULL,";
    $query .= "`language_id` INT(11) NOT NULL,";
    $query .= "`description` VARCHAR(255) NOT NULL DEFAULT '',";
    $query .= "`warehouse_type` VARCHAR(100) NOT NULL DEFAULT '',";
    $query .= "PRIMARY KEY (`description_id`)) DEFAULT CHARSET=utf8;";
    $this->db->query($query);
}
    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "novaposhta_api_areas`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "novaposhta_api_cities`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "novaposhta_api_cities_description`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "novaposhta_api_warehouses`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "novaposhta_api_warehouses_description`;");
    }

}