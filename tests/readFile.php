<?php

$cliArgs = getopt('f:h', ['file:', 'help']);

if (isset($cliArgs['h']) || isset($cliArgs['help'])) {
    echo
        'Usage : ./tests/readFile.php -f="<path>"'."\n"
        ."\n"
        .'Options :'."\n"
        .' -f, --file="<path>" : File to read'."\n"
        .' -h, --help          : Display this message'."\n"
    ;
    return;
}

$file = null;
if (isset($cliArgs['f'])) {
    $file = $cliArgs['f'];
} elseif (isset($cliArgs['file'])) {
    $file = $cliArgs['file'];
}

if ($file === null) {
    echo 'A file path should be passed with -f or --file parameter.'."\n";
    return;
}

if (!file_exists($file)) {
    echo 'The file '.$file.' not exist.'."\n";
    return;
}

require_once(__DIR__.'/../vendor/autoload.php');

$parser = new \NMEA\Parser;
$fop    = fopen($file, 'r');

while ($line = fgets($fop)) {
    echo '$line : '.$line."\n";
    
    try {
        $frame = $parser->readLine($line);
    } catch (\Exception $e) {
        echo 'EXCEPTION : ['.$e->getCode().'] '.$e->getMessage()."\n";
        echo '---------------------------------------------------------------'."\n";
        continue;
    }
    
    echo $frame;
    
    $frameType = $frame->getFrameType();
    if ($frameType === 'GGA' || $frameType === 'GLL' || $frameType === 'RMC') {
        $latDeg = \NMEA\Utils\Coordinates::convertGPDataToDegree(
            $frame->getLatitude(),
            $frame->getLatitudeDirection(),
            true
        );
        $latDec = \NMEA\Utils\Coordinates::convertGPDataToDec(
            $frame->getLatitude()
        );
        
        $longDeg = \NMEA\Utils\Coordinates::convertGPDataToDegree(
            $frame->getLongitude(),
            $frame->getLongitudeDirection(),
            true
        );
        $longDec = \NMEA\Utils\Coordinates::convertGPDataToDec(
            $frame->getLongitude()
        );
        
        echo "\n".'Conversion coordinates : '."\n";
        echo 'Latitude : '.$latDeg.' / '.$latDec."\n";
        echo 'Longitude : '.$longDeg.' / '.$longDec."\n";
    }
    
    echo '---------------------------------------------------------------'."\n";
}

fclose($fop);
