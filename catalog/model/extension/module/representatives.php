<?php
class ModelExtensionModuleRepresentatives extends Model {
    public function getAllCities() {
        $result = [];
        $sql = "SELECT * FROM " . DB_PREFIX . "representative_cities rc";
        $sql .= " LEFT JOIN " . DB_PREFIX . "representative_city_descriptions description";
        $sql .= " ON (rc.city_id = description.city_id)";
        $sql .= " WHERE rc.status = '1'";
        $sql .= " AND description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " ORDER BY description.name DESC, rc.sort_order ASC;";
        $query = $this->db->query($sql);

        $result = $query->rows;

        foreach ($result as $index => $city) {
            $result[$index]['representatives'] = $this->getRepresentatives($city['city_id']);
        }

        foreach ($result as $index => $city) {
            foreach ($city['representatives'] as $key => $representative) {
                $result[$index]['representatives'][$key]['addresses'] = $this->unpuckAddress(html_entity_decode($representative['address']));
            }
        }
        return $result;
    }

    public function getRepresentatives($city_id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "representatives r";
        $sql .= " LEFT JOIN " . DB_PREFIX . "representative_descriptions description";
        $sql .= " ON (r.representative_id = description.representative_id)";
        $sql .= " WHERE r.status = '1'";
        $sql .= " AND r.city_id = " . $city_id;
        $sql .= " AND description.language_id = " . (int)$this->config->get('config_language_id');
        $sql .= " ORDER BY r.sort_order ASC;";
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function unpuckAddress($address) {
        $tmp = [];
        $result = [];
        $patterns = ['text', 'tel', 'email'];
        $texts = [];
        $tels = [];
        $emails = [];
        foreach ($patterns as $pattern) {
            $rgx = '/\<' . $pattern . '\>(?<' . $pattern . '>.*)\<\/' . $pattern . '\>/mi';
            preg_match_all($rgx, $address, $tmp);
            switch ($pattern) {
                case 'text':
                    $texts = $tmp[$pattern];
                    break;
                case 'tel':
                    $tels = $tmp[$pattern];
                    break;
                case 'email':
                    $emails = $tmp[$pattern];
                    break;
                default:
                    break;
            }
        }
        $result = $texts;
        foreach ($tels as $tel) {
            $result[] = '<a href="tel: ' . str_replace([' ', '-'], '', $tel) . '" class="representativesAdress_list_a">' . $tel . '</a>';
        }
        foreach ($emails as $email) {
            $result[] = '<a href="mailto: ' . $email . '" class="representativesAdress_list_a">' . $email . '</a>';
        }
        return $result;
    }
}
