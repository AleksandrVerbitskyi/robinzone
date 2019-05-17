<?php
class ControllerAccountForgottenSuccess extends Controller {
    private $error = array();

    public function index() {
        if ($this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/account', '', true));
        }

        $this->load->language('account/forgotten');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/customer');

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_forgotten'),
            'href' => $this->url->link('account/forgotten', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_forgotten_success'),
            'href' => $this->url->link('account/forgotten_success', '', true)
        );

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_success'] = $this->language->get('text_success');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['text_button_forgotten'] = $this->language->get('text_button_forgotten');
        $data['text_button_forgotten_success'] = $this->language->get('text_button_forgotten_success');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['back'] = $this->url->link('product/category', 'path=' . '61' , true);

        $this->document->setBreadcrumbs($data['breadcrumbs']);

        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('account/forgotten_success', $data));
    }
}
