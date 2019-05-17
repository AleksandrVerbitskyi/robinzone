<?php
class ControllerExtensionModuleSlickSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;		

		$this->load->model('extension/module/banner_plus');
		$this->load->model('tool/image');

		$data['banners'] = array();

		$results = $this->model_extension_module_banner_plus->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
                $result['link'] = trim($result['link'], '/');
			    if ($result['link'] !== '') {
                    if (key_exists($result['link'], $this->cache->get('seo_pro')['keywords'])) {
                        $seo_url = $this->cache->get('seo_pro')['keywords'][$result['link']];
                        $result['link'] = $seo_url;
                    }
                    $result['link'] = $this->url->link($result['link']);
                } else {
                    $result['link'] = '';
                }

				$data['banners'][] = array(
					'title' => $result['title'],
                    'button_text' => trim($result['button_text']),
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/slick_slideshow', $data);
	}
}
