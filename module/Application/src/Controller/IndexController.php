<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Module;
use Laminas\ComponentInstaller\ConfigDiscovery\ApplicationConfig;
use Laminas\Mvc\Application;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;


class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function aboutAction()
    {


        $appName = 'EDSManager';
        $appDescription = 'Description Application EDSManager...';

        // Возвращает переменные скрипту представления с помощью
        // переменной-контейнера ViewModel
        return new ViewModel([
            'appName' => $appName,
            'appVersion' => Module::VERSION,
            'appDescription' => $appDescription
        ]);
    }
}
