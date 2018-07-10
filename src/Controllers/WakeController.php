<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Classes\MagicPacket;
use App\Models\Device;

class WakeController extends BaseController{
    function wakeupDevice($id){
        $device = Device::loadById($id);
        $magicPacket = new MagicPacket($device->getProperty('mac'), $device->getProperty('ip'),$device->getProperty('subnet'));
        $magicPacket->send();
        header('location: /devices');
    }
}