<?php
class CsvWriter
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
}