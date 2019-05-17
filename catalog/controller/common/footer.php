<?php
class ControllerCommonFooter extends Controller {

	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');


		$data['text_support'] = $this->language->get('text_support');
		$data['text_delivery'] = $this->language->get('text_delivery');
		$data['delivery_page'] = $this->url->link('information/information', 'information_id=6');
		$data['text_about'] = $this->language->get('text_about');
        $data['about_page'] = $this->url->link('information/information', 'information_id=4');
//        $data['text_gallery'] = $this->language->get('text_gallery');
//        $data['gallery_page'] = $this->url->link('information/gallery');
        $data['text_articles'] = $this->language->get('text_articles');
        $data['articles_page'] = $this->url->link('information/articles');
        $data['text_account_info'] = $this->language->get('text_account_info');
        $data['account_info_page'] = $this->url->link('account/edit');
        $data['text_account_address'] = $this->language->get('text_account_address');
        $data['account_address_page'] = $this->url->link('account/address');
        $data['text_account_reward'] = $this->language->get('text_account_reward');
        $data['account_reward_page'] = $this->url->link('account/reward');

        $data['text_representation'] = $this->language->get('text_representation');
        $data['link_representation'] = $this->url->link('information/representatives', '' , true);

        $data['text_contact_title'] = $this->language->get('text_contact_title');

        $data['telephone'] = $this->config->get('config_telephone');
        $data['config_email'] = $this->config->get('config_email');
        $data['config_address'] = html_entity_decode($this->config->get('config_address'));
        $data['config_comment'] = $this->config->get('config_comment');

        $data['text_social_networks'] = $this->language->get('text_social_networks');
        $data['social_networks'] = $this->load->controller('extension/module/socialnetworkinfo');
        $data['social_networks_adaptive'] = $this->load->controller('extension/module/socialnetworkinfo_adaptive');

        $data['text_write_us'] = $this->language->get('text_write_us');
        $data['text_phone_us'] = $this->language->get('text_phone_us');
        $data['text_phone_us_full'] = $this->language->get('text_phone_us_full');
        $data['text_modal_name'] = $this->language->get('text_modal_name');
        $data['text_modal_telephone'] = $this->language->get('text_modal_telephone');
        $data['text_modal_email'] = $this->language->get('text_modal_email');
        $data['text_modal_question'] = $this->language->get('text_modal_question');
        $data['text_modal_button'] = $this->language->get('text_modal_button');

        $data['text_subscribe_title'] = $this->language->get('text_subscribe_title');
        $data['text_subscribe_sub_title'] = $this->language->get('text_subscribe_sub_title');
        $data['text_subscribe_email'] = $this->language->get('text_subscribe_email');
        $data['text_subscribe_button'] = $this->language->get('text_subscribe_button');


		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

        $data['sitemap'] = $this->url->link('information/sitemap', '', true);
		array_push($data['informations'],
            [
                'title' => $data['text_sitemap'],
                'href'  => $data['sitemap']
            ]);

        $data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['contact_action'] = $this->url->link('information/contact/contactUs', '', true);
		$data['subscribe_action'] = $this->url->link('information/contact/subscribe', '', true);

//		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
		$data['powered'] = sprintf($this->language->get('text_powered'));
		$data['payment_list'] = $this->getPaymentSystems();

        $data['current'] = $this->getCurrentUrl();

        $data['text_news'] = $this->language->get('text_news');
        $data['link_news'] = $this->url->link('information/articles', '', true);

        $data['text_clients'] = $this->language->get('text_clients');
        $data['link_clients'] = $this->url->link('information/clients', '', true);

        $data['link_home'] = $this->url->link('common/home', '', true);

        // Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		return $this->load->view('common/footer', $data);
	}

	private function getPaymentSystems() {
	    $payment_list = [
            0 => [
                'url' => 'catalog/view/theme/robinzone/img/masterCard.png',
                'alt' => 'master card payment system',
                'title' => 'master card payment system',
                'status' => 'on',
                'sort'   => '3'
            ],
            1 => [
                'url' => 'catalog/view/theme/robinzone/img/visa.png',
                'alt' => 'visa payment system',
                'title' => 'visa payment system',
                'status' => 'on',
                'sort'   => '2'
            ],
            2 => [
                'url' => 'catalog/view/theme/robinzone/img/novaPoshta.png',
                'alt' => 'nova poshta payment system',
                'title' => 'nova poshta payment system',
                'status' => 'on',
                'sort'   => '1'
            ],
            3 => [
                'url' => 'catalog/view/theme/robinzone/img/meest.png',
                'alt' => 'meest payment system',
                'title' => 'meest payment system',
                'status' => 'on',
                'sort'   => '0'
            ]
        ];
	    usort($payment_list, [$this, 'payment_sort']);

	    foreach ($payment_list as $key => $value) {
	        if ($value['status'] == 'off') unset($payment_list[$key]);
        }

        return array_values($payment_list);
    }

    private function payment_sort($a, $b) {
	    $al = (int)$a['sort'];
        $bl = (int)$b['sort'];
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? -1 : +1;
    }

    public function getCurrentUrl() {
        return (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
    }
}
