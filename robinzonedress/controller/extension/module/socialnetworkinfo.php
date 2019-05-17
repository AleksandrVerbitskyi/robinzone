<?php
class ControllerExtensionModuleSocialNetworkInfo extends Controller {
    private $error = array();

    public function index() {
        $this->install();

        $this->load->language('extension/module/socialnetworkinfo');
        $this->load->model('extension/module/socialnetworkinfo');
        $this->load->model('tool/image');

        $this->document->addStyle('view/template/extension/module/socialnetworkinfo/socnetinfo.css');
        $this->document->addScript('view/template/extension/module/socialnetworkinfo/socnetinfo.js');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $data = [];

        $data['token'] = $this->session->data['token'];

        $this->getBreadcrumbs($data);
        $this->getLanguageVariables($data);
        $this->getLayout($data);
        $this->getButtons($data);

        $this->getForm($data);

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 50, 50);
        } elseif (!empty($social_info) && is_file(DIR_IMAGE . $social_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($social_info['image'], 50, 50);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);

        $data['image'] = '';

        if (isset($this->error['soc_net_rows'])) {
            $data['error_warning'] = $this->language->get('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $this->response->setOutput($this->load->view('extension/module/socialnetworkinfo/socialnetworkinfo', $data));
    }

    public function save() {
        $this->load->language('extension/module/socialnetworkinfo');
        $json = [];
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ($this->validateForm()) {
                $this->load->model('extension/module/socialnetworkinfo');
                $result = $this->model_extension_module_socialnetworkinfo->saveSocialNetworks($this->request->post['soc_net_rows']);
                $json['success'] = $this->language->get('success');
            } else {
                $json['error'] = $this->error;
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function delete() {
        $this->load->language('extension/module/socialnetworkinfo');
        $json = [];
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (isset($this->request->post['delete'])) {
                $this->load->model('extension/module/socialnetworkinfo');
                $result = $this->model_extension_module_socialnetworkinfo->deleteSocialNetwork($this->request->post['delete']);
                $json['success'] = $this->language->get('success');
            } else {
                $json['error'] = $this->error;
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function getForm(&$data) {

        $social_networks = [];
        $social_networks = $this->model_extension_module_socialnetworkinfo->getSocialNetworks();

        if (isset($this->session->data['error'])) {
            $this->error = $this->session->data['error'];
            unset($this->session->data['error']);
        }

        foreach ($social_networks as $social_network_id => $value) {
            foreach ($value as $field => $val) {
                if (isset($this->error['soc_net_rows'][$social_network_id][$field])) {
                    $data['error']['soc_net_rows'][$social_network_id]['error_' . $field] = $this->error['soc_net_rows'][$social_network_id][$field];
                } else {
                    $data['error']['soc_net_rows'][$social_network_id]['error_' . $field] = '';
                }
            }

        }

        if (isset($this->request->post['soc_net_rows'])) {
            $data['soc_net_rows'] = $this->request->post['soc_net_rows'];
        } else {
            $data['soc_net_rows'] = $social_networks;
        }

        foreach ($data['soc_net_rows'] as $index => $item) {
            foreach ($item as $field => $value) {
                if ($field == 'image') {
                    if (is_file(DIR_IMAGE . $value)) {
                        $data['soc_net_rows'][$index]['thumb'] = $this->model_tool_image->resize($value, 50, 50);
                    } else {
                        $data['soc_net_rows'][$index]['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
                    }
                }
            }
        }

    }

    private function validateForm() {
        $this->load->language('extension/module/socialnetworkinfo');

        foreach ($this->request->post['soc_net_rows'] as $social_network_id => $value) {
            foreach ($value as $field => $val) {
                if ($field == 'sort' && !is_numeric($val)) {
                    $this->error['soc_net_rows'][$social_network_id][$field] = $this->language->get('error_sort');
                }
                if ($field == 'url' && utf8_strlen($val) < 1) {
                    $this->error['soc_net_rows'][$social_network_id][$field] = $this->language->get('error_url');
                }
            }
        }
        if (!isset($this->error['soc_net_rows'])) return true;
        return false;
    }

    private function getBreadcrumbs(&$data) {
        $url = '';

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true)
        );
    }

    private function getLanguageVariables(&$data) {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = $this->language->get('text_form');
        $data['entry_ico'] = $this->language->get('entry_ico');
        $data['entry_url'] = $this->language->get('entry_url');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort'] = $this->language->get('entry_sort');

        $data['entry_font'] = $this->language->get('entry_font');
        $data['entry_which_ico'] = $this->language->get('entry_which_ico');
        $data['entry_which_image'] = $this->language->get('entry_which_image');
        $data['entry_which_font'] = $this->language->get('entry_which_font');

        $data['entry_status_on'] = $this->language->get('entry_status_on');
        $data['entry_status_off'] = $this->language->get('entry_status_off');

//        $data['error_image'] = $this->language->get('error_image');

        $data['error_permission'] = $this->language->get('error_permission');
    }

    private function getLayout(&$data) {
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
    }

    private function getButtons(&$data) {
        $url = '';
        $data['save'] = $this->url->link('extension/module/socialnetworkinfo/save', 'token=' . $this->session->data['token'] . $url, true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . $url, true);

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_add'] = $this->language->get('button_add');
    }

    public function install() {
        $this->load->model('extension/module/socialnetworkinfo');
        $this->model_extension_module_socialnetworkinfo->install();
    }

    public function uninstall() {
        $this->load->model('extension/module/socialnetworkinfo');
        $this->model_extension_module_socialnetworkinfo->uninstall();
    }
}