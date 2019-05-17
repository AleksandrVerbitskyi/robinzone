<?php
class ModelExtensionModuleDatabaseSchemaChanging extends Model
{
    private $from = 'MyISAM';
    private $to = 'INNODB';
    public function execute($from = null, $to = null)
    {
        if ($from == null) {
            $from = $this->from;
        }
        if ($to == null) {
            $to = $this->to;
        }
        $tables = $this->getTablesNames($from);
        echo "<pre>";
        foreach ($tables as $table) {
            if ($this->changeSchema($table, $to)) {
                print_r(["schema $table engine changing to $to finished =>", 'successfully']);
            } else {
                print_r(["schema $table engine changing to $to finished =>", 'error']);
            }
        }
        echo "</pre>";
        die('END');
    }

    private function getTablesNames($from)
    {
        $result = [];
        $query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE 
        TABLE_SCHEMA = '" . DB_DATABASE . "' AND ENGINE = '" . $from . "';");
        foreach ($query->rows as $row) {
            array_push($result, $row['TABLE_NAME']);
        }
        return $result;
    }

    public function getTablesEngine()
    {
        $result = [];
        $query = $this->db->query("SELECT TABLE_NAME, ENGINE FROM INFORMATION_SCHEMA.TABLES WHERE 
        TABLE_SCHEMA = '" . DB_DATABASE . "';");
        foreach ($query->rows as $row) {
            $result[$row['TABLE_NAME']] = $row['ENGINE'];
        }
        echo "<pre>";
        foreach ($result as $table => $engine) {
            print_r(["Table => $table", "ENGINE => $engine"]);
        }
        echo "</pre>";
    }

    private function changeSchema($table, $to)
    {
        $result = $this->db->query("ALTER TABLE `" . $table . "` ENGINE = '" . $to . "';");
        return $result;
    }

//$this->load->model('extension/database_schema_changing');
//$this->model_extension_database_schema_changing->getTablesEngine();
}