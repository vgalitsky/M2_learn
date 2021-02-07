<?php
namespace Vg\Learn\Helper;

class Debug {
    static function dump($var, $return = false){
        echo '<pre>';
        print_r($var, $return);
        echo '</pre>';
    }
}