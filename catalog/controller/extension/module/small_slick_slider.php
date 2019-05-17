<?php
class ControllerExtensionModuleSmallSlickSlider extends Controller {
	public function index($setting) {
		static $module = 0;		

		$this->load->model('extension/module/banner_plus');
		$this->load->model('tool/image');

		$data['banners'] = array();

		$data['slider_type'] = $setting['slider_type'];
		$data['slider_name'] = $setting['description'][$this->config->get('config_language_id')]['name'];

		$results = $this->model_extension_module_banner_plus->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
                    'button_text' => trim($result['button_text']),
					'link'  => trim($result['link']) != '' ? $this->url->link(trim($result['link'])) : '',
					'image' => 'image/' . $result['image']
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/small_slick_slider', $data);
	}
}
