<?php

class ModelExtensionShippingukrposhta extends Model {

    function getQuote($address) {
        $this->load->language('extension/shipping/ukrposhta');

        if ($address == '') {
            $status = true;
        } elseif ($this->config->get('ukrposhta_status')) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE 
            geo_zone_id = '" . (int) $this->config->get('ukrposhta_geo_zone_id') . "' 
            AND country_id = '" . (int) $address['country_id'] . "' 
            AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

            if (!$this->config->get('ukrposhta_geo_zone_id')) {
                $status = TRUE;
            } elseif ($query->num_rows) {
                $status = TRUE;
            } else {
                $status = FALSE;
            }
        } else {
            $status = FALSE;
        }

        $method_data = array();

        if ($status) {
            $quote_data = array();

            $cost = 0.00;
            if ($this->config->get('ukrposhta_min_total_for_free_ukrposhta') > $this->cart->getSubTotal()) {
                $cost = $this->config->get('ukrposhta_ukrposhta_price');
            }

            $quote_data['ukrposhta'] = array(
                'code' => 'ukrposhta.ukrposhta',
                'title' => $this->language->get('text_description'),
                'cost' => $cost,
                'tax_class_id' => 0,
                //'text'         => 'Стоимость можно расчитать с помощью Калькулятора' //$this->currency->format($cost)
                'text' => $this->currency->format($cost, $this->session->data['currency'])
            );

            $method_data = array(
                'code' => 'ukrposhta',
                'title' => $this->language->get('text_title'),
                'image' => $this->language->get('shipping_image'),
                'quote' => $quote_data,
                'sort_order' => $this->config->get('ukrposhta_sort_order'),
                'error' => FALSE
            );
        }

        return $method_data;
    }

}

?>