<?php
class ModelExtensionModuleUkrposhtaImport extends Model {
    public function install() {
        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "ukrposhta_areas`(";
        $query .= "`area_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`area_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "ukrposhta_cities`(";
        $query .= "`city_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`area_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`city_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

    }
    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "ukrposhta_areas`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "ukrposhta_cities`;");
    }

}