<?php
namespace App\Classes;

use App\Traits\NetworkCalc;

class MagicPacket
{
    use NetworkCalc;
    private $destinationAddress, $destinationSubnetMask, $destinationMac, $destinationPort, $socket;

    public function __construct($destinationMac, $destinationAddress, $destinationSubnetMask, $port = 7)
    {
        $this->destinationMac = $destinationMac;
        $this->destinationSubnetMask = $destinationSubnetMask;
        $this->destinationAddress = $destinationAddress;
        $this->port = $port;

        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    }

    public function send(){
        $data = $this->generatePacket();
        $broadcastAddress = $this->calculateBroadcast($this->destinationAddress,$this->destinationSubnetMask);
        socket_connect($this->socket, $broadcastAddress, $this->destinationPort);
        socket_write($this->socket, $data, strlen($data));
    }

    private function generatePacket(){
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