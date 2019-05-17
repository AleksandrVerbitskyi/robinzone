<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2017 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license

	$sc_ver = VERSION;
	if (!defined('SC_VERSION')) define('SC_VERSION', (int)substr(str_replace('.','',$sc_ver), 0,2));
	require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
    require_once(DIR_SYSTEM . 'library/exceptionizer.php');

	if (!isset($registry)) {
		$registry = $this->registry;
	}

    $registry->set('sc_time_start', microtime(true));

 	$this->file = DIR_APPLICATION.'controller/common/front.php';
    require_once($this->file);
	$SeoCMSFront = new ControllerCommonFront($registry);
	$SeoCMSFront->install();
