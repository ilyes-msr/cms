<?php

if (!function_exists('slugify')) {
  function slugify($text)
  {
    // Normalize unicode characters and replace non-letter or digits by -
    $text = preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $text);

    // Remove unwanted characters
    $text = preg_replace('/[^-\w]+/u', '', $text);

    // Trim
    $text = trim($text, '-');

    // Remove duplicate -
    $text = preg_replace('/-+/', '-', $text);

    // Lowercase
    $text = mb_strtolower($text, 'UTF-8');

    return empty($text) ? 'n-a' : $text;
  }
}

if (!function_exists('nb_alerts')) {
  function nb_alerts()
  {
    return App\Models\Alert::where('user_id', auth()->id())->first()->alert;
  }
}

if (!function_exists('get_role')) {
  function get_role()
  {
    return App\Models\Role::find(auth()->user()->role_id)->first()->role;
  }
}

if (!function_exists('ArabicDate')) {
  function ArabicDate()
  {
    $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
    $your_date = date('y-m-d'); // The Current Date
    $en_month = date("M", strtotime($your_date));
    foreach ($months as $en => $ar) {
      if ($en == $en_month) {
        $ar_month = $ar;
      }
    }

    $find = array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri");
    $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
    $ar_day_format = date('D'); // The Current Day
    $ar_day = str_replace($find, $replace, $ar_day_format);

    header('Content-Type: text/html; charset=utf-8');
    $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    // $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
    $current_date = $ar_day . ' ' . date('d') . ' ' . $ar_month . ' ' . date('Y');
    $arabic_date = str_replace($standard, $standard, $current_date);

    return $arabic_date;
  }
}
