<?php
namespace LoginForm\Groups;

use LoginForm\Users\User;
use Doctrine\Common\Collections\ArrayCollection;

/** @Entity */
class Group {
    /**
     * @Id @Column(type="integer") @GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /**
     * @Column(type="string", length=50) 
     * @var string
     */
    private $name;
    
    /**
     * @ManyToMany(targetEntity="LoginForm\Users\User", mappedBy="groups")
     * @var ArrayCollection
     */
    private $users;
    
    public function getName() {
        return $this->name;
    }

    public function getUsers() {
        return $this->users;
    }

    public function __construct($name) {
        if($name === null || (string)$name === '') {
            throw new \InvalidArgumentException('the $name parameter should be a non-null string');
        }
        
        $this->name = (string) $name;
        
        $this->users = new ArrayCollection();
    }
    
    public function addUser(User $user) {
        $this->users[] = $user;
        $groups = $user->getGroups();
        $groups[] = $this;
    }
}