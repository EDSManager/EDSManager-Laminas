<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Authentication\Result;
use Laminas\Uri\Uri;
use User\Form\LoginForm;
use User\Entity\User;
use User\Service\UserManager;
use User\View\Helper\CurrentUser;

/**
 * Этот контроллер отвечает для предоставлению пользователю возможности входа в систему и выхода из нее.
 */
class AuthController extends AbstractActionController
{

    /**
     * Менеджер сущностей.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Менеджер аутентификации.
     * @var User\Service\AuthManager
     */
    private $authManager;

    /**
     * Сервис аутентификации.
     * @var \Laminas\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * Менеджер пользователей.
     * @var User\Service\UserManager
     */
    private $userManager;

    /**
     * Конструктор.
     */
    public function __construct($entityManager, $authManager, $authService, $userManager)

    //public function __construct($entityManager, $authManager, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->userManager = $userManager;
        $this->authService = $authService;
    }

    /**
     * Аутентифицирует пользователя по заданным логину и паролю.
     */
    public function loginAction()
    {

        // Извлекает URL перенаправления (если таковой передается). Мы перенаправим пользователя
        // на данный URL после успешной аутентификации.
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }

        // Проверяем, есть ли вообще в базе данных пользователи. Если их нет,
        // создаем пользователя 'Admin'.
        $this->userManager->createAdminUserIfNotExists();

        // Создаем форму входа на сайт.
        $form = new LoginForm();
        $form->get('redirect_url')->setValue($redirectUrl);


        // Храним статус входа на сайт.
        $isLoginError = false;

        // Проверяем, заполнил ли пользователь форму
        if ($this->getRequest()->isPost()) {

            // Заполняем форму POST-данными
            $data = $this->params()->fromPost();

            $form->setData($data);


            // Валидируем форму
            if($form->isValid()) {

                // Получаем отфильтрованные и валидированные данные
                $data = $form->getData();

                // Выполняем попытку входа в систему.
                $result = $this->authManager->login($data['login'],
                    $data['password'], $data['remember_me']);

                // Проверяем результат.
                if ($result->getCode() == Result::SUCCESS) {


                    // Обновялем дату последнего логина
                    $this->user = $this->entityManager->getRepository(User::class)
                        ->findOneByLogin($this->authService->getIdentity());

                    $this->user->setDateLastLogin(date('Y-m-d H:i:s'));
                    $this->entityManager->persist($this->user);
                    $this->entityManager->flush();

                    // Получаем URL перенаправления.
                    $redirectUrl = $this->params()->fromPost('redirect_url', '');

                    if (!empty($redirectUrl)) {
                        // Проверка ниже нужна для предотвращения возможных атак перенаправления
                        // (когда кто-то пытается перенаправить пользователя на другой домен).
                        $uri = new Uri($redirectUrl);
                        if (!$uri->isValid() || $uri->getHost()!=null)
                            throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                    }

                    // Если задан URL перенаправления, перенаправляем на него пользователя;
                    // иначе перенаправляем пользователя на страницу Home.

                     if(empty($redirectUrl)) {
                         return $this->redirect()->toRoute('home');
                     } else {
                         $this->redirect()->toUrl($redirectUrl);
                     }
                } else {
                    $isLoginError = true;
                }
            } else {
                $isLoginError = true;
            }
        }

        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl
        ]);

    }

    /**
     * The "logout" action performs logout operation.
     */
    public function logoutAction()
    {
        $this->authManager->logout();

        return $this->redirect()->toRoute('login');
    }


}
