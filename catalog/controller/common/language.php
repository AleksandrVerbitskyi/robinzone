<?php
class ControllerCommonLanguage extends Controller {
	public function index() {
		$this->load->language('common/language');

		$data['text_language'] = $this->language->get('text_language');

		$data['action'] = $this->url->link('common/language/language', '', isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')));

		$data['code'] = $this->session->data['language'];

		$this->load->model('localisation/language');

		$data['languages'] = array();

		$results = $this->model_localisation_language->getLanguages();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['languages'][] = array(
					'name' => $this->getLanguageName($result['code']),
					'code' => $result['code']
				);
				if($result['code'] == $data['code']) $data['current_lang_name'] = $this->getLanguageName($result['code']);
			}
		}

		if (!isset($this->request->get['route'])) {
			$data['redirect'] = $this->url->link('common/home');
		} else {
			$url_data = $this->request->get;

			$route = $url_data['route'];

			unset($url_data['route']);

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['redirect'] = $this->url->link($route, $url, isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')));
		}

		return $this->load->view('common/language', $data);
	}

	public function language() {
        $json = [];
		if (isset($this->request->post['code'])) {
			$this->session->data['language'] = $this->request->post['code'];
		}

        if (isset($this->request->post['redirect'])) {
            $json['redirect'] = $this->request->post['redirect'];
        } else {
            $json['redirect'] = $this->url->link('common/home');
        }

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    private function getLanguageName($code) {
//        $this->load->language('common/language');
//        return $this->language->get('text_language_' . str_replace('-', '_', $code));
        return strtoupper(explode('-', $code)[0]);
    }
}