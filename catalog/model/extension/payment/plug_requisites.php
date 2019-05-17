<?php
class ModelExtensionPaymentPlugRequisites extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/plug_requisites');

        $method_data = array(
            'code'       => 'plug_requisites',
            'title'      => $this->language->get('text_title'),
            'image'      => $this->language->get('image'),
            'terms'      => '',
            'sort_order' => $this->config->get('plug_requisites_sort_order')
        );

		return $method_data;
	}
}