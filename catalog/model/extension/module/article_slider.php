<?php
class ModelExtensionModuleArticleSlider extends Model {
    public function getArticles() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n
        LEFT JOIN " . DB_PREFIX . "news_descriptions nd ON (n.news_id = nd.news_id)
        WHERE n.status = '1'
        AND nd.language_id = " . (int)$this->config->get('config_language_id') . "
        ORDER BY n.published DESC, n.sort_order ASC
        LIMIT 10");
        
        return $query->rows;
    }
}