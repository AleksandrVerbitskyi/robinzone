<?php

namespace Import;

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

        while (!feof($handle)) {
            $values = fgetcsv($handle, 1024, $delimiter);
            if (count($header) == count($values)) {
                $entry = array_combine($header, $values);
                $result[] = $entry;
            }
        }
        fclose($handle);
        return empty($result) ? false : $result;
    }
}