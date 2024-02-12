<?php

namespace KN\BookPlugin;
/**
 * Represents a Rating Generator
 */
class RatingGenerator
{

    /**
     * @param int $value Review rating value
     * @return string Formatted rating
     */
    public static function outputRatings($value){
        $ratings = array(
            'one' => '<i class=\'fa fa-star\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>
                    <i class=\'fa fa-star-o\' aria-hidden=\'true\'></i>',
            'two' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>',
            'three' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>',
            'four' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>',
            'five' => '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>'
        );

        $output = '';

        switch($value) {
            case 1:
                $output = $ratings['one'];
                break;
            case 2:
                $output = $ratings['two'];
                break;
            case 3:
                $output = $ratings['three'];
                break;
            case 4:
                $output = $ratings['four'];
                break;
            case 5:
                $output = $ratings['five'];
                break;
        }

        return $output;
    }
}