<?php

/**
* Converti une chaine en format json en chaine de carcatère
*/
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


/**
* Convertir une chaine  de caractère en date 
*/ 
if(!function_exists('string_to_date')){

    function string_to_date($string_date, $lang="fr"){


        if($lang == "en"){
          $date =  date('Y-m-d',strtotime( $string_date));
        }else{
        
            $date =  date('d/m/Y',strtotime( $string_date));
        
        }
        
        return $date;
    }
    
}
