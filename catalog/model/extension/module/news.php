<?php
class ModelExtensionModuleNews extends Model {
    public function getAllNews($data = null) {
        $result = [];
        $sql = "SELECT * FROM " . DB_PREFIX . "news n 
        LEFT JOIN " . DB_PREFIX . "news_descriptions nd ON (n.news_id = nd.news_id) 
        WHERE n.status = '1' 
        AND nd.language_id = " . (int)$this->config->get('config_language_id') . "
        ORDER BY n.published DESC, n.sort_order ASC 
        ";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 12;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $news) {
            $texts = $this->getTexts($news['news_id']);
            $result[] = [
                'news_id' => $news['news_id'],
                'title' => $news['title'],
                'thumb' => $news['thumb'],
                'texts' => $texts,
                'published' => date('Y-m-d H:i', $news['published']),
                'published_by' => $news['published_by']
            ];

        }

        return $result;
    }

    public function getTexts($news_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_texts 
        WHERE news_id = " . (int)$news_id . " 
        AND language_id = " . (int)$this->config->get('config_language_id') . " 
        ORDER BY sort_order ASC, text_group_id ASC");

        return $query->rows;
    }

    public function getSlides($news_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_images 
        WHERE news_id = " . (int)$news_id . " 
        ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getTotalNews() {
        $sql = "SELECT COUNT(DISTINCT n.news_id) as total FROM " . DB_PREFIX . "news n 
        WHERE n.status = '1';";
        return $this->db->query($sql)->row['total'];
    }

    public function getSingleNews($news_id) {
        $result = [];
        $sql = "SELECT * FROM " . DB_PREFIX . "news n 
        LEFT JOIN " . DB_PREFIX . "news_descriptions nd ON (n.news_id = nd.news_id) 
        WHERE n.status = '1' 
        AND nd.language_id = " . (int)$this->config->get('config_language_id') . "
        AND n.news_id = " . (int)$news_id . ";";
        $query = $this->db->query($sql);

        $news = $query->row;

        $texts = $this->getTexts($news_id);
        $slides = $this->getSlides($news_id);
        if ($slides) {
            $slider = $this->renderSlider($slides, $news['title']);
        } else $slider = false;

        $content = $this->getContent($texts, $slider);

        $result = [
            'news_id' => $news['news_id'],
            'title' => $news['title'],
            'image' => $news['image'],
            'image_title' => $news['image_title'],
            'content' => $content,
            'published' => date('Y-m-d H:i', $news['published']),
            'published_by' => $news['published_by']
        ];


        return $result;
    }

    private function getContent($texts, $slider) {
        $result = [];
        for ($i = 0; $i < count($texts); $i++) {
            $result[] = ['type'=>'text', 'value'=>html_entity_decode($texts[$i]['text'])];
            if ($i == 0 && $slider !== false) $result[] = ['type'=>'slider', 'value'=>$slider];
        }
        return $result;
    }

    private function renderSlider($slides, $title) {
        $output = '<div class="lazy slider newsSlide" data-sizes="50vw">';
        $n_s = 0;
        foreach ($slides as $slide) {
            $output .= '<div>';
                $output .= '<div class="newsSlider_imgCover">';
                    $output .= '<img src="image/' . $slide['image'] . '" alt="' . $title . ' slide ' . $n_s . '" title="' . $title . ' slide ' . $n_s++ . '">';
                $output .= '</div>';
            $output .= '</div>';
        }
        $output .= '</div>';
        return $output;
    }

    public function setViewed($news_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "news SET viewed = (viewed + 1) WHERE news_id = " . (int)$news_id . ";");
    }

    public function getMostViewed($top_n) {
        $result = [];
        $sql = "SELECT * FROM " . DB_PREFIX . "news n 
        LEFT JOIN " . DB_PREFIX . "news_descriptions nd ON (n.news_id = nd.news_id) 
        WHERE n.status = '1' 
        AND nd.language_id = " . (int)$this->config->get('config_language_id') . "
        ORDER BY n.viewed DESC LIMIT " . (int)$top_n . ";";
        $query = $this->db->query($sql);
        foreach ($query->rows as $top) {
            $result[] = [
                'title' => $top['title'],
                'viewed' => $top['viewed'],
                'news_id' => $top['news_id']
            ];
        }
        return $result;
    }
}
