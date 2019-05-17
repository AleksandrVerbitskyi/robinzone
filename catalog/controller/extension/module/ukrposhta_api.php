<?php
class ControllerExtensionModuleUkrPoshtaApi extends Controller {
    public function getAddress() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $json = [];
            $this->load->language('extension/shipping/ukrposhta');
            $json['text_area'] = $this->language->get('select_area');
            $json['text_city'] = $this->language->get('select_city');
            $json['text_warehouse'] = $this->language->get('entry_warehouse');

            $this->load->model('extension/module/ukrposhta_api');
            $json['areas'] = $this->model_extension_module_ukrposhta_api->getAreas();
            if (isset($this->request->post['area_id'])) {
                $json['cities'] = $this->model_extension_module_ukrposhta_api->getCities($this->request->post['area_id']);
            }


            $json['success'] = 'success';
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }
}
