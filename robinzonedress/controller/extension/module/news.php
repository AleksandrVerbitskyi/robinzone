<?php
class ControllerExtensionModuleNews extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/news');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/news');
        
        $this->getList();
    }

    public function add() {
        $this->load->language('extension/module/news');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/news');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $this->model_extension_module_news->addNews($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('extension/module/news');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/news');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_extension_module_news->editNews($this->request->get['news_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('extension/module/news');

        $this->document->setTitle($this->language->get('heading_title_main'));

        $this->load->model('extension/module/news');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $news_id) {
                $this->model_extension_module_news->deleteNews($news_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList() {

        $this->getPageLanguageVariables($data);

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->getBreadcrumbs($data, $url);

        $data['add'] = $this->url->link('extension/module/news/add', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete'] = $this->url->link('extension/module/news/delete', 'token=' . $this->session->data['token'] . $url, true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . $url, true);
        $data['regenerate_seo_urls'] = $this->url->link('extension/module/news/regenerate_all_urls', 'token=' . $this->session->data['token'] . $url, true);


        $data['news'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

//        $banner_total = $this->model_extension_module_news->getTotalBanners();

        $results = $this->model_extension_module_news->getAllNews($filter_data);

        foreach ($results as $result) {
            $data['news'][] = array(
                'news_id' => $result['news_id'],
                'title'      => $result['title'],
                'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                'edit'      => $this->url->link('extension/module/news/edit', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, true)
            );
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_title'] = $this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . '&sort=title' . $url, true);
        $data['sort_status'] = $this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $banner_total = 0;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($banner_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($banner_total - $this->config->get('config_limit_admin'))) ? $banner_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $banner_total, ceil($banner_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/news/news_list', $data));
    }

    private function getFormLanguageVariables(&$data) {
        // Tabs
        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data'] = $this->language->get('tab_data');
        $data['tab_text'] = $this->language->get('tab_text');
        $data['tab_image'] = $this->language->get('tab_image');

        // General
        $data['entry_title'] = $this->language->get('entry_title');
        $data['entry_image_title'] = $this->language->get('entry_image_title');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');

        // Data
        $data['entry_published'] = $this->language->get('entry_published');
        $data['entry_published_by'] = $this->language->get('entry_published_by');
        $data['entry_last_edited'] = $this->language->get('entry_last_edited');
        $data['entry_last_edited_by'] = $this->language->get('entry_last_edited_by');
        $data['entry_thumb'] = $this->language->get('entry_thumb');
        $data['entry_image'] = $this->language->get('entry_image');
        $data['entry_keyword'] = $this->language->get('entry_keyword');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_status_on'] = $this->language->get('entry_status_on');
        $data['entry_status_off'] = $this->language->get('entry_status_off');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        // Texts
        $data['entry_text'] = $this->language->get('entry_text');
        $data['entry_text_sort_order'] = $this->language->get('entry_text_sort_order');
        $data['button_text_add'] = $this->language->get('button_text_add');

        // Images
        $data['entry_slider_images'] = $this->language->get('entry_slider_images');
        $data['button_image_add'] = $this->language->get('button_image_add');
    }

    private function getPageLanguageVariables(&$data) {
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] = !isset($this->request->get['news_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_default'] = $this->language->get('text_default');

        $data['entry_link'] = $this->language->get('entry_link');
        $data['entry_button_text'] = $this->language->get('entry_button_text');
        // Buttons
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_regenerate'] = $this->language->get('button_regenerate');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_title'] = $this->language->get('column_title');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_action'] = $this->language->get('column_action');
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
            'href' => $this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . $url, true)
        );
    }

    private function getFormValues(&$data, $news_info = null) {
        // Main fields
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($news_info)) {
            $data['status'] = $news_info['status'];
        } else {
            $data['status'] = false;
        }
        if (isset($this->request->post['keyword'])) {
            $data['keyword'] = $this->request->post['keyword'];
        } elseif (!empty($news_info)) {
            $data['keyword'] = $news_info['keyword'];
        } else {
            $data['keyword'] = '';
        }
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($news_info)) {
            $data['sort_order'] = $news_info['sort_order'];
        } else {
            $data['sort_order'] = '0';
        }
        if (isset($this->request->post['published'])) {
            $data['published'] = $this->request->post['published'];
        } elseif (!empty($news_info)) {
            $data['published'] = date('Y-m-d H:i', $news_info['published']);
            $data['published_block'] = false;
        } else {
            $data['published'] = date("Y-m-d H:i");
            $data['published_block'] = true;
        }
        if (isset($this->request->post['published_by'])) {
            $data['published_by'] = $this->request->post['published_by'];
        } elseif (!empty($news_info)) {
            $data['published_by'] = $news_info['published_by'];
        } else {
            $data['published_by'] = $this->user->getUserName();
        }
        if (isset($this->request->get['news_id'])) {
            if (isset($this->request->post['last_edited'])) {
                $data['last_edited'] = $this->request->post['last_edited'];
            } else {
                $data['last_edited'] = date("Y-m-d H:i");
            }
        }
        if (isset($this->request->get['news_id'])) {
            if (isset($this->request->post['last_edited_by'])) {
                $data['last_edited_by'] = $this->request->post['last_edited_by'];
            } else {
                $data['last_edited_by'] = $this->user->getUserName();
            }
        }

        $this->load->model('tool/image');
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['thumb'])) {
            $data['thumb'] = '/image/' . $this->request->post['thumb'];
        } elseif (!empty($news_info)) {
            $data['thumb'] = $news_info['thumb'];
        } else {
            $data['thumb'] = '';
        }

        if (isset($this->request->post['thumb']) && is_file(DIR_IMAGE . $this->request->post['thumb'])) {
            $data['thumb_thumb'] = $this->model_tool_image->resize($this->request->post['thumb'], 100, 100);
        } elseif (!empty($news_info) && is_file(DIR_IMAGE . $news_info['thumb'])) {
            $data['thumb_thumb'] = $this->model_tool_image->resize($news_info['thumb'], 100, 100);
        } else {
            $data['thumb_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        if (isset($this->request->post['image'])) {
            $data['image'] = '/image/' . $this->request->post['image'];
        } elseif (!empty($news_info)) {
            $data['image'] = $news_info['image'];
        } else {
            $data['image'] = '';
        }

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['image_thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($news_info) && is_file(DIR_IMAGE . $news_info['image'])) {
            $data['image_thumb'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
        } else {
            $data['image_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        // Description fields
        if (isset($this->request->post['news_description'])) {
            $data['news_description'] = $this->request->post['news_description'];
        } elseif (isset($this->request->get['news_id'])) {
            $data['news_description'] = $this->model_extension_module_news->getNewsDescriptions($this->request->get['news_id']);
        } else {
            $data['news_description'] = [];
        }

        // Text fields
        if (isset($this->request->post['news_texts'])) {
            $data['news_texts'] = $this->request->post['news_texts'];
        } elseif (isset($this->request->get['news_id'])) {
            $data['news_texts'] = $this->model_extension_module_news->getNewsTexts($this->request->get['news_id']);
            if (count($data['news_texts']) > 0) {
                end($data['news_texts']);
                $last_sort_order_texts = $data['news_texts'][key($data['news_texts'])]['sort_order'];
            }
        } else {
            $data['news_texts'] = [];
        }

        if (isset($last_sort_order_texts)) {
            $data['last_sort_order_texts'] = ++$last_sort_order_texts;
        } else $data['last_sort_order_texts'] = 0;

        // Image fields
        if (isset($this->request->post['news_images'])) {
            $news_images = $this->request->post['news_images'];
        } elseif (isset($this->request->get['news_id'])) {
            $news_images = $this->model_extension_module_news->getNewsImages($this->request->get['news_id']);
            if (count($news_images) > 0) {
                end($news_images);
                $last_sort_order_images = $news_images[key($news_images)]['sort_order'];
            }
        } else {
            $news_images = [];
        }

        $data['news_images'] = array();

        foreach ($news_images as $news_image) {
            if (is_file(DIR_IMAGE . $news_image['image'])) {
                $image = $news_image['image'];
                $thumb = $news_image['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['news_images'][] = array(
                'image'      => $image,
                'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order' => $news_image['sort_order']
            );
        }
        if (isset($last_sort_order_images)) {
            $data['last_sort_order_images'] = ++$last_sort_order_images;
        } else $data['last_sort_order_images'] = 0;
    }

    protected function getForm() {

        $this->document->addStyle('view/javascript/jquery-ui/jquery-ui.css');
        $this->document->addStyle('https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
        $this->document->addScript('view/javascript/jquery-ui/jquery-ui.min.js');

        $this->getEditor($data);

        $this->getPageLanguageVariables($data);
        $this->getFormLanguageVariables($data);
        $this->getFormErrors($data);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->getBreadcrumbs($data, $url);

        if (!isset($this->request->get['news_id'])) {
            $data['action'] = $this->url->link('extension/module/news/add', 'token=' . $this->session->data['token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('extension/module/news/edit', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . $url, true);

        $news_info = null;

        if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $news_info = $this->model_extension_module_news->getNews($this->request->get['news_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->getFormValues($data, $news_info);

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/news/news_form', $data));
    }

//    protected function validateForm() {
//        if (!$this->user->hasPermission('modify', 'extension/module/news')) {
//            $this->error['warning'] = $this->language->get('error_permission');
//        }
//
//        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
//            $this->error['name'] = $this->language->get('error_name');
//        }
//
//        if (isset($this->request->post['banner_image'])) {
//            foreach ($this->request->post['banner_image'] as $language_id => $value) {
//                foreach ($value as $banner_image_id => $banner_image) {
////					if ((utf8_strlen($banner_image['title']) < 2) || (utf8_strlen($banner_image['title']) > 64)) {
////						$this->error['banner_image'][$language_id][$banner_image_id] = $this->language->get('error_title');
////					}
//                }
//            }
//        }
//
//        return !$this->error;
//    }

    public function regenerate_all_urls() {
        $this->load->model('extension/module/news');
        $this->model_extension_module_news->regenerate_all_urls();
        $this->response->redirect($this->url->link('extension/module/news', 'token=' . $this->session->data['token'] . '', true));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/news')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function install() {
        $this->load->model('extension/module/news');
        $this->model_extension_module_news->install();
    }
    public function uninstall() {
        $this->load->model('extension/module/news');
        $this->model_extension_module_news->uninstall();
    }

    private function getFormErrors(&$data) {
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['thumb'])) {
            $data['error_thumb'] = $this->error['thumb'];
        } else {
            $data['error_thumb'] = '';
        }
        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = '';
        }
        if (isset($this->error['status'])) {
            $data['error_status'] = $this->error['status'];
        } else {
            $data['error_status'] = '';
        }
        if (isset($this->error['sort_order'])) {
            $data['error_sort_order'] = $this->error['sort_order'];
        } else {
            $data['error_sort_order'] = '';
        }
        if (isset($this->error['published'])) {
            $data['error_published'] = $this->error['published'];
        } else {
            $data['error_published'] = '';
        }
        if (isset($this->error['published_by'])) {
            $data['error_published_by'] = $this->error['published_by'];
        } else {
            $data['error_published_by'] = '';
        }
        if (isset($this->error['last_edited'])) {
            $data['error_last_edited'] = $this->error['last_edited'];
        } else {
            $data['error_last_edited'] = '';
        }
        if (isset($this->error['last_edited_by'])) {
            $data['error_last_edited_by'] = $this->error['last_edited_by'];
        } else {
            $data['error_last_edited_by'] = '';
        }


        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = '';
        }
        if (isset($this->error['image_title'])) {
            $data['error_image_title'] = $this->error['image_title'];
        } else {
            $data['error_image_title'] = '';
        }

        if (isset($this->error['text'])) {
            $data['error_text'] = $this->error['text'];
        } else {
            $data['error_text'] = '';
        }
    }
}