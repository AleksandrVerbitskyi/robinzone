<?php
class ControllerExtensionModuleSocialNetworkInfoAdaptive extends Controller {

    public function index() {
        $this->load->model('extension/module/socialnetworkinfo');
        $data = [];
        $social_networks = $this->model_extension_module_socialnetworkinfo->getSocialNetworks();
        $data['social_networks'] = $social_networks;

        return $this->load->view('extension/module/socialnetworkinfo_adaptive', $data);
    }
}