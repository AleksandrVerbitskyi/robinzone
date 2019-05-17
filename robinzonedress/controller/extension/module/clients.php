<?php
class ControllerExtensionModuleClients extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/clients');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/clients');

        $this->model_extension_module_clients->install();
        
        $this->getForm();
    }

    public function deleteTextile() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $json = [];
            if (isset($this->request->post['textile_id'])) {
                $this->load->model('extension/module/clients');
                $this->model_extension_module_clients->deleteTextile($this->request->post['textile_id']);
                $this->load->language('extension/module/clients');
                $json['success'] =  $this->language->get('text_success_delete');
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    public function deleteSize() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $json = [];
            if (isset($this->request->post['size_id'])) {
                $this->load->model('extension/module/clients');
                $this->model_extension_module_clients->deleteSize($this->request->post['size_id']);
                $this->load->language('extension/module/clients');
                $json['success'] =  $this->language->get('text_success_delete');
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    public function deleteRecommendation() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $json = [];
            if (isset($this->request->post['recommendation_id'])) {
                $this->load->model('extension/module/clients');
                $this->model_extension_module_clients->deleteRecommendation($this->request->post['recommendation_id']);
                $this->load->language('extension/module/clients');
                $json['success'] =  $this->language->get('text_success_delete');
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    public function deleteQuality() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $json = [];
            if (isset($this->request->post['quality_id'])) {
                $this->load->model('extension/module/clients');
                $this->model_extension_module_clients->deleteQuality($this->request->post['quality_id']);
                $this->load->language('extension/module/clients');
                $json['success'] =  $this->language->get('text_success_delete');
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    public function deleteImage() {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $json = [];
            if (isset($this->request->post['image_id'])) {
                $this->load->model('extension/module/clients');
                $this->model_extension_module_clients->deleteImage($this->request->post['image_id']);
                $this->load->language('extension/module/clients');
                $json['success'] =  $this->language->get('text_success_delete');
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    public function edit() {
        $this->load->language('extension/module/clients');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/clients');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            if ((isset($this->request->post['textile']) || isset($this->request->post['textile_new'])) && $valid = $this->validateForm()) {
                if (isset($this->request->post['textile'])) {
                    foreach ($this->request->post['textile'] as $textile) {
                        $this->model_extension_module_clients->editTextile($textile['textile_id'], $textile);
                    }
                }
                if (isset($this->request->post['textile_new'])) {
                    foreach ($this->request->post['textile_new'] as $textile) {
                        $this->model_extension_module_clients->addTextile($textile);
                    }
                }
                if (isset($this->request->post['size'])) {
                    foreach ($this->request->post['size'] as $size) {
                        $this->model_extension_module_clients->editSize($size['size_id'], $size);
                    }
                }
                if (isset($this->request->post['size_new'])) {
                    foreach ($this->request->post['size_new'] as $size) {
                        $this->model_extension_module_clients->addSize($size);
                    }
                }
                if (isset($this->request->post['care'])) {
                    $care = $this->request->post['care'];
                    if ($care['care_id'] !== '') {
                        $this->model_extension_module_clients->editCare($care['care_id'], $care);
                    } else {
                        $this->model_extension_module_clients->addCare($care);
                    }
                }
                if (isset($this->request->post['recommendation'])) {
                    foreach ($this->request->post['recommendation'] as $recommendation) {
                        $this->model_extension_module_clients->editRecommendation($recommendation['recommendation_id'], $recommendation);
                    }
                }
                if (isset($this->request->post['recommendation_new'])) {
                    foreach ($this->request->post['recommendation_new'] as $recommendation) {
                        $this->model_extension_module_clients->addRecommendation($recommendation);
                    }
                }
                if (isset($this->request->post['quality'])) {
                    foreach ($this->request->post['quality'] as $quality) {
                        $this->model_extension_module_clients->editQuality($quality['quality_id'], $quality);
                    }
                }
                if (isset($this->request->post['quality_new'])) {
                    foreach ($this->request->post['quality_new'] as $quality) {
                        $this->model_extension_module_clients->addQuality($quality);
                    }
                }
                if (isset($this->request->post['image'])) {
                    foreach ($this->request->post['image'] as $image) {
                        $this->model_extension_module_clients->editImage($image['image_id'], $image);
                    }
                }
                if (isset($this->request->post['image_new'])) {
                    foreach ($this->request->post['image_new'] as $image) {
                        $this->model_extension_module_clients->addImage($image);
                    }
                }
                if (isset($this->request->post['setting_exist']) && isset($this->request->post['settings']) && !empty($this->request->post['settings'])) {
                    $settings = $this->request->post['settings'];
                    if ($this->request->post['setting_exist'] == '0') {
                        $this->model_extension_module_clients->addSetting($settings);
                    } else if ($this->request->post['setting_exist'] == '1') {
                        $this->model_extension_module_clients->editSetting($settings);
                    }
                }

                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/module/clients', 'token=' . $this->session->data['token'], true));

            }
//            $this->model_extension_module_clients->editClients($this->request->get['clients_id'], $this->request->post);

            $url = '';

        }

        $this->getForm();
    }

    private function getFormLanguageVariables(&$data) {

        $data['heading_title'] = $this->language->get('heading_title');


        // Tabs
        $data['tab_textile'] = $this->language->get('tab_textile');
        $data['tab_sizes_table'] = $this->language->get('tab_sizes_table');
        $data['tab_recommendations'] = $this->language->get('tab_recommendations');
        $data['tab_quality'] = $this->language->get('tab_quality');
        $data['tab_slider'] = $this->language->get('tab_slider');
        $data['tab_settings'] = $this->language->get('tab_settings');

        // Entry
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_status_on'] = $this->language->get('entry_status_on');
        $data['entry_status_off'] = $this->language->get('entry_status_off');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');

        $data['entry_textile_description'] = $this->language->get('entry_textile_description');
        $data['entry_sizes_description'] = $this->language->get('entry_sizes_description');
        $data['entry_recommendation_description'] = $this->language->get('entry_recommendation_description');
        $data['entry_quality_description'] = $this->language->get('entry_quality_description');

        // Textile
        $data['entry_images'] = $this->language->get('entry_images');
        $data['entry_image_title'] = $this->language->get('entry_image_title');
        $data['entry_image_title_p'] = $this->language->get('entry_image_title_p');
        $data['button_textile_add'] = $this->language->get('button_textile_add');


        // Size
        $data['entry_age'] = $this->language->get('entry_age');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_chest'] = $this->language->get('entry_chest');
        $data['entry_thigh'] = $this->language->get('entry_thigh');
        $data['button_size_add'] = $this->language->get('button_size_add');

        // Recommendation
        $data['entry_care_text'] = $this->language->get('entry_care_text');
        $data['button_recommendation_add'] = $this->language->get('button_recommendation_add');
        $data['entry_recommendation'] = $this->language->get('entry_recommendation');


        // Texts
        $data['entry_text'] = $this->language->get('entry_text');
        $data['entry_title'] = $this->language->get('entry_title');
        $data['button_text_add'] = $this->language->get('button_text_add');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_remove'] = $this->language->get('button_remove');

        // Images
        $data['entry_slider_images'] = $this->language->get('entry_slider_images');
        $data['button_image_add'] = $this->language->get('button_image_add');
    }

    private function getEditor(&$data) {
        // Summernote
        $this->document->addScript('view/javascript/summernote/summernote.js');
        $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
        $this->document->addScript('view/javascript/summernote/opencart.js');
        $this->document->addStyle('view/javascript/summernote/summernote.css');
        $data['summernote'] = $this->config->get('config_editor_default');
    }

    private function getBreadcrumbs(&$data, $url) {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/clients', 'token=' . $this->session->data['token'] . $url, true)
        );
    }

    private function getFormValues(&$data,
                                   $textile_info = null,
                                   $size_info = null,
                                   $care_info = null,
                                   $recommendation_info = null,
                                   $quality_info = null,
                                   $image_info = null,
                                   $settings_info = null) {
        $this->load->model('tool/image');
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        // Textile fields
        if (isset($this->request->post['textile'])) {
            $textile = $this->request->post['textile'];
        } elseif (!empty($textile_info)) {
            $textile = $textile_info;

            if (count($textile) > 0) {
                end($textile);
                $last_sort_order_textile = $textile[key($textile)]['sort_order'];
            }
        } else {
            $textile = [];
            $data['textile'] = [];
        }

        if (isset($last_sort_order_textile)) {
            $data['last_sort_order_textile'] = ++$last_sort_order_textile;
        } else $data['last_sort_order_textile'] = 0;

        $this->fillTextile($data, $textile, 'textile');

        // new Textile fields
        if (isset($this->request->post['textile_new'])) {
            $textile_new = $this->request->post['textile_new'];
        } else {
            $textile_new = [];
            $data['textile_new'] = [];
        }

        $this->fillTextile($data, $textile_new, 'textile_new');

        // Size fields
        if (isset($this->request->post['size'])) {
            $size = $this->request->post['size'];
        } elseif (!empty($size_info)) {
            $size = $size_info;

            if (count($size) > 0) {
                end($size);
                $last_sort_order_size = $size[key($size)]['sort_order'];
            }
        } else {
            $size = [];
            $data['size'] = [];
        }

        if (isset($last_sort_order_size)) {
            $data['last_sort_order_size'] = ++$last_sort_order_size;
        } else $data['last_sort_order_size'] = 0;

        $this->fillSize($data, $size, 'size');

        // new Size fields
        if (isset($this->request->post['size_new'])) {
            $size_new = $this->request->post['size_new'];
        } else {
            $size_new = [];
            $data['size_new'] = [];
        }

        $this->fillSize($data, $size_new, 'size_new');

        // Care fields
        if (isset($this->request->post['care'])) {
            $data['care'] = $this->request->post['care'];
        } elseif (!empty($care_info)) {
            $data['care'] = $care_info;
        } else {
            $data['care'] = [];
        }

        // Recommendation fields
        if (isset($this->request->post['recommendation'])) {
            $recommendation = $this->request->post['recommendation'];
        } elseif (!empty($recommendation_info)) {
            $recommendation = $recommendation_info;

            if (count($recommendation) > 0) {
                end($recommendation);
                $last_sort_order_recommendation = $recommendation[key($recommendation)]['sort_order'];
            }
        } else {
            $recommendation = [];
            $data['recommendation'] = [];
        }

        if (isset($last_sort_order_recommendation)) {
            $data['last_sort_order_recommendation'] = ++$last_sort_order_recommendation;
        } else $data['last_sort_order_recommendation'] = 0;

        $this->fillRecommendation($data, $recommendation, 'recommendation');

        // new Textile fields
        if (isset($this->request->post['recommendation_new'])) {
            $recommendation_new = $this->request->post['recommendation_new'];
        } else {
            $recommendation_new = [];
            $data['recommendation_new'] = [];
        }

        $this->fillRecommendation($data, $recommendation_new, 'recommendation_new');

        // Quality fields
        if (isset($this->request->post['quality'])) {
            $quality = $this->request->post['quality'];
        } elseif (!empty($quality_info)) {
            $quality = $quality_info;

            if (count($quality) > 0) {
                end($quality);
                $last_sort_order_quality = $quality[key($quality)]['sort_order'];
            }
        } else {
            $quality = [];
            $data['quality'] = [];
        }

        if (isset($last_sort_order_quality)) {
            $data['last_sort_order_quality'] = ++$last_sort_order_quality;
        } else $data['last_sort_order_quality'] = 0;

        $this->fillQuality($data, $quality, 'quality');

        // new Quality fields
        if (isset($this->request->post['quality_new'])) {
            $quality_new = $this->request->post['quality_new'];
        } else {
            $quality_new = [];
            $data['quality_new'] = [];
        }

        $this->fillQuality($data, $quality_new, 'quality_new');

        // Image fields
        if (isset($this->request->post['image'])) {
            $image = $this->request->post['image'];
        } elseif (!empty($image_info)) {
            $image = $image_info;

            if (count($image) > 0) {
                end($image);
                $last_sort_order_image = $image[key($image)]['sort_order'];
            }
        } else {
            $image = [];
            $data['image'] = [];
        }

        if (isset($last_sort_order_image)) {
            $data['last_sort_order_image'] = ++$last_sort_order_image;
        } else $data['last_sort_order_image'] = 0;

        $this->fillImage($data, $image, 'image');

        // new Image fields
        if (isset($this->request->post['image_new'])) {
            $image_new = $this->request->post['image_new'];
        } else {
            $image_new = [];
            $data['image_new'] = [];
        }

        $this->fillImage($data, $image_new, 'image_new');

        // Settings
        if (isset($this->request->post['settings'])) {
            $data['settings'] = $this->request->post['settings'];
        } else if (!empty($settings_info)){
            $data['settings'] = $settings_info;
        } else {
            $data['settings'] = [];
        }

    }

    private function fillTextile(&$data, $textile, $name) {
        foreach ($textile as $item) {
            if (isset($item['image']) && is_file(DIR_IMAGE . $item['image'])) {
                $thumb = $this->model_tool_image->resize($item['image'], 100, 100);
                $image = $item['image'];
            } else {
                $thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
                $image = '';
            }
            $data[$name][] = array(
                'textile_id' => $item['textile_id'],
                'image'      => $image,
                'thumb'      => $thumb,
                'sort_order' => !isset($item['sort_order']) ? 0 : $item['sort_order'],
                'status' => !isset($item['status']) ? 0 : $item['status'],
                'description' => !isset($item['description']) ? ['', ''] : $item['description']
            );
        }
    }

    private function fillSize(&$data, $size, $name) {
        foreach ($size as $item) {
            $data[$name][] = array(
                'size_id' => $item['size_id'],
                'height'  => $item['height'],
                'chest'  => $item['chest'],
                'thigh'  => $item['thigh'],
                'sort_order' => !isset($item['sort_order']) ? 0 : $item['sort_order'],
                'status' => !isset($item['status']) ? 0 : $item['status'],
                'description' => !isset($item['description']) ? ['', ''] : $item['description']
            );
        }
    }

    private function fillRecommendation(&$data, $recommendation, $name) {
        foreach ($recommendation as $item) {
            if (isset($item['image']) && is_file(DIR_IMAGE . $item['image'])) {
                $thumb = $this->model_tool_image->resize($item['image'], 100, 100);
                $image = $item['image'];
            } else {
                $thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
                $image = '';
            }
            $data[$name][] = array(
                'recommendation_id' => $item['recommendation_id'],
                'image'      => $image,
                'thumb'      => $thumb,
                'sort_order' => !isset($item['sort_order']) ? 0 : $item['sort_order'],
                'status' => !isset($item['status']) ? 0 : $item['status'],
                'description' => !isset($item['description']) ? ['', ''] : $item['description']
            );
        }
    }

    private function fillQuality(&$data, $quality, $name) {
        foreach ($quality as $item) {
            $data[$name][] = array(
                'quality_id' => $item['quality_id'],
                'sort_order' => !isset($item['sort_order']) ? 0 : $item['sort_order'],
                'status' => !isset($item['status']) ? 0 : $item['status'],
                'description' => !isset($item['description']) ? ['', ''] : $item['description']
            );
        }
    }

    private function fillImage(&$data, $image, $name) {
        foreach ($image as $item) {
            if (isset($item['image']) && is_file(DIR_IMAGE . $item['image'])) {
                $thumb = $this->model_tool_image->resize($item['image'], 100, 100);
                $image = $item['image'];
            } else {
                $thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
                $image = '';
            }
            $data[$name][] = array(
                'image_id' => $item['image_id'],
                'image'      => $image,
                'thumb'      => $thumb,
                'sort_order' => !isset($item['sort_order']) ? 0 : $item['sort_order'],
                'status' => !isset($item['status']) ? 0 : $item['status'],
                'description' => !isset($item['description']) ? ['', ''] : $item['description']
            );
        }
    }

    protected function getForm() {

        $this->document->addStyle('view/javascript/jquery-ui/jquery-ui.css');
        $this->document->addStyle('https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
        $this->document->addScript('view/javascript/jquery-ui/jquery-ui.min.js');

        $this->getEditor($data);

        $this->getFormLanguageVariables($data);
        $this->getFormErrors($data);

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->session->data['warning'])) {
            $data['error_warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        } else {
            $data['error_warning'] = '';
        }

        $url = '';

        $this->getBreadcrumbs($data, $url);

        $data['action'] = $this->url->link('extension/module/clients/edit', 'token=' . $this->session->data['token'] . $url, true);

        $data['cancel'] = $this->url->link('extension/module/clients', 'token=' . $this->session->data['token'] . $url, true);

        $textile_info = null;
        $size_info = null;
        $care_info = null;
        $recommendation_info = null;
        $quality_info = null;
        $image_info = null;

        $settings_info = $this->model_extension_module_clients->getSettings();
        $textile_info = $this->model_extension_module_clients->getAllTextiles();
        $size_info = $this->model_extension_module_clients->getAllSizes();
        $care_info = $this->model_extension_module_clients->getAllCares();
        $recommendation_info = $this->model_extension_module_clients->getAllRecommendations();
        $quality_info = $this->model_extension_module_clients->getAllQualities();
        $image_info = $this->model_extension_module_clients->getAllImages();

        $data['token'] = $this->session->data['token'];

        $this->getFormValues($data, $textile_info, $size_info, $care_info, $recommendation_info, $quality_info, $image_info, $settings_info);

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/clients/clients_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'extension/module/clients')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (isset($this->request->post['textile'])) {
            foreach ($this->request->post['textile'] as $textile) {
                if (isset($textile['description'])) {
                    foreach ($textile['description'] as $language_id => $value) {
                        if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
                            $this->error['textile']['title'][$textile['textile_id']] = $this->language->get('error_title');
                        }
                    }
                }
            }
        }
        if (isset($this->request->post['textile_new'])) {
            foreach ($this->request->post['textile_new'] as $textile) {
                if (isset($textile['description'])) {
                    foreach ($textile['description'] as $language_id => $value) {
                        if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
                            $this->error['textile_new']['title'][$textile['textile_id']] = $this->language->get('error_title');
                        }
                    }
                }
            }
        }
        if (isset($this->request->post['care']['description'])) {
            foreach ($this->request->post['care']['description'] as $language_id => $value) {
                if ((utf8_strlen($value['text']) < 5) || (utf8_strlen($value['text']) > 700)) {
                    $this->error['care_text'][$language_id] = $this->language->get('error_care_text');
                }
            }
        }
        if (isset($this->request->post['recommendation'])) {
            foreach ($this->request->post['recommendation'] as $recommendation) {
                if (isset($recommendation['description'])) {
                    foreach ($recommendation['description'] as $language_id => $value) {
                        if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
                            $this->error['recommendation'][$recommendation['recommendation_id']]['title'][$language_id] = $this->language->get('error_title');
                        }
                        if ((utf8_strlen($value['description']) < 10) || (utf8_strlen($value['description']) > 255)) {
                            $this->error['recommendation'][$recommendation['recommendation_id']]['description'][$language_id] = $this->language->get('error_description');
                        }
                    }
                }
            }
        }
        if (isset($this->request->post['recommendation_new'])) {
            foreach ($this->request->post['recommendation_new'] as $recommendation) {
                if (isset($recommendation['description'])) {
                    foreach ($recommendation['description'] as $language_id => $value) {
                        if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
                            $this->error['recommendation_new'][$recommendation['recommendation_id']]['title'][$language_id] = $this->language->get('error_title');
                        }
                        if ((utf8_strlen($value['description']) < 10) || (utf8_strlen($value['description']) > 255)) {
                            $this->error['recommendation_new'][$recommendation['recommendation_id']]['description'][$language_id] = $this->language->get('error_description');
                        }
                    }
                }
            }
        }

        if (isset($this->request->post['image'])) {
            foreach ($this->request->post['image'] as $image) {
                if (isset($image['description'])) {
                    foreach ($image['description'] as $language_id => $value) {
                        if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
                            $this->error['image'][$image['image_id']]['title'][$language_id] = $this->language->get('error_title');
                        }
                    }
                }
            }
        }
        if (isset($this->request->post['image_new'])) {
            foreach ($this->request->post['image_new'] as $image) {
                if (isset($image['description'])) {
                    foreach ($image['description'] as $language_id => $value) {
                        if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
                            $this->error['image_new'][$image['image_id']]['title'][$language_id] = $this->language->get('error_title');
                        }
                    }
                }
            }
        }

        return !$this->error;
    }



    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/clients')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function install() {
        $this->load->model('extension/module/clients');
        $this->model_extension_module_clients->install();
    }
    public function uninstall() {
        $this->load->model('extension/module/clients');
        $this->model_extension_module_clients->uninstall();
    }

    private function getFormErrors(&$data) {
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['textile']['title'])) {
            $data['error_textile']['title'] = $this->error['textile']['title'];
        } else {
            $data['error_textile']['title'] = '';
        }
        if (isset($this->error['textile_new']['title'])) {
            $data['error_textile_new']['title'] = $this->error['textile_new']['title'];
        } else {
            $data['error_textile_new']['title'] = '';
        }
        if (isset($this->error['care_text'])) {
            $data['error_care_text'] = $this->error['care_text'];
            $this->session->data['warning'] = $this->language->get('warning_empty_care');
        } else {
            $data['error_care_text'] = '';
        }
        if (isset($this->error['recommendation'])) {
            $data['error_recommendation'] = $this->error['recommendation'];
            $this->session->data['warning'] = $this->language->get('warning_empty_recommendation');
        } else {
            $data['error_recommendation'] = '';
        }
        if (isset($this->error['recommendation_new'])) {
            $data['error_recommendation_new'] = $this->error['recommendation_new'];
            $this->session->data['warning'] = $this->language->get('warning_empty_recommendation');
        } else {
            $data['error_recommendation_new'] = '';
        }
        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
            $this->session->data['warning'] = $this->language->get('warning_empty_image');
        } else {
            $data['error_image'] = '';
        }
        if (isset($this->error['image_new'])) {
            $data['error_image_new'] = $this->error['image_new'];
            $this->session->data['warning'] = $this->language->get('warning_empty_image');
        } else {
            $data['error_image_new'] = '';
        }

    }
}