<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Classes\MagicPacket;
use App\Models\Device;

class WakeController extends BaseController{
    function wakeupDevice($id){
        $device = Device::loadById($id);
        $magicPacket = new MagicPacket($device->getMAC(), $device->getIP(),$device->getSubnet());
        $magicPacket->send();
        header('location: /devices');
    }
}