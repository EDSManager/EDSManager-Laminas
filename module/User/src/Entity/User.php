<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Этот класс представляет собой зарегистрированного пользователя.
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */

class User
{
    // Константы статуса пользователя.
    const STATUS_ACTIVE       = 1; // Активный пользователь.
    const STATUS_RETIRED      = 2; // Неактивный пользователь.

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="person_id")
     */
    protected $personId;
    /**
     * @ORM\Column(name="login")
     */
    protected $login;

    /**
     * @ORM\Column(name="password")
     */
    protected $password;

    /**
     * @ORM\Column(name="status")
     */
    protected $status;

    /**
     * @ORM\Column(name="date_created")
     */
    protected $dateCreated;

    /**
     * @ORM\Column(name="date_last_login")
     */
    protected $dateLastLogin;

    // ******************************

    /**
     * Возвращает ID пользователя.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Задает ID пользователя.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Возвращает Person_Id пользователя.
     * @return integer
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Задает Person_Id пользователя.
     * @param int $personId
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;
    }

    /**
     * Возвращает логин
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Задает логин
     * @param string $login
     */
    public function setEmail($login)
    {
        $this->login = $login;
    }

    /**
     * Возвращает статус.
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Возвращает возможные статусы в виде массива.
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_RETIRED => 'Retired'
        ];
    }

    /**
     * Возвращает статус пользователя в виде строки.
     * @return string
     */
    public function getStatusAsString()
    {
        $list = self::getStatusList();
        if (isset($list[$this->status]))
            return $list[$this->status];

        return 'Unknown';
    }

    /**
     * Устанавливает статус.
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Возвращает пароль.
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Задает пароль.
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Возвращает дату создания пользователя.
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Задает дату создания пользователя.
     * @param string $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * Возвращает дату последнего входа пользователя.
     * @return string
     */
    public function getDateLastLogin()
    {
        return $this->dateLastLogin;
    }

    /**
     * Задает дату последнего входа пользователя.
     * @param string $dateLastLogin
     */
    public function setDateLastLogin($dateLastLogin)
    {
        $this->dateLastLogin = $dateLastLogin;
    }

}