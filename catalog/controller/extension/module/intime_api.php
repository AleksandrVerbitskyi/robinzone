<?php
class ControllerExtensionModuleIntimeApi extends Controller {
    public function getAddress() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $json = [];
            $this->load->language('extension/module/novaposhta_api');
            $json['text_area'] = $this->language->get('select_area');
            $json['text_city'] = $this->language->get('select_city');
            $json['text_warehouse'] = $this->language->get('select_warehouse');

            $types = $this->getCityTypes();

            $this->load->model('extension/module/intime_api');
            $json['areas'] = $this->model_extension_module_intime_api->getAreas();
            if (isset($this->request->post['area_id'])) {
                $cities = $this->model_extension_module_intime_api->getCities($this->request->post['area_id']);
                foreach ($cities as $index => $city) {
                    if ($city['type'] == 3 || $city['type'] == 4) {
                        unset($cities[$index]);
                        continue;
                    }
                    $cities[$index]['name'] = $types[$city['type']][$this->config->get('config_language_id')] . ' ' . $city['name'];
                }
                $json['cities'] = $cities;
            }
            if (isset($this->request->post['city_id'])) {
                $warehouses = $this->model_extension_module_intime_api->getWarehouses($this->request->post['city_id']);
                foreach ($warehouses as $index => $warehouse) {
                    $warehouses[$index]['name'] = $warehouse['name'] . ' (' . $warehouse['address'] . ')';
                }
                $json['warehouses'] = $warehouses;
            }


            $json['success'] = 'success';
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    private $types_ua = ['місто', 'місто', 'смт.', 'селище', 'село'];
    private $types_ru = ['город', 'город', 'смт.', 'поселок', 'село'];

    private function getCityTypes() {
        $result = [];
        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        for ($i = 0; $i < count($this->types_ua); $i++) {
            foreach ($languages as $language) {
                if ($language['code'] == 'ua-uk') {
                    $value = $this->types_ua[$i];
                } else if ($language['code'] == 'ru-ru') {
                    $value = $this->types_ru[$i];
                }
                $result[$i][$language['language_id']] = $value;
            }
        }
        return $result;
    }
}
