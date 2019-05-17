<?php
class ModelExtensionModuleClients extends Model {

                                                            /// Settings CRUD ///
    public function addSetting($data) {
        foreach ($data as $language_id => $value) {
            $sql = "INSERT INTO " . DB_PREFIX . "clients_settings SET";
            $sql .= " `language_id` = '" . (int)$language_id . "',";
            $sql .= " `meta_title` = '" . $this->db->escape($value['meta_title']) . "',";
            $sql .= " `meta_description` = '" . $this->db->escape($value['meta_description']) . "',";
            $sql .= " `meta_keywords` = '" . $this->db->escape($value['meta_keywords']) . "',";

            $sql .= " `textile_description` = '" . $this->db->escape($value['textile_description']) . "',";
            $sql .= " `sizes_description` = '" . $this->db->escape($value['sizes_description']) . "',";
            $sql .= " `recommendation_description` = '" . $this->db->escape($value['recommendation_description']) . "',";
            $sql .= " `quality_description` = '" . $this->db->escape($value['quality_description']) . "';";
            $this->db->query($sql);
        }
    }

    public function editSetting($data) {
        foreach ($data as $language_id => $value) {
            $sql = "UPDATE " . DB_PREFIX . "clients_settings SET";
            $sql .= " `meta_title` = '" . $this->db->escape($value['meta_title']) . "',";
            $sql .= " `meta_description` = '" . $this->db->escape($value['meta_description']) . "',";
            $sql .= " `meta_keywords` = '" . $this->db->escape($value['meta_keywords']) . "',";

            $sql .= " `textile_description` = '" . $this->db->escape($value['textile_description']) . "',";
            $sql .= " `sizes_description` = '" . $this->db->escape($value['sizes_description']) . "',";
            $sql .= " `recommendation_description` = '" . $this->db->escape($value['recommendation_description']) . "',";
            $sql .= " `quality_description` = '" . $this->db->escape($value['quality_description']) . "'";
            $sql .= " WHERE `language_id` = '" . (int)$language_id . "';";
            $this->db->query($sql);
        }
    }

    public function getSettings() {
        $result = [];

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "clients_settings");
        foreach ($query->rows as $index => $item) {
            $result[$item['language_id']]['meta_title'] = $item['meta_title'];
            $result[$item['language_id']]['meta_description'] = $item['meta_description'];
            $result[$item['language_id']]['meta_keywords'] = $item['meta_keywords'];
            $result[$item['language_id']]['textile_description']  = $item['textile_description'] == NULL ? '' : $item['textile_description'];
            $result[$item['language_id']]['sizes_description']  = $item['sizes_description'] == NULL ? '' : $item['sizes_description'];
            $result[$item['language_id']]['recommendation_description']  = $item['recommendation_description'] == NULL ? '' : $item['recommendation_description'];
            $result[$item['language_id']]['quality_description']  = $item['quality_description'] == NULL ? '' : $item['quality_description'];
        }

