<?php 


use Illuminate\Support\Str;

if (!function_exists('slugify')) {
    function slugify($text)
    {
        // Converts: "Graphic Design Course" → "graphic-design-course"
        return Str::slug($text);
    }
}

if (!function_exists('unslugify')) {
    function unslugify($text)
    {
        // Converts: "graphic-design-course" → "Graphic Design Course"
        return ucwords(str_replace('-', ' ', $text));
    }
}
