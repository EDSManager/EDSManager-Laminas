<?php
namespace User\Service;

use User\Entity\User;
use Laminas\Crypt\Password\Bcrypt;


/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * PHP template renderer.
     * @var type
     */
    private $viewRenderer;

    /**
     * Application config.
     * @var type
     */
    private $config;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager, $viewRenderer, $config)
    {
        $this->entityManager = $entityManager;
        $this->viewRenderer = $viewRenderer;
        $this->config = $config;
    }

    /**
     * Этот метод добавляет нового пользователя.
     */
    public function addUser($data)
    {
        // Не допускаем создание нескольих пользователей с одинаковым адресом эл. почты.
        if ($this->checkUserExists($data['login'])) {
            throw new \Exception("User with login " .
                $data['$login'] . " already exists");
        }

        // Создаем новую сущность User.
        $user = new User();
        $user->setLogin($data['login']);

        // Зашифровываем пароль и храним его в зашифрованном состоянии.
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);
        $user->setPassword($passwordHash);

        $user->setStatus($data['status']);

        $currentDate = date('Y-m-d H:i:s');
        $user->setDateCreated($currentDate);

        // Добавляем сущность в менеджер сущностей.
        $this->entityManager->persist($user);

        // Применяем изменения к базе данных.
        $this->entityManager->flush();

        return $user;
    }

    /**
     * This method updates data of an existing user.
     */
    public function updateUser($user, $data)
    {
        // Do not allow to change user email if another user with such email already exits.
        if($user->getLogin()!=$data['login'] && $this->checkUserExists($data['login'])) {
            throw new \Exception("Another user with login " . $data['login'] . " already exists");
        }

        $user->setLogin($data['login']);
        $user->setStatus($data['status']);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }

    /**
     * Этот метод проверяет, существует ли хотя бы один пользователь, и, если таковых нет, создает
     * пользователя 'Admin' с логином 'admin' и паролем 'admin'.
     */
    public function createAdminUserIfNotExists()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([]);
        if ($user==null) {
            $user = new User();
            $user->setLogin('admin');
            $bcrypt = new Bcrypt();
            $passwordHash = $bcrypt->create('admin');
            $user->setPassword($passwordHash);
            $user->setStatus(User::STATUS_ACTIVE);
            $user->setDateCreated(date('Y-m-d H:i:s'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }

    /**
     * Checks whether an active user with given login already exists in the database.
     */
    public function checkUserExists($login) {

        $user = $this->entityManager->getRepository(User::class)
            ->findOneByLogin($login);

        return $user !== null;
    }

    /**
     * Проверяет, что заданный пароль является корректным..
     */
    public function validatePassword($user, $password)
    {
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if ($bcrypt->verify($password, $passwordHash)) {
            return true;
        }

        return false;
    }

    /**
     * This method is used to change the password for the given user. To change the password,
     * one must know the old password.
     */
    public function changePassword($user, $data)
    {
        $oldPassword = $data['old_password'];

        // Check that old password is correct
        if (!$this->validatePassword($user, $oldPassword)) {
            return false;
        }

        $newPassword = $data['new_password'];

        // Check password length
        if (strlen($newPassword)<6 || strlen($newPassword)>64) {
            return false;
        }

        // Set new password for user
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($newPassword);
        $user->setPassword($passwordHash);

        // Apply changes
        $this->entityManager->flush();

        return true;
    }

}