        return $result;
    }

                                                            /// Textile CRUD ///
    public function addTextile($data) {
        $image = $this->db->escape($data['image']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "INSERT INTO " . DB_PREFIX . "clients_textile SET";
        $sql .= " image = '" . $image . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "'";

        $this->db->query($sql);

        $textile_id = $this->db->getLastId();

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "clients_textile_description SET";
                $sql .= " textile_id = '" . (int)$textile_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " title = '" . $this->db->escape($value['title']) . "',";
                $sql .= " text = '" . $this->db->escape($value['text']) . "'";
                $this->db->query($sql);
            }
        }

        return $textile_id;
    }

    public function editTextile($textile_id, $data) {
        $image = $this->db->escape($data['image']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "UPDATE " . DB_PREFIX . "clients_textile SET";
        $sql .= " image = '" . $image . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "' WHERE textile_id = '" . (int)$textile_id . "'";

        $this->db->query($sql);

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "clients_textile_description SET";
                $sql .= " title = '" . $this->db->escape($value['title']) . "',";
                $sql .= " text = '" . $this->db->escape($value['text']) . "'";
                $sql .= " WHERE language_id = '" . (int)$language_id . "' AND textile_id = '" . (int)$textile_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getTextile($textile_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_textile WHERE textile_id = '" . (int)$textile_id . "'");
        $result = $query->row;
        $result['description'] = $this->getTextileDescription($textile_id);
        return $result;
    }

    public function getTextileDescription($textile_id) {
        $result = [];

        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_textile_description WHERE textile_id = '" . (int)$textile_id . "'");
        foreach ($query->rows as $index => $item) {
            $result[$item['language_id']]['title'] = $item['title'];
            $result[$item['language_id']]['text']  = $item['text'] == NULL ? '' : $item['text'];
        }

        return $result;
    }

    public function deleteTextile($textile_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_textile WHERE textile_id = '" . (int)$textile_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_textile_description WHERE textile_id = '" . (int)$textile_id . "'");
    }

    public function getAllTextiles() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_textile ORDER BY sort_order ASC";
        $query = $this->db->query($sql);
        $result = $query->rows;
        foreach ($result as $index => $textile) {
            $result[$index]['description'] = $this->getTextileDescription($textile['textile_id']);
        }
        return $result;
    }

                                                                /// Sizes table CRUD ///
    public function addSize($data) {
        $height = (int)$this->db->escape($data['height']);
        $chest = (int)$this->db->escape($data['chest']);
        $thigh = (int)$this->db->escape($data['thigh']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "INSERT INTO " . DB_PREFIX . "clients_sizes SET";
        $sql .= " height = '" . $height . "',";
        $sql .= " chest = '" . $chest . "',";
        $sql .= " thigh = '" . $thigh . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "'";

        $this->db->query($sql);

        $size_id = $this->db->getLastId();

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "clients_sizes_description SET";
                $sql .= " size_id = '" . (int)$size_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " age = '" . $this->db->escape($value['age']) . "'";
                $this->db->query($sql);
            }
        }

        return $size_id;
    }

    public function editSize($size_id, $data) {
        $height = (int)$this->db->escape($data['height']);
        $chest = (int)$this->db->escape($data['chest']);
        $thigh = (int)$this->db->escape($data['thigh']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "UPDATE " . DB_PREFIX . "clients_sizes SET";
        $sql .= " height = '" . $height . "',";
        $sql .= " chest = '" . $chest . "',";
        $sql .= " thigh = '" . $thigh . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "' WHERE size_id = '" . (int)$size_id . "'";

        $this->db->query($sql);

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "clients_sizes_description SET";
                $sql .= " age = '" . $this->db->escape($value['age']) . "'";
                $sql .= " WHERE language_id = '" . (int)$language_id . "' AND size_id = '" . (int)$size_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getSize($size_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_sizes WHERE size_id = '" . (int)$size_id . "'");
        $result = $query->row;
        $result['description'] = $this->getSizeDescription($size_id);
        return $result;
    }

    public function getSizeDescription($size_id) {
        $result = [];
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_sizes_description WHERE size_id = '" . (int)$size_id . "'");
        foreach ($query->rows as $index => $item) {
            $result[$item['language_id']]['age'] = $item['age'];
        }
        return $result;
    }

    public function deleteSize($size_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_sizes WHERE size_id = '" . (int)$size_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_sizes_description WHERE size_id = '" . (int)$size_id . "'");
    }

    public function getAllSizes() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_sizes ORDER BY sort_order ASC";
        $query = $this->db->query($sql);
        $result = $query->rows;
        foreach ($result as $index => $size) {
            $result[$index]['description'] = $this->getSizeDescription($size['size_id']);
        }
        return $result;
    }

                                                            /// Care and recommendations table CRUD ///
    public function addCare($data) {
        $status = (int)$this->db->escape($data['status']);

        $sql = "INSERT INTO " . DB_PREFIX . "clients_care SET";
        $sql .= " status = '" . $status . "'";

        $this->db->query($sql);

        $care_id = $this->db->getLastId();

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "clients_care_description SET";
                $sql .= " care_id = '" . (int)$care_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " text = '" . $this->db->escape($value['text']) . "'";
                $this->db->query($sql);
            }
        }

        return $care_id;
    }

    public function editCare($care_id, $data) {
        $status = (int)$this->db->escape($data['status']);

        $sql = "UPDATE " . DB_PREFIX . "clients_care SET";
        $sql .= " status = '" . $status . "'";
        $sql .= " WHERE care_id = '" . (int)$care_id . "'";

        $this->db->query($sql);

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "clients_care_description SET";
                $sql .= " text = '" . $this->db->escape($value['text']) . "'";
                $sql .= " WHERE language_id = '" . (int)$language_id . "' AND care_id = '" . (int)$care_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getCare($care_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_care WHERE care_id = '" . (int)$care_id . "'");
        $result = $query->row;
        $result['description'] = $this->getCareDescription($care_id);
        return $result;
    }

    public function getCareDescription($care_id) {
        $result = [];
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_care_description WHERE care_id = '" . (int)$care_id . "'");
        foreach ($query->rows as $index => $item) {
            $result[$item['language_id']]['text'] = $item['text'];
        }
        return $result;
    }

    public function getAllCares() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_care LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->rows[0];
        $result['description'] = $this->getCareDescription($result['care_id']);
        return $result;
    }

    public function addRecommendation($data) {
        $image = $this->db->escape($data['image']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "INSERT INTO " . DB_PREFIX . "clients_recommendations SET";
        $sql .= " image = '" . $image . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "'";

        $this->db->query($sql);

        $recommendation_id = $this->db->getLastId();

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "clients_recommendation_description SET";
                $sql .= " recommendation_id = '" . (int)$recommendation_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " title = '" . $this->db->escape($value['title']) . "',";
                $sql .= " description = '" . $this->db->escape($value['description']) . "'";
                $this->db->query($sql);
            }
        }

        return $recommendation_id;
    }

    public function editRecommendation($recommendation_id, $data) {
        $image = $this->db->escape($data['image']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "UPDATE " . DB_PREFIX . "clients_recommendations SET";
        $sql .= " image = '" . $image . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "' WHERE recommendation_id = '" . (int)$recommendation_id . "'";

        $this->db->query($sql);

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "clients_recommendation_description SET";
                $sql .= " title = '" . $this->db->escape($value['title']) . "',";
                $sql .= " description = '" . $this->db->escape($value['description']) . "'";
                $sql .= " WHERE language_id = '" . (int)$language_id . "' AND recommendation_id = '" . (int)$recommendation_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getRecommendation($recommendation_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_recommendations WHERE recommendation_id = '" . (int)$recommendation_id . "'");
        $result = $query->row;
        $result['description'] = $this->getRecommendationDescription($recommendation_id);
        return $result;
    }

    public function getRecommendationDescription($recommendation_id) {
        $result = [];
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_recommendation_description WHERE recommendation_id = '" . (int)$recommendation_id . "'");
        foreach ($query->rows as $index => $item) {
            $result[$item['language_id']]['title'] = $item['title'];
            $result[$item['language_id']]['description'] = $item['description'];
        }
        return $result;
    }

    public function deleteRecommendation($recommendation_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_recommendations WHERE recommendation_id = '" . (int)$recommendation_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_recommendation_description WHERE recommendation_id = '" . (int)$recommendation_id . "'");
    }

    public function getAllRecommendations() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_recommendations  ORDER BY sort_order ASC";
        $query = $this->db->query($sql);
        $result = $query->rows;
        foreach ($result as $index => $recommendation) {
            $result[$index]['description'] = $this->getRecommendationDescription($recommendation['recommendation_id']);
        }
        return $result;
    }

                                                /// Clients Quality and Image tables CRUD ///
    public function addQuality($data) {
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "INSERT INTO " . DB_PREFIX . "clients_quality SET";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "'";

        $this->db->query($sql);

        $quality_id = $this->db->getLastId();

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "clients_quality_description SET";
                $sql .= " quality_id = '" . (int)$quality_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " title = '" . $this->db->escape($value['title']) . "',";
                $sql .= " text = '" . $this->db->escape($value['text']) . "'";
                $this->db->query($sql);
            }
        }

        return $quality_id;
    }

    public function editQuality($quality_id, $data) {
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "UPDATE " . DB_PREFIX . "clients_quality SET";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "' WHERE quality_id = '" . (int)$quality_id . "'";

        $this->db->query($sql);

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "clients_quality_description SET";
                $sql .= " title = '" . $this->db->escape($value['title']) . "',";
                $sql .= " text = '" . $this->db->escape($value['text']) . "'";
                $sql .= " WHERE language_id = '" . (int)$language_id . "' AND quality_id = '" . (int)$quality_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getQuality($quality_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_quality WHERE quality_id = '" . (int)$quality_id . "'");
        $result = $query->row;
        $result['description'] = $this->getQualityDescription($quality_id);
        return $result;
    }

    public function getQualityDescription($quality_id) {
        $result = [];
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_quality_description WHERE quality_id = '" . (int)$quality_id . "'");
        foreach ($query->rows as $index => $item) {
            $result[$item['language_id']]['title'] = $item['title'];
            $result[$item['language_id']]['text'] = $item['text'];
        }
        return $result;
    }

    public function deleteQuality($quality_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_quality WHERE quality_id = '" . (int)$quality_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_quality_description WHERE quality_id = '" . (int)$quality_id . "'");
    }

    public function getAllQualities() {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_quality ORDER BY sort_order ASC";
        $query = $this->db->query($sql);
        $result = $query->rows;
        foreach ($result as $index => $quality) {
            $result[$index]['description'] = $this->getQualityDescription($quality['quality_id']);
        }
        return $result;
    }

    public function addImage($data) {
        $image = $this->db->escape($data['image']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "INSERT INTO " . DB_PREFIX . "clients_images SET";
        $sql .= " image = '" . $image . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "'";

        $this->db->query($sql);

        $image_id = $this->db->getLastId();

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "INSERT INTO " . DB_PREFIX . "clients_image_description SET";
                $sql .= " image_id = '" . (int)$image_id . "',";
                $sql .= " language_id = '" . (int)$language_id . "',";
                $sql .= " title = '" . $this->db->escape($value['title']) . "'";
                $this->db->query($sql);
            }
        }

        return $image_id;
    }

    public function editImage($image_id, $data) {
        $image = $this->db->escape($data['image']);
        $status = (int)$this->db->escape($data['status']);
        $sort_order = (int)$this->db->escape($data['sort_order']);

        $sql = "UPDATE " . DB_PREFIX . "clients_images SET";
        $sql .= " image = '" . $image . "',";
        $sql .= " status = '" . $status . "',";
        $sql .= " sort_order = '" . $sort_order . "' WHERE image_id = '" . (int)$image_id . "'";

        $this->db->query($sql);

        if (isset($data['description'])) {
            foreach ($data['description'] as $language_id => $value) {
                $sql = "UPDATE " . DB_PREFIX . "clients_image_description SET";
                $sql .= " title = '" . $this->db->escape($value['title']) . "'";
                $sql .= " WHERE language_id = '" . (int)$language_id . "' AND image_id = '" . (int)$image_id . "'";
                $this->db->query($sql);
            }
        }
    }

    public function getImage($image_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_images WHERE image_id = '" . (int)$image_id . "'");
        $result = $query->row;
        $result['description'] = $this->getImageDescription($image_id);
        return $result;
    }

    public function getImageDescription($image_id) {
        $result = [];
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clients_image_description WHERE image_id = '" . (int)$image_id . "'");
        foreach ($query->rows as $index => $item) {
            $result[$item['language_id']]['title'] = $item['title'];
        }
        return $result;
    }

    public function deleteImage($image_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_images WHERE image_id = '" . (int)$image_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "clients_image_description WHERE image_id = '" . (int)$image_id . "'");
    }

    public function getAllImages($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "clients_images ORDER BY sort_order ASC";
        $query = $this->db->query($sql);
        $result = $query->rows;
        foreach ($result as $index => $image) {
            $result[$index]['description'] = $this->getImageDescription($image['image_id']);
        }
        return $result;
    }

    public function install() {
        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_settings`(";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "`meta_title` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`meta_description` VARCHAR(165) NOT NULL DEFAULT '',";
        $query .= "`meta_keywords` VARCHAR(165) NOT NULL DEFAULT '',";

        $query .= "`textile_description` TEXT,";
        $query .= "`sizes_description` TEXT,";
        $query .= "`recommendation_description` TEXT,";
        $query .= "`quality_description` TEXT,";

        $query .= "PRIMARY KEY (`language_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_textile`(";
        $query .= "`textile_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`image` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`sort_order` INT(11) NOT NULL DEFAULT 0,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`textile_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_textile_description`(";
        $query .= "`textile_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`textile_id` INT(11) NOT NULL,";
        $query .= "`title` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`text` TEXT,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`textile_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_sizes`(";
        $query .= "`size_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`height`  VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`chest` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`thigh` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`sort_order` INT(11) NOT NULL DEFAULT 0,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`size_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_sizes_description`(";
        $query .= "`sizes_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`size_id` INT(11) NOT NULL,";
        $query .= "`age` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`sizes_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_care`(";
        $query .= "`care_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`care_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_care_description`(";
        $query .= "`care_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`care_id` INT(11) NOT NULL,";
        $query .= "`text` TEXT,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`care_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_recommendations`(";
        $query .= "`recommendation_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`image` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "`sort_order` INT(11) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`recommendation_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_recommendation_description`(";
        $query .= "`recommendation_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`recommendation_id` INT(11) NOT NULL,";
        $query .= "`title` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`description` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`recommendation_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_quality`(";
        $query .= "`quality_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "`sort_order` INT(11) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`quality_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_quality_description`(";
        $query .= "`quality_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`quality_id` INT(11) NOT NULL,";
        $query .= "`title` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`text` TEXT,";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`quality_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_images`(";
        $query .= "`image_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`image` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "`status` TINYINT(1) NOT NULL DEFAULT 0,";
        $query .= "`sort_order` INT(11) NOT NULL DEFAULT 0,";
        $query .= "PRIMARY KEY (`image_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "clients_image_description`(";
        $query .= "`image_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`image_id` INT(11) NOT NULL,";
        $query .= "`title` VARCHAR(150) NOT NULL DEFAULT '',";
        $query .= "`language_id` INT(11) NOT NULL,";
        $query .= "PRIMARY KEY (`image_description_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_textile`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_textile_description`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_sizes`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_sizes_description`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_care`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_care_description`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_recommendations`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_recommendation_description`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_quality`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_quality_description`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_images`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "clients_image_description`;");
    }
}
