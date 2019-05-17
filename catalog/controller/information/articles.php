<?php
class ControllerInformationArticles extends Controller {
    public function index() {
        $this->load->language('information/articles');
        $this->load->model('extension/module/news');
        $this->load->model('tool/image');

        $this->load->model('tool/monthformat');

        $this->load->model('localisation/language');
        $language_code = $this->model_localisation_language->getLanguage($this->config->get('config_language_id'))['code'];

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/articles')
        );

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = (int)$this->request->get['limit'];
        } else {
            $limit = 12;
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_top5'] = $this->language->get('text_top5');

        $parameters = [
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        ];

        if (isset($this->request->get['news_id'])) {
            $news_id = $this->request->get['news_id'];
        } else $news_id = false;

        if ($news_id) {
            $news_item = $this->model_extension_module_news->getSingleNews($news_id);

            $this->document->setTitle($news_item['title']);
            $data['title'] = $news_item['title'];
            foreach ($news_item['content'] as $content) {
                if ($content['type'] == 'text') {
//                    $this->document->setDescription($content['value']);
                    break;
                }
            }

            $this->model_extension_module_news->setViewed($news_id);
            $top5 = $this->model_extension_module_news->getMostViewed(5);
            foreach ($top5 as $index => $item) {
                $top5[$index]['url'] = $this->url->link('information/articles', 'news_id=' . $item['news_id'], true);
            }
            $data['top5'] = $top5;
            if ($news_item['image']) {
                $news_item['image'] = $this->model_tool_image->resize($news_item['image'], 720, 208);
            } else {
                $news_item['image'] = $this->model_tool_image->resize('placeholder.png', 720, 208);
            }
            if ($news_item['published']) {
                $news_item['published'] = $this->model_tool_monthformat->format($news_item['published'], $language_code);
            }

            $data['breadcrumbs'][] = array(
                'text' => $news_item['title'],
                'href' => $this->url->link('information/articles', 'news_id=' . $news_item['news_id'], true)
            );

            $data['news'] = $news_item;
            $this->document->setOgType('article');
            $this->document->setOgImage($news_item['image']);
            $data['news_url'] = str_replace('www.', '',$this->url->link('information/articles', 'news_id=' . $news_item['news_id'], true));
            $data['news_url'] = urlencode($data['news_url']);

            $this->document->setBreadcrumbs($data['breadcrumbs']);

            $this->getLayouts($data);

            $this->response->setOutput($this->load->view('information/single_article', $data));
        } else {

            $this->document->setTitle($this->language->get('heading_title'));
            $data['title'] = $this->language->get('heading_title');

            $news = $this->model_extension_module_news->getAllNews($parameters);

            foreach ($news as $index => $item) {
                $news[$index]['url'] = $this->url->link('information/articles', 'news_id=' . $item['news_id'], true);
                if ($item['thumb']) {
                    $news[$index]['thumb'] = $this->model_tool_image->resize($item['thumb'], 255, 168);
                } else {
                    $news[$index]['thumb'] = $this->model_tool_image->resize('placeholder.png', 255, 168);
                }
                if (!empty($item['texts']) && is_array($item['texts'])) {
                    $text = html_entity_decode($item['texts'][0]['text']);
                    $text = strip_tags($text);
                    $news[$index]['text'] = substr($text, 0, 500);
                } else $news[$index]['text'] = '';
                if ($item['published']) {
                    $news[$index]['published'] = $this->model_tool_monthformat->format($item['published'], $language_code);
                }

            }

            $data['news'] = $news;

            $url = '';

            $pagination = new Pagination();
            $pagination->total = $this->model_extension_module_news->getTotalNews();
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('information/articles', $url . '&page={page}');

            $data['pagination'] = $pagination->renderFront();

            $this->document->setBreadcrumbs($data['breadcrumbs']);

            $this->getLayouts($data);

            $this->response->setOutput($this->load->view('information/articles', $data));
        }
    }

    private function getLayouts(&$data) {
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
    }
}