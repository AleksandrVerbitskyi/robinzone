<?php
class ControllerInformationContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->sendMail();
			$this->response->redirect($this->url->link('information/contact/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_our_email'] = $this->language->get('text_our_email');
		$data['text_our_site'] = $this->language->get('text_our_site');


		$data['text_write_us'] = $this->language->get('text_write_us');
		$data['text_phone_us_full'] = $this->language->get('text_phone_us_full');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_question'] = $this->language->get('entry_question');

		$data['entry_captcha'] = $this->language->get('entry_captcha');
		$data['button_map'] = $this->language->get('button_map');

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

        if (isset($this->error['question'])) {
            $data['error_question'] = $this->error['question'];
        } else {
            $data['error_question'] = '';
        }

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('information/contact', '', true);

		$this->load->model('tool/image');

		if ($this->config->get('config_image')) {
			$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
		} else {
			$data['image'] = false;
		}

		$this->load->model('localisation/location');

        $data['store'] = $this->config->get('config_name');
        $data['store_telephone'] = $this->config->get('config_telephone');
        $data['config_email'] = $this->config->get('config_email');
        $data['config_address'] = html_entity_decode($this->config->get('config_address'));
        $data['config_comment'] = $this->config->get('config_comment');
        $data['geocode'] = $this->config->get('config_geocode');
        $data['geocode_hl'] = $this->config->get('config_language');
        $data['fax'] = $this->config->get('config_fax');
        $data['open'] = nl2br($this->config->get('config_open'));

        $data['site_address'] = HTTP_SERVER;

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = $this->customer->getTelephone();
		}

        if (isset($this->request->post['question'])) {
            $data['question'] = $this->request->post['question'];
        } else {
            $data['question'] = '';
        }

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		$this->getContactUsForm($data);

		$this->document->setBreadcrumbs($data['breadcrumbs']);

		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/contact', $data));
	}

    private function getContactUsForm(&$data) {
        $this->load->language('information/contact');

        $data['contact_us_url'] = 'index.php?route=information/contact/contactUs';
    }

	public function contactUs() {
	    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	        $json = [];
            $this->load->language('information/contact');
	        $this->validate();
	        if (!$this->error) {
	            $this->sendMail();
	            $json['success'] = 'success';
                $json['redirect'] = $this->url->link('information/contact/success', '', true);
            } else {
	            $json['errors'] = $this->error;
            }

	        $this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($json));
        }
    }

    public function subscribe() {
	    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	        $json = [];
            $this->load->language('information/contact');
	        $this->validateSubscribe();
	        if (!$this->error) {
	            $this->sendMail('subscribe');
	            $json['success'] = 'success';
                $json['redirect'] = $this->url->link('information/contact/successSubscribe', '', true);
            } else {
	            $json['errors'] = $this->error;
            }

	        $this->response->addHeader('Content-Type: application/json');
	        $this->response->setOutput(json_encode($json));
        }
    }

    private function sendMail($action = 'default') {
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        if ($action == 'default') {
            $name = html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8');
            $telephone = html_entity_decode($this->request->post['telephone'], ENT_QUOTES, 'UTF-8');
            $email = html_entity_decode($this->request->post['email'], ENT_QUOTES, 'UTF-8');
            $question = "";
            if (isset($this->request->post['question'])) {
                $question = html_entity_decode($this->request->post['question'], ENT_QUOTES, 'UTF-8');
            }
            $message = sprintf($this->language->get('text_message'), $name, $telephone, $email, $question);
        } else if ($action == 'subscribe') {
            $name = 'Customer';
            $email = html_entity_decode($this->request->post['email'], ENT_QUOTES, 'UTF-8');
            $message = sprintf($this->language->get('text_message_subscribe'), $email);
        }

        $mail->setTo($this->config->get('config_email'));
        $mail->setFrom($this->config->get('config_email'));
        $mail->setReplyTo($this->request->post['email']);
        $mail->setSender($name);
        $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $name), ENT_QUOTES, 'UTF-8'));
        $mail->setHtml($message);
        $mail->send();
    }

	protected function validate() {
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!preg_match($this->config->get('config_mail_regexp'), $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

        if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }

        if ((utf8_strlen($this->request->post['question']) < 3) || (utf8_strlen($this->request->post['question']) > 500)) {
            $this->error['question'] = $this->language->get('error_question');
        }

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
	}

    protected function validateSubscribe() {
        if (!preg_match($this->config->get('config_mail_regexp'), $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
        }
        return !$this->error;
    }

	public function success() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title_success'));

        $data['heading_title_main'] = $this->language->get('heading_title');
        $data['heading_title'] = $this->language->get('heading_title_success');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_success'),
			'href' => $this->url->link('information/contact/success')
		);

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

        $this->document->setBreadcrumbs($data['breadcrumbs']);

		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/success', $data));
	}

    public function successSubscribe() {
        $this->load->language('information/contact');

        $this->document->setTitle($this->language->get('heading_title_success'));

        $data['heading_title_main'] = $this->language->get('heading_title');
        $data['heading_title'] = $this->language->get('heading_title_success');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/contact')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title_success'),
            'href' => $this->url->link('information/contact/success')
        );

        $data['text_message'] = $this->language->get('text_success_subscribe');

        $data['button_continue'] = $this->language->get('button_continue');

        $data['continue'] = $this->url->link('common/home');

        $this->document->setBreadcrumbs($data['breadcrumbs']);

        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('common/success', $data));
    }
}
