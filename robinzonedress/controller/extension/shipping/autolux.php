<?php
class ControllerExtensionShippingAutoLux extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/shipping/autolux');

        $this->document->setTitle($this->language->get('heading_title2'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('autolux', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_none'] = $this->language->get('text_none');

        $data['button_synchronize'] = $this->language->get('button_synchronize');
        $data['synchronize'] = $this->url->link('extension/shipping/autolux/synchronize', 'token=' . $this->session->data['token'] . '', true);

        $data['entry_api_name'] = $this->language->get('entry_api_name');
        $data['entry_api_password'] = $this->language->get('entry_api_password');
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
            'href' => $this->url->link('extension/shipping/autolux', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/shipping/autolux', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

        if (isset($this->request->post['autolux_api_name'])) {
            $data['autolux_api_name'] = $this->request->post['autolux_api_name'];
        } else {
            $data['autolux_api_name'] = $this->config->get('autolux_api_name');
        }

        if (isset($this->request->post['autolux_api_password'])) {
            $data['autolux_api_password'] = $this->request->post['autolux_api_password'];
        } else {
            $data['autolux_api_password'] = $this->config->get('autolux_api_password');
        }

        if (isset($this->request->post['autolux_postcode'])) {
            $data['autolux_postcode'] = $this->request->post['autolux_postcode'];
        } else {
            $data['autolux_postcode'] = $this->config->get('autolux_postcode');
        }

        if (isset($this->request->post['autolux_standard'])) {
            $data['autolux_standard'] = $this->request->post['autolux_standard'];
        } else {
            $data['autolux_standard'] = $this->config->get('autolux_standard');
        }

        if (isset($this->request->post['autolux_express'])) {
            $data['autolux_express'] = $this->request->post['autolux_express'];
        } else {
            $data['autolux_express'] = $this->config->get('autolux_express');
        }

        if (isset($this->request->post['autolux_display_time'])) {
            $data['autolux_display_time'] = $this->request->post['autolux_display_time'];
        } else {
            $data['autolux_display_time'] = $this->config->get('autolux_display_time');
        }

        if (isset($this->request->post['autolux_weight_class_id'])) {
            $data['autolux_weight_class_id'] = $this->request->post['autolux_weight_class_id'];
        } else {
            $data['autolux_weight_class_id'] = $this->config->get('autolux_weight_class_id');
        }

        $this->load->model('localisation/weight_class');

        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        if (isset($this->request->post['autolux_tax_class_id'])) {
            $data['autolux_tax_class_id'] = $this->request->post['autolux_tax_class_id'];
        } else {
            $data['autolux_tax_class_id'] = $this->config->get('autolux_tax_class_id');
        }

        $this->load->model('localisation/tax_class');

        $data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        if (isset($this->request->post['autolux_geo_zone_id'])) {
            $data['autolux_geo_zone_id'] = $this->request->post['autolux_geo_zone_id'];
        } else {
            $data['autolux_geo_zone_id'] = $this->config->get('autolux_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['autolux_status'])) {
            $data['autolux_status'] = $this->request->post['autolux_status'];
        } else {
            $data['autolux_status'] = $this->config->get('autolux_status');
        }

        if (isset($this->request->post['autolux_sort_order'])) {
            $data['autolux_sort_order'] = $this->request->post['autolux_sort_order'];
        } else {
            $data['autolux_sort_order'] = $this->config->get('autolux_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/autolux', $data));
    }

    public function synchronize() {
        require_once DIR_APPLICATION . '/controller/extension/module/_autolux_api_synch.php';
        synchronizeApi();
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/autolux')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}