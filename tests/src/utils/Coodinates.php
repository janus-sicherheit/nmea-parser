<?php

namespace BultonFr\NMEA\Utils\tests\units;

use mageekguy\atoum;

/**
 * Unit test class for class \BultonFr\NMEA\Utils\Coordinates
 * 
 * @package BultonFr\NMEA
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 */
class Coordinates extends atoum\test
{
    /**
     * Test method for \BultonFr\NMEA\Utils\Coordinates::convertGPDataToDegree method
     * 
     * @return void
     */
    public function testConvertGPDataToDegree()
    {
        $this->assert('Coordinates::convertGPDataToDegree for latitude with object format')
            ->object($obj = \BultonFr\NMEA\Utils\Coordinates::convertGPDataToDegree('4916.45'))
                ->isInstanceOf('\stdClass')
            ->boolean(property_exists($obj, 'degree'))
                ->isTrue()
            ->integer($obj->degree)
                ->isEqualTo(49)
            ->boolean(property_exists($obj, 'minute'))
                ->isTrue()
            ->integer($obj->minute)
                ->isEqualTo(16)
            ->boolean(property_exists($obj, 'second'))
                ->isTrue()
            ->integer($obj->second)
                ->isEqualTo(45)
        ;
        
        $this->assert('Coordinates::convertGPDataToDegree for latitude with string format')
            ->string(\BultonFr\NMEA\Utils\Coordinates::convertGPDataToDegree('4916.45', 'N', false, true))
                ->isEqualTo('49° 16\' 45" N')
        ;
        
        $this->assert('Coordinates::convertGPDataToDegree for longitude with object format')
            ->object($obj = \BultonFr\NMEA\Utils\Coordinates::convertGPDataToDegree('12311.12', 'W', true))
                ->isInstanceOf('\stdClass')
            ->boolean(property_exists($obj, 'degree'))
                ->isTrue()
            ->integer($obj->degree)
                ->isEqualTo(123)
            ->boolean(property_exists($obj, 'minute'))
                ->isTrue()
            ->integer($obj->minute)
                ->isEqualTo(11)
            ->boolean(property_exists($obj, 'second'))
                ->isTrue()
            ->integer($obj->second)
                ->isEqualTo(12)
        ;
        
        $this->assert('Coordinates::convertGPDataToDegree for longitude with string format')
            ->string(\BultonFr\NMEA\Utils\Coordinates::convertGPDataToDegree('12311.12', 'W', true, true))
                ->isEqualTo('123° 11\' 12" W')
        ;
    }
    
    /**
     * Test method for \BultonFr\NMEA\Utils\Coordinates::convertGPDataToDec method
     * 
     * @return void
     */
    public function testConvertGPDataToDec()
    {
        $this->assert('Coordinates::convertGPDataToDec for latitude')
            ->given($lat = \BultonFr\NMEA\Utils\Coordinates::convertGPDataToDec('4916.45'))
            ->float(round($lat, 8))
                ->isEqualTo(49.27916667)
        ;
        
        $this->assert('Coordinates::convertGPDataToDec for longitude')
            ->given($long = \BultonFr\NMEA\Utils\Coordinates::convertGPDataToDec('12311.12', true))
            ->float(round($long, 8))
                ->isEqualTo(123.18666667)
        ;
    }
}
