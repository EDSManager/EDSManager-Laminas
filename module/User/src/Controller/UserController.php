<?php

namespace User\Controller;

//use User\Module;
//use Laminas\ComponentInstaller\ConfigDiscovery\ApplicationConfig;
//use Laminas\Mvc\Application;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;


class UserController extends AbstractActionController
{
    public function indexAction()
    {

        return new ViewModel();

    }

    public function loginAction()
    {

        echo "test";
        return new ViewModel();

    }
}
