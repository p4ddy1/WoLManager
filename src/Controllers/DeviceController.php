<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Models\Device;

class DeviceController extends BaseController
{
    public function index(){
        $search = $_GET['search'];
        if(isset($search)){
            $devices = Device::where('name','LIKE','%'.$search.'%', true);
        }else{
            $devices = Device::loadAll();
        }
        echo $this->twig->render('devices/index.html.twig', ['devices' => $devices, 'search' => $search]);
    }

    public function create(){
        echo $this->twig->render('devices/create.html.twig');
    }

    public function save(){
        if($data = $this->validateInput()){
            $device = new Device();
            $device->setProperty('name', $data['name']);
            $device->setProperty('ip', $data['ip']);
            $device->setProperty('subnet', $data['subnet']);
            $device->setProperty('mac', $data['mac']);
            $device->create();
        }

        header('Location: /devices');
    }

    public function delete($id){
        $device = Device::loadById($id);
        $device->delete();

        header('Location: /devices');
    }

    public function edit($id){
        $device = Device::loadById($id);
        echo $this->twig->render('devices/edit.html.twig', ['device' => $device]);
    }

    public function update(){
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $data = $this->validateInput();
        if($id && $data){
            $device = Device::loadById($id);
            $device->setProperty('name', $data['name']);
            $device->setProperty('ip', $data['ip']);
            $device->setProperty('subnet', $data['subnet']);
            $device->setProperty('mac', $data['mac']);
            $device->update();
        }

        header('Location: /devices');
    }

    private function validateInput(){
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $ip = filter_var($_POST['ip'], FILTER_VALIDATE_IP);
        $subnet = filter_var($_POST['subnet'], FILTER_VALIDATE_IP);
        $mac = filter_var($_POST['mac'], FILTER_VALIDATE_MAC);
        if($name && $ip && $subnet && $mac){
            return [
                'name' => $name,
                'ip' => $ip,
                'subnet' => $subnet,
                'mac' => $mac
            ];
        }else{
            return false;
        }
    }
}