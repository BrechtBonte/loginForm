<?php

require_once('User.php');

/**
 * Contains  methods to allow the user class to interact with the mysql database
 *
 * @author brecht.bonte
 */
class UserMysqlDatastore {

    //<editor-fold desc="- constructors -">

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
            self::$instance = new UserMysqlDatastore();
        }

        return self::$instance;
    }

    /**
     * Initializes the db connection if it is not yet initialized
     */
    public function  __construct() {
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

        return User::getUserByArray($row);
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

        return User::getUserByArray($row);
    }

    /**
     * checks if a user exists with the specified id
     * @param int $id
     * @return bool
     */
    public function userExists($id) {
        $id = (int) $id;

        return $this->getUserById($id)->getId() != 0;
    }

    /**
     * checks if a user exists with the specified name
     * @param string $name
     * @return bool
     */
    public function userNameExists($name) {
        $name = (string) $name;

        return $this->getUserByName($name)->getId() != 0;
    }

    //</editor-fold>


    //<editor-fold desc="- password related -">

    public function saltExists($salt) {
        $salt = (string) $salt;

        $stmt = self::$db->query('select salt from users where salt = ?', $salt);

        return $stmt->fetch() != false;
    }

    //</editor-fold>


    //<editor-fold desc="- Inserts -">

    /**
     * Inserts a user into the database
     * @param User $user
     * @return User
     */
    public function addUser(User $user) {

        $data = array('name' => $user->getName(), 'password' => $user->getPassword(), 'salt' => $user->getSalt());
        $id = self::$db->insert('users', $data);

        $stmt = self::$db->query('select id,name,password,salt from users where id = ?', $id);
        $row = $stmt->fetch();

        return User::getUserByArray($row);
    }

    //</editor-fold>

}
?>
