<?php
class ModelExtensionModuleIntimeApi extends Model {
    public function getAreas() {
        $sql = "SELECT * FROM "  . DB_PREFIX . "intime_api_areas a";
        $sql .= " LEFT JOIN " . DB_PREFIX . "intime_api_areas_description d ON (a.area_id = d.area_id)";
        $sql .= " WHERE language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCities($area_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "intime_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "intime_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.area_id = " . (int)$area_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getWarehouses($city_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "intime_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "intime_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getArea($area_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "intime_api_areas a";
        $sql .= " LEFT JOIN " . DB_PREFIX . "intime_api_areas_description d ON (a.area_id = d.area_id)";
        $sql .= " WHERE a.area_id = " . (int)$area_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->row['name'];
    }

    public function getCity($city_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "intime_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "intime_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $this->getCityType($query->row['type']) . ' ' . $query->row['name'];
    }

    public function getWarehouse($warehouse_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "intime_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "intime_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.warehouse_id = " . (int)$warehouse_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->row['name'] . ' (' . $query->row['address'] . ')';
    }

    private $types_ua = ['місто', 'місто', 'смт.', 'селище', 'село'];
    private $types_ru = ['город', 'город', 'смт.', 'поселок', 'село'];

    private function getCityType($id) {
        $query = $this->db->query("SELECT * FROM `oc_language` ORDER BY `sort_order`, `name`;");
        foreach ($query->rows as $language) {
            $languages[$language['language_id']] = $language['code'];
        }
        $current_lang_code = $languages[$this->config->get('config_language_id')];

        if ($current_lang_code == 'ua-uk') {
            return $this->types_ua[$id];
        } else if ($current_lang_code == 'ru-ru') {
            return $this->types_ru[$id];
        }
        return '';
    }
}
