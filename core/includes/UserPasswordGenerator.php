<?php

use LoginForm\Users\User;

class UserPasswordGenerator {

    /** @var UserDatastore */
//    private static $dataStore;
    
    /** @var UserPasswordGenerator */
    private static $instance;

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

//    private function __construct() {
//        if(self::$dataStore === null) {
//            self::$dataStore = UserMysqlDatastore::getInstance();
//        }
//    }

    /* http://code.activestate.com/recipes/576894-generate-a-salt/ */
    private function generateSalt($max = 32) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
    }

    /** @return array (password, salt) */
    public function encrypt($password, $salt = NULL) {
        if($salt === NULL) {
            global $em;
            do {
                $salt = $this->generateSalt();
            } while($em->getRepository('LoginForm\Users\User')->findBySalt($salt));

        } else {
            $salt = (string) $salt;
        }

        $pass = md5($salt . (string)$password);
        return array($pass, $salt);
    }
    
    public function checkPass(User $user, $password) {
        $enc = md5($user->getSalt() . (string) $password);

        return $user->getPassword() === $enc;
    }
}