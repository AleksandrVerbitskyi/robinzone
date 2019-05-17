<?php
class ModelExtensionModuleUkrposhtaApi extends Model {
    public function getAreas() {
        $sql = "SELECT * FROM " . DB_PREFIX . "ukrposhta_areas ORDER BY `name` ASC;";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCities($area_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "ukrposhta_cities WHERE `area_id` = " . (int)$area_id . "  ORDER BY `name` ASC;";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getArea($area_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "ukrposhta_areas WHERE area_id = " . (int)$area_id;
        $query = $this->db->query($sql);
        return $query->row['name'] . ' обл.';
    }

    public function getCity($city_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "ukrposhta_cities WHERE city_id = " . (int)$city_id;
        $query = $this->db->query($sql);
        return $query->row['name'];
    }
}
