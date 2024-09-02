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
