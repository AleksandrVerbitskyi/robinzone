<?php
class ModelExtensionModuleBannerPlus extends Model {
	public function addBanner($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "banner_plus SET 
		name = '" . $this->db->escape($data['name']) . "', 
		status = '" . (int)$data['status'] . "'");

		$banner_id = $this->db->getLastId();

		if (isset($data['banner_image'])) {
			foreach ($data['banner_image'] as $language_id => $value) {
				foreach ($value as $banner_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "banner_plus_image SET 
					banner_id = '" . (int)$banner_id . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" .  $this->db->escape($banner_image['title']) . "', 
					button_text = '" .  $this->db->escape($banner_image['button_text']) . "', 
					link = '" .  $this->db->escape($banner_image['link']) . "', 
					image = '" .  $this->db->escape($banner_image['image']) . "', 
					sort_order = '" .  (int)$banner_image['sort_order'] . "'");
				}
			}
		}

		return $banner_id;
	}

	public function editBanner($banner_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "banner_plus SET 
		name = '" . $this->db->escape($data['name']) . "', 
		status = '" . (int)$data['status'] . "' WHERE banner_id = '" . (int)$banner_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "banner_plus_image WHERE banner_id = '" . (int)$banner_id . "'");

		if (isset($data['banner_image'])) {
			foreach ($data['banner_image'] as $language_id => $value) {
				foreach ($value as $banner_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "banner_plus_image SET 
					banner_id = '" . (int)$banner_id . "', 
					language_id = '" . (int)$language_id . "', 
					title = '" .  $this->db->escape($banner_image['title']) . "', 
					button_text = '" .  $this->db->escape($banner_image['button_text']) . "', 
					link = '" .  $this->db->escape($banner_image['link']) . "', 
					image = '" .  $this->db->escape($banner_image['image']) . "', 
					sort_order = '" . (int)$banner_image['sort_order'] . "'");
				}
			}
		}
	}

	public function deleteBanner($banner_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "banner_plus WHERE banner_id = '" . (int)$banner_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "banner_plus_image WHERE banner_id = '" . (int)$banner_id . "'");
	}

	public function getBanner($banner_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "banner_plus WHERE banner_id = '" . (int)$banner_id . "'");

		return $query->row;
	}

	public function getBanners($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "banner_plus";

		$sort_data = array(
			'name',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getBannerImages($banner_id) {
		$banner_image_data = array();

		$banner_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_plus_image WHERE banner_id = '" . (int)$banner_id . "' ORDER BY sort_order ASC");

		foreach ($banner_image_query->rows as $banner_image) {
			$banner_image_data[$banner_image['language_id']][] = array(
				'title'       => $banner_image['title'],
                'button_text' => $banner_image['button_text'],
				'link'        => $banner_image['link'],
				'image'       => $banner_image['image'],
				'sort_order'  => $banner_image['sort_order']
			);
		}

		return $banner_image_data;
	}

	public function getTotalBanners() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "banner_plus");

		return $query->row['total'];
	}

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "banner_plus`(
	`banner_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`status` TINYINT(1) NOT NULL DEFAULT 0,
	`name` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`banner_id`)) DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "banner_plus_image`(
	`banner_image_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`banner_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`button_text` VARCHAR(255) NOT NULL DEFAULT '',
	`link` VARCHAR(255) NOT NULL DEFAULT '',
	`image` VARCHAR(255) NOT NULL DEFAULT '',
	`sort_order` INT(5) NOT NULL DEFAULT 0,
	PRIMARY KEY (`banner_image_id`)) DEFAULT CHARSET=utf8;");
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "banner_plus`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "banner_plus_image`;");
    }
}
