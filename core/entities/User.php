<?php
class User {

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /**
     * hashed password
     * @var string
     */
    private $password;

    /** @var string */
    private $salt;
    
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

    public function __construct($name, $password, $salt) {
        $this->name = (string) $name;
        $this->password = (string) $password;
        $this->salt = (string) $salt;
    }

    public static function getUserByArray(array $arr) {
        $user = new User($arr['name'], $arr['password'], $arr['salt']);
        $user->id = $arr['id'];
        return $user;
    }
}
