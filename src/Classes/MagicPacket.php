<?php
namespace App\Classes;

use App\Traits\NetworkCalc;

class MagicPacket
{
    use NetworkCalc;
    private $destinationAddress, $destinationSubnetMask, $destinationMac, $destinationPort, $socket;

    /**
     * MagicPacket constructor.
     * @param $destinationMac
     * @param $destinationAddress
     * @param $destinationSubnetMask
     * @param int $port
     */
    public function __construct($destinationMac, $destinationAddress, $destinationSubnetMask, $port = 7)
    {
        $this->destinationMac = $destinationMac;
        $this->destinationSubnetMask = $destinationSubnetMask;
        $this->destinationAddress = $destinationAddress;
        $this->destinationPort = $port;

        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_option($this->socket, SOL_SOCKET, SO_BROADCAST, 1);
    }

    /**
     * Sends the magic packet
     * @return bool
     */
    public function send(){
        $data = $this->generatePacketData();
        $broadcastAddress = $this->calculateBroadcast($this->destinationAddress,$this->destinationSubnetMask);
        if(!socket_connect($this->socket, $broadcastAddress, $this->destinationPort)){
            return false;
        }
        if(!socket_write($this->socket, $data, strlen($data))){
            return false;
        }
        return true;
    }

    /**
     * Generates the magic packet data with 6x 0xFF and 16x the MAC address
     * @return string
     */
    private function generatePacketData(){
        $packetData = '';
        $binaryMac = $this->macToBin($this->destinationMac);

        //Magic Packets always start with 6x 0xFF
        for($i=0;$i<6;$i++){
            $packetData .= "\xFF";
        }

        //Add the mac address 16x
        for($i=0;$i<16;$i++){
            $packetData .= $binaryMac;
        }

        return $packetData;
    }
}