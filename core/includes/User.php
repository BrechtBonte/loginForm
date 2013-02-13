<?php
/**
 * Represents an account used in the login form
 *
 * @author brecht.bonte
 */

require_once 'UserDatastore.php';

class User {

    //<editor-fold desc="- propreties -">

    /**
     * ID of the user
     * @var int
     */
    private $id;

    /**
     * name of the user
     * @var string
     */
    private $name;

    /**
     * hashed password of the user
     * @var string
     */
    private $password;

    /**
     * salt used by the usre
     * @var string
     */
    private $salt;
    
    /**
     * gets the user's id proprety
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * gets the user's name proprety
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * gets the user's hashed password
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * gets the user's salt
     * @return salt
     */
    public function getSalt() {
        return $this->salt;
    }


    //</editor-fold>

    
    //<editor-fold desc="- constructors -">

    /**
     * creates new user instance
     * @param int $id
     * @param string $name
     * @param string $password
     * @param sring $salt
     */
    public function __construct($id, $name, $password, $salt) {
        $id = (int) $id;
        $name = (string) $name;
        $password = (string) $password;
        $salt = (string) $salt;

        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->salt = $salt;
    }

    /**
     * creates a new user according to an array
     * @param array $arr
     * @return User
     */
    public static function getUserByArray($arr) {
        return new User($arr['id'], $arr['name'], $arr['password'], $arr['salt']);
    }

    //</editor-fold>
}

?>
