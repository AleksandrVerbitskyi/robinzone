<?php
class ControllerExtensionModuleSocialNetworkInfo extends Controller {

    public function index() {
        $this->load->model('extension/module/socialnetworkinfo');
        $data = [];
        $social_networks = $this->model_extension_module_socialnetworkinfo->getSocialNetworks();
        $data['social_networks'] = $social_networks;

        return $this->load->view('extension/module/socialnetworkinfo', $data);
//        $this->response->setOutput($this->load->view('extension/module/socialnetworkinfo', $data));
    }
}