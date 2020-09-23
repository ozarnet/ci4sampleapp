<?php

function goSanitize($var, bool $nullIfEmpty = true, bool $allowTags = false, bool $allowJs = false, bool $onlyAlphaNumeric = false, bool $fromGetRequest = false) {
    
    $malScore = 0;
    
    if (empty($var)) {
        return [$nullIfEmpty ? null : $var, 0];
    }
    
    if (is_numeric($var) ) {
        if (is_int($var)) {
            $finalVal = filter_var($var, FILTER_SANITIZE_NUMBER_INT);
        } else {
            $finalVal = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);
        }
    } else {

        $str1 = $allowTags ? $var : strip_tags($var);
        
        if (!$allowJs) {
            $badParts = ['<script', 'onchange', 'onmouse', 'onblur', 'onfocus', 'oninput', 'onclick', 'onshow', 'onkey','onload','alert(','</script>'];
        
            if ($onlyAlphaNumeric) {
                $badparts[] = "='";
                $badparts[] = '="';
                $badparts[] = '=';
                $badparts[] = '_';
                $badparts[] = '/';
                $badparts[] = '"';
                $badparts[] = "'";
                $badparts[] = ">";
                $badparts[] = "<";
                $badparts[] = "()";
            }

            foreach ($badParts as $bp) {
                if (strpos($str1, $bp)!==false) {
                    $malScore += 1;
                    $str1 = str_replace($bp, '', $str1);
                }
            }
        }

        if ($fromGetRequest) {
            $str1 = urldecode ($str1);
        }

        $str2 = filter_var($str1, FILTER_SANITIZE_STRING);
        $finalVal = filter_var($str2, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    return [trim($finalVal),$malScore];
}


function convertTurkishCharacters($text) {
    // https://www.kodevreni.com/639-php-türkçe-karakterleri-ingilizceye-dönüştürme/
    $text = trim($text);
    $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
    $replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
    $new_text = str_replace($search,$replace,$text);
    return $new_text;
}

// Check if the function does not exists
if ( ! function_exists('slugify')) {
    // Slugify a string
    function slugify($string)
    {
        helper('text');

        // Replace unsupported characters (add your owns if necessary)
        $string = str_replace("'", '-', $string);
        $string = str_replace(".", '-', $string);
        $string = str_replace("²", '2', $string);

        // Slugify and return the string
        return url_title(convert_accented_characters(convertTurkishCharacters($string)), '-', true);
    }
}