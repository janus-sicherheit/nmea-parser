<?php

namespace NMEA\Utils\tests\units;

require_once(__DIR__.'/../../../vendor/autoload.php');

use mageekguy\atoum;

/**
 * Unit test class for class \NMEA\Utils\Coordinates
 * 
 * @package NMEA
 * @author Vermeulen Maxime <bulton.fr@gmail.com>
 */
class Coordinates extends atoum\test
{
    /**
     * Test method for \NMEA\Utils\Coordinates::convertGPDataToDegree method
     * 
     * @return void
     */
    public function testConvertGPDataToDegree()
    {
        $this->assert('Coordinates::convertGPDataToDegree with object format')
            ->object($obj = \NMEA\Utils\Coordinates::convertGPDataToDegree(4916.45))
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
        
        $this->assert('Coordinates::convertGPDataToDegree with string format')
            ->string(\NMEA\Utils\Coordinates::convertGPDataToDegree(4916.45, 'N', true))
                ->isEqualTo('49° 16\' 45" N')
        ;
    }
    
    /**
     * Test method for \NMEA\Utils\Coordinates::convertGPDataToDec method
     * 
     * @return void
     */
    public function testConvertGPDataToDec()
    {
        $this->assert('Coordinates::convertGPDataToDec')
            ->given($lat = \NMEA\Utils\Coordinates::convertGPDataToDec(4916.45))
            ->float(round($lat, 8))
                ->isEqualTo(49.27916667)
        ;

    }
}
