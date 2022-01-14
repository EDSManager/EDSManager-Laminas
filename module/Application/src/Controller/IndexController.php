<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Module;
use Laminas\ComponentInstaller\ConfigDiscovery\ApplicationConfig;
use Laminas\Mvc\Application;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Entity\User;


class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructor. Its purpose is to inject dependencies into the controller.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function indexAction()
    {

        return new ViewModel();

    }

    public function aboutAction()
    {

        $appName = 'EDS Manager';
        $appDescription = 'Краткое описание приложения EDS Manager.';

        // Возвращает переменные скрипту представления с помощью
        // переменной-контейнера ViewModel
        return new ViewModel([
            'appName' => $appName,
            'appVersion' => Module::VERSION,
            'appDescription' => $appDescription
        ]);
    }

    /**
     * The "settings" action displays the info about currently logged in user.
     */
    public function settingsAction()
    {
        // Use the CurrentUser controller plugin to get the current user.
        $user = $this->currentUser();

        if ($user==null) {
            throw new \Exception('Not logged in');
        }

        return new ViewModel([
            'user' => $user
        ]);
    }

    public function libraryAction()
    {
        return new ViewModel();
    }
}
