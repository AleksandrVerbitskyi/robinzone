<?php

require_once 'csv.php';
require_once 'databaseadapter.php';
require_once 'import.php';

$import = new Import\Import('production');
$import->startImport();