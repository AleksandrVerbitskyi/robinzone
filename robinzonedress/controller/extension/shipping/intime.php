<?php
class ControllerExtensionShippingintime extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/shipping/intime');

        $this->document->setTitle($this->language->get('heading_title2'));

        $data['heading_title'] = $this->language->get('heading_title');

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('intime', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
        }

        $data['button_synchronize'] = $this->language->get('button_synchronize');
        $data['synchronize'] = $this->url->link('extension/shipping/intime/synchronize', 'token=' . $this->session->data['token'] . '', true);

        $data['text_edit'] = $this->language->get('text_edit');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_none'] = $this->language->get('text_none');

        $data['entry_api_code'] = $this->language->get('entry_api_code');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_standard'] = $this->language->get('entry_standard');
        $data['entry_express'] = $this->language->get('entry_express');
        $data['entry_display_time'] = $this->language->get('entry_display_time');
        $data['entry_weight_class'] = $this->language->get('entry_weight_class');
        $data['entry_tax_class'] = $this->language->get('entry_tax_class');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['help_display_time'] = $this->language->get('help_display_time');
        $data['help_weight_class'] = $this->language->get('help_weight_class');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['postcode'])) {
            $data['error_postcode'] = $this->error['postcode'];
        } else {
            $data['error_postcode'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/shipping/intime', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/shipping/intime', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

        if (isset($this->request->post['intime_api_code'])) {
            $data['intime_api_code'] = $this->request->post['intime_api_code'];
        } else {
            $data['intime_api_code'] = $this->config->get('intime_api_code');
        }

        if (isset($this->request->post['intime_postcode'])) {
            $data['intime_postcode'] = $this->request->post['intime_postcode'];
        } else {
            $data['intime_postcode'] = $this->config->get('intime_postcode');
        }

        if (isset($this->request->post['intime_standard'])) {
            $data['intime_standard'] = $this->request->post['intime_standard'];
        } else {
            $data['intime_standard'] = $this->config->get('intime_standard');
        }

        if (isset($this->request->post['intime_express'])) {
            $data['intime_express'] = $this->request->post['intime_express'];
        } else {
            $data['intime_express'] = $this->config->get('intime_express');
        }

        if (isset($this->request->post['intime_display_time'])) {
            $data['intime_display_time'] = $this->request->post['intime_display_time'];
        } else {
            $data['intime_display_time'] = $this->config->get('intime_display_time');
        }

        if (isset($this->request->post['intime_weight_class_id'])) {
            $data['intime_weight_class_id'] = $this->request->post['intime_weight_class_id'];
        } else {
            $data['intime_weight_class_id'] = $this->config->get('intime_weight_class_id');
        }

        $this->load->model('localisation/weight_class');

        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        if (isset($this->request->post['intime_tax_class_id'])) {
            $data['intime_tax_class_id'] = $this->request->post['intime_tax_class_id'];
        } else {
            $data['intime_tax_class_id'] = $this->config->get('intime_tax_class_id');
        }

        $this->load->model('localisation/tax_class');

        $data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        if (isset($this->request->post['intime_geo_zone_id'])) {
            $data['intime_geo_zone_id'] = $this->request->post['intime_geo_zone_id'];
        } else {
            $data['intime_geo_zone_id'] = $this->config->get('intime_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['intime_status'])) {
            $data['intime_status'] = $this->request->post['intime_status'];
        } else {
            $data['intime_status'] = $this->config->get('intime_status');
        }

        if (isset($this->request->post['intime_sort_order'])) {
            $data['intime_sort_order'] = $this->request->post['intime_sort_order'];
        } else {
            $data['intime_sort_order'] = $this->config->get('intime_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/intime', $data));
    }

    public function synchronize() {
        require_once DIR_APPLICATION . '/controller/extension/module/_intime_api_synch.php';
        synchronizeApi();
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/intime')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}