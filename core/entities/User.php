<?php
namespace LoginForm\Users;

use LoginForm\Groups\Group;
use LoginForm\Enums\Language;
use Doctrine\Common\Collections\ArrayCollection;

/** @Entity @Table(name="users") */
class User {
    /** 
     * @Id @Column(type="integer") @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /** 
     * @Column(type="string", length=20)
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string", length=32)
     * @var string
     * hashed password
     */
    protected $password;

    /** 
     * @Column(type="string", length=32)
     * @var string
     */
    protected $salt;
    
    
    /**
     * @OneToOne(targetEntity="LoginForm\Enums\Language")
     * @var Language
     */
    protected $language;
    
    /**
     * @ManyToMany(targetEntity="LoginForm\Groups\Group", inversedBy="users")
     * @var ArrayCollection
     */
    protected $groups;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSalt() {
        return $this->salt;
    }
    
    public function getLanguage() {
        return $this->language;
    }

    public function getGroups() {
        return $this->groups;
    }

    public function __construct($name, $password, $salt, Language $language = null) {
        if($name === null || (string)$name === '') {
            throw new \InvalidArgumentException('the $name attribute should be a non-empty string');
        }
        if($password === null || (string)$password === '') {
            throw new \InvalidArgumentException('the $password attribute should be a non-empty string');
        }
        if($salt === null || (string)$salt === '') {
            throw new \InvalidArgumentException('the $salt attribute should be a non-empty string');
        }
        
        $this->name = (string) $name;
        $this->password = (string) $password;
        $this->salt = (string) $salt;
        $this->language = $language;
        
        $this->groups = new ArrayCollection();
    }
    
    public function setLanguage(Language $language) {
        $this->language = $language;
    }

    public function addGroup(Group $group) {
        $this->groups[] = $group;
        $usrs = $group->getUsers();
        $usrs[] = $this;
    }


}