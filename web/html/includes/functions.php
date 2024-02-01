<?php
/**
 * A function to convert runtime minute into hour
 * @author Kayla Nguyen
 *
 * @param number $runtime The runtime in minute
 * @return string The runtime in hour
 */
function convertRuntime($runtime){
    $hour = floor($runtime/60);
    $minute = $runtime - $hour*60;
    if($minute == 0){
        return $hour.'h';
    }
    if($hour == 0){
        return $minute.'min';
    }
    return $hour.'h '.$minute.'min';
}
?>
