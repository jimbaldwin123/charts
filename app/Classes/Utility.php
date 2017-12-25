<?php
/**
 * Created by PhpStorm.
 * User: ninge
 * Date: 12/24/17
 * Time: 5:13 PM
 */

namespace App\Classes;


class Utility
{
    public static function get_data_line($body)
    {
        $body = explode("\n",$body);
        foreach($body as $line){
            if(strpos($line,'name')!== false) {
                $names = explode('=', $line);
                $name = trim($names[1]);
            }
            if(strpos($line,'death_date')!== false){
                $dates = explode('|',$line);
                $death_date = $dates['2'] . '-' . self::pad($dates['3']) . '-' . self::pad($dates['4']);
                $birth_date = $dates['5'] . '-' . self::pad($dates['6']) . '-' . self::pad($dates['7']);
                return [$name,$birth_date,$death_date];
            }
        }
    }

    public static function pad($date)
    {
        $date = trim(str_replace('}','',$date));
        return substr('0'.$date,-2);
    }

    /**
     * recursively find a key in a deep array
     *
     * @param $needle_key
     * @param $array
     * @return bool
     */
    public static function array_search_key( $needle_key, $array ) {
        foreach($array AS $key=>$value){
            if($key == $needle_key) return $value;
            if(is_array($value)){
                if( ($result = self::array_search_key($needle_key,$value)) !== false)
                    return $result;
            }
        }
        return false;
    }
}