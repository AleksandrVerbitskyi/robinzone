<?php
class ControllerExtensionModuleNovaposhtaApi extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/novaposhta_api');

        $this->document->setTitle($this->language->get('main_heading_title'));

        $this->load->model('extension/module/novaposhta_api');

        $this->getList();
    }

    public function citiesList()
    {
        $this->load->language('extension/module/novaposhta_api');

        $this->document->setTitle($this->language->get('main_heading_title'));

        $this->load->model('extension/module/novaposhta_api');

        $this->getCitiesList();
    }

    public function warehousesList()
    {
        $this->load->language('extension/module/novaposhta_api');

        $this->document->setTitle($this->language->get('main_heading_title'));

        $this->load->model('extension/module/novaposhta_api');

        $this->getWarehousesList();
    }

    private function getBreadcrumbs(&$data, $url) {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/novaposhta_api', 'token=' . $this->session->data['token'] . $url, true)
        );
    }

    public function synchronize() {
        require_once '_novaposhta_api_synch.php';
        synchronizeApi();
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

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . $url, true);
        $data['synchronize'] = $this->url->link('extension/module/novaposhta_api/synchronize', 'token=' . $this->session->data['token'] . $url, true);

        $data['areas'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $areas_total = $this->model_extension_module_novaposhta_api->getTotalAreas();

        $results = $this->model_extension_module_novaposhta_api->getAllAreas($filter_data);

        foreach ($results as $result) {
            $data['areas'][] = array(
                'area_id' => $result['area_id'],
                'ref'     => $result['ref'],
                'name'    => $result['description'],
                'cities'  => $this->url->link('extension/module/novaposhta_api/citiesList', 'token=' . $this->session->data['token'] . '&area_id=' . $result['area_id'] . $url, true)
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

        $data['sort_name'] = $this->url->link('extension/module/novaposhta_api', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $areas_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/module/novaposhta_api', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($areas_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($areas_total - $this->config->get('config_limit_admin'))) ? $areas_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $areas_total, ceil($areas_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['start_n'] = ($page - 1) * $this->config->get('config_limit_admin');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/novaposhta/novaposhta_api_areas', $data));
    }

    protected function getCitiesList() {

        $this->getPageLanguageVariables($data);

        if (isset($this->request->get['area_id'])) {
            $area_id = $this->request->get['area_id'];
        } else {
            $area_id = 0;
        }
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'description';
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

        $area_name = $this->model_extension_module_novaposhta_api->getAreaName($area_id);

        $data['breadcrumbs'][] = array(
            'text' => sprintf($this->language->get('heading_title_cities'), $area_name),
            'href' => $this->url->link('extension/module/novaposhta_api/citiesList/', 'token=' . $this->session->data['token'] . '&area_id=' . $area_id . $url, true)
        );

        $data['text_list_cities'] = sprintf($this->language->get('text_list_cities'), $area_name);


        $data['cancel'] = $this->url->link('extension/module/novaposhta_api', 'token=' . $this->session->data['token'] . $url, true);
        $data['synchronize'] = $this->url->link('extension/module/novaposhta_api/synchronize', 'token=' . $this->session->data['token'] . $url, true);

        $data['cities'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $cities_total = $this->model_extension_module_novaposhta_api->getTotalCities($area_id);

        $results = $this->model_extension_module_novaposhta_api->getAllCities($filter_data, $area_id);

        foreach ($results as $result) {
            $data['cities'][] = array(
                'city_id' => $result['area_id'],
                'ref'     => $result['ref'],
                'name'    => $result['description'],
                'type'    => $result['settlement_type'],
                'warehouses'  => $this->url->link('extension/module/novaposhta_api/warehousesList', 'token=' . $this->session->data['token'] . '&city_id=' . $result['city_id'] . $url, true)
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

        $data['sort_name'] = $this->url->link('extension/module/novaposhta_api/citiesList', 'token=' . $this->session->data['token'] . '&area_id=' . $area_id . '&sort=name' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $cities_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/module/novaposhta_api/citiesList', 'token=' . $this->session->data['token'] . '&area_id=' . $area_id . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($cities_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($cities_total - $this->config->get('config_limit_admin'))) ? $cities_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $cities_total, ceil($cities_total / $this->config->get('config_limit_admin')));

        $data['start_n'] = ($page - 1) * $this->config->get('config_limit_admin');

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/novaposhta/novaposhta_api_cities', $data));
    }

    protected function getWarehousesList() {

        $this->getPageLanguageVariables($data);

        if (isset($this->request->get['city_id'])) {
            $city_id = $this->request->get['city_id'];
        } else {
            $city_id = 0;
        }
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'description';
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

        $area_id = $this->model_extension_module_novaposhta_api->getAreaIdByCity($city_id);
        $area_name = $this->model_extension_module_novaposhta_api->getAreaName($area_id);

        $data['breadcrumbs'][] = array(
            'text' => sprintf($this->language->get('heading_title_cities'), $area_name),
            'href' => $this->url->link('extension/module/novaposhta_api/citiesList/', 'token=' . $this->session->data['token'] . '&area_id=' . $area_id . $url, true)
        );

        $city_name = $this->model_extension_module_novaposhta_api->getCityName($city_id);

        $data['breadcrumbs'][] = array(
            'text' => sprintf($this->language->get('heading_title_warehouses'), $city_name),
            'href' => $this->url->link('extension/module/novaposhta_api/warehousesList/', 'token=' . $this->session->data['token'] . '&city_id=' . $city_id . $url, true)
        );

        $data['text_list_warehouses'] = sprintf($this->language->get('text_list_warehouses'), $city_name);


        $data['cancel'] = $this->url->link('extension/module/novaposhta_api/citiesList', 'token=' . $this->session->data['token'] . $url, true);
        $data['synchronize'] = $this->url->link('extension/module/novaposhta_api/synchronize', 'token=' . $this->session->data['token'] . $url, true);

        $data['warehouses'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $warehouses_total = $this->model_extension_module_novaposhta_api->getTotalWarehouses($city_id);

        $results = $this->model_extension_module_novaposhta_api->getAllWarehouses($filter_data, $city_id);

        foreach ($results as $result) {
            $data['warehouses'][] = array(
                'warehouse_id' => $result['warehouse_id'],
                'ref'     => $result['ref'],
                'name'    => $result['description'],
                'type'    => $result['warehouse_type']
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

        $data['sort_name'] = $this->url->link('extension/module/novaposhta_api/warehousesList', 'token=' . $this->session->data['token'] . '&city_id=' . $city_id . '&sort=name' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $warehouses_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/module/novaposhta_api/warehousesList', 'token=' . $this->session->data['token'] . '&city_id=' . $city_id . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($warehouses_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($warehouses_total - $this->config->get('config_limit_admin'))) ? $warehouses_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $warehouses_total, ceil($warehouses_total / $this->config->get('config_limit_admin')));

        $data['start_n'] = ($page - 1) * $this->config->get('config_limit_admin');

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/novaposhta/novaposhta_api_warehouses', $data));
    }

    private function getPageLanguageVariables(&$data) {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['button_synchronize'] = $this->language->get('button_synchronize');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['text_success'] = $this->language->get('text_success');
        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_watch_cities'] = $this->language->get('text_watch_cities');
        $data['text_watch_warehouses'] = $this->language->get('text_watch_warehouses');

        $data['column_area_name'] = $this->language->get('column_area_name');
        $data['column_area_ref'] = $this->language->get('column_area_ref');
        $data['column_area_cities'] = $this->language->get('column_area_cities');

        $data['column_city_name'] = $this->language->get('column_city_name');
        $data['column_city_type'] = $this->language->get('column_city_type');
        $data['column_city_code'] = $this->language->get('column_city_code');
        $data['column_city_ref'] = $this->language->get('column_city_ref');

        $data['column_warehouse_name'] = $this->language->get('column_warehouse_name');
        $data['column_warehouse_type'] = $this->language->get('column_warehouse_type');
        $data['column_warehouse_ref'] = $this->language->get('column_warehouse_ref');

        $data['column_city_warehouses'] = $this->language->get('column_city_warehouses');
    }

    public function loadRepresentative() {
        $this->load->language('extension/module/novaposhta_api');

        $this->load->model('extension/module/novaposhta_api');

        $json = [];

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['representative_id'])) {
            $representative_id = $this->request->post['representative_id'];
            $json = $this->model_extension_module_novaposhta_api->getRepresentative($representative_id);
            $json['entry_status_on'] = $this->language->get('entry_status_on');
            $json['entry_status_off'] = $this->language->get('entry_status_off');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/novaposhta_api')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }

    public function install() {
        $this->load->model('extension/module/novaposhta_api');
        $this->model_extension_module_novaposhta_api->install();
    }
    public function uninstall() {
        $this->load->model('extension/module/novaposhta_api');
        $this->model_extension_module_novaposhta_api->uninstall();
    }

    private function getFormErrors(&$data) {
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
    }
}