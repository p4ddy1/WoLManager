<?php
namespace App\Controllers;

use App\Base\BaseController;
use App\Classes\Auth;
use App\Models\Device;

class DeviceController extends BaseController
{
    protected $isRestricted = true;

    public function index(){
        $search = null;
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $devices = Device::where('name','LIKE','%'.$search.'%', true);
        }else {
            $devices = Device::loadAll();
        }
        $this->render('devices/index.html.twig', ['devices' => $devices, 'search' => $search]);
    }

    public function create(){
        echo $this->render('devices/create.html.twig');
    }

    public function save(){
        if($data = $this->validateInput()){
            $device = new Device();
            $device->setName($data['name']);
            $device->setIP($data['ip']);
            $device->setSubnet($data['subnet']);
            $device->setMAC(strtoupper($data['mac']));
            $device->create();
            $this->setSuccess('Device successfully added!');
        }else{
            $this->setError('Error while creating new device');
        }

        header('Location: /devices');
    }

    public function delete($id){
        $device = Device::loadById($id);
        $device->delete();

        $this->setSuccess('Device successfully deleted!');
        header('Location: /devices');
    }

    public function edit($id){
        $device = Device::loadById($id);
        echo $this->render('devices/edit.html.twig', ['device' => $device]);
    }

    public function update(){
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $data = $this->validateInput();
        if($id && $data){
            $device = Device::loadById($id);
            $device->setName($data['name']);
            $device->setIP($data['ip']);
            $device->setSubnet($data['subnet']);
            $device->setMAC(strtoupper($data['mac']));
            $device->update();
            $this->setSuccess('Device successfully edited!');
        }else{
            $this->setError('Error while saving device!');
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