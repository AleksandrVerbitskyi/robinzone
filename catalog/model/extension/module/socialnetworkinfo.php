<?php
class ModelExtensionModuleSocialNetworkInfo extends Model {

    public function getSocialNetworks() {
        $sql = "SELECT * FROM " . DB_PREFIX . "social_network_info;";
        $result = [];
        foreach ($this->db->query($sql)->rows as $index => $item) {
            if ((int)$item['status'] == 1) {
                $result[] = $item;
                if ($item['which_ico'] == 'image') {
                    end($result);
                    $this->addAttributesForImage($result[key($result)]);
                }
            }
        }

        usort($result, [$this, 'socials_sort']);

        return array_values($result);
    }

    private function socials_sort($a, $b) {
        $al = (int)$a['sort'];
        $bl = (int)$b['sort'];
        if ($al == $bl) return 0;
        return ($al > $bl) ? +1 : -1;
    }

    private function addAttributesForImage(&$social) {
        $image_name = basename($social['image']);
        $filtered_name = preg_replace('/(\..*)$/', '', $image_name);
        $social['image_alt'] = $filtered_name;
        $social['image_title'] = $filtered_name;
    }
}