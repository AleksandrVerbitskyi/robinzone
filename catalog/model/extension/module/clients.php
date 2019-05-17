<?php
class ModelExtensionModuleClients extends Model {
    public function getAllSettings() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_settings";
        $sql .= " WHERE language_id = " . (int)$this->config->get('config_language_id') . ";";
        return $this->db->query($sql)->row;
    }
    public function getAllTextiles() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_textile ct";
        $sql .= " LEFT JOIN " . DB_PREFIX . "clients_textile_description description";
        $sql .= " ON (ct.textile_id = description.textile_id)";
        $sql .= " WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " AND ct.status = 1";
        $sql .= " ORDER BY sort_order ASC;";
        return $this->db->query($sql)->rows;
    }
    public function getAllSizes() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_sizes cs";
        $sql .= " LEFT JOIN " . DB_PREFIX . "clients_sizes_description description";
        $sql .= " ON (cs.size_id = description.size_id)";
        $sql .= " WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " AND cs.status = 1";
        $sql .= " ORDER BY sort_order ASC;";
        return $this->db->query($sql)->rows;
    }
    public function getCare() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_care cc";
        $sql .= " LEFT JOIN " . DB_PREFIX . "clients_care_description description";
        $sql .= " ON (cc.care_id = description.care_id)";
        $sql .= " WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " AND cc.status = 1 LIMIT 1;";
        return $this->db->query($sql)->rows;
    }
    public function getAllRecommendations() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_recommendations cr";
        $sql .= " LEFT JOIN " . DB_PREFIX . "clients_recommendation_description description";
        $sql .= " ON (cr.recommendation_id = description.recommendation_id)";
        $sql .= " WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " AND cr.status = 1";
        $sql .= " ORDER BY sort_order ASC;";
        return $this->db->query($sql)->rows;
    }
    public function getAllQualities() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_quality cq";
        $sql .= " LEFT JOIN " . DB_PREFIX . "clients_quality_description description";
        $sql .= " ON (cq.quality_id = description.quality_id)";
        $sql .= " WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " AND cq.status = 1";
        $sql .= " ORDER BY sort_order ASC;";
        return $this->db->query($sql)->rows;
    }
    public function getAllImages() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_images ci";
        $sql .= " LEFT JOIN " . DB_PREFIX . "clients_image_description description";
        $sql .= " ON (ci.image_id = description.image_id)";
        $sql .= " WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " AND ci.status = 1";
        $sql .= " ORDER BY sort_order ASC;";
        return $this->db->query($sql)->rows;
    }
}
