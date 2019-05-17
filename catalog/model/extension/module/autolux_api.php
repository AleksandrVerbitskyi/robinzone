<?php
class ModelExtensionModuleAutoLuxApi extends Model {
    public function getAreas() {
        $sql = "SELECT * FROM "  . DB_PREFIX . "autolux_api_areas a";
        $sql .= " LEFT JOIN " . DB_PREFIX . "autolux_api_areas_description d ON (a.area_id = d.area_id)";
        $sql .= " WHERE language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCities($area_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "autolux_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "autolux_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.area_id = " . (int)$area_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getWarehouses($city_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "autolux_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "autolux_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getArea($area_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "autolux_api_areas a";
        $sql .= " LEFT JOIN " . DB_PREFIX . "autolux_api_areas_description d ON (a.area_id = d.area_id)";
        $sql .= " WHERE a.area_id = " . (int)$area_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->row['name'];
    }

    public function getCity($city_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "autolux_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "autolux_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->row['name'];
    }

    public function getWarehouse($warehouse_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "autolux_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "autolux_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.warehouse_id = " . (int)$warehouse_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.name ASC";
        $query = $this->db->query($sql);
        return $query->row['name'];
    }
}
