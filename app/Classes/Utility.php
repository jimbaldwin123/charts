<?php
/**
 * Created by PhpStorm.
 * User: ninge
 * Date: 12/24/17
 * Time: 5:13 PM
 */

namespace App\Classes;
use \Exception;
use App\Event;

class Utility
{
    public static function get_data_line($data)
    {
        $title = $data[0];
        $body = explode("\n",$data[1]);
        $error_message = '';
        foreach($body as $line){

            if(strpos(strtolower($line),'| birth_date')!== false || strpos(strtolower($line),'|birth_date') !== false) {
                $dates = self::parseDate($line,'birth date');
                $index = self::findFirstNumeric($dates);
                try {
                    if(!isset($dates[$index])){
                        throw new Exception();
                    }
                    $year = $dates[$index++];
                    $month = $dates[$index++];
                    $day = $dates[$index++];
                    \Log::debug('Y-m-d',[$year,$month,$day]);
                    $birth_date = $year . '-' . self::defaultDate(self::pad($month ?? 1)) . '-' . self::defaultDate(self::pad($day ?? 1));
                    \Log::debug('BIRTH DATE ', [$birth_date]);
                }
                catch (exception $e) {
                    $error_message .= ' ' . $line;
                    unset($birth_date);
                }
            }
            if(strpos(strtolower($line),'| death_date')!== false || strpos(strtolower($line),'|death_date')!== false) {
                $dates = self::parseDate($line,'death date');
                $index = self::findFirstNumeric($dates);
                try {
                    if(!isset($dates[$index])){
                        throw new Exception();
                    }
                    $year = $dates[$index++];
                    $month = $dates[$index++];
                    $day = $dates[$index++];
                    \Log::debug('Y-m-d',[$year,$month,$day]);
                    $death_date = $year . '-' . self::defaultDate(self::pad($month ?? 1)) . '-' . self::defaultDate(self::pad($day ?? 1));
                    \Log::debug('DEATH DATE ', [$death_date]);
                }
                catch (exception $e) {
                    $error_message .= ' ' . $line;
                    unset($death_date);
                }
            }

        }
        if(isset($birth_date) && isset($death_date)){
            return [$title,$birth_date,$death_date];
        } else {
            return [$title, $error_message,'error'=>true];
        }
    }




    public static function pad($date)
    {
        $date = trim(str_replace('}','',$date));
        return substr('0'.$date,-2);
    }

    public static function defaultDate($date)
    {
        return is_numeric($date) ? $date : 1;
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
            if((string)$key == $needle_key) return $value;
            if(is_array($value)){
                if( ($result = self::array_search_key($needle_key,$value)) !== false)
                    return $result;
            }
        }
        return false;
    }

    public static function findFirstNumeric($dates)
    {
        $index = 0;
        foreach($dates as $date){
            if(is_numeric($date)){
                return $index;
            }
            $index++;
        }
    }

    public static function parseDate($line,$key){
        if (preg_match('/\{\{'. $key . '(.*?)\}\}/i', $line, $display) === 1) {
            $dates = explode('|',$display[1]);
        } else {
            $dates = explode('|',$line);
        }
        return $dates;
    }
}