<?php
if ( ! function_exists('easyui_clearstr')){
    function easyui_clearstr($str){
        $str=str_replace(' ','_',$str);
        $str=str_replace('.','',$str);
        $str=str_replace("'","",$str);
        return $str;
    }
}
if ( ! function_exists('capwords')){
    function capwords($str){
        if(!isset($str)){
            return '';
        }else{
            return ucwords(strtolower($str));
        }
    }
}
if ( ! function_exists('clearcomma')){
    function clearcomma($str){
         $str=str_replace("'"," ",$str);
        return $str;
    }
}