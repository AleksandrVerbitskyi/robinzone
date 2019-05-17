<?php
class ControllerExtensionModuleFilter extends Controller {

    private function getLanguageVariables(&$data) {
        $this->load->language('extension/module/filter');
        $data['heading_title'] = $this->language->get('heading_title');
        // Text
        $data['text_reset_filter'] = $this->language->get('text_reset_filter');
        $data['text_filter_button'] = $this->language->get('text_filter_button');
        $data['text_catalog'] = $this->language->get('text_catalog');

        $data['button_filter'] = $this->language->get('button_filter');
    }

    public function index($distinctive_options = null) {
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
        if (isset($this->request->get['price'])) {
            $prices = explode(',', $this->request->get['price']);
        } else {
            $prices = array();
        }

        if (isset($parts[0])) {
            $category_id = $parts[0];
        } else {
            $category_id = 0;
        }

        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

        // MAX AND MIN PRICE

        $minPrice = $this->model_catalog_product->getMinPrice();
        $maxPrice = $this->model_catalog_product->getMaxPrice();

        if (!empty($prices)) {
            $minValue = $prices[0];
            $maxValue = $prices[1];
        } else {
            $minValue = $minPrice;
            $maxValue = $maxPrice;
        }

        $data['minPrice'] = $minPrice;
        $data['maxPrice'] = $maxPrice;
        $data['minValue'] = $minValue;
        $data['maxValue'] = $maxValue;
        //

		$data['categories'] = $this->getCategories($category_id);
		$data['category_id'] = $category_id;


		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {

		    $this->getLanguageVariables($data);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

//			$data['action'] = str_replace('&amp;', '&', $this->url->link('product/category', $url));
			$data['action'] = str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url));

			if (isset($this->request->get['filter'])) {
				$data['filter_category'] = explode(',', $this->request->get['filter']);
			} else {
				$data['filter_category'] = array();
			}

			$data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getAllFilters();

            $options = $distinctive_options;

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {

					    if ($filter_group['alias'] == 'size' || $filter_group['alias'] == 'color') {
                            if (in_array($filter['name'], $options)) {
                                $filter_data = array(
                                    'filter_category_id' => $category_id,
                                    'filter_filter'      => $filter['filter_id']
                                );

                                $childen_data[] = array(
                                    'filter_id' => $filter['filter_id'],
                                    'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')
                                );
                            }
                        } else {
                            $filter_data = array(
                                'filter_category_id' => $category_id,
                                'filter_filter'      => $filter['filter_id']
                            );

                            $childen_data[] = array(
                                'filter_id' => $filter['filter_id'],
                                'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')
                            );
                        }
					}

                    usort($childen_data, function ($a, $b) {
                        $first = $a['name'];
                        $second = $b['name'];
                        if ($first == $second) return 0;
                        if ($first < $second) return -1;
                        if ($first > $second) return 1;
                    });

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
                        'isSmartFilter'            => $filter_group['isSmartFilter'],
                        'alias'            => $filter_group['alias'],
						'filter'          => $childen_data
					);
				}

				return $this->load->view('extension/module/filter', $data);
			}
		}
	}

	private function getCategories($category_id) {
        $data['categories'] = [];
        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            $children_data = array();

            if ($category['category_id'] == $category_id) {
                $children = $this->model_catalog_category->getCategories($category['category_id']);

                foreach($children as $child) {
                    $filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

                    $children_data[] = array(
                        'category_id' => $child['category_id'],
                        'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                }
            }

            $filter_data = array(
                'filter_category_id'  => $category['category_id'],
                'filter_sub_category' => true
            );

            $data['categories'][] = array(
                'category_id' => $category['category_id'],
                'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                'children'    => $children_data,
                'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }
        return $data['categories'];
    }
}