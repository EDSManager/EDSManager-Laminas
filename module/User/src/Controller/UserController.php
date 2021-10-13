<?php

namespace User\Controller;

//use User\Module;
//use Laminas\ComponentInstaller\ConfigDiscovery\ApplicationConfig;
//use Laminas\Mvc\Application;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Laminas\Paginator\Paginator;
//use Application\Entity\Post;
use User\Entity\User;
use User\Form\UserForm;
use User\Form\PasswordChangeForm;



class UserController extends AbstractActionController
{
    public function indexAction()
    {

        return new ViewModel();

    }

}
