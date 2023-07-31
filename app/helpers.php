<?php

if (!function_exists('decode_string')) {

    function decode_string($encode_string)
    {
        $strings = json_decode($encode_string);
        $decode_string = "";

        if(!is_array($strings)) return "";
        $string_length = sizeof($strings);
        
        foreach ($strings as $key => $string) {

            if ($string_length == $key + 1) {
                $decode_string .= $strings[0];
            } else {

                $decode_string .= $string . " - ";
            }
        }

        return $decode_string;
    }

}
