<?php

if (!function_exists('get_image')) {
    function get_image($string) {
        $matches = [];
        $pattern = '/<img src="[^"]+\/([^\/"]+\.(?:jpeg|jpg|png|gif|webp))"/';
        
        preg_match_all($pattern, $string, $matches);
        
        return $matches[1];
    }
}