<?php
class ModelExtensionModuleRepresentatives extends Model {

    public function addCity($data) {
        $city_alias = $this->db->escape($data['alias']);
        $city_status = (int)$this->db->escape($data['status']);
        $city_sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "INSERT INTO " . DB_PREFIX . "representative_cities SET";
        $sql .= " alias = '" . $city_alias . "',";
        $sql .= " status = '" . $city_status . "',";
        $sql .= " sort_order = '" . $city_sort_order . "'";

        $this->db->query($sql);

        $city_id = $this->db->getLastId();

        if (isset($data['city_description'])) {
            foreach ($data['city_description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "representative_city_descriptions SET";
                $sql .= " city_id = '" . (int)$city_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " name = '" . $this->db->escape($value['name']) . "'";
                $this->db->query($sql);
            }
        }

        return $city_id;
    }

    public function editCity($city_id, $data) {
        $city_alias = $this->db->escape($data['alias']);
        $city_status = (int)$this->db->escape($data['status']);
        $city_sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "UPDATE " . DB_PREFIX . "representative_cities SET";
        $sql .= " alias = '" . $city_alias . "',";
        $sql .= " status = '" . $city_status . "',";
        $sql .= " sort_order = '" . $city_sort_order . "' WHERE city_id = '" . (int)$city_id . "'";

        $this->db->query($sql);

        if (isset($data['city_description'])) {
            foreach ($data['city_description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "representative_city_descriptions SET";
                $sql .= " name = '" . $this->db->escape($value['name']) . "'";
                $sql .= " WHERE language_id = '" . (int)$language_id . "' AND city_id = '" . (int)$city_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getCity($city_id) {
        $result = [];
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "representative_cities WHERE city_id = '" . (int)$city_id . "'");
        $result = $query->row;
        $result['description'] = $this->getCityDescription($city_id);
        return $result;
    }

    public function getCityName($city_id) {
        $result = [];
        $result['description'] = $this->getCityDescription($city_id, $this->config->get('config_language_id'));
        return $result['description'][$this->config->get('config_language_id')]['name'];
    }

    public function getCityDescription($city_id, $language_id = null) {
        $result = [];
        if (isset($language_id)) {
            $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "representative_city_descriptions 
            WHERE language_id = '" . (int)$language_id . "' AND city_id = '" . (int)$city_id . "'");
            $result[$query->row['language_id']]['name'] = $query->row['name'];
        } else {
            $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "representative_city_descriptions WHERE city_id = '" . (int)$city_id . "'");
            foreach ($query->rows as $index => $item) {
                $result[$item['language_id']]['name'] = $item['name'];
            }
        }
        return $result;
    }

    public function addRepresentative($data) {
        $city_id = $this->db->escape($data['representative']['city_id']);
        $lat = $this->db->escape($data['representative']['lat']);
        $lng = $this->db->escape($data['representative']['lng']);
        $sort_order = (int)$this->db->escape($data['representative']['sort_order']);
        $status = (int)$this->db->escape($data['representative']['status']);

        $sql = "INSERT INTO " . DB_PREFIX . "representatives SET";
        $sql .= " city_id = '" . $city_id . "',";
        $sql .= " lat = '" . $lat . "',";
        $sql .= " lng = '" . $lng . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "'";

        $this->db->query($sql);

        $representative_id = $this->db->getLastId();

        if (isset($data['representative']['description'])) {
            foreach ($data['representative']['description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "representative_descriptions SET";
                $sql .= " representative_id = '" . (int)$representative_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " name = '" . $this->db->escape($value['name']) . "',";
                $sql .= " address = '" . $this->db->escape($value['address']) . "'";
                $this->db->query($sql);
            }
        }

        return $representative_id;
    }

    public function editRepresentative($representative_id, $data) {
        $city_id = $this->db->escape($data['representative']['city_id']);
        $lat = $this->db->escape($data['representative']['lat']);
        $lng = $this->db->escape($data['representative']['lng']);
        $sort_order = (int)$this->db->escape($data['representative']['sort_order']);
        $status = (int)$this->db->escape($data['representative']['status']);

        $sql = "UPDATE " . DB_PREFIX . "representatives SET";
        $sql .= " city_id = '" . $city_id . "',";
        $sql .= " lat = '" . $lat . "',";
        $sql .= " lng = '" . $lng . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "' WHERE representative_id = '" . (int)$representative_id . "'";

        $this->db->query($sql);

        if (isset($data['representative']['description'])) {
            foreach ($data['representative']['description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "representative_descriptions SET";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " name = '" . $this->db->escape($value['name']) . "',";
                $sql .= " address = '" . $this->db->escape($value['address']) . "' WHERE language_id = '" . (int)$language_id . "' AND representative_id = '" . (int)$representative_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getRepresentative($representative_id) {
        $result = [];
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "representatives WHERE representative_id = '" . (int)$representative_id . "'");
        $result = $query->row;
        $result['description'] = $this->getRepresentativeDescription($representative_id);
        return $result;
    }

    public function getRepresentativeDescription($representative_id) {
        $result = [];
            $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "representative_descriptions WHERE representative_id = '" . (int)$representative_id . "'");
            foreach ($query->rows as $index => $item) {
                $result[$item['language_id']]['name'] = $item['name'];
                $result[$item['language_id']]['address'] = html_entity_decode($item['address']);
            }
        return $result;
    }

    public function deleteRepresentative($representative_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "representatives WHERE representative_id = '" . (int)$representative_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "representative_descriptions WHERE representative_id = '" . (int)$representative_id . "'");
    }

    public function deleteCity($city_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "representative_cities WHERE city_id = '" . (int)$city_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "representative_city_descriptions WHERE city_id = '" . (int)$city_id . "'");
        $representatives = $this->getAllRepresentatives($city_id);
        foreach ($representatives as $representative) {
            $this->deleteRepresentative($representative['representative_id']);
        }
    }

    public function getAllCities($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "representative_cities as rc LEFT JOIN " . DB_PREFIX . "representative_city_descriptions as description 
        ON (rc.city_id = description.city_id) WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sort_data = array(
            'name',
            'status'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
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

    public function getTotalCities($data = array()) {
        $sql = "SELECT COUNT(DISTINCT rc.city_id) as total FROM " . DB_PREFIX . "representative_cities as rc LEFT JOIN " . DB_PREFIX . "representative_city_descriptions as description 
        ON (rc.city_id = description.city_id) WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sort_data = array(
            'name',
            'status'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
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
        return $query->row['total'];
    }

    public function getAllRepresentatives($city_id, $data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "representatives as r 
        LEFT JOIN " . DB_PREFIX . "representative_descriptions as description 
        ON (r.representative_id = description.representative_id) 
        WHERE r.city_id = '" . (int)$city_id . "' 
        AND description.language_id = " . (int)$this->config->get('config_language_id');

        $sort_data = array(
            'name',
            'status'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
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

    public function getTotalRepresentatives($city_id, $data = array()) {
        $sql = "SELECT COUNT(DISTINCT r.representative_id) as total FROM " . DB_PREFIX . "representatives as r 
        LEFT JOIN " . DB_PREFIX . "representative_descriptions as description 
        ON (r.representative_id = description.representative_id) 
        WHERE r.city_id = '" . (int)$city_id . "' 
        AND description.language_id = " . (int)$this->config->get('config_language_id');

        $sort_data = array(
            'name',
            'status'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
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

        return $query->row['total'];
    }


    public function install() {
        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "representative_cities`(";
        $query .= "`city_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`alias` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`sort_order` INT(11) NOT NULL DEFAULT 0,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`city_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "representative_city_descriptions`(";
        $query .= "`city_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`city_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`city_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "representatives`(";
        $query .= "`representative_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`city_id` INT(11) NOT NULL,";
        $query .= "`lat` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`lng` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`sort_order` INT(11) NOT NULL DEFAULT 0,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`representative_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "representative_descriptions`(";
        $query .= "`representative_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`representative_id` INT(11) NOT NULL,";
        $query .= "`name` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`address` text DEFAULT '',";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`representative_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "representative_cities`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "representative_city_descriptions`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "representatives`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "representative_descriptions`;");
    }
}
