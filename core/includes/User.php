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
     * datastore that contains all database related methods
     * @var UserDatastore
     */
    private static $datastore;
    
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

    /**
     * initializes the static functionality of the User class
     */
    public static function init() {
        if(self::$datastore === null) {
            self::$datastore = UserMysqlDatastore::getInstance();
        }
    }

    //</editor-fold>


    //<editor-fold desc="- getters -">

    /**
     * Creates a new user instance for the specified user
     * @param int $id 
     * @return User
     */
    public static function getUserById($id) {
        $id = (int) $id;

        return self::$datastore->getUserById($id);
    }

    /**
     * Creates a new user instance for the specified user
     * @param string $name
     * @return User
     */
    public static function getUserByName($name) {
        $name = (string) $name;

        return self::$datastore->getUserByName($name);
    }
    
    /**
     * checks if a user with the given id exists
     * @param int $id
     * @return bool
     */
    public static function exists($id) {
        return self::$datastore->userExists($id);
    }

    //</editor-fold>

    //<editor-fold desc="- methods -">

    /**
     * Adds a new user to the database
     * @param string $name
     * @param string $password
     */
    public static function addNew($name, $password) {
        $name = (string) $name;
        $password = (string) $password;

        list($pass, $salt) = self::encrypt($password);

        $user = new User(0, $name, $pass, $salt);

        return self::$datastore->addUser($user);
    }

    /**
     * Checks if the username is already in use
     * @param string $name
     */
    public static function checkName($name) {
        $name = (string) $name;

        return self::$datastore->userNameExists($name);
    }

    /**
     * checks the user's password to a supplied password
     * @param string $pass
     */
    public function checkPass($password) {
        $password = (string) $password;

        $enc = md5($this->salt.$password);

        return $this->password == $enc;
    }

    /**
     * gets all registered users
     * @return array of User objects
     */
    public static function getAll() {

        return self::$datastore->getAll();
    }

    //</editor-fold>

    //<editor-fold desc="- authentication functions -">

    /**
     * http://code.activestate.com/recipes/576894-generate-a-salt/
     * This function generates a password salt as a string of x (default = 15) characters
     * in the a-zA-Z0-9!@#$%&*? range.
     * @param $max integer The number of characters in the string
     * @return string
     * @author AfroSoft <info@afrosoft.tk>
     */
    private static function generateSalt($max = 32) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
    }

    /**
     * generates a salt and hash for the password
     * @param string $password
     * @return array (password, salt)
     */
    private static function encrypt($password, $salt = NULL) {
        $password = (string) $password;

        if($salt == NULL) {

            do {
                $salt = self::generateSalt();
            } while(self::$datastore->saltExists($salt));

        } else {
            $salt = (string) $salt;
        }

        $pass = md5($salt.$password);
        return array($pass, $salt);
    }

    //</editor-fold>
}

User::Init();

?>
