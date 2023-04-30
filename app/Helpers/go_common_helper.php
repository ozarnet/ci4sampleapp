<?php

function goSanitize($var, bool $nullIfEmpty = false, bool $allowTags = false, bool $allowJs = false, bool $onlyAlphaNumeric = false, bool $fromGetRequest = false) {
    
    $malScore = 0;
    
    if (is_numeric($var) ) {

        $decimalSeparator = localeconv()['decimal_point'];
    
        if (strpos($var, $decimalSeparator)===false) {
           
            $finalVal = intval(filter_var($var, FILTER_SANITIZE_NUMBER_INT));
    
        } else {
            
            $finalVal = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
        }
    
    } else {
        if (empty($var)) {
            return [$nullIfEmpty ? null : $var, 0];
        }
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

        // $finalVal = filter_var($str1, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // doesn't play well with esc() and old() as well as form_textarea() functions of CI 4 
        $finalVal = $str1; 
    }
    return [trim($finalVal),$malScore];
}


function convertTurkishCharacters($text) {
    $text = trim($text);
    $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
    $replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
    $new_text = str_replace($search,$replace,$text);
    return $new_text;
}

function convertPhpDateToMomentFormat($format)
{
    $replacements = [
        'd' => 'DD',
        'D' => 'ddd',
        'j' => 'D',
        'l' => 'dddd',
        'N' => 'E',
        'S' => 'o',
        'w' => 'e',
        'z' => 'DDD',
        'W' => 'W',
        'F' => 'MMMM',
        'm' => 'MM',
        'M' => 'MMM',
        'n' => 'M',
        't' => '', // no equivalent
        'L' => '', // no equivalent
        'o' => 'YYYY',
        'Y' => 'YYYY',
        'y' => 'YY',
        'a' => 'a',
        'A' => 'A',
        'B' => '', // no equivalent
        'g' => 'h',
        'G' => 'H',
        'h' => 'hh',
        'H' => 'HH',
        'i' => 'mm',
        's' => 'ss',
        'u' => 'SSS',
        'e' => 'zz', // deprecated since version 1.6.0 of moment.js
        'I' => '', // no equivalent
        'O' => '', // no equivalent
        'P' => '', // no equivalent
        'T' => '', // no equivalent
        'Z' => '', // no equivalent
        'c' => '', // no equivalent
        'r' => '', // no equivalent
        'U' => 'X',
    ];
    $momentFormat = strtr($format, $replacements);
    return $momentFormat;
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

if (!function_exists('convertToSnakeCase')) {
    function convertToSnakeCase($strInput) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $strInput, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}

if (!function_exists('newUUID')) {

    function newUUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

}