<?php

if (!function_exists('get_image')) {
    function get_image($string) {
        $matches = [];
        $pattern = '/<img src="[^"]+\/([^\/"]+\.(?:jpeg|jpg|png|gif|webp))"/';
        
        preg_match_all($pattern, $string, $matches);
        
        return $matches[1];
    }
}

if (!function_exists('handle_array_users')) {
    function handle_array_users($array) {
        $userArray = [];
        $authorArray = [];

        foreach ($array as $item) {
            preg_match('/(\d+)-(.+)/', $item, $matches);

            if (count($matches) === 3) {
                $number = intval($matches[1]);
                $role = $matches[2];
                
                if ($role === "user") {
                    $userArray[] = $number;
                } elseif ($role === "author") {
                    $authorArray[] = $number;
                }
            }
        }
        $array = [];
        $array['user'] = $userArray;
        $array['author'] = $authorArray;
        return $array;
    }
}