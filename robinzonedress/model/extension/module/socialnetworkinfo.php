<?php
class ModelExtensionModuleSocialNetworkInfo extends Model {

    public function getSocialNetworks() {
        $sql = "SELECT * FROM " . DB_PREFIX . "social_network_info;";
        $result = [];
        foreach ($this->db->query($sql)->rows as $index => $item) {
            $result[$item['social_network_id']] = $item;
        }
        return $result;
    }

    public function saveSocialNetworks($social_networks) {
        foreach ($social_networks as $social_network_id => $social_network) {
            if ($this->itemExists($social_network_id)) {
                $result = $this->editItem($social_network, $social_network_id);
            } else {
                $result = $this->addItem($social_network);
            }
        }
    }

    private function addItem($item) {
        $sql = "INSERT INTO `" . DB_PREFIX . "social_network_info` SET 
        `status` = " . (int)$item['status'] . ",
        `sort` = " . (int)$item['sort'] . ",
        `url` = '" . $this->db->escape($item['url']) . "',
        `font` = '" . $this->db->escape($item['font']) . "',
	    `which_ico` = '" . $this->db->escape($item['which_ico']) . "',
        `image` = '" . $this->db->escape($item['image']) . "';";
        $result = $this->db->query($sql);
        return $result->num_rows;
    }
    private function editItem($item, $item_id) {
        $sql = "UPDATE `" . DB_PREFIX . "social_network_info` SET 
        `status` = " . (int)$item['status'] . ",
        `sort` = " . (int)$item['sort'] . ",
        `url` = '" . $this->db->escape($item['url']) . "',
        `font` = '" . $this->db->escape($item['font']) . "',
	    `which_ico` = '" . $this->db->escape($item['which_ico']) . "',
        `image` = '" . $this->db->escape($item['image']) . "' WHERE social_network_id = " . (int)$item_id . ";";
        $result = $this->db->query($sql);
        return $result->num_rows;
    }

    private function itemExists($item_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "social_network_info WHERE social_network_id = " . (int)$item_id . ";";
        $result = $this->db->query($sql)->row;
        if (count($result) >= 1) return true;
        return false;
    }

    public function deleteSocialNetwork($item_id) {
        $result = false;
        if ($this->itemExists($item_id)) {
            $result = $this->deleteItem($item_id);
        }
        return $result;
    }

    private function deleteItem($item_id) {
        $sql = "DELETE FROM `" . DB_PREFIX . "social_network_info` WHERE social_network_id = " . (int)$item_id . ";";
        $result = $this->db->query($sql);
        return $result->num_rows;
    }

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "social_network_info`(
	`social_network_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`status` TINYINT(1) NOT NULL DEFAULT 0,
	`sort` INT(11) NOT NULL DEFAULT 0,
	`url` VARCHAR(255) NOT NULL DEFAULT '',
	`font` VARCHAR(255) NOT NULL DEFAULT '',
	`which_ico` VARCHAR(10) NOT NULL DEFAULT 'image',
	`image` VARCHAR(255) NOT NULL DEFAULT 'placeholder.png',
	PRIMARY KEY (`social_network_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "social_network_info`;");
    }
}