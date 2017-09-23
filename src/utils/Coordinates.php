<?php

namespace NMEA\Utils;

/**
 * Tools to convert NMEA coordinates
 * 
 * @package NMEA
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 */
class Coordinates
{
    /**
     * Convert coordinate to degree format
     * 
     * @param string|float $data Data readed by parser
     * @param string $direction (default null) Direction of the coordinate
     * @param boolean $toString (default false) Return format
     * 
     * @return \stdClass|string Change with $toString parameter value
     */
    public static function convertGPDataToDegree(
        $data,
        $direction = null,
        $toString = false
    ) {
        $dotPosition = strpos($data, '.');
        
        $obj = (object) [
            'degree' => (int) substr($data, 0, 2),
            'minute' => (int) substr($data, 2, $dotPosition),
            'second' => (int) substr($data, $dotPosition+1)
        ];
        
        if ($toString === false) {
            return $obj;
        }
        
        return $obj->degree.'° '.$obj->minute.'\' '.$obj->second.'" '.$direction;
    }
    
    /**
     * Convert coordinate to decimal format
     * 
     * @param string|float $data Data readed by parser
     * 
     * @return float
     */
    public static function convertGPDataToDec($data)
    {
        $obj = self::convertGPDataToDegree($data);
        
        /**
         * DD = d + (min/60) + (sec/3600)
         * @link http://www.latlong.net/degrees-minutes-seconds-to-decimal-degrees
         */
        return ($obj->degree) + ($obj->minute / 60) + ($obj->second / 3600);
    }
}
