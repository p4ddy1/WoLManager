<?php
namespace App\Traits;

trait NetworkCalc {
    /** Calculates the broadcast address of a network according to the given information
     * @param $ip
     * @param $subnetMask
     * @return string
     */
    public function calculateBroadcast($ip, $subnetMask){
        return long2ip(ip2long($ip) | ~ip2long($subnetMask));
    }

    /** Converts a MAC Address from a string to its binary representation
     * @param $macAddress
     * @return bool|string
     */
    private function macToBin($macAddress){
        $mac = str_replace(':', '', $macAddress);
        return hex2bin($mac);
    }
}