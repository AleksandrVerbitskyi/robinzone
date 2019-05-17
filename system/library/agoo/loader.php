<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2017 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class agooLoader extends Controller
{
	protected $Loader;
	protected $sc_force_output_cache = false;
	protected $sc_force_cache_no_access = false;
	protected $sc_cache_name = '';
	protected $seocms_settings;
	protected $jetcache_settings;
	protected $cont_jetcache_loading = false;



	public function __call($name, array $params) {
		$this->registry->set('loader_work', true);

        $this->seocms_settings = $this->registry->get('config')->get('ascp_settings');

		if (
			isset($this->seocms_settings['latest_widget_status']) && $this->seocms_settings['latest_widget_status'] &&
			$this->registry->get('seocms_url_alter') &&
			!class_exists('ControllerCommonSeoBlog') &&
			(class_exists('ControllerCommonSeoUrl') ||
			 class_exists('ControllerCommonSeoPro') ||
			 class_exists('ControllerStartupSeoUrl') ||
			 class_exists('ControllerStartupSeoPro'))
			 && !$this->registry->get('admin_work')
             && !$this->config->get('sc_ar_'.strtolower('ControllerCommonSeoBlog'))
			 ) {
			agoo_cont('record/addrewrite', $this->registry);
			$this->controller_record_addrewrite->add_construct($this->registry);
		}

        if ($this->registry->get('seocms_cache_status') && (!$this->sc_force_cache_no_access && !$this->sc_force_output_cache)) {
			if ($this->sc_force_output_cache = $this->controller_jetcache_jetcache->sc_force_cache_access_output()) {
				$this->controller_jetcache_jetcache->from_cache_output();
			} else {
				if (isset($this->request->get['route']) && $this->request->get['route'] != 'error/not_found') {
					$this->sc_force_cache_no_access	= true;
				}
			}
		}

        unset($this->seocms_settings);

		$flag    = false;
		$modules = NULL;

		if ($name == 'library') {

  			$name_agoo = str_replace('agoo/', '', $params[0]);

            $file = DIR_SYSTEM . 'library/agoo/' . $name_agoo . '.php';

            if (function_exists('modification')) {
        		$file = modification($file);
        	}

			if (file_exists($file)) {

				if (SC_VERSION < 20) {
                	include_once($file);
				} else {
					require_once($file);
				}

				if (SC_VERSION > 21) {
					$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$name_agoo);
					$class = str_replace('/', '', $params[0]);
					$this->registry->set(basename($route), new $class($this->registry));
				}

				$flag = true;

			} else {

				if (!is_callable(array('Loader', 'library'))) {
					$file = DIR_SYSTEM . 'library/' . $params[0] . '.php';
		            if (function_exists('modification')) {
		        		$file = modification($file);
		        	}

					if (file_exists($file)) {

						if (SC_VERSION < 20) {
		                	include_once($file);
						} else {
							require_once($file);
						}

						if (SC_VERSION > 21) {
							$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$params[0]);
							$class = str_replace('/', '\\', $route);
							$this->registry->set(basename($route), new $class($this->registry));
						}

  						$flag = true;
					}
				}
			}
		}
		if ($name == 'helper') {
			$file = DIR_SYSTEM . 'helper/agoo/' . $params[0] . '.php';
            if (function_exists('modification')) {
        		$file = modification($file);
        	}
			if (file_exists($file)) {
				$params[0] = 'agoo/' . $params[0];
				$flag      = true;
			}
		}
		if ($name == 'model') {
			$file = DIR_APPLICATION . 'model/agoo/' . $params[0] . '.php';
            if (function_exists('modification')) {
        		$file = modification($file);
        	}

			if (file_exists($file) || isset($params[1])) {
				$flag = true;
				if (isset($params[1])) {
					if (isset($params[2])) {
						$this->agoomodel($params[0], $params[1], $params[2]);
					} else {
						$this->agoomodel($params[0], $params[1]);
					}
				} else {
					$this->agoomodel($params[0]);
				}
			}
		}
		if (SC_VERSION > 15) {
			if ($name == 'controller' && !$this->registry->get('admin_work')) {

				if ($this->registry->get('seocms_cache_status') && $this->controller_jetcache_jetcache->jetcache_cont_access($params[0])) {
	                // From cache Controller
                    $cache_from = $this->controller_jetcache_jetcache->jetcache_cont_from_cache($params[0]);

                    if ($cache_from) {
                    	return $cache_from;
                    }

				}

				$asc_replacecontroller = $this->registry->get('asc_replacecontroller');
				if (!empty($asc_replacecontroller)) {
					foreach ($asc_replacecontroller as $replace_controller_key => $replace_controller) {
						list($key_replace_controller, $value_replace_controller) = each($replace_controller);
						if ($params[0] == $key_replace_controller) {
							if (!isset($params[1])) {
								$modules = $this->load->controller($value_replace_controller);
							} else {
								$modules = $this->load->controller($value_replace_controller, $params[1]);
							}
							$this->registry->set('loader_work', false);
							return $modules;
						}
					}
				}
				if ($this->registry->get('returnResponseSetOutput')) {
					if ($params[0] == 'common/column_left' || $params[0] == 'common/column_right' || $params[0] == 'common/content_top' || $params[0] == 'common/content_bottom' || $params[0] == 'common/footer' || $params[0] == 'common/header') {
						return '';
					}
				}
			}
			if ($name == 'view' && !$this->registry->get('admin_work')) {
				if (SC_VERSION > 21) {
					if (strpos($params[0], 'agootemplates/') !== false) {
					    $params[0] = str_replace('default/template', '', $params[0]);
						$params[0] = str_replace($this->registry->get('theme_directory') . '/template', '', $params[0]);
					}
				}
				$asc_replacedata = $this->registry->get('asc_replacedata');
				if (!empty($asc_replacedata)) {
					foreach ($asc_replacedata as $replace_data_key => $replace_data) {
						list($key_replace_data, $value_replace_data) = each($replace_data);

						if ($key_replace_data != '') {
							if (SC_VERSION > 21) {
								$pos = stripos($key_replace_data, $params[0]);
							} else {
	                          	$pos = stripos($params[0], $key_replace_data);
							}
						} else {
							$pos = true;
						}
						if ($key_replace_data == '' || $pos !== false) {
							$params[1] = $this->replacedatamethod($params[1], $key_replace_data, $value_replace_data);
							if ($key_replace_data != '') {
								unset($asc_replacedata[$replace_data_key]);
								$this->registry->set('asc_replacedata', $asc_replacedata);
							}
						}
					}
				}
			}
		}
		if (!$flag) {

			$this_loader = $this->registry->get('load');
			if (!$this->registry->get('loader_work')) {
				$this->Loader = $this->registry->get('load_old');
			} else {
				$this->Loader = new Loader($this->registry);
			}
			if ($name == 'library' && !is_callable(array('Loader', 'library'))) {
				$flag = true;
			}

			if (!$flag) {

				$modules = call_user_func_array(array(
					$this->Loader,
					$name
				), $params);

				if ($this->registry->get('seocms_cache_status') &&  $name == 'controller') {
	    			if ($this->controller_jetcache_jetcache->jetcache_cont_access($params[0])) {
						// To cache Controller
       					$this->controller_jetcache_jetcache->jetcache_cont_to_cache($modules, $params[0]);
					}
			   	}
			}

			$this->registry->set('load', $this_loader);
			unset($this->Loader);

		}
		$this->registry->set('loader_work', false);
		return $modules;
	}

	public function setreplacecontroller($data) {
		$asc_replacecontroller   = $this->registry->get('asc_replacecontroller');
		$asc_replacecontroller[] = $data;
		$this->registry->set('asc_replacecontroller', $asc_replacecontroller);
	}

	public function getreplacecontroller() {
		return $this->registry->get('asc_replacecontroller');
	}

	public function setreplacedata($data) {
		$asc_replacedata   = $this->registry->get('asc_replacedata');
		$asc_replacedata[] = $data;
		$this->registry->set('asc_replacedata', $asc_replacedata);
	}

	public function getreplacedata() {
		return $this->registry->get('asc_replacedata');
	}

	public function replacedatamethod($data, $value, $newvalue)	{
		list($key_replace_data, $value_replace_data) = each($newvalue);
		if (isset($data[$key_replace_data]) || $key_replace_data == '') {
			if (is_object($value_replace_data)) {
				// reset($value_replace_data);
				$value_replace_data = (array) $value_replace_data;
				list($object_str, $method_str) = each($value_replace_data);
				$this_obgect = new $object_str($this->registry);
				if ($key_replace_data == '') {
					$this_obgect->$method_str();
				} else {
					$data[$key_replace_data] = $this_obgect->$method_str($data[$key_replace_data]);
				}
			} else {
				$data[$key_replace_data] = $value_replace_data;
			}
		}
		return $data;
	}

	public function agoomodel($model, $data = array(), $dir_application = DIR_APPLICATION) {
		$model = str_replace('../', '', (string) $model);
		$file  = $dir_application . 'model/agoo/' . $model . '.php';
  		if (function_exists('modification')) {
        	$file = modification($file);
        }
		$class = 'agooModel' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
		if (!file_exists($file)) {
			$file  = $dir_application . 'model/' . $model . '.php';
			if (function_exists('modification')) {
        		$file = modification($file);
        	}
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
		}
		if (file_exists($file)) {
			include_once($file);
			$this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
		} else {

		}
	}


	public function agoo_mod_vq($file) {
		    $original_file = $file;
		    if (function_exists('modification')) {
		 		$file = modification($file);
		 	}

			if (class_exists('VQMod',false)) {
				if (VQMod::$directorySeparator) {
					if (strpos($file,'vq2-')!==FALSE) {
					} else {
						if (version_compare(VQMod::$_vqversion,'2.5.0','<')) {
							//trigger_error("You are using an old VQMod version '".VQMod::$_vqversion."', please upgrade your VQMod!");
							//exit;
						}
						if ($original_file != $file) {
							$file = VQMod::modCheck($file,$original_file);
						} else {
							$file = VQMod::modCheck($original_file);
						}
					}
				}
			}
			return $file;
	}


}
