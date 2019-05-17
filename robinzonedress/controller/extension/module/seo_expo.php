<?php
class ControllerExtensionModuleSeoExpo extends Controller {
    private $error = array();
    private $_session_token;
    private $_ssl_code;

    public function __construct($registry) {
        parent::__construct($registry);

        if (version_compare(VERSION, '2.2.0.0', '>=')) {
            $this->_ssl_code = true;
        } else {
            $this->_ssl_code = 'SSL';
        }

        if (version_compare(VERSION, '3.0.0.0', '>=')) {
            $this->_session_token = 'user_token='.$this->session->data['user_token'];
        } else {
            $this->_session_token = 'token='.$this->session->data['token'];
        }
    }

    public function index() {
        $data = array();
        $data = array_merge($data, $this->load->language('extension/module/seo_expo'));

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $this->load->model('extension/module/seo_expo');

        $scripts = array();

        if (version_compare(VERSION, '2.3.0.2', '<')) {
            $scripts[] = 'http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js';
        }

        if (version_compare(VERSION, '2.3.0.2', '>=')) {
            $scripts[] = 'view/javascript/summernote/summernote.js';
            $scripts[] = 'view/javascript/summernote/opencart.js';
        }

        foreach ($scripts as $script) {
            if ($script) {
                $this->document->addScript($script);
            }
        }

        $styles = array();

        if (version_compare(VERSION, '2.3.0.2', '<')) {
            $styles[] =  'http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css';
        }

        if (version_compare(VERSION, '2.3.0.2', '>=')) {
            $styles[] = 'view/javascript/summernote/summernote.css';
        }

        foreach ($styles as $style) {
            if ($style) {
                $this->document->addStyle($style);
            }
        }


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('seo_expo', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['actionstay']) && $this->request->post['actionstay'] == 1) {
                $this->response->redirect($this->url->link('extension/module/seo_expo', $this->_session_token, $this->_ssl_code));
            } else {
                $this->response->redirect($this->url->link('extension/extension', $this->_session_token.'&type=module', $this->_ssl_code));
            }
        }

        $data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->session->data['warning'])) {
            $data['warning'] = $this->session->data['warning'];

            unset($this->session->data['warning']);
        } else {
            $data['warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', $this->_session_token, $this->_ssl_code)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', $this->_session_token.'&type=module', $this->_ssl_code)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/seo_expo', $this->_session_token, $this->_ssl_code)
        );

        $data['action'] = $this->url->link('extension/module/seo_expo', $this->_session_token, $this->_ssl_code);
        $data['cancel'] = $this->url->link('extension/extension', $this->_session_token.'&type=module', $this->_ssl_code);

        $data['token'] = $this->_session_token;

        if (!$this->checkIfTableExist(DB_PREFIX."seo_expo_product_seo")) {
            $sql1  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."seo_expo_product_seo` (";
            $sql1 .= "`seo_id` int(11) NOT NULL AUTO_INCREMENT, ";
            $sql1 .= "`status` tinyint(1) NOT NULL DEFAULT '1', ";
            $sql1 .= "`date_added` datetime NOT NULL, ";
            $sql1 .= "`date_modified` datetime NOT NULL, ";
            $sql1 .= "PRIMARY KEY (`seo_id`) ";
            $sql1 .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";

            $this->db->query($sql1);
        }

        if (!$this->checkIfTableExist(DB_PREFIX."seo_expo_product_description")) {
            $sql2  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."seo_expo_product_description` (";
            $sql2 .= "`seo_id` int(11) NOT NULL, ";
            $sql2 .= "`language_id` int(11) NOT NULL, ";
            $sql2 .= "`seo_url` text COLLATE utf8_general_ci NOT NULL, ";
            $sql2 .= "`seo_title` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
            $sql2 .= "`seo_h1` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
            $sql2 .= "`seo_meta_description` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
            $sql2 .= "`seo_meta_keywords` varchar(255) COLLATE utf8_general_ci NOT NULL, ";
            $sql2 .= "`seo_description` text COLLATE utf8_general_ci NOT NULL ";
            $sql2 .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci; ";

            $this->db->query($sql2);
        }

        if (isset($this->request->post['seo_expo_status'])) {
            $data['seo_expo_status'] = $this->request->post['seo_expo_status'];
        } else {
            $data['seo_expo_status'] = $this->config->get('seo_expo_status');
        }

        if (isset($this->request->post['seo_expo_data'])) {
            $data['seo_expo_data'] = $this->request->post['seo_expo_data'];
        } else {
            $data['seo_expo_data'] = $this->config->get('seo_expo_data');
        }

        $data['data_feed'] = HTTP_CATALOG . 'index.php?route=extension/module/seo_expo/sitemap';

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/seo_expo', $data));
    }

    public function checkIfColumnExist($table_name, $table_column) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".$table_name."' AND COLUMN_NAME  = '".$table_column."'")->row['total'];

        return $query;
    }

    public function checkIfTableExist($table_name) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".$table_name."'")->row['total'];

        return $query;
    }

    public function install() {
        $this->load->language('extension/module/seo_expo');
        $this->load->model('extension/module/seo_expo');

        $this->model_extension_module_seo_expo->makeDB();

        $this->session->data['success'] = $this->language->get('text_success_install');
    }

    public function uninstall() {
        $this->load->model('extension/module/seo_expo');

        $this->model_extension_module_seo_expo->removeDB();
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/seo_expo')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (isset($this->error) && $this->error) {
            $this->session->data['warning'] = $this->language->get('error_check_from');
        }
        return !$this->error;
    }

    public function history_seo() {
        $data = array();

        $this->load->model('extension/module/seo_expo');
        $this->load->model('localisation/language');

        $data = array_merge($data, $this->language->load('extension/module/seo_expo'));

        $data['text_seo'] = (isset($this->request->get['seo_id']) && $this->request->get['seo_id']) ? $this->language->get('text_edit_seo') : $this->language->get('text_add_seo');

        $data['default_language_id'] = $this->config->get('config_language_id');
        $data['token'] = $this->_session_token;

        if (isset($this->request->get['seo_id'])) {
            $data['seo_id'] = $this->request->get['seo_id'];
        } else {
            $data['seo_id'] = 0;
        }

        if ((isset($this->request->get['seo_id']) && $this->request->get['seo_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $form_info = $this->model_extension_module_seo_expo->getSeo($this->request->get['seo_id']);
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (isset($this->request->get['seo_id']) && $form_info) {
            $data['status'] = $form_info['status'];
        } else {
            $data['status'] = '1';
        }

        if (isset($this->request->post['form_description'])) {
            $data['form_description'] = $this->request->post['form_description'];
        } elseif (isset($this->request->get['seo_id']) && $form_info) {
            $data['form_description'] = $this->model_extension_module_seo_expo->getSeoDescription($this->request->get['seo_id']);
        } else {
            foreach ($this->model_localisation_language->getLanguages() as $language) {
                $data['form_description'][$language['language_id']] = array(
                    'seo_url' => '',
                    'seo_title' => '',
                    'seo_h1' => '',
                    'seo_meta_description' => '',
                    'seo_meta_keywords' => '',
                    'seo_description' => ''
                );
            }
        }

        $data['languages'] = array();

        foreach ($this->model_localisation_language->getLanguages() as $language) {
            if (version_compare(VERSION, '2.1.0.2', '<=')) {
                $data['languages'][] = array(
                    'language_id' => $language['language_id'],
                    'code'        => $language['code'],
                    'name'        => $language['name'],
                    'image'       => 'view/image/flags/'.$language['image']
                );
            } else {
                $data['languages'][] = array(
                    'language_id' => $language['language_id'],
                    'code'        => $language['code'],
                    'name'        => $language['name'],
                    'image'       => 'language/'.$language['code'].'/'.$language['code'].'.png'
                );
            }
        }

        if (version_compare(VERSION, '3.0.0.0', '>=')) {
            $this->response->setOutput($this->load->view('extension/module/seo_expo_index', $data));
        } else {
            $this->response->setOutput($this->load->view('extension/module/seo_expo_index.tpl', $data));
        }
    }

    public function history_seo_action() {
        $json = array();

        $this->language->load('extension/module/seo_expo');

        $this->load->model('extension/module/seo_expo');
        $this->load->model('localisation/language');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            foreach ($this->request->post['form_description'] as $language_id => $value) {
                if (utf8_strlen($value['seo_url']) < 1) {
                    $json['error']['form_description_language']['seo_url'][$language_id] = $this->language->get('error_for_all_field');
                }

                if ((utf8_strlen($value['seo_title']) < 1) || (utf8_strlen($value['seo_title']) > 255)) {
                    $json['error']['form_description_language']['seo_title'][$language_id] = $this->language->get('error_for_all_field');
                }

                if ((utf8_strlen($value['seo_h1']) < 1) || (utf8_strlen($value['seo_h1']) > 255)) {
                    $json['error']['form_description_language']['seo_h1'][$language_id] = $this->language->get('error_for_all_field');
                }

                if ((utf8_strlen($value['seo_meta_description']) < 1) || (utf8_strlen($value['seo_meta_description']) > 255)) {
                    $json['error']['form_description_language']['seo_meta_description'][$language_id] = $this->language->get('error_for_all_field');
                }

                if ((utf8_strlen($value['seo_meta_keywords']) < 1) || (utf8_strlen($value['seo_meta_keywords']) > 255)) {
                    $json['error']['form_description_language']['seo_meta_keywords'][$language_id] = $this->language->get('error_for_all_field');
                }

                if (utf8_strlen($value['seo_description']) < 1) {
                    $json['error']['form_description_language']['seo_description'][$language_id] = $this->language->get('error_for_all_field');
                }
            }

            if (isset($json['error']) && !isset($json['error']['warning'])) {
                $json['error']['warning'] = $this->language->get('error_warning');
            }

            if (!isset($json['error'])) {
                if (isset($this->request->post['seo_id']) && $this->request->post['seo_id']) {
                    $this->model_extension_module_seo_expo->editSeo($this->request->post['seo_id'], $this->request->post);
                } else {
                    $this->model_extension_module_seo_expo->addSeo($this->request->post);
                }

                $json['success'] = $this->language->get('text_success_form');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function history_seo_list() {
        $data = array();

        $this->load->model('extension/module/seo_expo');

        $data = array_merge($data, $this->language->load('extension/module/seo_expo'));
        $page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;
        $data['token'] = $this->_session_token;

        $data['histories'] = array();

        $filter_data = array(
            'filter_seo_url' => (isset($this->request->get['filter_seo_url'])) ? trim($this->request->get['filter_seo_url']) : '',
            'start'       => ($page - 1)*10,
            'limit'       => 10,
            'sort'        => 'f.date_added',
            'order'       => 'DESC'
        );

        $results = $this->model_extension_module_seo_expo->getSeos($filter_data);

        foreach ($results as $result) {
            $protocol = strtolower(substr($this->request->server["SERVER_PROTOCOL"], 0, 5)) == 'https' ? HTTPS_CATALOG : HTTP_CATALOG;

            $data['histories'][] = array(
                'seo_id'        => $result['seo_id'],
                'seo_title'     => $result['seo_title'],
                'seo_url_name'  => utf8_substr(strip_tags($result['seo_url']), 0, 100) . '...',
                'seo_url'       => $protocol.$result['seo_url'],
                'date_added'    => $result['date_added'],
                'date_modified' => $result['date_modified'],
                'status'        => $result['status'] ? $this->language->get('text_status_enabled') : $this->language->get('text_status_disabled')
            );
        }

        $history_total = $this->model_extension_module_seo_expo->getTotalSeos($filter_data);

        $pagination = new Pagination();
        $pagination->total = $history_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('extension/module/seo_expo/history_seo', $this->_session_token.'&page={page}', $this->_ssl_code);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1)*10) + 1 : 0, ((($page - 1)*10) > ($history_total - 10)) ? $history_total : ((($page - 1)*10) + 10), $history_total, ceil($history_total/10));

        if (version_compare(VERSION, '3.0.0.0', '>=')) {
            $this->response->setOutput($this->load->view('extension/module/seo_expo_history', $data));
        } else {
            $this->response->setOutput($this->load->view('extension/module/seo_expo_history.tpl', $data));
        }
    }

    public function delete_all() {
        $json = array();

        $this->load->model('extension/module/seo_expo');

        $this->language->load('extension/module/seo_expo');

        if (isset($this->request->get['type']) && $this->request->get['type']) {
            $type = $this->request->get['type'];
        } else {
            $type = '';
        }

        if (!$this->user->hasPermission('modify', 'extension/module/seo_expo')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if ($type) {
                $result = $this->model_extension_module_seo_expo->deleteSeos();

                if (!isset($result) || !$result) {
                    $json['error'] = $this->language->get('error_task');
                } else {
                    $json['success'] = $this->language->get('text_success_task');
                }
            } else {
                $json['error'] = $this->language->get('error_task');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function delete_selected() {
        $json = array();

        $this->load->model('extension/module/seo_expo');

        $this->language->load('extension/module/seo_expo');

        if (isset($this->request->get['type']) && $this->request->get['type']) {
            $type = $this->request->get['type'];
        } else {
            $type = '';
        }

        if (!$this->user->hasPermission('modify', 'extension/module/seo_expo')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if ($type) {
                $info = $this->model_extension_module_seo_expo->getSeo((int)$this->request->get['delete']);

                if ($info) {
                    $result = $this->model_extension_module_seo_expo->deleteSeo((int)$this->request->get['delete']);
                }

                if (!isset($result) || !$result) {
                    $json['error'] = $this->language->get('error_task');
                } else {
                    $json['success'] = $this->language->get('text_success_task');
                }
            } else {
                $json['error'] = $this->language->get('error_task');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function delete_all_selected() {
        $json = array();

        $this->load->model('extension/module/seo_expo');

        $this->language->load('extension/module/seo_expo');

        if (isset($this->request->get['type']) && $this->request->get['type']) {
            $type = $this->request->get['type'];
        } else {
            $type = '';
        }

        if (!$this->user->hasPermission('modify', 'extension/module/seo_expo')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if ($type) {
                if (isset($this->request->request['selected'])) {
                    foreach ($this->request->request['selected'] as $seo_id) {
                        $info = $this->model_extension_module_seo_expo->getSeo((int)$seo_id);

                        if ($info) {
                            $result = $this->model_extension_module_seo_expo->deleteSeo((int)$seo_id);
                        }
                    }
                }

                if (!isset($result) || !$result) {
                    $json['error'] = $this->language->get('error_task');
                } else {
                    $json['success'] = $this->language->get('text_success_task');
                }
            } else {
                $json['error'] = $this->language->get('error_task');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function copy_selected() {
        $json = array();

        $this->load->model('extension/module/seo_expo');

        $this->language->load('extension/module/seo_expo');

        if (!$this->user->hasPermission('modify', 'extension/module/seo_expo')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['copy']) && $this->request->get['copy']) {
                $info = $this->model_extension_module_seo_expo->getSeo((int)$this->request->get['copy']);

                if ($info) {
                    $result = $this->model_extension_module_seo_expo->copySeo((int)$this->request->get['copy']);
                }

                if (!isset($result) || !$result) {
                    $json['error'] = $this->language->get('error_task');
                } else {
                    $json['success'] = $this->language->get('text_success_task');
                }
            } else {
                $json['error'] = $this->language->get('error_task');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function autocomplete_seo_url() {
        $json = array();

        if (isset($this->request->request['filter_seo_url'])) {
            $this->load->model('extension/module/seo_expo');

            $filter_data = array(
                'filter_seo_url'       => $this->request->request['filter_seo_url'],
                'filter_group_seo_url' => true
            );

            $results = $this->model_extension_module_seo_expo->getSeos($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'seo_url' => $result['seo_url'],
                    'seo_id'  => $result['seo_id']
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}