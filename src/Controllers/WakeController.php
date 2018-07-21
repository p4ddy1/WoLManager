<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Classes\MagicPacket;
use App\Models\Device;

class WakeController extends BaseController{
    protected $isRestricted = true;

    /**
     * Sends a magic packet to the device with the given id
     * @param $id
     */
    function wakeupDevice($id){
        $device = Device::loadById($id);
        $magicPacket = new MagicPacket($device->getMAC(), $device->getIP(),$device->getSubnet());
        if($magicPacket->send()){
            $this->setSuccess('MagicPacket successfully sent to '.$device->getName(). '!');
        }else{
            $this->setError('Error while MagicPacket to '.$device->getName(). '!');
        }
        header('location: /devices');
    }
}