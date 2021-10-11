<?php

namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Laminas\Authentication\Storage\Session as SessionStorage;
use User\Service\AuthAdapter;

/**
 * Это фабрика, отвечающая за создание сервиса аутентификации.
 */

class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * Этот метод создает сервис Zend\Authentication\AuthenticationService
     * и возвращает его экземпляр.
     */
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $sessionManager = $container->get(SessionManager::class);
        $authStorage = new SessionStorage('Zend_Auth', 'session', $sessionManager);
        $authAdapter = $container->get(AuthAdapter::class);

        // Создаем сервис и внедряем зависимости в его конструктор.
        return new AuthenticationService($authStorage, $authAdapter);
    }
}