<?php
namespace App\Traits;

/**
 * Providing a getter and setter for multidimensional arrays.
 * Usage: key1.key2.key3
 * Trait MultiGetSet
 * @package App\Traits
 */
trait MultiGetSet{
    /**
     * @param $array
     * @param $path
     * @return mixed
     */
    private function multiGet($array, $path){
        $path = explode('.',$path);
        $tmp = $array;
        foreach ($path as $key){
            $tmp = $tmp[$key];
        }
        return $tmp;
    }

    /**
     * @param $array
     * @param $path
     * @param $value
     */
    private function multiSet(&$array, $path, $value){
        $path = explode('.',$path);
        $tmp =& $array;
        foreach ($path as $key){
            $tmp =& $tmp[$key];
        }
        $tmp = $value;
    }

    /**
     * @param $array
     * @param $path
     * @return bool
     */
    private function multiExists($array, $path){
        $path = explode('.',$path);
        $tmp = $array;
        foreach ($path as $key){
            if(gettype($tmp) !== "array"){
                return false;
            }
            if(key_exists($key, $tmp)){
                $tmp = $tmp[$key];
            }else{
                return false;
            }

        }
        return true;
    }
}