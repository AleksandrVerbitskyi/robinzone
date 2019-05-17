<?php
class ControllerCheckoutConfirm extends Controller {

    protected $address1 = '';
    protected $address2 = '';
    protected $city = '';
    protected $company = '';

    public function index() {
        // Validate minimum quantity requirements.
        $products = $this->cart->getProducts();
        $json = $this->validate();

//        echo "<pre>";
//        print_r($json);
//
//        die();

        $this->load->model('account/address');

        if ($json) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {
            if (!$this->customer->isLogged() && isset($this->request->post['account']) && ($this->request->post['account'] == 'register' || $this->request->post['account'] == 'guest')) {
                // Get shipping address BEGIN
                $this->load->model('extension/module/novaposhta_api');
                $this->load->model('extension/module/intime_api');
                $this->load->model('extension/module/autolux_api');
                $this->load->model('extension/module/ukrposhta_api');
                $shipping_method = explode('.', $this->request->post['shipping_method'])[0] . '_api';
                $model = 'model_extension_module_' . $shipping_method;
                $shipping_area = $this->{$model}->getArea($this->request->post['shipping_area']);
                $shipping_city = $this->{$model}->getCity($this->request->post['shipping_city']);
                if ($shipping_method !== 'ukrposhta_api') {
                    $shipping_warehouse = $this->{$model}->getWarehouse($this->request->post['shipping_warehouse']);
                } else {
                    $shipping_warehouse = $this->request->post['shipping_warehouse'];
                }
                $this->address1 = $shipping_area;
                $this->address2 = $shipping_city;
                $this->city = $shipping_warehouse;
                // Get shipping address END
            }

            foreach ($products as $product) {
                $product_total = 0;

                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total += $product_2['quantity'];
                    }
                }

                if ($product['minimum'] > $product_total) {
                    $redirect = $this->url->link('checkout/cart');

                    break;
                }
            }


            $order_data = array();

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = array(
                'totals' => &$totals,
                'taxes'  => &$taxes,
                'total'  => &$total
            );

