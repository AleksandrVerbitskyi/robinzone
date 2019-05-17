<?php
/* All rights reserved belong to the module, the module developers http://opencartadmin.com */
// http://opencartadmin.com © 2011-2017 All Rights Reserved
// Distribution, without the author's consent is prohibited
// Commercial license
class agooResponse extends Controller
{
	protected $response_old;
	protected $sc_data;
	protected $agooheaders = array();
	protected $header_flag_octet_stream = false;

	protected $sc_cache_name = '';
	protected $cont_jetcache_loading = false;

	public function __call($name, array $params) {

		//$enter_mem = memory_get_peak_usage();
        $cache_output = $this->registry->get('jetcache_output');

		if ($this->registry->get('returnResponseSetOutput') && strtolower($name) == 'setoutput') {
			$this->registry->set('returnResponseSetOutput', $params[0]);
			return;
		}
		if ($this->config->get('ascp_settings') != '') {
			$this->sc_data['settings_general'] = $this->config->get('ascp_settings');
		} else {
			$this->sc_data['settings_general'] = Array();
		}

		if (strtolower($name) == 'addheader') {

			$this->agooheaders[] = $params[0];

			if (is_string($params[0]) && strpos(strtolower($params[0]), '/octet-stream') !== false) {
            	$this->header_flag_octet_stream = true;
			}

			if (is_string($params[0]) && strpos(strtolower($params[0]), '/json') !== false) {

            	$this->registry->set('header_flag_json', true);


			}

		}

		$modules = false;

        if (!$cache_output) {

			if (isset($params[0]) && is_string($params[0])) {
				if (!$this->registry->get('admin_work')) {
					if (strtolower($name) == 'setoutput') {
						$params[0] = $this->set_sitemap($params[0]);
					}

					$params[0] = $this->set_agoo_og_page($params[0]);
					$params[0] = $this->set_agoo_hreflang($params[0]);

					$this->cont('record/pagination');
					$params[0] = $this->controller_record_pagination->setPagination($params[0]);
					unset($this->controller_record_pagintation);
				}
				if ($this->registry->get('admin_work') && isset($this->sc_data['settings_general']['menu_admin_status']) && $this->sc_data['settings_general']['menu_admin_status']) {
					if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
					} else {
						if (strtolower($name) == 'setoutput' && $this->cont('catalog/seocms')) {
							$admin_html = $this->controller_catalog_seocms->index();
							$find       = array(
								'</body>'
							);
							$replace    = array(
								$admin_html . '</body>'
							);

							if (!$this->header_flag_octet_stream) {
								if (!isset($params[0][11000000])) {
									$params[0]  = str_replace($find, $replace, $params[0]);
								}
							}
						}
					}
				}
			}

        }

		if ($this->registry->get('seocms_cache_status')) {
	        if ($this->registry->get('cont_jetcache_loading')) {
		        if (isset($params[0]) && is_string($params[0])) {
		        	$params[0] = $this->controller_jetcache_jetcache->info($params[0], $name);
		        }
	        }
		}

		$this->registry->set('response_work', true);
		$this->response_old = $this->registry->get('response_old');
		$modules = call_user_func_array(array(
			$this->response_old,
			$name
		), $params);
        $this->registry->set('response_work', false);
		// low memory consumption
		// print_my(memory_get_peak_usage() - $enter_mem);

        if (!$cache_output && $this->registry->get('seocms_cache_status')) {
            if ($this->registry->get('cont_jetcache_loading') && !$this->registry->get('seocms_jetcache_alter')) {
            	//$this->registry->set('jetcache_response_output', $params[0]);
            	$this->controller_jetcache_jetcache->to_cache_output($name, $this->registry->get('header_flag_json'));
            }
        }

        unset($this->response_old);
        unset($params);
        unset($cache_output);

