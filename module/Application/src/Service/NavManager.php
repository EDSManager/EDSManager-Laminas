<?php

namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Laminas\Authentication\Authentication
     */
    private $authService;
    
    /**
     * Url view helper.
     * @var Laminas\View\Helper\Url
     */
    private $urlHelper;
    
    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper) 
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
    }
    
    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() 
    {
        $url = $this->urlHelper;
        $items = [];

        //$items[] = [
        //    'id' => 'home',
        //    'label' => 'Home',
        //    'link'  => $url('home')
        //];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.

        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {

            $items[] = [
                'id' => 'library',
                'label' => 'Библиотека',
                'dropdown' => [
                    [
                        'id' => 'users',
                        'label' => 'Журнал документов',
                        'link'  => $url('library')

                    ]
                ]
            ];

            $items[] = [
                'id' => 'admin',
                'label' => 'Администрирование',
                'dropdown' => [
                    [
                        'id' => 'users',
                        'label' => 'Пользователи',
                        'link' => $url('users')
                    ]
                ]
            ];

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => 'Settings',
                        'link' => $url('application', ['action'=>'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Sign out',
                        'link' => $url('logout')
                    ],
                ]
            ];

        }

        $items[] = [
            'id' => 'about',
            'label' => 'О программе',
            'link'  => $url('about')
        ];

        return $items;
    }
}


