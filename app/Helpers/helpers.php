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
