<?php
class ModelToolMonthFormat extends Model {
    private $en_gb = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    private $ru_ru = ['Декабря', 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября'];
    private $ua_uk = ['Січня', 'Лютого', 'Березня', 'Квітня', 'Травня', 'Червня', 'Липня', 'Серпня', 'Вересня', 'Жовтня', 'Листопада', 'Грудня'];
	public function format($date, $language_code) {
        $raw_date = strtotime($date);
        $year = date('Y', $raw_date);
        $month = date('m', $raw_date);
        $day = date('d', $raw_date);


        $full_months = $this->{str_replace('-', '_', $language_code)};
        $full_month = $full_months[(int)$month - 1];

		return $day . ' ' . $full_month . ' ' . $year;
	}
}