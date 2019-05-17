<?php
class ModelExtensionModuleNovaposhtaApi extends Model {
    public function getAreas() {
        $sql = "SELECT * FROM " . DB_PREFIX . "novaposhta_api_areas";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCities($area_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "novaposhta_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.area_id = " . (int)$area_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.description ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getWarehouses($city_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "novaposhta_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.description ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getArea($area_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "novaposhta_api_areas WHERE area_id = " . (int)$area_id;
        $query = $this->db->query($sql);
        return $query->row['description'] . ' обл.';
    }

    public function getCity($city_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "novaposhta_api_cities c";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_cities_description d ON (c.city_id = d.city_id)";
        $sql .= " WHERE c.city_id = " . (int)$city_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.description ASC";
        $query = $this->db->query($sql);
        return $query->row['settlement_type'] . ' ' . $query->row['description'];
    }

    public function getWarehouse($warehouse_id) {
        $sql = "SELECT * FROM "  . DB_PREFIX . "novaposhta_api_warehouses w";
        $sql .= " LEFT JOIN " . DB_PREFIX . "novaposhta_api_warehouses_description d ON (w.warehouse_id = d.warehouse_id)";
        $sql .= " WHERE w.warehouse_id = " . (int)$warehouse_id . " AND language_id = " . $this->config->get('config_language_id');
        $sql .= " ORDER BY d.description ASC";
        $query = $this->db->query($sql);
        return $query->row['description'];
    }
}
