<?php
class ControllerExtensionModuleArticleSlider extends Controller {
    public function index($setting) {
        $this->load->language('extension/module/article_slider');
        
        $data['heading_title'] = $this->language->get('heading_title');
        
        $this->load->model('extension/module/article_slider');
        $this->load->model('tool/monthformat');
    
        $this->load->model('localisation/language');
        $language_code = $this->model_localisation_language->getLanguage($this->config->get('config_language_id'))['code'];
        
        $data['articles'] = array();
        
        $results = $this->model_extension_module_article_slider->getArticles();
        
        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                }
    
                if ($result['published']) {
                    $result['published'] = $this->model_tool_monthformat->format($result['published'], $language_code);
                }
                
                $data['articles'][] = array(
                    'news_id' => $result['news_id'],
                    'thumb' => $result['image'],
                    'image' => $image,
                    'title' => $result['title'],
                    'published' => $result['published'],
                    'viewed' => $result['viewed'],
                    'url' => $this->url->link('information/articles', 'news_id=' . $result['news_id'], true)
                    
                );
            }
            return $this->load->view('extension/module/article_slider', $data);
        }
    }
}