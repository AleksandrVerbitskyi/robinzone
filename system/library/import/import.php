<?php
namespace Import;

require_once __DIR__ . '/settings.php';
require_once 'logger.php';
define('BASE_DIR', DIR_APPLICATION . '/../import_files/');

date_default_timezone_set('Europe/Kiev');

class Import {

    private $category;
    private $color;
    private $size;
    private $product;
    private $product_qty;

    private $csv;
    private $db;
    private $logger;

    public function __construct($logger_mode = null)
    {
        $this->category = BASE_DIR . CATEGORY_FILENAME;
        $this->color = BASE_DIR . COLOR_FILENAME;
        $this->size = BASE_DIR . SIZE_FILENAME;
        $this->product = BASE_DIR . PRODUCT_FILENAME;
        $this->product_qty = BASE_DIR . PRODUCT_QTY_FILENAME;

        $this->csv = new csv;
        $this->db = new DatabaseAdapter(DB_DATABASE, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
        $this->logger = new Logger();
        if ($logger_mode == null) {
            $logger_mode = 'developer';
        }
        $this->logger
            ->setFilename('crontab_store_import.log')
            ->setMode($logger_mode);
        $this->install();
    }

    public function startImport()
    {
        $this->logger->output(sprintf("<br/> Імпорт запущено %s <br/>", date("Y-m-d H:i:s")));
        if ($this->isChanged($this->category)) {
            $this->logger->output("Розпочато імпорт 'Категорій' <br/>");
            $category_data = $this->csv->read($this->category, ';');
            $this->import($category_data, $this->category);
            $this->logger->output("Завершено імпорт 'Категорій' <br/>");
        } else {
            $this->logger->output(sprintf("<br/> Файл `%s` не змінено з попереднього імпорту! <br/>", CATEGORY_FILENAME));
        }
        if ($this->isChanged($this->color)) {
            $this->logger->output("Розпочато імпорт 'Кольорів' <br/>");
            $color_data = $this->csv->read($this->color, ';');
            $this->import($color_data, $this->color);
            $this->logger->output("Завершено імпорт 'Категорій' <br/>");
        } else {
            $this->logger->output(sprintf("Файл `%s` не змінено з попереднього імпорту! <br/>", COLOR_FILENAME));
        }
        if ($this->isChanged($this->size)) {
            $this->logger->output("Розпочато імпорт 'Розмірів' <br/>");
            $size_data = $this->csv->read($this->size, ';');
            $this->import($size_data, $this->size);
            $this->logger->output("Завершено імпорт 'Розмірів' <br/>");
        } else {
            $this->logger->output(sprintf("Файл `%s` не змінено з попереднього імпорту! <br/>", SIZE_FILENAME));
        }
        if ($this->isChanged($this->product)) {
            $this->logger->output("Розпочато імпорт 'Товарів' <br/>");
            $product_data = $this->csv->read($this->product, ';');
            $this->import($product_data, $this->product);
            $this->logger->output("Завершено імпорт 'Товарів' <br/>");
        } else {
            $this->logger->output(sprintf("Файл `%s` не змінено з попереднього імпорту! <br/>", PRODUCT_FILENAME));
        }
        if ($this->isChanged($this->product_qty)) {
            $this->logger->output("Розпочато імпорт 'Кількості товарів по опціям' <br/>");
            $product_qty_data = $this->csv->read($this->product_qty, ';');
            $this->import($product_qty_data, $this->product_qty);
            $this->logger->output("Завершено імпорт 'Кількості товарів по опціям' <br/>");
        } else {
            $this->logger->output(sprintf("Файл `%s` не змінено з попереднього імпорту! <br/>", PRODUCT_QTY_FILENAME));
        }

        $this->hashAllFiles();
        $this->logger->output(sprintf("Імпорт завершено %s", date("Y-m-d H:i:s")));
    }

    private function import($data, $file) {
        switch ($file) {
            case $file === $this->size:
                $this->importOptions($data, 'size');
                break;
            case $file === $this->color:
                $this->importOptions($data, 'color');
                break;
            case $file === $this->category:
                $this->importCategories($data);
                break;
            case $file === $this->product:
                $this->importProducts($data);
                break;
            case $file === $this->product_qty:
                $this->importProductQty($data);
                break;
        }
        return true;
    }

    private function importProductQty($data) {
        foreach ($data as $item) {
            $this->insertProductQty($item);
        }
    }

    private function insertProductQty($data) {
        $product_id = $this->getIdBySku($data['sku']);
        if ($product_id === false) {
            $message = sprintf("<br/>Ви спробували імпортувати к-ть товару по варіаціям (опціям) для неіснуючого товару. Перевірте наявність товару із SKU '%s' в файлах імпорту товарів.", $data['sku']);
            $this->logger->output($message);
            return false;
        }
        $product_qty = $this->getProductQty($product_id);

        $color_option_value = $this->getOptionValueIdBy1sId($data['color_id'], COLOR_OPTION_ID);
        $size_option_value = $this->getOptionValueIdBy1sId($data['size_id'], SIZE_OPTION_ID);

        $options = [COLOR_OPTION_ID => $color_option_value, SIZE_OPTION_ID => $size_option_value];

        foreach ($options as $option_id => $option_value_id) {
            $sql = "UPDATE " . DB_PREFIX . "product_option_value";
            $sql .= " SET ";
//            $sql .= " `quantity` = quantity + '" . $data['qty'] . "'";
            $sql .= " `quantity` = '" . $data['qty'] . "'";
            $sql .= " WHERE `option_id` = '" . (int)$option_id . "'";
            $sql .= " AND `product_id` = '" . (int)$product_id . "'";
            $sql .= " AND `option_value_id` = '" . (int)$option_value_id . "';";
            $this->db->query($sql);
        }
    }

    private function importProducts($data) {
        $import_settings = [
            'description_field' => 'product_id',
            'description_id' => 'product_id',
            'unique_field' => 'sku',
            'fields2edit' => [
                'product' => ['quantity', 'date_modified'],
                'product_description' => []
            ],
            'clause_fields' => ['sku'],
            'id_field'      => 'sku',
            'additional_tables' => [
                'product_option',
                'product_to_category',
                'product_to_store',
                'product_to_layout',
                'product_filter',
                'product_attribute',
            ]
        ];
        foreach ($data as $item) {
            $isInTwoCategories = $this->checkIfInsertTwiceFromProduct($item['category']);
            if ($isInTwoCategories) {
                $ids = $this->getParentCategoriesIdBy1sIdFromProduct($item['category']);
                $item_sku = $item['sku'];
                foreach ($ids as $_1s_id => $id) {
                    $item['category'] = $_1s_id;
                    $item['sku'] = $item_sku . '_' . $_1s_id;
                    $temp = $this->prepareProductData(UA_LANGUAGE_ID, RU_LANGUAGE_ID, $item);
                    $this->insertProductData($temp, ['product', 'product_description'], $import_settings);
                }
            } else {
                $temp = $this->prepareProductData(UA_LANGUAGE_ID, RU_LANGUAGE_ID, $item);
                $this->insertProductData($temp, ['product', 'product_description'], $import_settings);
            }
        }
    }

    private function prepareProductData($ua_id, $ru_id, $data) {
        return [
            'model'             => $data['model'],
            'sku'               => $data['sku'],
            'upc'               => '',
            'ean'               => '',
            'jan'               => '',
            'isbn'              => '',
            'mpn'               => '',
            'location'          => '',
            'quantity'          => $data['qty'],
            'stock_status_id'   => 7,
            'image'             => 'placeholder.png',
            'manufacturer_id'   => 0,
            'shipping'          => 1,
            'price'             => $data['price'],
            'points'            => 0,
            'tax_class_id'      => 0,
            'date_available'    => '',
            'weight'            => 1,
            'weight_class_id'   => '1',
            'length'            => '',
            'length_class_id'   => 1,
            'width'             => '',
            'height'            => '',
            'subtract'          => 1,
            'minimum'           => 1,
            'sort_order'        => 0,
            'status'            => $data['status'],
            'viewed'            => 0,
            'date_added'        => date("Y-m-d H:i:s"),
            'date_modified'     => date("Y-m-d H:i:s"),
            'description'       => [
                'ua' => [
                    'product_id'   => 0,
                    'language_id'   => $ua_id,
                    'name'          => htmlentities($this->db->escape($data['name'])),
                    'description'   => htmlentities($this->db->escape($data['name'])),
                    'tag'           => '',
                    'meta_title'    => '',
                    'meta_h1'       => '',
                    'meta_description'  => '',
                    'meta_keyword'  => '',
                ]
            ],
            'product_option'       => [
                'color' => [
                    'product_id'   => 0,
                    'option_id'    => $data['color_id'],
                    'value'        => '',
                    'required'     => 1,
                ],
                'size' => [
                    'product_id'   => 0,
                    'option_id'    => $data['size_id'],
                    'value'        => '',
                    'required'     => 1,
                ],
                'product_option_value' => [
                    'product_option_id' => 0,
                    'product_id'        => 0,
                    'option_id'         => 0,
                    'option_value_id'   => 0,
                    'quantity'          => 0,
                    'subtract'          => 1,
                    'price'             => 0,
                    'price_prefix'      => '+',
                    'points'            => 0,
                    'points_prefix'     => '+',
                    'weight'            => 0,
                    'weight_prefix'     => '+',
                ],
            ],
            'product_to_category'   => [
                'product_id'        => 0,
                'category_id'       => $data['category'],
                'main_category'     => 0
            ],
            'product_to_store'       => [
                'product_id'    => 0,
                'store_id'      => 0,
            ],
            'product_to_layout'       => [
                'product_id'    => 0,
                'store_id'      => 0,
                'layout_id'     => 0
            ],
            'product_filter'    => [
                'product_id'    => 0,
                'filter_id'     => $data['season'],
                'size_id'       => $data['size_id']
            ],
            'product_attribute'    => [
                'product_id'    => 0,
                'attribute_id'  => TEXTILE_ID,
                'language_id'   => UA_LANGUAGE_ID,
                'text'          => $data['textile'],
            ]
        ];
    }

    private function insertProductData($data, $tables, $settings) {
        $value_id_field = $settings['description_field'];

        $description = $data['description'];
        unset($data['description']);

        foreach ($settings['additional_tables'] as $name) {
            $additional_tables[$name] = $data[$name];
            unset($data[$name]);
        }

        $table_name = $tables[0];
        $table_description_name = $tables[1];

        if (!$this->isDataExist($table_name, $data[$settings['unique_field']], $settings['unique_field'])) {
            $sql = "INSERT INTO " . DB_PREFIX . $table_name . " SET";
            $tmp = array_map([$this, 'generateKeyValue'], array_keys($data), $data);
            $tmp = implode(', ', $tmp);
            $sql .= ' ' . $tmp . ';';
            $this->db->query($sql);

            $last_id = $this->db->getLastId();

            $tmp_desciption = [];
            if (UA_LANGUAGE_ID !== null) {
                $tmp_desciption['ua'] = $description['ua'];
            }
            if (RU_LANGUAGE_ID !== null) {
                $tmp_desciption['ru'] = $description['ua'];
                $tmp_desciption['ru']['language_id'] = RU_LANGUAGE_ID;

            }
            $description = $tmp_desciption;
            unset($tmp_desciption);

            foreach ($description as $key => $description_item) {
                $description_item[$value_id_field] = $last_id;

                $sql = "INSERT INTO " . DB_PREFIX . $table_description_name . " SET";
                $tmp = array_map([$this, 'generateKeyValue'], array_keys($description_item), $description_item);
                $tmp = implode(', ', $tmp);
                $sql .= ' ' . $tmp . ';';
                $this->db->query($sql);
            }

            if (count($additional_tables) > 0) {
                foreach ($additional_tables as $name => $table_data) {
                    $table_data[$settings['description_field']] = $last_id;
                    if ($name == 'product_to_category') {
                        $table_data['category_id'] = $this->getCategoryIdBy1sId($table_data['category_id']);
                        $table_data['main_category'] = $this->isMainCategory($table_data['category_id']);
                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);
                        if (!$table_data['main_category']) {
                            $category_id = $table_data['category_id'];
                            $table_data['category_id'] = $this->getParentCategoryId($category_id);
                            $table_data['main_category'] = $this->isMainCategory($table_data['category_id']);
                            $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }
                    } else if ($name == 'product_filter') {
                        // COLLECTION FILTER START
                        $sizes = explode(',', $table_data['size_id']);
                        unset($table_data['size_id']);
                        // COLLECTION FILTER END

                        if (!array_key_exists($table_data['filter_id'], SEASON_MAP)) {
                            $message = sprintf("<br/>Сезон з 'ID' {%s} відсутній в системі. Доступні лише наступні: зима({%s}), осінь({%s}), літо({%s}), весна({%s})", $table_data['filter_id'], SEASON_WINTER_ID, SEASON_FALL_ID, SEASON_SUMMER_ID, SEASON_SPRING_ID);
                            $this->logger->output($message);
                        } else {
                            $table_data['filter_id'] = SEASON_MAP[$table_data['filter_id']];
                            $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }

                        // COLLECTION FILTER START
                        $add_filters = [];
                        $sizes_map = [];
                        foreach ($sizes as $index => $size) {
                            $size_id = $this->getOptionValueIdBy1sId($size, SIZE_OPTION_ID);
                            $sizes_map[$size_id] = $this->getOptionNameBy1sId($size, SIZE_OPTION_ID);
                        }
                        foreach ($sizes_map as $size_id => $size) {
                            foreach (COLLECTION_MAP as $diapason => $filter_id) {
                                $diapason_array = explode('-', $diapason);
                                $left = (int)array_shift($diapason_array);
                                $right = (int)array_shift($diapason_array);
                                if ((int)$size >= $left && (int)$size <= $right && !in_array((int)COLLECTION_MAP[$diapason], $add_filters)) {
                                    array_push($add_filters, (int)COLLECTION_MAP[$diapason]);
                                }
                            }
                        }
                        foreach ($add_filters as $filter_id) {
                            $table_data['filter_id'] = $filter_id;
                            $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }

                        // COLLECTION FILTER END
                    } else if ($name == 'product_attribute') {
                        if (UA_LANGUAGE_ID !== null) {
                            $attributes['ua'] = $table_data;
                        }
                        if (RU_LANGUAGE_ID !== null) {
                            $attributes['ru'] = $table_data;
                            $attributes['ru']['language_id'] = RU_LANGUAGE_ID;
                        }
                        foreach ($attributes as $attribute) {
                            $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($attribute), $attribute);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }
                    } else if ($name == 'product_option') {
                        $option_value_pattern = $table_data['product_option_value'];
                        unset($table_data['product_option_value']);

                        $size_pattern = $table_data['size'];
                        if (strpos($size_pattern['option_id'], ',')) {
                            $sizes = explode(',', $size_pattern['option_id']);
                        } else {
                            $sizes[] = $size_pattern['option_id'];
                        }

                        $size_pattern['product_id'] = $table_data[$settings['description_field']];
                        $size_pattern['option_id'] = SIZE_OPTION_ID;

                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($size_pattern), $size_pattern);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);
                        $product_option_id = $this->db->getLastId();

                        foreach ($sizes as $size_id) {
                            $option_value_pattern['product_option_id'] = $product_option_id;
                            $option_value_pattern['product_id'] = $table_data[$settings['description_field']];
                            $option_value_pattern['option_id'] = SIZE_OPTION_ID;
                            $option_value_pattern['option_value_id'] = $this->getOptionValueIdBy1sId($size_id, SIZE_OPTION_ID);

                            $sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($option_value_pattern), $option_value_pattern);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }

                        $color_pattern = $table_data['color'];
                        if (strpos($color_pattern['option_id'], ',')) {
                            $colors = explode(',', $color_pattern['option_id']);
                        } else {
                            $colors[] = $color_pattern['option_id'];
                        }

                        $color_pattern['product_id'] = $table_data[$settings['description_field']];
                        $color_pattern['option_id'] = COLOR_OPTION_ID;

                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($color_pattern), $color_pattern);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);
                        $product_option_id = $this->db->getLastId();

                        foreach ($colors as $color_id) {
                            $option_value_pattern['product_option_id'] = $product_option_id;
                            $option_value_pattern['product_id'] = $table_data[$settings['description_field']];
                            $option_value_pattern['option_id'] = COLOR_OPTION_ID;
                            $option_value_pattern['option_value_id'] = $this->getOptionValueIdBy1sId($color_id, COLOR_OPTION_ID);

                            $sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($option_value_pattern), $option_value_pattern);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }

                    } else {
                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);
                    }
                }
            }
        } else {
            $table_fields = $this->getTableFields($table_name);
            $table_fields = array_map(function ($element) {
                return $element['COLUMN_NAME'];
            }, $table_fields);

            $exist = false;
            foreach ($settings['fields2edit'][$table_name] as $field) {
                if (in_array($field, $table_fields)) $exist = true;
            }
            if ($exist) {
                $filter = $settings['fields2edit'][$table_name];
                $fields = array_filter($data, function($value, $field) use ($filter) {
                    return in_array($field, $filter);
                }, ARRAY_FILTER_USE_BOTH);

                $sql = "UPDATE " . DB_PREFIX . $table_name . " SET";
                $tmp = array_map([$this, 'generateKeyValue'], array_keys($fields), $fields);
                $tmp = implode(', ', $tmp);
                $clause = array_map(function($clause_fields) use ($data) {
                    return "`" . $clause_fields . "` = '" . $data[$clause_fields] . "'";
                }, $settings['clause_fields']);
                $clause = implode(' AND ', $clause);
                $sql .= ' ' . $tmp . ' WHERE ' . $clause . ';';
                $this->db->query($sql);
            }
            $table_fields = $this->getTableFields($table_description_name);
            $table_fields = array_map(function ($element) {
                return $element['COLUMN_NAME'];
            }, $table_fields);
            $exist = false;
            foreach ($settings['fields2edit'][$table_description_name] as $field) {
                if (in_array($field, $table_fields)) $exist = true;
            }
            if ($exist) {
                $clause = array_map(function($clause_fields) use ($data) {
                    return "`" . $clause_fields . "` = '" . $data[$clause_fields] . "'";
                }, $settings['clause_fields']);
                $clause = implode(' AND ', $clause);
                $sql = "SELECT * FROM " . DB_PREFIX . $table_name . " WHERE " . $clause . ";";
                $clause_value = $this->db->select($sql)[$settings['description_id']];

                $filter = $settings['fields2edit'][$table_description_name];
                $fields = array_filter($description['ua'], function($value, $key) use ($filter) {
                    return in_array($key, $filter);
                }, ARRAY_FILTER_USE_BOTH);

                if (UA_LANGUAGE_ID === null) {
                    $language_id = RU_LANGUAGE_ID;
                } else {
                    $language_id = UA_LANGUAGE_ID;
                }


                $sql = "UPDATE " . DB_PREFIX . $table_description_name . " SET";
                $tmp = array_map([$this, 'generateKeyValue'], array_keys($fields), $fields);
                $tmp = implode(', ', $tmp);
                $sql .= " " . $tmp . " WHERE `" . $settings['description_id'] . "` = '" . (int)$clause_value . "' AND `language_id` = '" . $language_id . "';";
                $this->db->query($sql);
            }

            if (count($additional_tables) > 0) {
                foreach ($additional_tables as $name => $table_data) {
                    $table_data[$settings['description_field']] = 0;
                    if ($name == 'product_to_category') {
                        $table_data['product_id'] = $this->getIdBySku($data[$settings['id_field']]);
                        $table_data['category_id'] = $this->getCategoryIdBy1sId($table_data['category_id']);
                        $table_data['main_category'] = $this->isMainCategory($table_data['category_id']);

                        $this->deleteProduct2Category($table_data['product_id']);

                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);
                        if (!$table_data['main_category']) {
                            $category_id = $table_data['category_id'];
                            $table_data['category_id'] = $this->getParentCategoryId($category_id);
                            $table_data['main_category'] = $this->isMainCategory($table_data['category_id']);
                            $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }
                    } else if ($name == 'product_filter') {
                        // COLLECTION FILTER START
                        $sizes = explode(',', $table_data['size_id']);
                        unset($table_data['size_id']);
                        // COLLECTION FILTER END

                        $table_data['product_id'] = $this->getIdBySku($data[$settings['id_field']]);
                        $this->deleteProductFilter($table_data['product_id']);

                        if (!array_key_exists($table_data['filter_id'], SEASON_MAP)) {
                            $message = sprintf("<br/>Сезон з 'ID' {%s} відсутній в системі. Доступні лише наступні: зима({%s}), осінь({%s}), літо({%s}), весна({%s})", $table_data['filter_id'], SEASON_WINTER_ID, SEASON_FALL_ID, SEASON_SUMMER_ID, SEASON_SPRING_ID);
                            $this->logger->output($message);
                        } else {
                            $table_data['filter_id'] = SEASON_MAP[$table_data['filter_id']];
                            $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }
                        // COLLECTION FILTER START
                        $add_filters = [];
                        $sizes_map = [];
                        foreach ($sizes as $index => $size) {
                            $size_id = $this->getOptionValueIdBy1sId($size, SIZE_OPTION_ID);
                            $sizes_map[$size_id] = $this->getOptionNameBy1sId($size, SIZE_OPTION_ID);
                        }
                        foreach ($sizes_map as $size_id => $size) {
                            foreach (COLLECTION_MAP as $diapason => $filter_id) {
                                $diapason_array = explode('-', $diapason);
                                $left = (int)array_shift($diapason_array);
                                $right = (int)array_shift($diapason_array);
                                if ((int)$size >= $left && (int)$size <= $right && !in_array((int)COLLECTION_MAP[$diapason], $add_filters)) {
                                    array_push($add_filters, (int)COLLECTION_MAP[$diapason]);
                                }
                            }
                        }
                        foreach ($add_filters as $filter_id) {
                            $table_data['filter_id'] = $filter_id;
                            $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }

                        // COLLECTION FILTER END

                    } else if ($name == 'product_attribute') {
                        $table_data['product_id'] = $this->getIdBySku($data[$settings['id_field']]);
                        $this->deleteProductAttribute($table_data['product_id']);

                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);

                    } else if ($name == 'product_option') {
                        $table_data['product_id'] = $this->getIdBySku($data[$settings['id_field']]);
                        $this->deleteProductOptions($table_data['product_id']);

                        $option_value_pattern = $table_data['product_option_value'];
                        unset($table_data['product_option_value']);

                        $size_pattern = $table_data['size'];
                        if (strpos($size_pattern['option_id'], ',')) {
                            $sizes = explode(',', $size_pattern['option_id']);
                        } else {
                            $sizes[] = $size_pattern['option_id'];
                        }

                        $size_pattern['product_id'] = $table_data[$settings['description_field']];
                        $size_pattern['option_id'] = SIZE_OPTION_ID;

                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($size_pattern), $size_pattern);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);
                        $product_option_id = $this->db->getLastId();

                        foreach ($sizes as $size_id) {
                            $option_value_pattern['product_option_id'] = $product_option_id;
                            $option_value_pattern['product_id'] = $table_data[$settings['description_field']];
                            $option_value_pattern['option_id'] = SIZE_OPTION_ID;
                            $option_value_pattern['option_value_id'] = $this->getOptionValueIdBy1sId($size_id, SIZE_OPTION_ID);

                            $sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($option_value_pattern), $option_value_pattern);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }

                        $color_pattern = $table_data['color'];
                        if (strpos($color_pattern['option_id'], ',')) {
                            $colors = explode(',', $color_pattern['option_id']);
                        } else {
                            $colors[] = $color_pattern['option_id'];
                        }

                        $color_pattern['product_id'] = $table_data[$settings['description_field']];
                        $color_pattern['option_id'] = COLOR_OPTION_ID;

                        $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                        $tmp = array_map([$this, 'generateKeyValue'], array_keys($color_pattern), $color_pattern);
                        $tmp = implode(', ', $tmp);
                        $sql .= ' ' . $tmp . ';';
                        $this->db->query($sql);
                        $product_option_id = $this->db->getLastId();

                        foreach ($colors as $color_id) {
                            $option_value_pattern['product_option_id'] = $product_option_id;
                            $option_value_pattern['product_id'] = $table_data[$settings['description_field']];
                            $option_value_pattern['option_id'] = COLOR_OPTION_ID;
                            $option_value_pattern['option_value_id'] = $this->getOptionValueIdBy1sId($color_id, COLOR_OPTION_ID);

                            $sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET";
                            $tmp = array_map([$this, 'generateKeyValue'], array_keys($option_value_pattern), $option_value_pattern);
                            $tmp = implode(', ', $tmp);
                            $sql .= ' ' . $tmp . ';';
                            $this->db->query($sql);
                        }

                    }
                }
            }

        }
    }

    private function deleteProductOptions($product_id) {
        $sql = "DELETE FROM " . DB_PREFIX . "product_option WHERE `product_id` = " . $product_id;
        $this->db->query($sql);
        $sql = "DELETE FROM " . DB_PREFIX . "product_option_value WHERE `product_id` = " . $product_id;
        $this->db->query($sql);
    }
    private function deleteProductAttribute($product_id) {
        if (UA_LANGUAGE_ID === null) {
            $language_id = RU_LANGUAGE_ID;
        } else {
            $language_id = UA_LANGUAGE_ID;
        }
        $sql = "DELETE FROM " . DB_PREFIX . "product_attribute WHERE `product_id` = " . $product_id;
        $sql .= " AND `language_id` = " . $language_id;
        $this->db->query($sql);
    }
    private function deleteProductFilter($product_id) {
        $sql = "DELETE FROM " . DB_PREFIX . "product_filter WHERE `product_id` = " . $product_id;
        $this->db->query($sql);
    }
    private function deleteProduct2Category($product_id) {
        $sql = "DELETE FROM " . DB_PREFIX . "product_to_category WHERE `product_id` = " . $product_id;
        $this->db->query($sql);
    }
    private function getIdBySku($sku) {
//        $sql = "SELECT * FROM " . DB_PREFIX . "product WHERE `sku` = '" . $sku . "'";
        $sql = "SELECT * FROM " . DB_PREFIX . "product WHERE `sku` in ('" . $sku . "', '" . $sku . '_' . BOYS_1S_ID . "','" . $sku . '_' . GIRLS_1S_ID . "')";
        $product = $this->db->select($sql);
        if (!array_key_exists('product_id', $product)) {
            return false;
        }
        return $product['product_id'];
    }
    private function getProductQty($product_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "product WHERE `product_id` = '" . $product_id . "'";
        $product = $this->db->select($sql);
        if (!array_key_exists('quantity', $product)) {
            $a = true;
        }
        return $product['quantity'];
    }

    private function getOptionValueIdBy1sId($_1s_id, $option_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "option_value WHERE `1s_id` = '" . $_1s_id . "' AND `option_id` = " . $option_id;
        $option = $this->db->select($sql);
        return (int)$option['option_value_id'];
    }

    private function getOptionNameBy1sId($_1s_id, $option_id) {
        if (UA_LANGUAGE_ID === null) {
            $language_id = RU_LANGUAGE_ID;
        } else {
            $language_id = UA_LANGUAGE_ID;
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "option_value WHERE `1s_id` = '" . $_1s_id . "' AND `option_id` = " . $option_id;
        $option = $this->db->select($sql);
        $option_value_id = (int)$option['option_value_id'];
        $sql  = "SELECT * FROM " . DB_PREFIX . "option_value_description WHERE";
        $sql .= " `option_value_id` = '" . $option_value_id . "'";
        $sql .= " AND `option_id` = '" . $option_id . "'";
        $sql .= " AND `language_id` = '" . $language_id . "';";
        $option_value = $this->db->select($sql);
        return $option_value['name'];
    }

    private function isMainCategory($category_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "category WHERE `category_id` = " . $category_id;
        $category = $this->db->select($sql);
        return (int)$category['parent_id'] === 0 ? 1 : 0;
    }

    private function getParentCategoryId($category_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "category WHERE `category_id` = " . $category_id;
        $category = $this->db->select($sql);
        return (int)$category['parent_id'];
    }

    private function importCategories($data) {
        $import_settings = [
            'description_field' => 'category_id',
            'description_id' => 'category_id',
            'fields2edit' => [
                'category' => ['date_modified'],
                'category_description' => []
            ],
            'clause_fields' => ['1s_id'],
            'additional_tables' => ['category_to_store', 'category_to_layout', 'url_alias', 'category_path']
        ];
        foreach ($data as $item) {
            $isInTwoCategories = $this->checkIfInsertTwice($item['parent_id']);
            if ($isInTwoCategories) {
                $ids = $this->getParentCategoriesIdBy1sId($item['parent_id']);
                $item_id = $item['id'];
                foreach ($ids as $_1s_id => $id) {
                    $item['parent_id'] = $_1s_id;
                    $item['id'] = $item_id . '_' . $_1s_id;
                    $temp = $this->prepareCategoryData(UA_LANGUAGE_ID, RU_LANGUAGE_ID, $item);
                    $this->insertCategoryData($temp, ['category', 'category_description'], $import_settings, $ids);
                }
            } else {
                $temp = $this->prepareCategoryData(UA_LANGUAGE_ID, RU_LANGUAGE_ID, $item);
                $this->insertCategoryData($temp, ['category', 'category_description'], $import_settings);
            }
        }
    }

    private function prepareCategoryData($ua_id, $ru_id, $data) {
        $categoryData = [
            'image'         => '',
            'parent_id'     => $this->getParentCategoryIdBy1sId($data['parent_id']),
            'top'           => 0,
            'column'        => 1,
            'sort_order'    => 0,
            'status'        => 1,
            'date_added'    => date("Y-m-d H:i:s"),
            'date_modified' => date("Y-m-d H:i:s"),
            '1s_id'         => $data['id'],
            'description'       => [
            ],
            'category_path'       => [
                'category_id'   => 0
            ],
            'category_to_store'       => [
                'category_id'   => 0,
                'store_id'   => 0
            ],
            'category_to_layout'       => [
                'category_id'   => 0,
                'store_id'   => 0,
                'layout_id'   => 0
            ],
            'url_alias'       => [
                'query'   => 'category_id=',
                'keyword'   => '',
            ]
        ];

        if (UA_LANGUAGE_ID !== null) {
            $categoryData['description']['ua'] = [
                'category_id'   => 0,
                'language_id'   => $ua_id,
                'name'          => $data['name'],
                'description'   => $data['name']
            ];
        }

        if (RU_LANGUAGE_ID !== null) {
            $categoryData['description']['ru'] = [
                'category_id'   => 0,
                'language_id'   => $ru_id,
                'name'          => $data['name'],
                'description'   => $data['name']
            ];
        }

        return $categoryData;
    }

    private function getCategoryIdBy1sId($_1s_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "category WHERE `1s_id` = '" . $_1s_id . "';";
        $category = $this->db->select($sql);
        if (!array_key_exists('category_id', $category)) {
//            $category['category_id'] = 60;
        }
        return $category['category_id'];
    }

    private function getParentCategoryIdBy1sId($_1s_id) {
        $id = CATEGORY_PARENTS_MAP[$_1s_id];
        return $id;
    }

    private function getParentCategoriesIdBy1sId($_1s_id) {
        $id = CATEGORY_PARENTS_MAP[$_1s_id];
        if (is_array($id)) {
            return $id;
        }
        return false;
    }
    private function getParentCategoriesIdBy1sIdFromProduct($_1s_id) {
        $_1s_id_0 = $_1s_id . '_' . BOYS_1S_ID;
        $_1s_id_1 = $_1s_id . '_' . GIRLS_1S_ID;
        $id[$_1s_id_0] = $this->getCategoryIdBy1sId($_1s_id_0);
        $id[$_1s_id_1] = $this->getCategoryIdBy1sId($_1s_id_1);
        if (is_array($id)) {
            return $id;
        }
        return false;
    }

    private function checkIfInsertTwice($_1s_id) {
        $id = CATEGORY_PARENTS_MAP[$_1s_id];
        if (is_array($id)) {
            return true;
        }
        return false;
    }

    private function checkIfInsertTwiceFromProduct($_1s_id) {
        $id = explode('_', $_1s_id);
        if ($id[1] == 2) {
            return true;
        }
        return false;
    }

    private function insertCategoryData($data, $tables, $settings, $twisedCategories = false) {
        $value_id_field = $settings['description_field'];

        $description = $data['description'];
        unset($data['description']);

        $additional_tables = [];

        foreach ($settings['additional_tables'] as $name) {
            $additional_tables[$name] = $data[$name];
            unset($data[$name]);
        }

        $table_name = $tables[0];
        $table_description_name = $tables[1];

        if (!$this->isDataExist($table_name, $data['1s_id'])) {
            $this->insertCategoriesData($settings, $data, $description, $table_name, $table_description_name, $value_id_field, $additional_tables);
        } else {
            $this->updateCategoriesData($settings, $data, $description, $table_name, $table_description_name);
        }
    }

    private function insertCategoriesData($settings, $data, $description, $table_name, $table_description_name, $value_id_field, $additional_tables) {
        $sql = "INSERT INTO " . DB_PREFIX . $table_name . " SET";
        $tmp = array_map([$this, 'generateKeyValue'], array_keys($data), $data);
        $tmp = implode(', ', $tmp);
        $sql .= ' ' . $tmp . ';';
        $this->db->query($sql);

        $last_id = $this->db->getLastId();

        foreach ($description as $key => $description_item) {
            $description_item[$value_id_field] = $last_id;

            $sql = "INSERT INTO " . DB_PREFIX . $table_description_name . " SET";
            $tmp = array_map([$this, 'generateKeyValue'], array_keys($description_item), $description_item);
            $tmp = implode(', ', $tmp);
            $sql .= ' ' . $tmp . ';';
            $this->db->query($sql);
        }

        if (count($additional_tables) > 0) {
            foreach ($additional_tables as $name => $table_data) {
                $table_data[$settings['description_field']] = $last_id;
                if ($name == 'category_path') {
                    $level = 0;
                    $sql = "SELECT * FROM `" . DB_PREFIX . "category_path` WHERE";
                    $sql .= " category_id = '" . $data['parent_id'] . "' ORDER BY `level` ASC";
                    $result[] = $this->db->select($sql);
                    foreach ($result as $element) {
                        $sql = "INSERT INTO `" . DB_PREFIX . "category_path` SET";
                        $sql .= " `category_id` = '" . (int)$last_id . "',";
                        $sql .= " `path_id` = '" . (int)$element['path_id'] . "',";
                        $sql .= " `level` = '" . (int)$level . "'";
                        $this->db->query($sql);
                        $level++;
                    }
                    $sql = "INSERT INTO `" . DB_PREFIX . "category_path` SET";
                    $sql .= " `category_id` = '" . (int)$last_id . "',";
                    $sql .= " `path_id` = '" . (int)$last_id . "',";
                    $sql .= " `level` = '" . (int)$level . "'";
                    $this->db->query($sql);
                } else if ($name == 'url_alias') {
                    $table_data['query'] = $table_data['query'] . (int)$last_id;
                    if (UA_LANGUAGE_ID !== null) {
                        $description_name = $description['ua']['name'];
                    } else {
                        $description_name = $description['ru']['name'];
                    }
                    $table_data['keyword'] = $this->transliterate($description_name);
                    $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                    $sql .= " `query` = '" . $table_data['query'] . "',";
                    $sql .= " `keyword` = '" . $table_data['keyword'] . "';";
                    $this->db->query($sql);
                } else {
                    $sql = "INSERT INTO " . DB_PREFIX . $name . " SET";
                    $tmp = array_map([$this, 'generateKeyValue'], array_keys($table_data), $table_data);
                    $tmp = implode(', ', $tmp);
                    $sql .= ' ' . $tmp . ';';
                    $this->db->query($sql);
                }
            }
        }
    }

    private function updateCategoriesData($settings, $data, $description, $table_name, $table_description_name) {
        $table_fields = $this->getTableFields($table_name);
        $table_fields = array_map(function ($element) {
            return $element['COLUMN_NAME'];
        }, $table_fields);

        $exist = false;
        foreach ($settings['fields2edit'][$table_name] as $field) {
            if (in_array($field, $table_fields)) $exist = true;
        }
        if ($exist) {
            $filter = $settings['fields2edit'][$table_name];
            $fields = array_filter($data, function($value, $field) use ($filter) {
                return in_array($field, $filter);
            }, ARRAY_FILTER_USE_BOTH);

            $sql = "UPDATE " . DB_PREFIX . $table_name . " SET";
            $tmp = array_map([$this, 'generateKeyValue'], array_keys($fields), $fields);
            $tmp = implode(', ', $tmp);
            $clause = array_map(function($clause_fields) use ($data) {
                return "`" . $clause_fields . "` = '" . $data[$clause_fields] . "'";
            }, $settings['clause_fields']);
            $clause = implode(' AND ', $clause);
            $sql .= ' ' . $tmp . ' WHERE ' . $clause . ';';
            $this->db->query($sql);
        }
        $table_fields = $this->getTableFields($table_description_name);
        $table_fields = array_map(function ($element) {
            return $element['COLUMN_NAME'];
        }, $table_fields);
        $exist = false;
        foreach ($settings['fields2edit'][$table_description_name] as $field) {
            if (in_array($field, $table_fields)) $exist = true;
        }
        if ($exist) {
            $clause = array_map(function($clause_fields) use ($data) {
                return "`" . $clause_fields . "` = '" . $data[$clause_fields] . "'";
            }, $settings['clause_fields']);
            $clause = implode(' AND ', $clause);
            $sql = "SELECT * FROM " . DB_PREFIX . $table_name . " WHERE " . $clause . ";";
            $clause_value = $this->db->select($sql)[$settings['description_id']];

            $filter = $settings['fields2edit'][$table_description_name];
            $fields = array_filter($description['ua'], function($value, $key) use ($filter) {
                return in_array($key, $filter);
            }, ARRAY_FILTER_USE_BOTH);


            $sql = "UPDATE " . DB_PREFIX . $table_description_name . " SET";
            $tmp = array_map([$this, 'generateKeyValue'], array_keys($fields), $fields);
            $tmp = implode(', ', $tmp);
            $sql .= " " . $tmp . " WHERE `" . $settings['description_id'] . "` = '" . (int)$clause_value . "' AND `language_id` = '" . UA_LANGUAGE_ID . "';";
            $this->db->query($sql);
        }
    }

    private function importOptions($data, $option_type) {
        $import_settings = [
            'description_field' => 'option_value_id',
            'description_id' => 'option_value_id',
            'fields2edit' => [
                'option_value' => [],
                'option_value_description' => []
            ],
            'clause_fields' => ['1s_id', 'option_id']
        ];
        $option_id = constant(strtoupper($option_type). '_OPTION_ID');
        foreach ($data as $item) {
            $temp = $this->prepareOptionData(UA_LANGUAGE_ID, $option_id, $item['id'], $item['name']);
            $this->insertData($temp, ['option_value', 'option_value_description'], $import_settings, $option_id);
        }
    }

    private function prepareOptionData($language_id, $option_id, $_1s_id, $name) {
        return [
            'option_id' => $option_id,
            'image'     => '',
            'sort_order'=> '',
            '1s_id'     => $_1s_id,
            'description' => [
                'option_value_id' => 0,
                'language_id' => $language_id,
                'option_id'   => $option_id,
                'name'        => $name
            ]
        ];
    }

    private function insertData($data, $tables, $settings, $option_id) {
        $value_id_field = $settings['description_field'];

        $description = $data['description'];
        unset($data['description']);

        $table_name = $tables[0];
        $table_description_name = $tables[1];

        if (!$this->isDataExist($table_name, $data['1s_id'], '1s_id', $option_id)) {
            $sql = "INSERT INTO " . DB_PREFIX . $table_name . " SET";
            $tmp = array_map([$this, 'generateKeyValue'], array_keys($data), $data);
            $tmp = implode(', ', $tmp);
            $sql .= ' ' . $tmp . ';';
            $this->db->query($sql);

            $last_id = $this->db->getLastId();

            $description[$value_id_field] = $last_id;

            if (UA_LANGUAGE_ID !== null) {
                $description_multilang['ua'] = $description;
            }
            if (RU_LANGUAGE_ID !== null) {
                $description_multilang['ru'] = $description;
                $description_multilang['ru']['language_id'] = RU_LANGUAGE_ID;
            }

            foreach ($description_multilang as $desc) {
                $sql = "INSERT INTO " . DB_PREFIX . $table_description_name . " SET";
                $tmp = array_map([$this, 'generateKeyValue'], array_keys($desc), $desc);
                $tmp = implode(', ', $tmp);
                $sql .= ' ' . $tmp . ';';
                $this->db->query($sql);
            }
        } else {
            $table_fields = $this->getTableFields($table_name);
            $table_fields = array_map(function ($element) {
                return $element['COLUMN_NAME'];
            }, $table_fields);

            $exist = false;
            foreach ($settings['fields2edit'][$table_name] as $field) {
                if (in_array($field, $table_fields)) $exist = true;
            }
            if ($exist) {
                $filter = $settings['fields2edit'][$table_name];
                $fields = array_filter($data, function($key, $value) use ($filter) {
                    return in_array($key, $filter);
                }, ARRAY_FILTER_USE_BOTH);

                $sql = "UPDATE " . DB_PREFIX . $table_name . " SET";
                $tmp = array_map([$this, 'generateKeyValue'], array_keys($fields), $fields);
                $tmp = implode(', ', $tmp);
                $clause = array_map(function($clause_fields) use ($data) {
                    return "`" . $clause_fields . "` = '" . $data[$clause_fields] . "'";
                }, $settings['clause_fields']);
                $clause = implode(' AND ', $clause);
                $sql .= ' ' . $tmp . ' WHERE ' . $clause . ';';
                $this->db->query($sql);
            }
            $table_fields = $this->getTableFields($table_description_name);
            $table_fields = array_map(function ($element) {
                return $element['COLUMN_NAME'];
            }, $table_fields);
            $exist = false;
            foreach ($settings['fields2edit'][$table_description_name] as $field) {
                if (in_array($field, $table_fields)) $exist = true;
            }
            if ($exist) {
                $clause = array_map(function($clause_fields) use ($data) {
                    return "`" . $clause_fields . "` = '" . $data[$clause_fields] . "'";
                }, $settings['clause_fields']);
                $clause = implode(' AND ', $clause);
                $sql = "SELECT * FROM " . DB_PREFIX . $table_name . " WHERE " . $clause . ";";
                $clause_value = $this->db->select($sql)[$settings['description_id']];

                $filter = $settings['fields2edit'][$table_description_name];
                $fields = array_filter($description, function($value, $key) use ($filter) {
                    return in_array($key, $filter);
                }, ARRAY_FILTER_USE_BOTH);


                $sql = "UPDATE " . DB_PREFIX . $table_description_name . " SET";
                $tmp = array_map([$this, 'generateKeyValue'], array_keys($fields), $fields);
                $tmp = implode(', ', $tmp);
                $sql .= " " . $tmp . " WHERE `" . $settings['description_id'] . "` = '" . (int)$clause_value . "';";
                $this->db->query($sql);
            }

        }
    }

    private function isDataExist($table_name, $_1s_id, $clause = '1s_id', $option_id = false) {
        if ($option_id) {
            $additional_clause = " AND `option_id` = " . $option_id;
        } else {
            $additional_clause = "";
        }
        $sql = "SELECT * FROM " . DB_PREFIX . $table_name . " WHERE";
        $sql .= " `" . $clause . "` = '" . $_1s_id . "'" . $additional_clause . ";";
        if (empty($this->db->select($sql))) {
            return false;
        } else {
            return true;
        }
    }

    private function generateKeyValue($key, $element) {
        return "`" . $key . "` = '" . $element . "'";
    }

    private function getTableFields($table_name) {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS";
        $sql .= " WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . $table_name . "';";
        return $this->db->select($sql);
    }

    private function isChanged($file) {
        $hash = hash_file('md5', $file);
        $sql = "SELECT * FROM " . DB_PREFIX . "import_settings WHERE";
        $sql .= " `code` = 'file_hash'";
        $sql .= " AND `key` = '" . basename($file, '.csv') . "';";
        $file_hash = $this->db->select($sql);
        if ($hash === $file_hash['value']) {
            return false;
        } else {
            return true;
        }
    }

    private function hashAllFiles() {
        $this->hashFile($this->category);
        $this->hashFile($this->color);
        $this->hashFile($this->size);
        $this->hashFile($this->product);
        $this->hashFile($this->product_qty);
    }

    private function hashFile($file) {
        $hash = hash_file('md5', $file);
        $sql = "SELECT * FROM " . DB_PREFIX . "import_settings WHERE";
        $sql .= " `code` = 'file_hash'";
        $sql .= " AND `key` = '" . basename($file, '.csv') . "';";
        $previous = $this->db->select($sql);

        if (empty($previous)) {
            $sql = "INSERT INTO " . DB_PREFIX . "import_settings";
            $sql .= " SET `code` = 'file_hash',";
            $sql .= " `key` = '" . basename($file, '.csv') . "',";
            $sql .= " `value` = '" . $hash . "';";
            $this->db->query($sql);
        } else {
            $sql = "UPDATE " . DB_PREFIX . "import_settings";
            $sql .= " SET `value` = '" . $hash . "' WHERE";
            $sql .= " `code` = 'file_hash'";
            $sql .= " AND `key` = '" . basename($file, '.csv') . "';";
            $this->db->query($sql);
        }
    }

    private function install() {
        $query = "CREATE TABLE IF NOT EXISTS `"  . DB_PREFIX . "import_settings`(";
        $query .= "`setting_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $query .= "`code` VARCHAR(50) NOT NULL DEFAULT '',";
        $query .= "`key` VARCHAR(50) NOT NULL DEFAULT '',";
        $query .= "`value` VARCHAR(255) NOT NULL DEFAULT '',";
        $query .= "PRIMARY KEY (`setting_id`)) DEFAULT CHARSET=utf8;";
        $this->db->query($query);

        $this->prepareTables();
    }

    private function prepareTables() {
        $tables = ['option_value', 'category'];
        foreach ($tables as $table) {
            $this->prepareTable($table);
        }
    }

    private function prepareTable($table) {
        $sql = "SELECT * FROM " . DB_PREFIX . "import_settings WHERE";
        $sql .= " `code` = 'modified_tables'";
        $sql .= " AND `key` = '" . $table . "';";
        $option_modified = $this->db->select($sql);

        if (empty($option_modified)) {
            $sql = "ALTER TABLE " . DB_PREFIX . $table . " ADD 1s_id VARCHAR(11) NOT NULL DEFAULT '';";
            $this->db->query($sql);

            $sql = "INSERT INTO " . DB_PREFIX . "import_settings";
            $sql .= " SET `code` = 'modified_tables',";
            $sql .= " `key` = '" . $table . "',";
            $sql .= " `value` = '1';";
            $this->db->query($sql);
        }
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `"  . DB_PREFIX . "import_settings`;");
    }

    public function transliterate($str)
    {
        $rus = array('/','%','&','?',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я','і','ї','ґ','є','І','Ї','Ґ','Є','!',',','-','"','\'');
        $lat = array('_0','_1','_2','_3','_','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya','i','yi','gg','ye','I','YI','GG','YE','_','_','_','_','_');
        return str_replace($rus, $lat, $str);
    }
}