<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Этот класс представляет собой зарегистрированного пользователя.
 * @ORM\Entity(repositoryClass="\User\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User
{

    // Константы статуса пользователя.
    const STATUS_ACTIVE       = 1; // Активный пользователь.
    const STATUS_RETIRED      = 2; // Заблокированный пользователь.

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\Person", inversedBy="user")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

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

    /**
     * @ORM\Column(name="person_id")
     */
    protected $personId;


    /**
     * Возвращает ID пользователя.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Возвращает login.
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Задает login.
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
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

    /**
     * Возвращает person_id.
     * @return int
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Задает person_id.
     * @param int $personId
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;
    }

    /**
     * Возвращает связанный person.
     * @return \User\Entity\Person
     */
        public function getPerson()
    {
        return $this->person;
    }

    // Возвращает полное ФИО связанной записи из person
    public function getPersonFullName()
    {
        if ($this->getPerson() != null) {
            return $this->getPerson()->getFullName();
        } else return '';
    }

    // Возвращает e-mail связанной записи из person
    public function getPersonEmail()
    {
        if ($this->getPerson() != null) {
            return $this->getPerson()->getEmail();
        } else return '';
    }

}