		return $modules;
	}

	private function set_sitemap($params) {
		if ($this->config->get('google_sitemap_blog_status')) {
			if ($this->config->get('ascp_settings_sitemap') != '') {
				$data['ascp_settings_sitemap'] = $this->config->get('ascp_settings_sitemap');
			} else {
				$data['ascp_settings_sitemap'] = Array();
			}
			if (isset($data['ascp_settings_sitemap']['google_sitemap_blog_inter_status']) && $data['ascp_settings_sitemap']['google_sitemap_blog_inter_status']) {
				if (isset($this->request->get['route'])) {
					$data['route'] = $this->request->get['route'];
				} else {
					$data['route'] = false;
				}
				if (isset($data['ascp_settings_sitemap']['google_sitemap_blog_inter_route']) && $data['ascp_settings_sitemap']['google_sitemap_blog_inter_route'] != '' && $data['ascp_settings_sitemap']['google_sitemap_blog_inter_route'] == $data['route'] && $data['route'] != 'record/google_sitemap_blog') {
					if (isset($data['ascp_settings_sitemap']['google_sitemap_blog_inter_tag']) && $data['ascp_settings_sitemap']['google_sitemap_blog_inter_tag'] != '') {
						$google_sitemap_blog_inter_tag = html_entity_decode($data['ascp_settings_sitemap']['google_sitemap_blog_inter_tag'], ENT_QUOTES, 'UTF-8');
						if (strpos($params, $google_sitemap_blog_inter_tag) === false) {
						} else {
							if ($this->cont('record/google_sitemap_blog')) {
								$sitemap_html = $this->controller_record_google_sitemap_blog->getascp();
								$find = array($google_sitemap_blog_inter_tag);
								$replace = array($sitemap_html . $google_sitemap_blog_inter_tag);
								$params = str_replace($find, $replace, $params);
							}
						}
					}
				}
			}
		}
		return $params;
	}

	private function set_agoo_hreflang($params) {
		if (isset($params) && !$this->registry->get('admin_work')) {
			if (is_string($params) && strpos($params, '<link rel="alternate"') === false && is_callable(array($this->document, 'getAgooHreflang'))) {
				$sc_hreflang = $this->document->getAgooHreflang();
				if ($sc_hreflang && !empty($sc_hreflang)) {
					foreach ($sc_hreflang as $sc_hreflang_code => $sc_hreflang_array) {
						$params = str_replace("</head>", '
<link rel="alternate" hreflang="' . $sc_hreflang_array['hreflang'] . '" href="' . $sc_hreflang_array['href'] . '" />
</head>', $params);
					}
				}
			}
		}
		return $params;
	}

	private function set_agoo_og_page($params) {
		if (isset($params) && !$this->registry->get('admin_work')) {
			if (isset($this->request->get['route']) && ($this->request->get['route'] == 'record/record' || $this->request->get['route'] == 'record/blog')) {

				if (is_string($params) && strpos($params, '<meta name="robots"') === false && method_exists($this->document, 'getSCRobots')) {
					$sc_robots = $this->document->getSCRobots();
					if ($sc_robots && $sc_robots != '')
						$params = str_replace("</head>", '
<meta name="robots" content="' . $sc_robots . '" />
</head>', $params);
				}
				if (isset($this->sc_data['settings_general']['og']) && $this->sc_data['settings_general']['og']) {
					if (is_string($params) && strpos($params, "og:image") === false && method_exists($this->document, 'getOgImage')) {
						$og_image = $this->document->getOgImage();
						if ($og_image && $og_image != '')
							$params = str_replace("</head>", '
<meta property="og:image" content="' . $og_image . '" />
</head>', $params);
					}
					if (is_string($params) && strpos($params, "og:title") === false && method_exists($this->document, 'getOgTitle')) {
						$og_title = $this->document->getOgTitle();
						if ($og_title && $og_title != '')
							$params = str_replace("</head>", '
<meta property="og:title" content="' . $og_title . '" />
</head>', $params);
					}
					if (is_string($params) && strpos($params, "og:description") === false && method_exists($this->document, 'getOgDescription')) {
						$og_description = $this->document->getOgDescription();
						if ($og_description && $og_description != '')
							$params = str_replace("</head>", '
<meta property="og:description" content="' . $og_description . '" />
</head>', $params);
					}
					if (is_string($params) && strpos($params, "og:url") === false && method_exists($this->document, 'getOgUrl')) {
						$og_url = $this->document->getOgUrl();
						if ($og_url && $og_url != '')
							$params = str_replace("</head>", '
<meta property="og:url" content="' . $og_url . '" />
</head>', $params);
					}
					if (is_string($params) && strpos($params, "og:type") === false && method_exists($this->document, 'getOgType')) {
						$og_type = $this->document->getOgType();
						if ($og_type && $og_type != '')
							$params = str_replace("</head>", '
<meta property="og:type" content="' . $og_type . '" />
</head>', $params);
					}
				}
			}
		}
		return $params;
	}


	public function getSCOutput() {
		return $this->output;
	}

	public function getSCHeaders() {
		return $this->agooheaders;
	}

	private function cont($cont) {
		$file  = DIR_APPLICATION . 'controller/' . $cont . '.php';
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $cont);
		if (file_exists($file)) {
			include_once($file);
			$this->registry->set('controller_' . str_replace('/', '_', $cont), new $class($this->registry));
			return true;
		} else {
			return false;
		}
	}


}
