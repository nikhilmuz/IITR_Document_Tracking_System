<?php
/**
 * Created by PhpStorm.
 * User: nikhil
 * Date: 25/8/18
 * Time: 10:39 AM
 */

class Functions
{
    public static function get_date_from_stamp($time){
        $tz = 'Asia/Kolkata';
        $timestamp = $time;
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp);
        return $dt->format('jS F, Y');
    }
    public static function get_time_from_stamp($time){
        $tz = 'Asia/Kolkata';
        $timestamp = $time;
        $dt = new DateTime("now", new DateTimeZone($tz));
        $dt->setTimestamp($timestamp);
        return $dt->format('h:i:s A');
    }
    public static function parse_csv($data){
        $array = explode(",",$data);
        return $array;
    }
    public static function generate_csv($array){
        $data="";
        $length=count($array);
        foreach($array as $element){
            if ($length>1){
                $data=$data.$element.",";
            }
            else {$data=$data.$element;}
            $length--;
        }
        return $data;
    }
}