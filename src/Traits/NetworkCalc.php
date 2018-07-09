<?php
namespace App\Traits;

trait NetworkCalc {
    public function calculateBroadcast($ip, $subnetMask){
        return long2ip(ip2long($ip) | ~ip2long($subnetMask));
    }

    private function macToBin($macAddress){
        $mac = str_replace(':', '', $macAddress);
        return hex2bin($mac);
    }
}