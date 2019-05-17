<?php

if (!defined('HTTP_SERVER')) require_once __DIR__ . '/../../../config.php';

define('CATEGORY_FILENAME', 'category.csv');
define('COLOR_FILENAME', 'color.csv');
define('SIZE_FILENAME', 'size.csv');
define('PRODUCT_FILENAME', 'product.csv');
define('PRODUCT_QTY_FILENAME', 'product_qty.csv');

define('UA_LANGUAGE_ID', 3);
define('RU_LANGUAGE_ID', 1);

define('SIZE_OPTION_ID', 11);
define('COLOR_OPTION_ID', 13);

define('SEASON_SUMMER_ID', 1);
define('SEASON_FALL_ID', 3);
define('SEASON_WINTER_ID', 2);
define('SEASON_SPRING_ID', 3);

// collection filter settings (filter_group_id=2)
//define('COLLECTION_MAP', ['80-116' => 4, '122-164' => 5]); // For php7.0 and higher
const COLLECTION_MAP = array('80-116' => 4, '122-164' => 5);

const CATEGORY_PARENTS_MAP = array(1 => 60, 0 => 61, 2 => [1 => 60, 0 => 61]);
define('BOYS_1S_ID', 0);
define('GIRLS_1S_ID', 1);

define('TEXTILE_GROUP_ID', 10);
define('TEXTILE_ID', 22);

//define('SEASON_MAP', [1 => SEASON_SUMMER_ID, 2 => SEASON_FALL_ID, 3 => SEASON_WINTER_ID, 4 => SEASON_SPRING_ID]);  // For php7.0 and higher
const SEASON_MAP = array(1 => SEASON_SUMMER_ID, 2 => SEASON_FALL_ID, 3 => SEASON_WINTER_ID, 4 => SEASON_SPRING_ID);
