<?php
class ControllerInformationSitemap extends Controller {
	public function index() {
		$this->load->language('information/sitemap');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/sitemap')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_history'] = $this->language->get('text_history');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_search'] = $this->language->get('text_search');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_contact'] = $this->language->get('text_contact');

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'name' => $category_3['name'],
						'href' => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'])
					);
				}

				$level_2_data[] = array(
					'name'     => $category_2['name'],
					'children' => $level_3_data,
					'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'])
				);
			}

			$data['categories'][] = array(
				'name'     => $category_1['name'],
				'children' => $level_2_data,
				'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'])
			);
		}

		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['edit'] = $this->url->link('account/edit', '', true);
		$data['password'] = $this->url->link('account/password', '', true);
		$data['address'] = $this->url->link('account/address', '', true);
		$data['history'] = $this->url->link('account/order', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['search'] = $this->url->link('product/search', '', true);
		$data['contact'] = $this->url->link('information/contact', '', true);

		$this->getCustomPages($data);

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			$data['informations'][] = array(
				'title' => $result['title'],
				'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
			);
		}

		$this->document->setBreadcrumbs($data['breadcrumbs']);

//		$data['column_left'] = $this->load->controller('common/column_left');
//		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/sitemap', $data));
	}

	private function getCustomPages(&$data) {
        $data['text_compare'] = $this->language->get('text_compare');
        $data['compare'] = $this->url->link('product/compare', '', true);

        $data['text_wishlist'] = $this->language->get('text_wishlist');
        $data['wishlist'] = $this->url->link('account/wishlist', '', true);

        $data['text_return'] = $this->language->get('text_return');
        $data['return'] = $this->url->link('account/return', '', true);

        $data['text_reward'] = $this->language->get('text_reward');
        $data['reward'] = $this->url->link('account/reward', '', true);

        $data['text_newsletter'] = $this->language->get('text_newsletter');
        $data['newsletter'] = $this->url->link('account/newsletter', '', true);


        $data['text_delivery'] = $this->language->get('text_delivery');
        $data['delivery_page'] = $this->url->link('information/information', 'information_id=6');

        $data['text_about'] = $this->language->get('text_about');
        $data['about_page'] = $this->url->link('information/information', 'information_id=4');

        $data['text_store'] = $this->language->get('text_store');
        $data['link_store'] = $this->url->link('product/category', 'path=' . '61' , true);

        $data['text_opt'] = $this->language->get('text_opt');
        $data['link_opt'] = $this->url->link('information/information', 'information_id=7', true);

        $data['text_representatives'] = $this->language->get('text_representatives');
        $data['representatives'] = $this->url->link('information/representatives');

        $data['text_for_clients'] = $this->language->get('text_for_clients');
        $data['link_for_clients'] = $this->url->link('information/clients', '', true);

        $data['text_sheet'] = $this->language->get('text_sheet');
        $data['link_sheet'] = trim($this->url->link('information/clients', '', true), '/') . '#fabricTypes';

        $data['text_sizes_table'] = $this->language->get('text_sizes_table');
        $data['link_sizes_table'] = trim($this->url->link('information/clients', '', true), '/') . '#fabricSizes';

        $data['text_guidance'] = $this->language->get('text_guidance');
        $data['link_guidance'] = trim($this->url->link('information/clients', '', true), '/') . '#fabricCare';

        $data['text_quality'] = $this->language->get('text_quality');
        $data['link_quality'] = trim($this->url->link('information/clients', '', true), '/') . '#fabricQuality';
    }
}