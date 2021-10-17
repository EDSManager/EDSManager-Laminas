<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use User\Entity\User;

// id
// Last_Name - Фамилия
// First_Name - Имя
// Middle_Name - Отчество
// email - электронная почта

/**
 * Этот класс представляет собой данные по персонам (Person).
 * @ORM\Entity(repositoryClass="\User\Repository\PersonRepository")
 * @ORM\Table(name="person")
 */
class Person
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="last_name")
     */
    protected $lastName;

    /**
     * @ORM\Column(name="first_name")
     */
    protected $firstName;

    /**
     * @ORM\Column(name="middle_name")
     */
    protected $middleName;

    /**
     * @ORM\Column(name="email")
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="\User\Entity\User", mappedBy="person")
     * @ORM\JoinColumn(name="id", referencedColumnName="person_id")
     */
    protected $users;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * Возвращает ID персоны.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Возвращает фамилию персоны (Last_Name).
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Задает фамилию персоны (Last_Name).
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Возвращает имя персоны (First_Name).
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Задает имя персоны (First_Name).
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Возвращает отчество персоны (Middle_Name).
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Задает отчество персоны (Middle_Name).
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * Возвращает электронную почту персоны (email).
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Задает электронную почту персоны (email).
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Возвращает FullName - полное ФИО.
     * @return string
     */
    public function getFullName()
    {
        return $this->lastName .' '. $this->firstName .' '. $this->middleName;
    }

}
