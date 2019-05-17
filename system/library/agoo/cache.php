<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2017 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class agooCache extends Controller
{
	protected $Cache;
	private $dir_cache = DIR_CACHE;
	private $first = false;
	public $expire = 36000;
	public $max_files = 300;
	public $maxfile_length = 9437184;
	private $sc_cache_auto_clear = 168;
	private $gzip_level = 0;
	private $is_ssl = false;
	private $is_mobile = false;
	private $is_tablet = false;
	private $is_desktop = false;


	public function agooconstruct($settings) {

		$jetcache_settings = $this->config->get('asc_jetcache_settings');

        if (isset($jetcache_settings['seocms_jetcache_gzip_level']) && $jetcache_settings['seocms_jetcache_gzip_level'] > 0 && $jetcache_settings['seocms_jetcache_gzip_level'] < 10) {        	if (extension_loaded('zlib')) {
             	$this->gzip_level = $jetcache_settings['seocms_jetcache_gzip_level'];
			}
        }

		if (isset($settings['cache_auto_clear']) && $settings['cache_auto_clear'] != '') {
        	$this->sc_cache_auto_clear = $settings['cache_auto_clear'];
    	}

        $this->load->model('jetcache/jetcache');

        if ($this->config->get('asc_cache_auto_clear') != '') {

	        if (((time() - $this->config->get('asc_cache_auto_clear')) / 60 / 60) > $this->sc_cache_auto_clear) {
             // Clear all cache
             // Save current time to setting - asc_cache_auto_clear
             $this->load->model('record/blog');
             $this->model_record_blog->editSetting('asc_cache_auto', array('asc_cache_auto_clear' => time()));
             // Delete all files cache
             agoo_cont('module/blog', $this->registry);
             $this->data = $this->controller_module_blog->cacheremove('no_access');

             // Delete all DB cache

	        }
		}
    	if (isset($settings['cache_expire']) && $settings['cache_expire'] != '') {        	$this->expire = $settings['cache_expire'];
    	}

    	if (isset($settings['cache_max_files']) && $settings['cache_max_files'] != '') {
        	$this->max_files = $settings['cache_max_files'];
    	}

    	if (isset($settings['cache_maxfile_length']) && $settings['cache_maxfile_length'] != '') {
        	$this->maxfile_length = $settings['cache_maxfile_length'];
    	}

		if ((isset($settings['seocms_url_secure']) && $settings['seocms_url_secure'] == 'https' && $settings['seocms_url_secure'] != 'http') || ((isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https') || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) == 'on')))) {
			$this->is_ssl = true;
		}

    	if (isset($settings['cache_mobile_detect']) && $settings['cache_mobile_detect']) {

			if (!class_exists('Mobile_Detect')) {
				loadlibrary('md/mobile_detect');
			}

	        $detect = new Mobile_Detect;

	        if ($detect->isMobile()) {
	        	$this->is_mobile = true;
			}

			if($detect->isTablet()){
	        	$this->is_tablet = true;
			}

			if(!$this->is_tablet && !$this->is_mobile){
	        	$this->is_desktop = true;
			}
        }
	}

	public function construct_cache() {
		$asc_construct_cache = $this->registry->get('asc_construct_cache');
		if (!isset($asc_construct_cache[$this->dir_cache])) {
	        $exceptionizer = new PHP_Exceptionizer(E_ALL);
         	try {
				$files = glob($this->dir_cache . 'cache.*');
				if ($files) {
					clearstatcache();
					$count_files = count($files);
					foreach ($files as $file) {
						$time      = substr(strrchr($file, '.'), 1);
						$file_size = @filesize($file);
						if (@file_exists($file)) {
							if ($time < time() || $count_files > $this->max_files || $file_size < 0 || $file_size > $this->maxfile_length) {
								@unlink($file);
							}
						}
					}
				}
				$asc_construct_cache[$this->dir_cache] = true;
				$this->registry->set('asc_construct_cache', $asc_construct_cache);
  			}  catch (E_WARNING $e) {
		       	return false;
			}
		}
	}

	public function __call($name, array $params) {
		$modules = false;

		if (is_string($params[0]) && isset($params[0])) {
			$pieces_array = explode('.', $params[0]);
		} else {
			$pieces_array = Array();
			$params[0]    = '';
		}
		if (!$this->config->get('blog_work') || $pieces_array[0] != 'blog') {

            // Return dot enter cache
			$this_cache  = $this->registry->get('cache');
			$this->Cache = $this->registry->get('cache_old');
			$modules     = call_user_func_array(array(
				$this->Cache,
				$name
			), $params);
			$this->registry->set('cache', $this_cache);
			unset($this->Cache);
			unset($this_cache);


		} else {
			if (isset($params[0])) {
				if (isset($pieces_array[1])) {
					$pieces = $pieces_array[1];
				} else {
					$pieces = '';
				}
			} else {
				$pieces = '';
			}
			if (isset($pieces_array[0]) && $pieces_array[0] == 'blog') {

				if ($pieces != 'db') {
					$file_cache = DIR_CACHE . 'seocms/index.html';
					if (!@file_exists($file_cache)) {
						$this->mkdirs($file_cache, true);
					}
					$file_cache = DIR_CACHE . 'seocms/' . $pieces . '/index.html';
					if (!@file_exists($file_cache)) {
						$this->mkdirs($file_cache, true);
					}
					if ($pieces == '') {
						$end_cache_devider = '';
					} else {
						$end_cache_devider = '/';
					}
					$this->dir_cache = DIR_CACHE . 'seocms/' . $pieces . $end_cache_devider;
					if ($name == 'set') {
						$modules = $this->set_agoo($params[0], $params[1]);
					}
					if ($name == 'get') {
						$modules = $this->get_agoo($params[0]);
					}
					if ($name == 'delete') {
						$modules = $this->delete_agoo($params[0]);
					}
				} else {
					$params[0] = $params[0].'.'.(int)$this->is_ssl.'_'.(int)$this->is_mobile.'_'.(int)$this->is_tablet.'_'.(int)$this->is_desktop.'.';

                    $table_suffix = '_0';
					$table = $pieces_array[2];
                    $hash = $pieces_array[3];
                    $hash_first = strtolower($hash[0]);

                    $table_0 = '01234567890';
                    if (strpos($table_0, $hash_first) !== false) {
                    	$table_suffix = '_0';
                    }
                    $table_1 = 'abcdefgh';
                    if (strpos($table_1, $hash_first) !== false) {
                    	$table_suffix = '_1';
                    }
                    $table_2 = 'ijklmn';
                    if (strpos($table_2, $hash_first) !== false) {
                    	$table_suffix = '_2';
                    }
                    $table_3 = 'opqrst';
                    if (strpos($table_3, $hash_first) !== false) {
                    	$table_suffix = '_3';
                    }
                    $table_4 = 'uvwxyz';
                    if (strpos($table_4, $hash_first) !== false) {
                    	$table_suffix = '_4';
                    }
                    $table = 'jetcache_'.$table.$table_suffix;

					if ($name == 'set') {
						$modules = $this->set_db_agoo($table, $params[0], $params[1]);
					}
					if ($name == 'get') {
						$modules = $this->get_db_agoo($table, $params[0]);
					}
					if ($name == 'delete') {
						$modules = $this->delete_db_agoo($table, $params[0]);
					}

				}

			} else {
				$this->dir_cache = DIR_CACHE;
			}
		}
		return $modules;
	}

    public function get_db_agoo($table, $key) {

       	$datas = $this->model_jetcache_jetcache->getSettings($table, $key);
        $exceptionizer = new PHP_Exceptionizer(E_ALL);
		if ($datas) {
			try {
				if ($this->gzip_level > 0) {
					$datas = gzdecode(base64_decode($datas));
				}
				$datas_array = json_decode($datas, true);
			} catch (E_WARNING $e) {			}

			if (!is_array($datas_array)) {
				$datas_array = false;
			}
		} else {			$datas_array = false;
		}
		unset($exceptionizer);
		return $datas_array;
    }

	public function set_db_agoo($table, $key, $value) {
        $this->delete_db_agoo($table, $key);
        $time_expire = time() + $this->expire;

        $exceptionizer = new PHP_Exceptionizer(E_ALL);
		if (is_array($value)) {
		    try {
		    	$value = json_encode($value);
		    }  catch (E_WARNING $e) {
		    	return false;
		    }
		}

		if ($this->gzip_level > 0) {
			$value = base64_encode(gzencode($value, (int)$this->gzip_level));
		}

		$this->model_jetcache_jetcache->setSettings($table, $key, $value, $time_expire);
        unset($exceptionizer);
		return true;
	}

    public function delete_db_agoo($table, $key) {
        $exceptionizer = new PHP_Exceptionizer(E_ALL);
		try {
            $datas = $this->model_jetcache_jetcache->deleteSettings($table, $key);
		} catch (E_WARNING $e) {
		}
    	unset($exceptionizer);
    	return true;
    }

	public function set_agoo($key, $value) {
		$this->delete_agoo($key);
		$file   = $this->dir_cache . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key).'.'.(int)$this->is_ssl.'_'.(int)$this->is_mobile.'_'.(int)$this->is_tablet.'_'.(int)$this->is_desktop.'.' . (time() + $this->expire);
		$handle = @fopen($file, 'w');
		@flock($handle, LOCK_EX);
		if (is_array($value)) {
			$exceptionizer = new PHP_Exceptionizer(E_ALL);
		    try {
		    	$value = json_encode($value);
		    }  catch (E_WARNING $e) {
		    	return false;
		    }
		}

		if ($this->gzip_level > 0) {			$value = gzencode($value, (int)$this->gzip_level);
		}

		@fwrite($handle, $value);
		@fflush($handle);
		@flock($handle, LOCK_UN);
		@fclose($handle);
		$this->construct_cache();
		return true;
	}

	public function get_agoo($key) {
		$files = glob($this->dir_cache . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key).'.'.(int)$this->is_ssl.'_'.(int)$this->is_mobile.'_'.(int)$this->is_tablet.'_'.(int)$this->is_desktop.'.*');
		if ($files) {
			$exceptionizer = new PHP_Exceptionizer(E_ALL);
         	try {
				clearstatcache();
				if (@file_exists($files[0])) {
					$handle = @fopen($files[0], 'r');
					@flock($handle, LOCK_SH);
					$file_size = @filesize($files[0]);

					$time = substr(strrchr($files[0], '.'), 1);

 					if ($time < time() || $file_size < 0 || $file_size > $this->maxfile_length) {
						@unlink($files[0]);
						$datas = '[]';
					} else {
						$datas = @fread($handle, $file_size);

						if ($this->gzip_level > 0) {
							$datas = gzdecode($datas);
						}

					}
					@flock($handle, LOCK_UN);
					@fclose($handle);
					$datas_array = json_decode($datas, true);
				} else {
					$datas_array = $datas = array();
				}
			} catch (E_WARNING $e) {
			}

			if (isset($datas_array) && is_array($datas_array)) {
				$datas = $datas_array;
			} else {
				try {
					$datas_array = @unserialize($datas);
				}
				catch (E_WARNING $e) {
				}
			}
			unset($exceptionizer);
			if (is_array($datas_array)) {
				return $datas_array;
			} else {
				return $datas;
			}
		}
		return false;
	}

	public function delete_agoo($key) {
		$files = glob($this->dir_cache . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key).'.'.(int)$this->is_ssl.'_'.(int)$this->is_mobile.'_'.(int)$this->is_tablet.'_'.(int)$this->is_desktop.'.*');
		if ($key == 'blog') {
			$files = $this->DirFilesR($this->dir_cache);
		}
		if ($files) {
	        $exceptionizer = new PHP_Exceptionizer(E_ALL);
         	try {
				clearstatcache();
				foreach ($files as $file) {
					if (@file_exists($file)) {
						@unlink($file);
					}
				}
				return true;
			}  catch (E_WARNING $e) {
		    	return false;
			}
		}
		return false;
	}

	private function DirFilesR($dir) {
		$handle   = opendir($dir);
		$files    = Array();
		$subfiles = Array();
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($dir . "/" . $file)) {
					$subfiles = $this->DirFilesR($dir . "/" . $file);
					$files    = array_merge($files, $subfiles);
				} else {
					$flie_name = $dir . "/" . $file;
					$flie_name = str_replace("//", "/", $flie_name);
					$files[]   = $flie_name;
				}
			}
		}
		closedir($handle);
		return $files;
	}

	private function mkdirs($pathname, $index = FALSE, $mode = 0777) {
		$flag_save = false;
		$path_file = dirname($pathname);
		$name_file = basename($pathname);
		if (is_dir(dirname($path_file))) {
		} else {
			$this->mkdirs(dirname($pathname), $index, $mode);
		}
		if (is_dir($path_file)) {
			if (@file_exists($path_file)) {
				$flag_save = true;
			}
		} else {
			@umask(0);
			if (@!file_exists($path_file)) {
				@mkdir($path_file, $mode);
			}
			if (@file_exists($path_file)) {
				$flag_save = true;
			}
			if ($index) {
				$accessFile = $path_file . "/" . $name_file;
				@touch($accessFile);
				$accessWrite = @fopen($accessFile, "wb");
				@fwrite($accessWrite, 'Access denied');
				@fclose($accessWrite);
				if (@file_exists($accessFile)) {
					$flag_save = true;
				} else {
					$flag_save = false;
				}
			}
		}
		return $flag_save;
	}

}