            $this->load->model('extension/extension');

            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);

            $order_data['totals'] = $totals;

            $this->load->language('checkout/checkout');

            $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $order_data['store_id'] = $this->config->get('config_store_id');
            $order_data['store_name'] = $this->config->get('config_name');

            if ($order_data['store_id']) {
                $order_data['store_url'] = $this->config->get('config_url');
            } else {
                if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $order_data['store_url'] = HTTPS_SERVER;
                } else {
                    $order_data['store_url'] = HTTP_SERVER;
                }
            }

            if ($this->customer->isLogged()) {
                $this->load->model('account/customer');

                $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

                $order_data['customer_id'] = $this->customer->getId();
                $order_data['customer_group_id'] = $customer_info['customer_group_id'];
                $order_data['firstname'] = $order_data['payment_firstname'] = $customer_info['firstname'];
                $order_data['lastname'] = $order_data['payment_lastname'] = $customer_info['lastname'];
                $order_data['email'] = $customer_info['email'];
                $order_data['telephone'] = $customer_info['telephone'];
                $order_data['fax'] = $customer_info['fax'];
                $order_data['custom_field'] = json_decode($customer_info['custom_field'], true);

                $address_id = $this->customer->getAddressId();
                $address_info = $this->model_account_address->getAddress($address_id);

                if (!$address_info) {
                    $order_data['firstname'] = $this->request->post['shipping']['firstname'];
                    $order_data['lastname'] = $this->request->post['shipping']['lastname'];
                    $order_data['payment_company'] = '';
                    $order_data['payment_address_1'] =  $this->request->post['shipping']['address_1'];
                    $order_data['payment_address_2'] = '';
                    $order_data['payment_city'] = $this->request->post['shipping']['city'];
                    $order_data['payment_postcode'] = '';

                    $this->load->model('account/address');
                    $new_address = [
                        'firstname' => $customer_info['firstname'],
                        'lastname' => $customer_info['lastname'],
                        'company' => '',
                        'address_1' => '',
                        'address_2' => $order_data['payment_city'],
                        'postcode' => '',
                        'city' => $order_data['payment_address_1'],
                        'default' => '1',
                    ];
                    $this->model_account_address->addAddress($new_address);
                } else {
                    $order_data['payment_company'] = $address_info['company'];
                    $order_data['payment_address_1'] = $address_info['address_1'];
                    $order_data['payment_address_2'] = $address_info['address_2'];
                    $order_data['payment_city'] = $address_info['city'];
                    $order_data['payment_postcode'] = $address_info['postcode'];
                }
                $order_data['payment_address_format'] = '';
                $order_data['payment_custom_field'] = '';
            } else {
                $order_data['customer_id'] = 0;
                $order_data['customer_group_id'] = 1;
                $this->session->data['guest']['firstname'] = $order_data['firstname'] = $this->request->post['firstname'];
                $this->session->data['guest']['lastname'] = $order_data['lastname'] = $this->request->post['lastname'];
                $this->session->data['guest']['email'] = $order_data['email'] = $this->request->post['email'];
                $this->session->data['guest']['telephone'] = $order_data['telephone'] = $this->request->post['telephone'];
                $this->session->data['guest']['fax'] = $order_data['fax'] = '';
                $this->session->data['guest']['custom_field'] = $order_data['custom_field'] = [];

                $order_data['payment_firstname'] = $this->request->post['firstname'];
                $order_data['payment_lastname'] = $this->request->post['lastname'];

//                $order_data['payment_company'] = $this->request->post['company'];
                $order_data['payment_company'] = '';
                $order_data['payment_address_1'] = $this->address1;
                $order_data['payment_address_2'] = $this->address2;
                $order_data['payment_city'] = $this->city;
//                $order_data['payment_postcode'] = $this->request->post['postcode'];
                $order_data['payment_postcode'] = '';
                $order_data['payment_address_format'] = '';
                $order_data['payment_custom_field'] = '';
            }

            if (isset($this->session->data['payment_methods'][$this->request->post['payment_method']]['title'])) {
                $order_data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']]['title'];
            } else {
                $order_data['payment_method'] = '';
            }

            if (isset($this->request->post['payment_method'])) {
                $order_data['payment_code'] = $this->request->post['payment_method'];
            } else {
                $order_data['payment_code'] = '';
            }

            if ($this->cart->hasShipping()) {
                if ($this->customer->isLogged()) {
                    if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
                        $address_id = $this->request->post['address_id'];
                        $address_info = $this->model_account_address->getAddress($address_id);
                        $order_data['shipping_firstname'] = $address_info['firstname'];
                        $order_data['shipping_lastname'] = $address_info['lastname'];
                        $order_data['shipping_company'] = $address_info['company'];
                        $order_data['shipping_address_1'] = $address_info['address_1'];
                        $order_data['shipping_address_2'] = $address_info['address_2'];
                        $order_data['shipping_city'] = $address_info['city'];
                        $order_data['shipping_postcode'] = $address_info['postcode'];
                    } else if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'new') {
                        $order_data['shipping_firstname'] = $this->customer->getFirstName();
                        $order_data['shipping_lastname'] = $this->customer->getLastName();
//                        $order_data['shipping_company'] = $this->request->post['shipping']['company'];
//                        $order_data['shipping_postcode'] = $this->request->post['shipping']['postcode'];
//                        $order_data['shipping_address_1'] = $this->request->post['shipping']['address_1'];
//                        $order_data['shipping_address_2'] = $this->request->post['shipping']['address_2'];
//                        $order_data['shipping_city'] = $this->request->post['shipping']['city'];

                        // Get shipping address BEGIN
                        $this->load->model('extension/module/novaposhta_api');
                        $this->load->model('extension/module/intime_api');
                        $this->load->model('extension/module/autolux_api');
                        $this->load->model('extension/module/ukrposhta_api');
                        $shipping_method = explode('.', $this->request->post['shipping_method'])[0] . '_api';
                        $model = 'model_extension_module_' . $shipping_method;
                        $shipping_area = $this->{$model}->getArea($this->request->post['shipping_area']);
                        $shipping_city = $this->{$model}->getCity($this->request->post['shipping_city']);
                        if ($shipping_method !== 'ukrposhta_api') {
                            $shipping_warehouse = $this->{$model}->getWarehouse($this->request->post['shipping_warehouse']);
                        } else {
                            $shipping_warehouse = $this->request->post['shipping_warehouse'];
                        }
                        $this->address1 = $shipping_area;
                        $this->address2 = $shipping_city;
                        $this->city = $shipping_warehouse;
                        // Get shipping address END

                        $order_data['shipping_firstname'] = $this->request->post['shipping']['firstname'];
                        $order_data['shipping_lastname'] = $this->request->post['shipping']['lastname'];
                        $order_data['shipping_company'] = '';
                        $order_data['shipping_address_1'] = $this->address1;
                        $order_data['shipping_address_2'] = $this->address2;
                        $order_data['shipping_city'] = $this->city;
                        $order_data['shipping_postcode'] = '';
                    } else {
                        // Get shipping address BEGIN
                        $this->load->model('extension/module/novaposhta_api');
                        $this->load->model('extension/module/intime_api');
                        $this->load->model('extension/module/autolux_api');
                        $this->load->model('extension/module/ukrposhta_api');
                        $shipping_method = explode('.', $this->request->post['shipping_method'])[0] . '_api';
                        $model = 'model_extension_module_' . $shipping_method;
                        $shipping_area = $this->{$model}->getArea($this->request->post['shipping_area']);
                        $shipping_city = $this->{$model}->getCity($this->request->post['shipping_city']);
                        if ($shipping_method !== 'ukrposhta_api') {
                            $shipping_warehouse = $this->{$model}->getWarehouse($this->request->post['shipping_warehouse']);
                        } else {
                            $shipping_warehouse = $this->request->post['shipping_warehouse'];
                        }
                        $this->address1 = $shipping_area;
                        $this->address2 = $shipping_city;
                        $this->city = $shipping_warehouse;
                        // Get shipping address END
                        $order_data['shipping_firstname'] = $this->request->post['shipping']['firstname'];
                        $order_data['shipping_lastname'] = $this->request->post['shipping']['lastname'];
                        $order_data['shipping_company'] = '';
                        $order_data['shipping_address_1'] = $this->address1;
                        $order_data['shipping_address_2'] = $this->address2;
                        $order_data['shipping_city'] = $this->city;
                        $order_data['shipping_postcode'] = '';
                        $this->load->model('account/address');
                        $new_address = [
                            'firstname' => $customer_info['firstname'],
                            'lastname' => $customer_info['lastname'],
                            'company' => '',
                            'address_1' => $this->address1,
                            'address_2' => $this->address2,
                            'postcode' => '',
                            'city' => $this->city,
                            'default' => '1',
                        ];
                        $this->model_account_address->addAddress($new_address);
                    }
                    $order_data['shipping_address_format'] = '';
                    $order_data['shipping_custom_field'] = '';
                } else {
                    $order_data['shipping_firstname'] = $this->request->post['firstname'];
                    $order_data['shipping_lastname'] = $this->request->post['lastname'];

//                    $order_data['shipping_company'] = $this->request->post['shipping']['company'];
                    $order_data['shipping_company'] = '';
                    $order_data['shipping_address_1'] = $this->address1;
                    $order_data['shipping_address_2'] = $this->address2;
                    $order_data['shipping_city'] = $this->city;
//                    $order_data['shipping_postcode'] = $this->request->post['shipping']['postcode'];
                    $order_data['shipping_postcode'] = '';
                    $order_data['shipping_address_format'] = '';
                    $order_data['shipping_custom_field'] = '';
                }

                if (isset($this->session->data['shipping_methods'][explode('.', $this->request->post['shipping_method'])[0]]['title'])) {
                    $order_data['shipping_method'] = $this->session->data['shipping_methods'][explode('.', $this->request->post['shipping_method'])[0]]['title'];
                } else {
                    $order_data['shipping_method'] = '';
                }

                if (isset($this->request->post['shipping_method'])) {
                    $order_data['shipping_code'] = $this->request->post['shipping_method'];
                } else {
                    $order_data['shipping_code'] = '';
                }
            } else {
                $order_data['shipping_firstname'] = '';
                $order_data['shipping_lastname'] = '';
                $order_data['shipping_company'] = '';
                $order_data['shipping_address_1'] = '';
                $order_data['shipping_address_2'] = '';
                $order_data['shipping_city'] = '';
                $order_data['shipping_postcode'] = '';
                $order_data['shipping_zone'] = '';
                $order_data['shipping_zone_id'] = '';
                $order_data['shipping_country'] = '';
                $order_data['shipping_country_id'] = '';
                $order_data['shipping_address_format'] = '';
                $order_data['shipping_custom_field'] = array();
                $order_data['shipping_method'] = '';
                $order_data['shipping_code'] = '';
            }

            $order_data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    $option_data[] = array(
                        'product_option_id'       => $option['product_option_id'],
                        'product_option_value_id' => $option['product_option_value_id'],
                        'option_id'               => $option['option_id'],
                        'option_value_id'         => $option['option_value_id'],
                        'name'                    => $option['name'],
                        'value'                   => $option['value'],
                        'type'                    => $option['type']
                    );
                }

                $order_data['products'][] = array(
                    'product_id' => $product['product_id'],
                    'name'       => $product['name'],
                    'model'      => $product['model'],
                    'option'     => $option_data,
                    'download'   => $product['download'],
                    'quantity'   => $product['quantity'],
                    'subtract'   => $product['subtract'],
                    'price'      => $product['price'],
                    'total'      => $product['total'],
                    'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
                    'reward'     => $product['reward']
                );
            }

            // Gift Voucher
            $order_data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $order_data['vouchers'][] = array(
                        'description'      => $voucher['description'],
                        'code'             => token(10),
                        'to_name'          => $voucher['to_name'],
                        'to_email'         => $voucher['to_email'],
                        'from_name'        => $voucher['from_name'],
                        'from_email'       => $voucher['from_email'],
                        'voucher_theme_id' => $voucher['voucher_theme_id'],
                        'message'          => $voucher['message'],
                        'amount'           => $voucher['amount']
                    );
                }
            }

            $order_data['comment'] = $this->request->post['comment'];
            $order_data['total'] = $total_data['total'];

            if (isset($this->request->cookie['tracking'])) {
                $order_data['tracking'] = $this->request->cookie['tracking'];

                $subtotal = $this->cart->getSubTotal();

                // Affiliate
                $this->load->model('affiliate/affiliate');

                $affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

                if ($affiliate_info) {
                    $order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
                    $order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
                } else {
                    $order_data['affiliate_id'] = 0;
                    $order_data['commission'] = 0;
                }

                // Marketing
                $this->load->model('checkout/marketing');

                $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

                if ($marketing_info) {
                    $order_data['marketing_id'] = $marketing_info['marketing_id'];
                } else {
                    $order_data['marketing_id'] = 0;
                }
            } else {
                $order_data['affiliate_id'] = 0;
                $order_data['commission'] = 0;
                $order_data['marketing_id'] = 0;
                $order_data['tracking'] = '';
            }

            $order_data['language_id'] = $this->config->get('config_language_id');
            $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
            $order_data['currency_code'] = $this->session->data['currency'];
            $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
            $order_data['ip'] = $this->request->server['REMOTE_ADDR'];

            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
            } else {
                $order_data['forwarded_ip'] = '';
            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {
                $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
            } else {
                $order_data['user_agent'] = '';
            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $order_data['accept_language'] = '';
            }

            if (!$this->customer->isLogged() && isset($this->request->post['account']) && $this->request->post['account'] == 'register') {
                $this->load->model('account/customer');
                $new_address = [
                    'firstname' => $this->request->post['firstname'],
                    'lastname' => $this->request->post['lastname'],
                    'company' => '',
                    'address_1' => $this->address1,
                    'address_2' => $this->address2,
                    'postcode' => '',
                    'city' => $this->city,
                    'default' => '1',
                ];
                $this->request->post = array_merge($this->request->post, $new_address);
                $result = $this->model_account_customer->addCustomer($this->request->post);
                if (isset($result['customer_id'])) {
                    $this->model_account_customer->deleteLoginAttempts($this->request->post['email']);

                    $this->session->data['account'] = 'register';

                    $this->load->model('account/customer_group');
                // Customer Group
                    if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                        $customer_group_id = $this->request->post['customer_group_id'];
                    } else {
                        $customer_group_id = $this->config->get('config_customer_group_id');
                    }
                    $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

                    if ($customer_group_info && !$customer_group_info['approval']) {
                        $this->customer->login($this->request->post['email'], $this->request->post['password']);
                    }

                    unset($this->session->data['guest']);

                    $this->cart = new Cart\Cart($this->registry);

                    // Add to activity log
                    $this->load->model('account/activity');

                    $activity_data = array(
                        'customer_id' => $result['customer_id'],
                        'name' => $this->request->post['firstname'].' '.$this->request->post['lastname']
                    );

                    $this->model_account_activity->addActivity('register', $activity_data);

                    $this->customer->login($this->request->post['email'], $this->request->post['password']);

                    $order_data['customer_id'] = $this->customer->getId();
//                    $this->load->model('account/address');
//                    $new_address = [
//                        'firstname' => $this->request->post['firstname'],
//                        'lastname' => $this->request->post['lastname'],
//                        'company' => '',
//                        'address_1' => $this->address1,
//                        'address_2' => $this->address2,
//                        'postcode' => '',
//                        'city' => $this->city,
//                        'default' => '1',
//                    ];
//                    $this->model_account_address->addAddress($new_address);
                }
            }

            $this->load->model('checkout/order');

            $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

            $data['text_recurring_item'] = $this->language->get('text_recurring_item');
            $data['text_payment_recurring'] = $this->language->get('text_payment_recurring');

            $data['column_name'] = $this->language->get('column_name');
            $data['column_model'] = $this->language->get('column_model');
            $data['column_quantity'] = $this->language->get('column_quantity');
            $data['column_price'] = $this->language->get('column_price');
            $data['column_total'] = $this->language->get('column_total');

            $this->load->model('tool/upload');

            $data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $value = $upload_info['name'];
                        } else {
                            $value = '';
                        }
                    }

                    $option_data[] = array(
                        'name'  => $option['name'],
                        'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                    );
                }

                $recurring = '';

                if ($product['recurring']) {
                    $frequencies = array(
                        'day'        => $this->language->get('text_day'),
                        'week'       => $this->language->get('text_week'),
                        'semi_month' => $this->language->get('text_semi_month'),
                        'month'      => $this->language->get('text_month'),
                        'year'       => $this->language->get('text_year'),
                    );

                    if ($product['recurring']['trial']) {
                        $recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    }

                    if ($product['recurring']['duration']) {
                        $recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    } else {
                        $recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    }
                }

                $data['products'][] = array(
                    'cart_id'    => $product['cart_id'],
                    'product_id' => $product['product_id'],
                    'name'       => $product['name'],
                    'model'      => $product['model'],
                    'option'     => $option_data,
                    'recurring'  => $recurring,
                    'quantity'   => $product['quantity'],
                    'subtract'   => $product['subtract'],
                    'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
                    'total'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']),
                    'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id'])
                );
            }

            // Gift Voucher
            $data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
                    );
                }
            }

            $data['totals'] = array();

            foreach ($order_data['totals'] as $total) {
                $data['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
                );
            }

            $shipping_single = explode('.', $this->request->post['shipping_method'])[0];
            $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping_single]['quote'][$shipping_single];
            $this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];

            $this->addOrderHistory();

            $new_data['redirect'] = $this->url->link('checkout/success', '', true);
            echo json_encode($new_data);
        }
