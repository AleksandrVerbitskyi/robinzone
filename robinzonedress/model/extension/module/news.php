<?php
class ModelExtensionModuleNews extends Model {
    private $ru_id = '';

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->ru_id = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE code = '" . $this->db->escape('ru-ru') . "'")->row['language_id'];
    }

    public function addNews($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "news SET 
		thumb = '" . $this->db->escape($data['thumb']) . "',
		image = '" . $this->db->escape($data['image']) . "', 
		keyword = '" . $this->db->escape($data['keyword']) . "', 
		published = '" . strtotime($this->db->escape($data['published'])) . "', 
		published_by = '" . strtotime($this->db->escape($data['published_by'])) . "', 
		last_edited = '0000/00/00', 
		last_edited_by = '', 
		sort_order = '" . (int)$data['sort_order'] . "',
		status = '" . (int)$data['status'] . "'
		");

        $news_id = $this->db->getLastId();

        $ru_id = $this->ru_id;
        if (isset($data['news_description'])) {
            $title = $data['news_description'][$ru_id]['title'];
        } else {
            $title = '';
        }
        $keyword = $this->seo_urls_generating('add', ['query' => 'news_id=' . $news_id, 'keyword' => $data['keyword'], 'title' => $title]);
        if ($keyword !== $this->db->escape($data['keyword'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "news SET keyword = '" . $this->db->escape($keyword) . "' WHERE news_id = " . (int)$news_id);
        }


        if (isset($data['news_description'])) {
            foreach ($data['news_description'] as $language_id => $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "news_descriptions SET 
                news_id = '" . (int)$news_id . "', 
                language_id = '" . (int)$language_id . "', 
                title = '" .  $this->db->escape($value['title']) . "', 
                image_title = '" .  $this->db->escape($value['image_title']) . "', 
                meta_title = '" .  $this->db->escape($value['meta_title']) . "', 
                meta_description = '" .  $this->db->escape($value['meta_description']) . "', 
                meta_keyword = '" .  $this->db->escape($value['meta_keyword']) . "'
                ");
            }
        }

        if (isset($data['news_texts'])) {
            foreach ($data['news_texts'] as $row => $text) {
                foreach ($text['text'] as $language_id => $value) {
                    if (!isset($text['sort_order'])) {
                        $text['sort_order'] = '0';
                    }
                    $this->db->query("INSERT INTO " . DB_PREFIX . "news_texts SET 
                    news_id = '" . (int)$news_id . "', 
                    text_group_id = '" . $text['text_group_id'] . "',
                    language_id = '" . (int)$language_id . "', 
                    text = '" .  $this->db->escape($value) . "', 
                    sort_order = '" .  (int)$text['sort_order'] . "'
                    ");
                }
            }
        }

        if (isset($data['news_images'])) {
            foreach ($data['news_images'] as $index => $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "news_images SET 
                news_id = '" . (int)$news_id . "', 
                image = '" .  $this->db->escape($image['image']) . "', 
                sort_order = '" .  (int)$image['sort_order'] . "'
                ");
            }
        }

        return $news_id;
    }

    public function editNews($news_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "news SET 
		thumb = '" . $this->db->escape($data['thumb']) . "',
		image = '" . $this->db->escape($data['image']) . "', 
		keyword = '" . $this->db->escape($data['keyword']) . "', 
		published = '" . strtotime($this->db->escape($data['published'])) . "', 
		published_by = '" . $this->db->escape($data['published_by']) . "', 
		last_edited = '" . strtotime($this->db->escape($data['last_edited'])) . "', 
		last_edited_by = '" . $this->db->escape($data['last_edited_by']) . "', 
		sort_order = '" . (int)$data['sort_order'] . "',
		status = '" . (int)$data['status'] . "' WHERE news_id = " . (int)$news_id);;

        $ru_id = $this->ru_id;
        if (isset($data['news_description'])) {
            $title = $data['news_description'][$ru_id]['title'];
        } else {
            $title = '';
        }
        $keyword = $this->seo_urls_generating('update', ['query' => 'news_id=' . $news_id, 'keyword' => $data['keyword'], 'title' => $title]);
        if ($keyword !== $this->db->escape($data['keyword'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "news SET keyword = '" . $this->db->escape($keyword) . "' WHERE news_id = " . (int)$news_id);
        }

        if (isset($data['news_description'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "news_descriptions WHERE news_id = '" . (int)$news_id . "'");
            foreach ($data['news_description'] as $language_id => $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "news_descriptions SET 
                news_id = '" . (int)$news_id . "', 
                language_id = '" . (int)$language_id . "', 
                title = '" .  $this->db->escape($value['title']) . "', 
                image_title = '" .  $this->db->escape($value['image_title']) . "', 
                meta_title = '" .  $this->db->escape($value['meta_title']) . "', 
                meta_description = '" .  $this->db->escape($value['meta_description']) . "', 
                meta_keyword = '" .  $this->db->escape($value['meta_keyword']) . "'
                ");
            }
        }

        if (isset($data['news_texts'])) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "news_texts WHERE news_id = '" . (int)$news_id . "'");
            foreach ($data['news_texts'] as $row => $text) {
                foreach ($text['text'] as $language_id => $value) {
                    if (!isset($text['sort_order'])) {
                        $text['sort_order'] = '0';
                    }
                    $this->db->query("INSERT INTO " . DB_PREFIX . "news_texts SET 
                    news_id = '" . (int)$news_id . "', 
                    text_group_id = '" . $text['text_group_id'] . "',
                    language_id = '" . (int)$language_id . "', 
                    text = '" .  $this->db->escape($value) . "', 
                    sort_order = '" .  (int)$text['sort_order'] . "'
                    ");
                }
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "news_images WHERE news_id = '" . (int)$news_id . "'");
        if (isset($data['news_images'])) {
            foreach ($data['news_images'] as $index => $image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "news_images SET 
                news_id = '" . (int)$news_id . "', 
                image = '" .  $this->db->escape($image['image']) . "', 
                sort_order = '" .  (int)$image['sort_order'] . "'
                ");
            }
        }
    }

    public function deleteNews($news_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "news_descriptions WHERE news_id = '" . (int)$news_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "news_images WHERE news_id = '" . (int)$news_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "news_texts WHERE news_id = '" . (int)$news_id . "'");
    }

    public function getNews($news_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news WHERE news_id = '" . (int)$news_id . "'");
        return $query->row;
    }

    public function getAllNews($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "news as news LEFT JOIN " . DB_PREFIX . "news_descriptions as description 
        ON (news.news_id = description.news_id) WHERE description.language_id = " . (int)$this->config->get('config_language_id');
        $sort_data = array(
            'title',
            'status'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY published";
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

    public function getNewsDescriptions($news_id) {
        $news_description = [];
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_descriptions WHERE news_id = " . (int)$news_id . ";");
        foreach ($query->rows as $result) {
            $news_description[$result['language_id']] = [
                'news_description_id' => $result['news_description_id'],
                'news_id' => $result['news_id'],
                'language_id' => $result['language_id'],
                'title' => $result['title'],
                'image_title' => $result['image_title'],
                'meta_title' => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword' => $result['meta_keyword']
            ];
        }
        return $news_description;
    }

    public function getNewsTexts($news_id) {
        $news_text = [];
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_texts WHERE news_id = " . (int)$news_id . " ORDER BY sort_order ASC;");
        foreach ($query->rows as $result) {
            $news_text[$result['text_group_id']]['text'][$result['language_id']] = $result['text'];
            $news_text[$result['text_group_id']]['sort_order'] = $result['sort_order'];
        }
        return $news_text;
    }

    public function getNewsImages($news_id) {
        $news_images = [];
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_images WHERE news_id = " . (int)$news_id . " ORDER BY sort_order ASC;");
        foreach ($query->rows as $result) {
            $news_images[] = [
                'news_image_id' => $result['news_image_id'],
                'news_id' => $result['news_id'],
                'image' => $result['image'],
                'sort_order' => $result['sort_order']
            ];
        }
        return $news_images;
    }

    private function seo_urls_generating($action, $data) {
        switch ($action) {
            case 'add':
                return $this->addSeoUrl($data);
                break;
            case 'update':
                return $this->updateSeoUrl($data);
                break;
        }
    }

    private function addSeoUrl(array $data) {
        $query = $data['query'];
        $keyword = $this->selectKeyword($data['keyword'], $data['title']);
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
        query = '" . $query . "', 
        keyword = '" . $keyword . "';");
        return $keyword;
    }

    private function updateSeoUrl(array $data) {
        $query = $data['query'];
        $keyword = $this->selectKeyword($data['keyword'], $data['title']);
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '" . $query . "';");
        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET
        query = '" . $query . "',  
        keyword = '" . $keyword . "';");
        return $keyword;
    }

    private function selectKeyword($keyword, $title) {
        if (!empty($keyword)) {
            return $this->translit($keyword);
        } else {
            return $this->translit($title);
        }
    }

    protected function translit($text) {
        $rus = array("а","А","б","Б","в","В","г","Г","д","Д","е","Е","ё","Ё","є","Є","ж", "Ж",  "з","З","и","И","і","І","ї","Ї","й","Й","к","К","л","Л","м","М","н","Н","о","О","п","П","р","Р", "с","С","т","Т","у","У","ф","Ф","х","Х","ц","Ц","ч", "Ч", "ш", "Ш", "щ",  "Щ", "ъ","Ъ", "ы","Ы","ь","Ь","э","Э","ю", "Ю", "я","Я",'/',' ', '-');
        $eng =array("a","A","b","B","v","V","g","G","d","D","e","E","e","E","e","E", "zh","ZH","z","Z","i","I","i","I","yi","YI","j","J","k","K","l","L","m","M","n","N","o","O", "p","P","r","R","s","S","t","T","u","U","f","F","h","H","c","C","ch","CH", "sh","SH","sch","SCH","", "", "y","Y","","","e","E","ju","JU","ja","JA",'','_', '_');
        $text = strtolower(str_replace($rus,$eng,$text));
        $disallow_symbols = array(
            ' ' => '-', '\\' => '-', '/' => '-', ':' => '-', '*' => '', '!' => '', '%' => '', '$' => '',
            '?' => '', ',' => '', '"' => '', '\'' => '', '<' => '', '>' => '', '|' => ''
        );
        $result = trim(strip_tags(str_replace(array_keys($disallow_symbols), array_values($disallow_symbols), trim(html_entity_decode($text, ENT_QUOTES, 'UTF-8')))), '-');
//        $result = preg_replace('/(-*)([0-9]+)(-*)/i', '_$2_', $result);
//        return trim(str_replace('__', '_', $result), '_');
        return $result;
    }

    public function regenerate_all_urls() {
        $all_news = $this->getAllNews();
        foreach ($all_news as $news) {
            if (empty($news['keyword'])) {
                $ru_id = $this->ru_id;
                if (isset($news['title'])) {
                    $title = $news['title'];
                } else {
                    $title = '';
                }
                $result = $this->seo_urls_generating('update', ['query' => 'news_id=' . $news['news_id'], 'keyword' => $news['keyword'], 'title' => $title]);
            }
        }
    }

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "news`(
	`news_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`thumb` VARCHAR(255) NOT NULL DEFAULT '',
	`image` VARCHAR(255) NOT NULL DEFAULT '',
	`keyword` VARCHAR(255) NOT NULL DEFAULT '',
	`status` TINYINT(1) NOT NULL DEFAULT 0,
	`sort_order` INT(11) NOT NULL DEFAULT 0,
	`published` VARCHAR(255) NOT NULL DEFAULT '0000-00-00 00:00',
	`published_by` VARCHAR(255) NOT NULL,
	`last_edited` VARCHAR(255) NOT NULL DEFAULT '0000-00-00 00:00',
	`last_edited_by` VARCHAR(255) NOT NULL DEFAULT '',
	`viewed` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY (`news_id`)) DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "news_descriptions`(
	`news_description_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`image_title` VARCHAR(255) NOT NULL DEFAULT '',
    `meta_title` varchar(255) NOT NULL,
    `meta_description` varchar(255) NOT NULL,
    `meta_keyword` varchar(255) NOT NULL,
	PRIMARY KEY (`news_description_id`)) DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "news_texts`(
	`news_text_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`text_group_id` VARCHAR(11) NOT NULL DEFAULT '',
	`news_id` INT(11) NOT NULL,
	`language_id` INT(11) NOT NULL,
	`text` text NOT NULL,
	`sort_order` INT(5) NOT NULL DEFAULT 0,
	PRIMARY KEY (`news_text_id`)) DEFAULT CHARSET=utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "news_images`(
	`news_image_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` INT(11) NOT NULL,
	`image` VARCHAR(255) NOT NULL DEFAULT '',
	`sort_order` INT(5) NOT NULL DEFAULT 0,
	PRIMARY KEY (`news_image_id`)) DEFAULT CHARSET=utf8;");
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "news`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "news_descriptions`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "news_texts`;");
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "news_images`;");
    }
}
