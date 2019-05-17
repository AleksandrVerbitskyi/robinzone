<?php
class ModelExtensionModuleLatest extends Model {
    public function getOptions($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov 
        LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) 
        WHERE pov.product_id = '" . (int)$product_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ovd.option_id = 11 AND pov.quantity > 0 ORDER BY ovd.name ASC");
        return $query->rows;
    }
}
