<?php
namespace App\Models;

use App\Base\BaseModel;

class Device extends BaseModel{
    function __construct()
    {
        parent::__construct();
    }

    public function setName($name){
        $this->setProperty('name', $name);
    }
    public function setIP($ip){
        $this->setProperty('ip', $ip);
    }
    public function setSubnet($subnet){
        $this->setProperty('subnet', $subnet);
    }
    public function setMAC($mac){
        $this->setProperty('mac', $mac);
    }

    public function getID(){
        return $this->getProperty('id');
    }
    public function getName(){
        return $this->getProperty('name');
    }
    public function getIP(){
        return $this->getProperty('ip');
    }
    public function getSubnet(){
        return $this->getProperty('subnet');
    }
    public function getMAC(){
        return $this->getProperty('mac');
    }
}