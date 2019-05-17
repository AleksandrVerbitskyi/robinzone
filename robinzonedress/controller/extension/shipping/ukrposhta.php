<?php
class ControllerExtensionShippingukrposhta extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/shipping/ukrposhta');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('ukrposhta', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_none'] = $this->language->get('text_none');

        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_standard'] = $this->language->get('entry_standard');
        $data['entry_express'] = $this->language->get('entry_express');
        $data['entry_display_time'] = $this->language->get('entry_display_time');
        $data['entry_weight_class'] = $this->language->get('entry_weight_class');
        $data['entry_tax_class'] = $this->language->get('entry_tax_class');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['help_display_time'] = $this->language->get('help_display_time');
        $data['help_weight_class'] = $this->language->get('help_weight_class');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        // Warehouses synch
        $data['button_synchronize'] = $this->language->get('button_synchronize');
        $data['synchronize'] = $this->url->link('extension/shipping/ukrposhta/synchronize', 'token=' . $this->request->get['token'], true);
        // Warehouses synch

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['postcode'])) {
            $data['error_postcode'] = $this->error['postcode'];
        } else {
            $data['error_postcode'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/shipping/ukrposhta', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('extension/shipping/ukrposhta', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

        if (isset($this->request->post['ukrposhta_postcode'])) {
            $data['ukrposhta_postcode'] = $this->request->post['ukrposhta_postcode'];
        } else {
            $data['ukrposhta_postcode'] = $this->config->get('ukrposhta_postcode');
        }

        if (isset($this->request->post['ukrposhta_standard'])) {
            $data['ukrposhta_standard'] = $this->request->post['ukrposhta_standard'];
        } else {
            $data['ukrposhta_standard'] = $this->config->get('ukrposhta_standard');
        }

        if (isset($this->request->post['ukrposhta_express'])) {
            $data['ukrposhta_express'] = $this->request->post['ukrposhta_express'];
        } else {
            $data['ukrposhta_express'] = $this->config->get('ukrposhta_express');
        }

        if (isset($this->request->post['ukrposhta_display_time'])) {
            $data['ukrposhta_display_time'] = $this->request->post['ukrposhta_display_time'];
        } else {
            $data['ukrposhta_display_time'] = $this->config->get('ukrposhta_display_time');
        }

        if (isset($this->request->post['ukrposhta_weight_class_id'])) {
            $data['ukrposhta_weight_class_id'] = $this->request->post['ukrposhta_weight_class_id'];
        } else {
            $data['ukrposhta_weight_class_id'] = $this->config->get('ukrposhta_weight_class_id');
        }

        $this->load->model('localisation/weight_class');

        $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

        if (isset($this->request->post['ukrposhta_tax_class_id'])) {
            $data['ukrposhta_tax_class_id'] = $this->request->post['ukrposhta_tax_class_id'];
        } else {
            $data['ukrposhta_tax_class_id'] = $this->config->get('ukrposhta_tax_class_id');
        }

        $this->load->model('localisation/tax_class');

        $data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        if (isset($this->request->post['ukrposhta_geo_zone_id'])) {
            $data['ukrposhta_geo_zone_id'] = $this->request->post['ukrposhta_geo_zone_id'];
        } else {
            $data['ukrposhta_geo_zone_id'] = $this->config->get('ukrposhta_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['ukrposhta_status'])) {
            $data['ukrposhta_status'] = $this->request->post['ukrposhta_status'];
        } else {
            $data['ukrposhta_status'] = $this->config->get('ukrposhta_status');
        }

        if (isset($this->request->post['ukrposhta_sort_order'])) {
            $data['ukrposhta_sort_order'] = $this->request->post['ukrposhta_sort_order'];
        } else {
            $data['ukrposhta_sort_order'] = $this->config->get('ukrposhta_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/ukrposhta', $data));
    }

    public function synchronize() {
        ini_set('memory_limit', '1024M');
        $this->load->model('extension/module/ukrposhta_import');
        $this->model_extension_module_ukrposhta_import->install();
        $this->clearTables();
        $base_path = DIR_APPLICATION . "../csv_warehouses_ukrposhta/";
        $path_to_csv = $base_path . "houses_en.csv";
        $csv_reader = new Csv();
        $data = $csv_reader->read($path_to_csv, ';');

        $time_start = microtime(true);
//        foreach ($data as $item) {
//            $area = $item['Область'];
//            $city = $item['Місто'];
//
//            $area_id = $this->getIdForArea($area);
//            if (!$area_id) {
//                $sql = "INSERT INTO " . DB_PREFIX . "ukrposhta_areas SET `name` = '" . $area . "';";
//                $this->db->query($sql);
//                $area_id = $this->db->getLastId();
//            }
//            $city_id = $this->getIdForCity($area_id, $city);
//            if (!$city_id) {
//                $sql = "INSERT INTO " . DB_PREFIX . "ukrposhta_cities SET `name` = '" . $city . "', `area_id` = '" . (int)$area_id . "';";
//                $this->db->query($sql);
//            }
//        }

        unset($data);
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "Запис всіх значень в DB виконано за $time секунд\n";
//        echo '<pre>';
//        print_r($data);
        die($path_to_csv);
    }

    private function getIdForArea($name) {
        $instance_id = false;
        $sql = "SELECT * FROM " . DB_PREFIX . "ukrposhta_areas WHERE `name` = '" . $name . "';";
        $instance = $this->db->query($sql)->row;
        try {
            if (!empty($instance)) {
                if (array_key_exists('area_id', $instance)) {
                    $instance_id = $instance['area_id'];
                } else {
                    throw new Exception("Error^");
                }
            }
        } catch (Exception $e) {
            echo '<pre>';
            echo '$instance:\n' . $e->getMessage() . ' with code=' . $e->getCode();
            print_r($instance);
        }
        return $instance_id;
    }

    private function getIdForCity($areaId, $name) {
        $instance_id = false;
        $sql = "SELECT * FROM " . DB_PREFIX . "ukrposhta_cities WHERE `name` = '" . $name . "' AND `area_id` = '" . (int)$areaId . "';";
        $instance = $this->db->query($sql)->row;
        try {
            if (!empty($instance)) {
                if (array_key_exists('city_id', $instance)) {
                    $instance_id = $instance['city_id'];
                } else {
                    throw new Exception("Error^");
                }
            }
        } catch (Exception $e) {
            echo '<pre>';
            echo '$instance:\n' . $e->getMessage() . ' with code=' . $e->getCode();
            print_r($instance);
        }
        return $instance_id;
    }

    private function clearTables() {
        $this->clearTable('ukrposhta_areas');
        $this->clearTable('ukrposhta_cities');
    }

    private function clearTable($table) {
        $query = "DELETE FROM " . DB_PREFIX . $table . ";";
        $this->db->query($query);
        $query = "ALTER TABLE " . DB_PREFIX . $table . " AUTO_INCREMENT = 1;";
        $this->db->query($query);
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/ukrposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}

class Csv
{
    public function render($array, $filename) {
        header('Content-type: text/csv');
        header("Content-Disposition: attachment; filename=$filename");
        $output = fopen('php://output', 'w');
        $header = array_keys($array[0]);
        fputcsv($output, $header, ';');
        foreach ($array as $row) {
            fputcsv($output, $row, ';');
        }
        fclose($output);
    }

    public function read($filename, $delimiter) {
        $result = [];
        $handle = fopen($filename, 'r');
        $header = fgetcsv($handle, 1024, $delimiter);

        $header = array_map(function($element) {
            return mb_convert_encoding($element, "utf-8", "windows-1251");
        }, $header);

        while (!feof($handle)) {
            $values = fgetcsv($handle, 1024, $delimiter);
            if (count($header) == count($values)) {
                $values = array_map(function($element) {
                    return mb_convert_encoding($element, "utf-8", "windows-1251");
                }, $values);
                $entry = array_combine($header, $values);
                $result[] = $entry;
            }
        }
        fclose($handle);
        return empty($result) ? false : $result;
    }
}