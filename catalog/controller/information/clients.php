<?php
class ControllerInformationClients extends Controller {
    public function index() {
        $this->load->language('information/clients');
        $this->load->model('extension/module/clients');
        $this->load->model('tool/image');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/clients')
        );


        $data['heading_title'] = $this->language->get('heading_title');

        $data['tab_textile'] = $this->language->get('tab_textile');
        $data['tab_size'] = $this->language->get('tab_size');
        $data['tab_recommendation'] = $this->language->get('tab_recommendation');
        $data['tab_quality'] = $this->language->get('tab_quality');

        $data['column_age'] = $this->language->get('column_age');
        $data['column_height'] = $this->language->get('column_height');
        $data['column_chest'] = $this->language->get('column_chest');
        $data['column_thigh'] = $this->language->get('column_thigh');

        $data['text_sizes_table_empty'] = $this->language->get('text_sizes_table_empty');
        $data['text_recommendations_empty'] = $this->language->get('text_recommendations_empty');

        $this->document->setTitle($this->language->get('heading_title'));

        $settings = $this->model_extension_module_clients->getAllSettings();

        if (isset($settings['meta_title']) && $settings['meta_title'] !== '') {
            $this->document->setTitle($settings['meta_title']);
        }
        if (isset($settings['meta_description']) && $settings['meta_description'] !== '') {
            $this->document->setDescription($settings['meta_description']);
        }
        if (isset($settings['meta_keywords']) && $settings['meta_keywords'] !== '') {
            $this->document->setKeywords($settings['meta_keywords']);
        }

        $data['settings'] = [
            'meta_title' => $settings['meta_title'],
            'meta_description' => $settings['meta_description'],
            'meta_keywords' => $settings['meta_keywords'],

            'textile_description' => html_entity_decode($settings['textile_description']),
            'sizes_description' => html_entity_decode($settings['sizes_description']),
            'recommendation_description' => html_entity_decode($settings['recommendation_description']),
            'quality_description' => html_entity_decode($settings['quality_description']),

        ];
//        $text = html_entity_decode($item['texts'][0]['text']);
//        $text = strip_tags($text);

        $textile = $this->model_extension_module_clients->getAllTextiles();
        $sizes = $this->model_extension_module_clients->getAllSizes();
        $care = $this->model_extension_module_clients->getCare();
        if (count($care) >= 1) $care = $care[0];
        $recommendations = $this->model_extension_module_clients->getAllRecommendations();
        $qualities = $this->model_extension_module_clients->getAllQualities();
        $images = $this->model_extension_module_clients->getAllImages();

        foreach ($textile as $index => $item) {
            if ($item['image']) {
                $textile[$index]['image'] = 'image/' . $item['image'];
            } else {
                $textile[$index]['image'] = 'placeholder.png';
            }
        }
        foreach ($recommendations as $index => $item) {
            if ($item['image']) {
                $recommendations[$index]['image'] = 'image/' . $item['image'];
            } else {
                $recommendations[$index]['image'] = 'placeholder.png';
            }
        }
        foreach ($qualities as $index => $item) {
            if (!empty($item['text'])) {
                $text = html_entity_decode($item['text']);
                $qualities[$index]['text'] = $text;
            } else $qualities[$index]['text'] = '';
        }
        foreach ($images as $index => $item) {
            if ($item['image']) {
                $images[$index]['image'] = 'image/' . $item['image'];
            } else {
                $images[$index]['image'] = 'placeholder.png';
            }
        }

        $data['textile'] = $textile;
        $data['sizes'] = $sizes;
        $data['care'] = $care;
        $data['recommendations'] = $recommendations;
        $data['qualities'] = $qualities;
        $data['images'] = $images;

        $this->document->setBreadcrumbs($data['breadcrumbs']);
        $this->getLayouts($data);

        $this->response->setOutput($this->load->view('information/clients', $data));
    }

    private function getLayouts(&$data) {
//        $data['column_left'] = $this->load->controller('common/column_left');
//        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
    }
}