<?php
require_once('User.php');

class UserMysqlDatastore {

    /** @var UserDatastore */
    private static $instance;

    /** @var Zend_Db_Adapter_Pdo_Mysql */
    private static $db;

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
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
    
    public function getAll() {
        $users = array();

        $stmt = self::$db->query('select id,name,password,salt from users');

        while($row = $stmt->fetch()) {
            $user = User::getUserByArray($row);
            array_push($users, $user);
        }

        return $users;
    }

    public function getUserById($id) {
        $stmt = self::$db->query('select id,name,password,salt from users where id = ?', (int) $id);
        $row = $stmt->fetch();

        return $row? User::getUserByArray($row) : null;
    }

    public function getUserByName($name) {
        $stmt = self::$db->query('select id,name,password,salt from users where name = ?', (string) $name);
        $row = $stmt->fetch();

        return $row? User::getUserByArray($row) : null;
    }

    public function userExists($id) {
        return $this->getUserById((int) $id) !== null;
    }

    public function userNameExists($name) {
        return $this->getUserByName((string) $name) !== null;
    }
    
    public function addUser(User $user) {
        $data = array('name' => $user->getName(), 'password' => $user->getPassword(), 'salt' => $user->getSalt());
        $id = self::$db->insert('users', $data);
        return $id;
    }

    public function saltExists($salt) {
        $stmt = self::$db->query('select salt from users where salt = ?', (string) $salt);

        return $stmt->fetch() != false;
    }
}