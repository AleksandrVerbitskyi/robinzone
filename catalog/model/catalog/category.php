<?php
class ModelCatalogCategory extends Model {

    private $smart_filter_settings = [
        'option' => [
            'filter_group' => 'option_description',
            'filter_group_id' => 'option_id',
            'table' => 'option_value',
            'description' => 'option_value_description',
            'filter_id' => 'option_value_id',
            'name'    => 'name',
            'clause_filter' => ''
        ],
//        'category' => [
//            'filter_group' => '',
//            'filter_group_id' => '',
//            'table' => 'category',
//            'description' => 'category_description',
//            'filter_id' => 'category_id',
//            'name'    => 'name',
//            'clause_filter' => " AND parent_id <> 0 GROUP BY name ",
//        ],
        'sex' => [
            'filter_group' => '',
            'filter_group_id' => '',
            'table' => 'category',
            'description' => 'category_description',
            'filter_id' => 'category_id',
            'name'    => 'name',
            'clause_filter' => " AND parent_id = 0 AND status = 1 GROUP BY name ",
        ]
    ];

    private $smart_filters = [
        3 => ['instance' => 'option'],
//        4 => ['instance' => 'sex'],
//        5 => ['instance' => 'category'],
        7 => ['instance' => 'option']
    ]; // Key => filter_group_id, Value => $smart_filter_settings

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}

	public function getCategoryFilters($category_id) {
		$implode = array();

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = array();

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = array();

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = array(
						'filter_id' => $filter['filter_id'],
						'name'      => $filter['name']
					);
				}

				if ($filter_data) {
					$filter_group_data[] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}
			}
		}

		return $filter_group_data;
	}

	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}

    /*
     * TODO: /// START
     * */

    public function getDisabledCategory($category_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c 
        LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
        LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
        WHERE c.category_id = '" . (int)$category_id . "' 
        AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '0'");

        return $query->row;
    }

    public function getAllCategories() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd 
        ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
        WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
        AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND 
        c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

        return $query->rows;
    }

	public function getAllFilters() {
        $filter_groups = [];

        $filter_groups = $this->db->query("SELECT DISTINCT fg.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter_group fg 
            LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) 
            WHERE fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
             GROUP BY fg.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

        if ($filter_groups) {

            $filter_group_data = [];

            foreach ($filter_groups->rows as $filter_group) {
                $filter_data = [];

                $filter_group_id = $filter_group['filter_group_id'];
                $isSmartFilter = $this->isSmartFilter($filter_group_id);

                if ($isSmartFilter) {
                    $smart_instance = $this->smart_filters[$filter_group_id]['instance'];
                    $settings = $this->smart_filter_settings[$smart_instance];

                    if ($smart_instance == 'category' || $smart_instance == 'sex') {
                        $smart_filter_group_id = $filter_group_id;
                    } else {
                        $smart_filter_group_id = $this->getSmartFilterGroupId($settings['filter_group'], $smart_instance, $filter_group['name']);
                    }

                    if ($settings['filter_group'] == '') {
                        $filter_group_clause = '';
                    } else {
                        $filter_group_clause = "t." . $settings['filter_group_id'] . " = " . (int)$smart_filter_group_id . " AND ";
                    }

                    $filter_query = $this->db->query("SELECT DISTINCT t." . $settings['filter_id'] . " as filter_id, td." . $settings['name'] . " as name FROM " . DB_PREFIX . $settings['table'] . " t 
                    LEFT JOIN " . DB_PREFIX . $settings['description'] . " td ON (t." . $settings['filter_id'] . " = td." . $settings['filter_id'] . ") 
                    WHERE $filter_group_clause  
                     td.language_id = '" . (int)$this->config->get('config_language_id') . "' " . $settings['clause_filter'] . " ORDER BY t.sort_order, LCASE(td." . $settings['name'] . ")");
                } else {
                    $filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f 
                    LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) 
                    WHERE f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' 
                    AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");
                }

                foreach ($filter_query->rows as $filter) {
                    $filter_data[] = [
                        'filter_id' => $filter['filter_id'],
                        'name'      => $filter['name']
                    ];
                }
                    $filter_group_data[] = [
                        'filter_group_id' => $filter_group['filter_group_id'],
                        'name'            => $filter_group['name'],
                        'isSmartFilter'   => $isSmartFilter,
                        'alias'           => $this->getAlias($filter_group['name']),
                        'filter'          => $filter_data
                    ];
            }
        }
        return $filter_group_data;
    }

    private function isSmartFilter($filter_group_id) {
	    $result = false;
	    if (isset($this->smart_filters) && !empty($this->smart_filters)) {
	        $smart_filters = array_keys($this->smart_filters);
	        if (in_array($filter_group_id, $smart_filters)) return true;
        }
        return $result;
    }

    private function getSmartFilterGroupId($table, $instance, $filter_group_name) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "$table 
        WHERE language_id = " . (int)$this->config->get('config_language_id') . " AND name = '" . $filter_group_name . "';");
        return $query->row[$instance . "_id"];
    }

    private function getSmartFilterInstanceByGroupId($filter_group_id) {
        return $this->smart_filters[$filter_group_id]['instance'];
    }

    private function getAlias($filter_group_name) {
	    switch ($filter_group_name) {
            case 'Size':
            case 'Размер':
                return 'size';
                break;
            case 'Розмір':
                return 'size';
                break;
            case 'Пол':
            case 'Gender':
            case 'Стать':
                return 'sex';
                break;
            case 'Category':
            case 'Категория':
            case 'Категорія':
                return 'category';
                break;
            case 'Цена':
                return 'price';
                break;
            case 'Ціна':
                return 'price';
                break;
            case 'Price':
                return 'price';
                break;
            case 'Colour':
            case 'Цвет':
            case 'Колір':
                return 'color';
                break;
            default:
                return 'default';
                break;
        }
    }

    public function getSmartFilterData($filters) {
        $filter_groups = [];
        $filter_group_instances = [];
        $filter_groups_data = [];
        $filters_data = [];
        $filters_data_string = "";
        $filter_by_sex= " AND ";
        $filter_by_options= " AND ";
        $filter_by_categories = " AND ";

        $options_map_by_groups = [];

        foreach ($filters as $item) {
            list($filter_group, $filter) = explode('_', $item);
            $filter_group_instance = $this->getSmartFilterInstanceByGroupId($filter_group);
            if (!in_array($filter_group, $filter_groups) && !in_array($filter_group_instance, $filter_group_instances)) {
                array_push($filter_groups, $filter_group);
                array_push($filter_group_instances, $filter_group_instance);
            }
            if (!isset($filters_data[$filter_group_instance])) $filters_data[$filter_group_instance] = [];
            array_push($filters_data[$filter_group_instance], $filter);
            if ($filter_group_instance == 'option') {
                $options_map_by_groups[$filter_group][] = $filter;
            }
        }
        if (!empty($filters_data)) {
            foreach ($filters_data as $instance => $filters) {
                switch ($instance) {
                    case 'option':
//                        foreach ($options_map_by_groups as $group => $filters_by_group) {
//                            $filter_by_options .= " pov.option_value_id IN (" . implode(',', $filters_by_group) . ") AND";
//                        }
//                        $filter_by_options .= " pov.quantity > 0";
                        $filter_by_options .= " pov.option_value_id IN (" . implode(',', $filters) . ") AND pov.quantity > 0";
                        $filters_data_string .= $filter_by_options;
                        break;
                    case 'category':
                        $filter_by_categories .= " p2c.category_id IN (" . implode(',', $filters) . ") ";
                        $filters_data_string .= $filter_by_categories;
                        break;
                    case 'sex':
                        $filter_by_sex .= " p2c.category_id IN (" . implode(',', $filters) . ") ";
                        $filters_data_string .= $filter_by_sex;
                        break;
                }
            }
        }
        foreach ($filter_groups as $filter_group) {
            $table_join = $this->getTableJoinForSmartFilterGroup((int)$filter_group);
            if (!in_array($table_join, $filter_groups_data))$filter_groups_data[] = $table_join;
        }
        return [
            'filter_groups_data' => $filter_groups_data,
            'filters_data' => $filters_data_string,
            'all_option_filters_by_groups' => $options_map_by_groups
        ];
    }

    private function getTableJoinForSmartFilterGroup($smart_group) {
        $smart_instance = $this->getSmartFilterInstanceByGroupId($smart_group);
        switch ($smart_instance) {
            case 'option':
                return $sql = " LEFT JOIN " . DB_PREFIX . "product_option_value pov ON (p.product_id = pov.product_id) ";
                break;
            case 'category' || 'sex':
                return $sql = " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
                break;
        }
        return '';
    }
}