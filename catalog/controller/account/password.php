<?php
class ControllerAccountPassword extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/password', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/password');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('account/customer');

			$this->model_account_customer->editPassword($this->customer->getEmail(), $this->request->post['password']);

			$this->session->data['success'] = $this->language->get('text_success');

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
				);

				$this->model_account_activity->addActivity('password', $activity_data);
			}

			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/password', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_password'] = $this->language->get('text_password');

		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

        if (isset($this->error['password_old'])) {
            $data['error_password_old'] = $this->error['password_old'];
        } else {
            $data['error_password_old'] = '';
        }

		$data['action'] = $this->url->link('account/password', '', true);

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

        if (isset($this->request->post['password_old'])) {
            $data['password_old'] = $this->request->post['password_old'];
        } else {
            $data['password_old'] = '';
        }

		$data['back'] = $this->url->link('account/account', '', true);

		$this->document->setBreadcrumbs($data['breadcrumbs']);

		$data['text_greeting'] = sprintf($this->language->get('text_greeting'), $this->customer->getFullName());
		$data['text_submit'] = $this->language->get('text_submit');
		$data['entry_password_old'] = $this->language->get('entry_password_old');

		$data['column_left'] = $this->load->controller('common/column_left');
//		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/password', $data));
	}

	protected function validate() {
        if ((utf8_strlen($this->request->post['password_old']) < 4) || (utf8_strlen($this->request->post['password_old']) > 20)) {
            $this->error['password_old'] = $this->language->get('error_password_old');
        } else {
            $typed_password = trim($this->request->post['password_old']);
            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomer($this->customer->getId());
            $old_password = $customer['password'];
            $salt = $customer['salt'];
            $typed_password = sha1($salt . sha1($salt . sha1($typed_password)));
            if ($old_password !== $typed_password) {
                $this->error['password_old'] = $this->language->get('error_password_old');
            }
        }

		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		} else {
            $typed_password = trim($this->request->post['password'], ' ');
            if ($this->request->post['password'] !== $typed_password) {
                $this->error['password'] = $this->language->get('error_password_spaces');
            }
        }

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		} else {
            $typed_password = trim($this->request->post['confirm'], ' ');
            if ($this->request->post['password'] !== $typed_password) {
                $this->error['password'] = $this->language->get('error_password_spaces');
            }
        }

		return !$this->error;
	}
}