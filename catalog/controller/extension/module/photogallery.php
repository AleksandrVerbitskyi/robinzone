<?php
class ControllerExtensionModulePhotogallery extends Controller {
    private $gallery_settings = [];

    public function index($setting) {
        static $module = 0;
        $this->setGallerySettings();

        $this->load->model('extension/module/banner_plus');
        $this->load->model('tool/image');

        $data['banners'] = array();

        $results = $this->model_extension_module_banner_plus->getBanner($setting['banner_id']);
        $min_in_row = $this->getMinInRow();

        $iterations = floor(count($results)/$min_in_row);
        $main_iter = 0;
        $iter = 0;

        $setting_index = 0;
        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                $width = $this->gallery_settings['width'][$setting_index];
                $height = $this->gallery_settings['height'][$setting_index];
                $data['banners'][] = array(
                    'title' => $result['title'],
                    'width' => $width,
                    'height' => $height,
                    'image' => 'image/' . $result['image']
                );
                $setting_index++;
                $iter++;
                if ($iter == $min_in_row) {
                    $main_iter++;
                    $setting_index = 0;
                }
                if ($main_iter >= $iterations) {
                    break;
                }
            }
        }

        $data['module'] = $module++;
        $data['rows'] = $this->gallery_settings['in_row'];

        return $this->load->view('extension/module/photogallery', $data);
    }

    private function setGallerySettings() {
        $this->gallery_settings['width'] = [1000, 1000, 1500, 1500, 900, 1500, 1000, 1000];
        $this->gallery_settings['height'] = [1365, 1365, 800, 800, 800, 800, 1365, 1365];
        $this->gallery_settings['in_row'] = [3, 2, 3];
    }

    private function getMinInRow() {
        $min = 0;
        foreach ($this->gallery_settings['in_row'] as $item) {
            $min += $item;
        }
        return $min;
    }

}
