<?php
class ControllerExtensionModuleAutoLuxApi extends Controller {
    public function getAddress() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $json = [];
            $this->load->language('extension/module/novaposhta_api');
            $json['text_area'] = $this->language->get('select_area');
            $json['text_city'] = $this->language->get('select_city');
            $json['text_warehouse'] = $this->language->get('select_warehouse');

            $this->load->model('extension/module/autolux_api');
            $json['areas'] = $this->model_extension_module_autolux_api->getAreas();
            if (isset($this->request->post['area_id'])) {
                $cities = $this->model_extension_module_autolux_api->getCities($this->request->post['area_id']);
                $json['cities'] = $cities;
            }
            if (isset($this->request->post['city_id'])) {
                $warehouses = $this->model_extension_module_autolux_api->getWarehouses($this->request->post['city_id']);
//                foreach ($warehouses as $index => $warehouse) {
//                    $warehouses[$index]['name'] = $warehouse['name'] . ' (' . $warehouse['address'] . ')';
//                }
                $json['warehouses'] = $warehouses;
            }


            $json['success'] = 'success';
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }
}
