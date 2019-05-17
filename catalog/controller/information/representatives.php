<?php
class ControllerInformationRepresentatives extends Controller {
    public function index() {
        $representatives = $this->load->language('information/representatives');
        $this->load->language('information/contact');
        $this->load->model('extension/module/representatives');
        $this->load->model('localisation/location');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/representatives')
        );

        $data['heading_title'] = $this->language->get('heading_title');
        $data['heading_representatives_title'] = $representatives['heading_title'];
    
        $data['text_address'] = $this->language->get('text_address');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_our_email'] = $this->language->get('text_our_email');
        $data['text_our_site'] = $this->language->get('text_our_site');
    
        $data['store'] = $this->config->get('config_name');
        $data['store_telephone'] = $this->config->get('config_telephone');
        $data['config_email'] = $this->config->get('config_email');
        $data['config_address'] = html_entity_decode($this->config->get('config_address'));
        $data['config_comment'] = $this->config->get('config_comment');
        $data['geocode'] = $this->config->get('config_geocode');
        $data['geocode_hl'] = $this->config->get('config_language');
        $data['fax'] = $this->config->get('config_fax');
        $data['open'] = nl2br($this->config->get('config_open'));
    
        $data['site_address'] = HTTP_SERVER;

        $this->document->setTitle($this->language->get('heading_title'));

        $cities = $this->model_extension_module_representatives->getAllCities();

        $data['cities'] = $cities;

        $this->document->setBreadcrumbs($data['breadcrumbs']);

        $this->getContactUsForm($data);

        $this->getLayouts($data);

        $this->response->setOutput($this->load->view('information/representatives', $data));
    }

    private function getLayouts(&$data) {
//        $data['column_left'] = $this->load->controller('common/column_left');
//        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
    }

    private function getContactUsForm(&$data) {
        $this->load->language('information/contact');

        $data['text_write_us'] = $this->language->get('text_write_us');
        $data['text_phone_us_full'] = $this->language->get('text_phone_us_full');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_question'] = $this->language->get('entry_question');

        $data['button_contact_us'] = $this->language->get('button_submit');

        $data['contact_us_url'] = 'index.php?route=information/contact/contactUs';
    }
}