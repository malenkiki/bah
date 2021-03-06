#!/usr/bin/env php
<?php

function toInt($str){
    return hexdec('0x'.$str);
}

function toHex($int){
    return '0x' . dechex($int);
}

function group($arr)
{
    $arr_cons = array();
    $int_idx = 0;

    foreach($arr as $k => $v){
        if(!isset($arr_cons[$int_idx])){
            $arr_cons[$int_idx] = array();
        }

        $arr_cons[$int_idx][] = $v;

        if(isset($arr[$k + 1])){
            if(($arr[$k + 1] - $v) > 1){
                $arr_cons[$int_idx] = reduce($arr_cons[$int_idx]);
                $int_idx++;
            }
        }

    }

    return $arr_cons;
}

function reduce($arr)
{
    $int_min = min($arr);
    $int_max = max($arr);

    if($int_min == $int_max){
        $arr = $int_min;
    } else {
        $arr = array($int_min, $int_max);
    }

    return $arr;
}

function php4RTL($arr){
    $str_simple_1st = 'if($cp == 0x%x) return true;' . PHP_EOL;
    $str_double_1st = 'if(0x%x <= $cp && $cp <= 0x%x) return true;' . PHP_EOL;
    $str_simple = 'elseif($cp == 0x%x) return true;' . PHP_EOL;
    $str_double = 'elseif(0x%x <= $cp && $cp <= 0x%x) return true;' . PHP_EOL;

    $str_out = '';

    foreach($arr as $k => $cond){
        if($k == 0){
            $str_cond_simple = $str_simple_1st; 
            $str_cond_double = $str_double_1st; 
        } else {
            $str_cond_simple = $str_simple; 
            $str_cond_double = $str_double; 
        }

        if(is_integer($cond)){
            $str_out .= sprintf($str_cond_simple, $cond);
        } else {
            $str_out .= sprintf($str_cond_double, $cond[0], $cond[1]);
        }
    }

    $str_out .= 'return false;' . PHP_EOL;

    return $str_out;
}



$arr_file = explode(PHP_EOL, file_get_contents('http://www.unicode.org/Public/6.0.0/ucd/UnicodeData.txt'));
$arr_code_points = array();
$arr_char_properties = array();

foreach($arr_file as $k => $v){
    $arr_line = explode(';', $v);
    
    if(count($arr_line) != 15){ 
        continue;
    }
    
    if(in_array($arr_line[4], array('R', 'AL'))){
        $arr_code_points[] = toInt($arr_line[0]);
    }

    if(!isset($arr_char_properties[$arr_line[2]])){
        $arr_char_properties[$arr_line[2]] = array();
    }

    $arr_char_properties[$arr_line[2]][] = toInt($arr_line[0]);
}

unset($arr_file);


$arr_code_points = group($arr_code_points);
if(is_array(end($arr_code_points))){
    $int_pos = count($arr_code_points) - 1;
    $arr_code_points[$int_pos] = reduce($arr_code_points[$int_pos]);
}



foreach($arr_char_properties as $cp => $v){
    $arr_char_properties[$cp] = group($v);
}


//var_dump($arr_code_points);
//var_dump($arr_char_properties['Lu']);
//foreach($arr_char_properties as $cp => $v){
//    var_dump($cp . ' has ' . count($v) . ' items');
//}
echo  php4RTL($arr_code_points);
