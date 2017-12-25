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
    public static function get_data_line($data)
    {
        $title = $data[0];
        $body = explode("\n",$data[1]);

        foreach($body as $line){

            if(strpos($line,'death_date')!== false){
                $dates = explode('|',$line);

                $index = 0;
                foreach($dates as $date){
                    if(is_numeric($date)){
                       break;
                    }
                    $index++;
                }
                $death_date = $dates[$index++] . '-' . self::pad($dates[$index++]) . '-' . self::pad($dates[$index++]);
                $birth_date = $dates[$index++] . '-' . self::pad($dates[$index++]) . '-' . self::pad($dates[$index++]);
                return [$title,$birth_date,$death_date];
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