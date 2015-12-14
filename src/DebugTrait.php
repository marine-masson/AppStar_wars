<?php
/**
 * Created by PhpStorm.
 * User: Marine
 * Date: 27/11/2015
 * Time: 11:30
 */

trait DebugTrait {

    private function debug($value){
        if(defined('DEBUG') && DEBUG){
            var_dump($value);
        }
    }
}