//        $data['payment'] = $this->load->controller('extension/payment/' . $this->session->data['payment_method']['code']);
//
//        $data['payment_html'] = $this->load->view('checkout/confirm', $data);
//
//        $this->response->addHeader('Content-Type: application/json');
//        $this->response->setOutput($data['payment']);
    }

    public function addOrderHistory() {
        $this->load->model('checkout/order');
        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'],
            $this->config->get($this->session->data['payment_method']['code'] . '_order_status_id'));
    }

    public function validate() {
        $this->load->language('checkout/checkout');

        $json = array();

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['error']['products'] = $this->getCartError();
        }

        if (!$json) {
            if ($this->cart->hasShipping()) {
                // Validate if shipping address has been set.
                if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'new') {
                    if (!isset($this->request->post['shipping'])) {
//                        $json['error']['shipping_address']  = $this->language->get('error_shipping');
                    } else {
                        if (!isset($this->request->post['shipping']['firstname']) || (utf8_strlen(trim($this->request->post['shipping']['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['shipping']['firstname'])) > 32)) {
                            $json['error']['shipping']['firstname'] = $this->language->get('error_firstname');
                        }
                        if (!isset($this->request->post['shipping']['lastname']) || (utf8_strlen(trim($this->request->post['shipping']['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['shipping']['lastname'])) > 32)) {
                            $json['error']['shipping']['lastname'] = $this->language->get('error_lastname');
                        }

//                        if (!isset($this->request->post['shipping']['address_1']) || (utf8_strlen(trim($this->request->post['shipping']['address_1'])) < 1) || (utf8_strlen(trim($this->request->post['shipping']['address_1'])) > 128)) {
//                            $json['error']['shipping']['address_1'] = $this->language->get('error_address_1');
//                        }
                    }
                }
            }

            // Validate if payment method has been set.
            if (!isset($this->request->post['payment_method'])) {
                $json['error']['payment_method']  = $this->language->get('error_payment');
            }

            if (!$this->customer->isLogged()) {
                // Validate post addresses
                if(isset($this->request->post['shipping_area']) && $this->request->post['shipping_area'] == 'default') {
                    $json['error']['shipping']['shipping_area'] = $this->language->get('error_area');
                }
                if(isset($this->request->post['shipping_city']) && $this->request->post['shipping_city'] == 'default') {
                    $json['error']['shipping']['shipping_city'] = $this->language->get('error_city');
                }
                if(isset($this->request->post['shipping_warehouse']) && $this->request->post['shipping_warehouse'] == 'default') {
                    $json['error']['shipping']['shipping_warehouse'] = $this->language->get('error_warehouse');
                }
                // END
            }

            if ($this->customer->isLogged() && isset($this->request->post['validate_address_for_logged']) && $this->request->post['validate_address_for_logged'] == 'true') {
                if (!isset($this->request->post['shipping']['firstname']) || (utf8_strlen(trim($this->request->post['shipping']['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['shipping']['firstname'])) > 32)) {
                    $json['error']['shipping_short']['firstname'] = $this->language->get('error_firstname');
                }
                if (!isset($this->request->post['shipping']['lastname']) || (utf8_strlen(trim($this->request->post['shipping']['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['shipping']['lastname'])) > 32)) {
                    $json['error']['shipping_short']['lastname'] = $this->language->get('error_lastname');
                }
                if (!isset($this->request->post['shipping']['address_1']) || (utf8_strlen(trim($this->request->post['shipping']['address_1'])) < 1) || (utf8_strlen(trim($this->request->post['shipping']['address_1'])) > 128)) {
                    $json['error']['shipping_short']['address_1'] = $this->language->get('error_address_1');
                }
                if (!isset($this->request->post['shipping']['city']) || (utf8_strlen(trim($this->request->post['shipping']['city'])) < 2) || (utf8_strlen(trim($this->request->post['shipping']['city'])) > 128)) {
                    $json['error']['shipping_short']['city'] = $this->language->get('error_city');
                }

            }

            if ($this->customer->isLogged()) {
                if(!$this->customer->getTelephone()){
                    if (!isset($this->request->post['telephone']) || $this->request->post['telephone'] == '') {
                        $json['error']['telephone'] = $this->language->get('error_telephone');
                    }
                }

                if(!$this->customer->getEmail()){
                    if (!isset($this->request->post['email']) || (utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                        $json['error']['email'] = $this->language->get('error_email');
                    }
                    $this->load->model('account/customer');
                    if (isset($this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
                        $json['error']['email'] = $this->language->get('error_exists');
                    }
                }
                if(!$json){
                    if(!$this->customer->getTelephone()) {
                        $this->load->model('account/customer');
                        $this->model_account_customer->editCustomerPhone($this->request->post);
                    }

                    if(!$this->customer->getEmail()) {
                        $this->load->model('account/customer');
                        $this->model_account_customer->editEmail($this->request->post);
                    }
                }


                if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
                    $this->load->model('account/address');

                    if (empty($this->request->post['address_id'])) {
                        $json['error']['address_id'] = $this->language->get('error_address');
                    } elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
                        $json['error']['address_id'] = $this->language->get('error_address');
                    }

                    if (!$json) {
                        // Default Shipping Address
                        $this->load->model('account/address');

                        $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->request->post['address_id']);
                    }
                } else {
//                  // Validate post addresses
                    if(isset($this->request->post['shipping_area']) && $this->request->post['shipping_area'] == 'default') {
                        $json['error']['shipping']['shipping_area'] = $this->language->get('error_area');
                    }
                    if(isset($this->request->post['shipping_city']) && $this->request->post['shipping_city'] == 'default') {
                        $json['error']['shipping']['shipping_city'] = $this->language->get('error_city');
                    }
                    if(isset($this->request->post['shipping_warehouse']) && $this->request->post['shipping_warehouse'] == 'default') {
                        $json['error']['shipping']['shipping_warehouse'] = $this->language->get('error_warehouse');
                    }
                    // END
                }
            } else {
//                if (!isset($this->request->post['city']) || (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
//                    $json['error']['city'] = $this->language->get('error_city');
//                }
                if (!isset($this->request->post['firstname']) || (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
                    $json['error']['firstname'] = $this->language->get('error_firstname');
                }
                if (!isset($this->request->post['lastname']) || (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
                    $json['error']['lastname'] = $this->language->get('error_lastname');
                }

                if (!isset($this->request->post['email']) || (utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
                    $json['error']['email'] = $this->language->get('error_email');
                }

                if (!isset($this->request->post['telephone']) || (utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
                    $json['error']['telephone'] = $this->language->get('error_telephone');
                }

//                if (!isset($this->request->post['address_1']) || (utf8_strlen(trim($this->request->post['address_1'])) < 1) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
//                    $json['error']['address_1'] = $this->language->get('error_address_1');
//                }

                // Customer Group
                if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                    $customer_group_id = $this->request->post['customer_group_id'];
                } else {
                    $customer_group_id = $this->config->get('config_customer_group_id');
                }

                // Custom field validation
                $this->load->model('account/custom_field');

                $custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

                // Captcha
                if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('guest', (array)$this->config->get('config_captcha_page'))) {
                    $captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

                    if ($captcha) {
                        $json['error'][] = $captcha;
                    }
                }
                if (isset($this->request->post['account']) && $this->request->post['account'] == 'register') {
                    if (!isset($this->request->post['password']) || (utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
                        $json['error']['password'] = $this->language->get('error_password');
                    }

                    if (isset($this->request->post['password']) && isset($this->request->post['confirm']) && $this->request->post['confirm'] != $this->request->post['password']) {
                        $json['error']['confirm'] = $this->language->get('error_confirm');
                    }
                }
                if (isset($this->request->post['account']) && $this->request->post['account'] == 'register') {
                    $this->load->model('account/customer');
                    if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
                        $json['error']['email'] = $this->language->get('error_exists');
                    }
                }
            }
        }

        return $json;
    }

    public function getCartError()
    {
        $this->load->language('checkout/cart');
        return $this->language->get('error_stock');
    }
}
