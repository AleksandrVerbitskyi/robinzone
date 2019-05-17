<?php
class ControllerExtensionModuleRepresentatives extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/representatives');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/representatives');
        
        $this->getList();
    }

    public function add() {
        $this->load->language('extension/module/representatives');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/representatives');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_extension_module_representatives->addCity($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function addRepresentative() {
        $this->load->language('extension/module/representatives');

        $this->load->model('extension/module/representatives');

        $json = [];

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $json = $this->validateRepresentativeForm();

            if (!isset($json['errors'])) {
                $representative_id = null;
                if (isset($this->request->post['representative']['representative_id']) && $this->request->post['representative']['representative_id'] != '') {
                    $representative_id = $this->request->post['representative']['representative_id'];
                }
                if (!is_null($representative_id)) {
                    $this->model_extension_module_representatives->editRepresentative($representative_id, $this->request->post);
                } else {
                    $this->model_extension_module_representatives->addRepresentative($this->request->post);
                }
                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function loadRepresentative() {
        $this->load->language('extension/module/representatives');

        $this->load->model('extension/module/representatives');

        $json = [];

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['representative_id'])) {
            $representative_id = $this->request->post['representative_id'];
            $json = $this->model_extension_module_representatives->getRepresentative($representative_id);
            $json['entry_status_on'] = $this->language->get('entry_status_on');
            $json['entry_status_off'] = $this->language->get('entry_status_off');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function deleteRepresentative() {
        $this->load->language('extension/module/representatives');

        $this->load->model('extension/module/representatives');

        $json = [];

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['representative_id'])) {
            $representative_id = $this->request->post['representative_id'];
            $json = $this->model_extension_module_representatives->deleteRepresentative($representative_id);
            $json['success'] = $this->language->get('text_success');
            $this->session->data['success'] = $json['success'];
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function edit() {
        $this->load->language('extension/module/representatives');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/representatives');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_extension_module_representatives->editCity($this->request->get['city_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('extension/module/representatives');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/representatives');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $city_id) {
                $this->model_extension_module_representatives->deleteCity($city_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList() {

        $this->getPageLanguageVariables($data);

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->getBreadcrumbs($data, $url);

        $data['add'] = $this->url->link('extension/module/representatives/add', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete'] = $this->url->link('extension/module/representatives/delete', 'token=' . $this->session->data['token'] . $url, true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . $url, true);

        $data['representative_cities'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $representative_cities_total = $this->model_extension_module_representatives->getTotalCities($filter_data);

        $results = $this->model_extension_module_representatives->getAllCities($filter_data);

        foreach ($results as $result) {
            $data['representative_cities'][] = array(
                'city_id' => $result['city_id'],
                'name'      => $result['name'],
                'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                'sort_order'    => $result['sort_order'],
                'edit'      => $this->url->link('extension/module/representatives/edit', 'token=' . $this->session->data['token'] . '&city_id=' . $result['city_id'] . $url, true)
            );
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
        $data['sort_status'] = $this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $representative_cities_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($representative_cities_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($representative_cities_total - $this->config->get('config_limit_admin'))) ? $representative_cities_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $representative_cities_total, ceil($representative_cities_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/representatives/representatives_list', $data));
    }

    private function getFormLanguageVariables(&$data) {
        // Tabs
        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data'] = $this->language->get('tab_data');

        // General
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_alias'] = $this->language->get('entry_alias');

        // Modal
        if (isset($this->request->get['city_id'])) {
            $city_name = $this->model_extension_module_representatives->getCityName($this->request->get['city_id']);
            $data['modal_title'] = sprintf($this->language->get('modal_title'), $city_name);
        } else {
            $data['modal_title'] = $this->language->get('modal_title');
        }
        $data['modal_name'] = $this->language->get('modal_name');
        $data['modal_address'] = $this->language->get('modal_address');
        $data['modal_address_example'] = $this->language->get('modal_address_example');
        $data['modal_latitude'] = $this->language->get('modal_latitude');
        $data['modal_longitude'] = $this->language->get('modal_longitude');
        $data['modal_sort_order'] = $this->language->get('modal_sort_order');

        $data['modal_save'] = $this->language->get('modal_save');
        $data['modal_cancel'] = $this->language->get('modal_cancel');
        $data['modal_delete'] = $this->language->get('modal_delete');

        // Data
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_status_on'] = $this->language->get('entry_status_on');
        $data['entry_status_off'] = $this->language->get('entry_status_off');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        // Texts
        $data['entry_text'] = $this->language->get('entry_text');
        $data['entry_text_sort_order'] = $this->language->get('entry_text_sort_order');
        $data['button_text_add'] = $this->language->get('button_text_add');

    }

    private function getPageLanguageVariables(&$data) {
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = !isset($this->request->get['representatives_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_default'] = $this->language->get('text_default');

        $data['entry_link'] = $this->language->get('entry_link');
        $data['entry_button_text'] = $this->language->get('entry_button_text');
        // Buttons
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_regenerate'] = $this->language->get('button_regenerate');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_sort_order'] = $this->language->get('column_sort_order');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');
    }


    private function getBreadcrumbs(&$data, $url) {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . $url, true)
        );
    }

    private function getFormValues(&$data, $city_info = null, $representative_info = null) {
        // City fields
        if (isset($this->request->post['alias'])) {
            $data['alias'] = $this->request->post['alias'];
        } elseif (!empty($city_info)) {
            $data['alias'] = $city_info['alias'];
        } else {
            $data['alias'] = false;
        }
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($city_info)) {
            $data['status'] = $city_info['status'];
        } else {
            $data['status'] = false;
        }
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($city_info)) {
            $data['sort_order'] = $city_info['sort_order'];
        } else {
            $data['sort_order'] = '0';
        }

        // City Description fields
        if (isset($this->request->post['city_description'])) {
            $data['city_description'] = $this->request->post['city_description'];
        } elseif (isset($this->request->get['city_id'])) {
            $data['city_description'] = $this->model_extension_module_representatives->getCityDescription($this->request->get['city_id']);
        } else {
            $data['city_description'] = [];
        }

        if (isset($this->request->post['representative']['city_id'])) {
            $data['representative']['city_id'] = $this->request->post['representative']['city_id'];
        } elseif (!empty($representative_info)) {
            $data['representative']['city_id'] = $representative_info['city_id'];
        } elseif (isset($this->request->get['city_id'])) {
            $data['representative']['city_id'] = $this->request->get['city_id'];
        }

        if (isset($this->request->post['representative']['representative_id'])) {
            $data['representative']['representative_id'] = $this->request->post['representative']['representative_id'];
        } elseif (!empty($representative_info)) {
            $data['representative']['representative_id'] = $representative_info['representative_id'];
        } else {
            $data['representative']['representative_id'] = '';
        }

        if (isset($this->request->post['representative']['status'])) {
            $data['representative']['status'] = $this->request->post['representative']['status'];
        } elseif (!empty($representative_info)) {
            $data['representative']['status'] = $representative_info['status'];
        } else {
            $data['representative']['status'] = false;
        }
        if (isset($this->request->post['representative']['sort_order'])) {
            $data['representative']['sort_order'] = $this->request->post['representative']['sort_order'];
        } elseif (!empty($representative_info)) {
            $data['representative']['sort_order'] = $representative_info['sort_order'];
        } else {
            $data['representative']['sort_order'] = '0';
        }
        if (isset($this->request->post['representative']['lat'])) {
            $data['representative']['lat'] = $this->request->post['representative']['lat'];
        } elseif (!empty($representative_info)) {
            $data['representative']['lat'] = $representative_info['lat'];
        } else {
            $data['representative']['lat'] = '';
        }
        if (isset($this->request->post['representative']['lng'])) {
            $data['representative']['lng'] = $this->request->post['representative']['lng'];
        } elseif (!empty($representative_info)) {
            $data['representative']['lng'] = $representative_info['lng'];
        } else {
            $data['representative']['lng'] = '';
        }

        // Representative Description fields
        if (isset($this->request->post['representative']['description'])) {
            $data['representative']['description'] = $this->request->post['representative']['description'];
        } elseif (isset($this->request->get['representative']['representative_id'])) {
            $data['representative']['description'] = $this->model_extension_module_representatives->getRepresentativeDescription($this->request->get['representative']['representative_id']);
        } else {
            $data['representative']['description'] = [];
        }

    }

    protected function getForm() {

        $this->getPageLanguageVariables($data);
        $this->getFormLanguageVariables($data);
        $this->getFormErrors($data);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['city_id'])) {
            $data['city_id'] = $this->request->get['city_id'];
            $data['representatives'] = $this->model_extension_module_representatives->getAllRepresentatives($this->request->get['city_id']);
        } else {
            $data['city_id'] = null;
            $data['representatives'] = null;
        }

        $this->getBreadcrumbs($data, $url);

        if (!isset($this->request->get['city_id'])) {
            $data['action'] = $this->url->link('extension/module/representatives/add', 'token=' . $this->session->data['token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('extension/module/representatives/edit', 'token=' . $this->session->data['token'] . '&city_id=' . $this->request->get['city_id'] . $url, true);
            $data['add_representative_action'] = $this->url->link('extension/module/representatives/addRepresentative', 'token=' . $this->session->data['token'], true);
        }

        $data['cancel'] = $this->url->link('extension/module/representatives', 'token=' . $this->session->data['token'] . $url, true);

        $city_info = null;
        $representative_info = null;

        if (isset($this->request->get['city_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $city_info = $this->model_extension_module_representatives->getCity($this->request->get['city_id']);
        }

        if (isset($this->request->get['representative']['representative_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $representative_info = $this->model_extension_module_representatives->getRepresentative($this->request->get['representative']['representative_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->getFormValues($data, $city_info, $representative_info);

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/representatives/representatives_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'extension/module/representatives')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['city_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
        }

        if ((utf8_strlen($this->request->post['alias']) < 3) || (utf8_strlen($this->request->post['alias']) > 255)) {
            $this->error['alias'] = $this->language->get('error_alias');
        }

        return !$this->error;
    }

    protected function validateRepresentativeForm() {
        $json = [];

        foreach ($this->request->post['representative']['description'] as $language_id => $value) {
            if ((utf8_strlen($value['address']) < 3) || (utf8_strlen($value['address']) > 500)) {
                $json['errors']['address'][$language_id] = $this->language->get('error_address');
            }
        }
        if ((utf8_strlen(trim($this->request->post['representative']['lat'])) < 3)) {
            $json['errors']['lat'] = $this->language->get('error_lat');
        }
        if ((utf8_strlen(trim($this->request->post['representative']['lng'])) < 3)) {
            $json['errors']['lng'] = $this->language->get('error_lng');
        }

        return $json;
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/representatives')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }

    public function install() {
        $this->load->model('extension/module/representatives');
        $this->model_extension_module_representatives->install();
    }
    public function uninstall() {
        $this->load->model('extension/module/representatives');
        $this->model_extension_module_representatives->uninstall();
    }

    private function getFormErrors(&$data) {
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->error['status'])) {
            $data['error_status'] = $this->error['status'];
        } else {
            $data['error_status'] = '';
        }
        if (isset($this->error['sort_order'])) {
            $data['error_sort_order'] = $this->error['sort_order'];
        } else {
            $data['error_sort_order'] = '';
        }
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }
        if (isset($this->error['alias'])) {
            $data['error_alias'] = $this->error['alias'];
        } else {
            $data['error_alias'] = '';
        }
    }
}