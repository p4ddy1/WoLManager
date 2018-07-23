<?php
namespace App\Classes;
use App\Traits\MultiGetSet;

class Config {
    use MultiGetSet;

    private static $instance = null;
    private $config = [], $sampleConfig = [];
    private $configPath = __DIR__.'/../../config/config.php';
    private $sampleConfigPath = __DIR__.'/../../config/config.sample.php';

    /**
     * Config constructor.
     * @throws \Exception
     */
    function __construct()
    {
        if(file_exists($this->configPath)){
            $this->config = include($this->configPath);
            $this->config['configured'] = true;
        } else{
            $this->config['configured'] = false;
        }

        if(file_exists($this->sampleConfigPath)){
            $this->sampleConfig = include($this->sampleConfigPath);
        }else{
            throw new \Exception('Sample config not found!');
        }
    }

    /**
     * Returns true if a configuration file exists
     * @return mixed
     */
    function isConfigured(){
        return $this->config['configured'];
    }

    /**
     * Returns configuration value for given key. Checks config.php first, then config.sample.php for default value.
     * @param $key
     * @return mixed
     */
    function get($key){
        if($this->multiExists($this->config, $key)){
            return $this->multiGet($this->config, $key);
        }else if($this->multiExists($this->sampleConfig, $key)){
            return $this->multiGet($this->sampleConfig, $key);
        }else{
            return false;
        }
    }

    /**
     * Singleton
     * @return Config|null
     * @throws \Exception
     */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self;
        }
        return self::$instance;
    }
}