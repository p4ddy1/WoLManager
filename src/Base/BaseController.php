<?php
namespace App\Base;

abstract class BaseController
{
    protected $twigLoader, $twig;

    function __construct()
    {
        $this->twigLoader = new \Twig_Loader_Filesystem(__DIR__.'/../../templates');
        $this->twig = new \Twig_Environment($this->twigLoader);
    }
}