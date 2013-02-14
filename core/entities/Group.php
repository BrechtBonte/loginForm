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

    function __construct($name) {
        $this->name = $name;
        
        $this->users = new ArrayCollection();
    }
}