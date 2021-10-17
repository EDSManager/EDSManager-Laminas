<?php
namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use User\Service\PersonManager;

/**
 * This is the factory class for PersonManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class PersonManagerFactory
{
    /**
     * This method creates the PersonManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $viewRenderer = $container->get('ViewRenderer');
        $config = $container->get('Config');
                        
        return new PersonManager($entityManager, $viewRenderer, $config);
    }
}
