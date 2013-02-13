<?php

require_once('User.php');

/**
 * Contains  methods to allow the user class to interact with the mysql database
 *
 * @author brecht.bonte
 */
class UserMysqlDatastore {

    //<editor-fold desc="- propreties & constructors -">

    /**
     * holds the instance of the UserMysqlDatastore
     * @var UserDatastore
     */
    private static $instance;

    /**
     * Contains the connection to the database
     * @var Zend_Db_Adapter_Pdo_Mysql
     */
    private static $db;


    /**
     * gets the instance of the UserMysqlDatastore class
     * @return UserMysqlDatastore
     */
    public static function getInstance() {

        if(self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initializes the db connection if it is not yet initialized
     */
    private function  __construct() {
        if(self::$db === null) {
            self::$db = new Zend_Db_Adapter_Mysqli(array(
                'host'      => DB_HOST,
                'username'  => DB_USER,
                'password'  => DB_PASS,
                'dbname'    => DB_DB
            ));
        }
    }

    //</editor-fold>


    //<editor-fold desc="- Getters -">

    /**
     * gets all users
     * @return array of Users
     */
    public function getAll() {
        $users = array();

        $stmt = self::$db->query('select id,name,password,salt from users');

        while($row = $stmt->fetch()) {
            $user = User::getUserByArray($row);
            array_push($users, $user);
        }

        return $users;
    }

    /**
     * gets the user with the specified id
     * @param int $id
     * @return User
     */
    public function getUserById($id) {
        $id = (int) $id;

        $stmt = self::$db->query('select id,name,password,salt from users where id = ?', $id);
        $row = $stmt->fetch();

        return $row? User::getUserByArray($row) : null;
    }

    /**
     * gets the user with the specified username
     * @param string $name
     * @return User
     */
    public function getUserByName($name) {
        $name = (string) $name;

        $stmt = self::$db->query('select id,name,password,salt from users where name = ?', $name);
        $row = $stmt->fetch();

        return $row? User::getUserByArray($row) : null;
    }

    /**
     * checks if a user exists with the specified id
     * @param int $id
     * @return bool
     */
    public function userExists($id) {
        $id = (int) $id;

        return $this->getUserById($id) !== null;
    }

    /**
     * checks if a user exists with the specified name
     * @param string $name
     * @return bool
     */
    public function userNameExists($name) {
        $name = (string) $name;

        return $this->getUserByName($name) !== null;
    }

    //</editor-fold>


    //<editor-fold desc="- Inserts -">

    /**
     * Inserts a user into the database
     * @param User $user
     * @return User
     */
    public function addUser($name, $password) {
        $name = (string) $name;
        $password = (string) $password;

        list($pass, $salt) = self::encrypt($password);

        $data = array('name' => $name, 'password' => $pass, 'salt' => $salt);
        $id = self::$db->insert('users', $data);

        $stmt = self::$db->query('select id,name,password,salt from users where id = ?', $id);
        $row = $stmt->fetch();

        return User::getUserByArray($row);
    }

    //</editor-fold>


    //<editor-fold desc="- authentication functions -">

    /**
     * checks the user's password to a supplied password
     * @param User $user
     * @param string $pass
     */
    public function checkPass(User $user, $password) {
        $password = (string) $password;

        $enc = md5($user->getSalt() . $password);

        return $user->getPassword() == $enc;
    }

    /**
     * checks if a given salt is already in use
     * @param string $salt
     * @return bool
     */
    private function saltExists($salt) {
        $salt = (string) $salt;

        $stmt = self::$db->query('select salt from users where salt = ?', $salt);

        return $stmt->fetch() != false;
    }

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
            } while(self::saltExists($salt));

        } else {
            $salt = (string) $salt;
        }

        $pass = md5($salt.$password);
        return array($pass, $salt);
    }

    //</editor-fold>

}
?>
