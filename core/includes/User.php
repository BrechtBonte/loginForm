<?php
/**
 * Represents an account used in the login form
 *
 * @author brecht.bonte
 */

require_once 'dbConn.php';

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
     * http://stackoverflow.com/questions/4478661/getter-and-setter
     * Return requested propreties
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    //</editor-fold>

    //<editor-fold desc="- constructor -">

    /**
     * creates new user instance
     * @param int $id
     * @param string $name
     * @return User
     */
    public static function getInstance($id, $name) {
        $id = (int) $id;
        $name = (string) $name;

        $var = new User();
        $var->id = $id;
        $var->name = $name;
        return $var;
    }

    /**
     * Creates a new user instance for the specified user
     * @param int $id 
     * @return User
     */
    public static function getUserById($id) {
        $id = (int) $id;

        try {
            $db = dbConn::getInstance();
            $result = $db->select('users', array('id', 'name'), array('id' => $id));
            $db->disconnect();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }

        if(count($result) > 0) {
            $usr = $result[0];

            $var = new User();
            $var->id = $usr['id'];
            $var->name = $usr['name'];
            return $var;
        } else {
            return null;
        }
    }

    /**
     * Creates a new user instance for the specified user
     * @param string $name
     * @return User
     */
    public static function getUserByName($name) {
        $name = (string) $name;

        try {
            $db = dbConn::getInstance();
            $result = $db->select('users', array('id', 'name'), array('name' => $name));
            $db->disconnect();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }

        if(count($result) > 0) {
            $usr = $result[0];

            $var = new User();
            $var->id = $usr['id'];
            $var->name = $usr['name'];
            return $var;
        } else {
            return null;
        }
    }
    
    /**
     * checks if a user with the given id exists
     * @param int $id
     * @return bool
     */
    public static function exists($id) {
        return self::getUserById($id) != null;
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

        try {
            $db = dbConn::getInstance();
            $result = $db->insert('users', array('name' => $name, 'password' => $pass, 'salt' => $salt));
            $db->disconnect();
            return result;
        } catch(Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * Checks if the username is already in use
     * @param string $name
     */
    public static function checkName($name) {
        $name = (string) $name;

        try {
            $db = dbConn::getInstance();
            $result = $db->select('users', array(), array('name' => $name));
            $db->disconnect();
            return count($result) > 0;
        } catch(Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * checks the user's password to a supplied password
     * @param string $pass
     */
    public function checkPass($password) {
        $password = (string) $password;

        try {
            $db = dbConn::getInstance();
            $result = $db->select('users', array('password', 'salt'), array('id' => $this->id));
            $db->disconnect();
        } catch(Exception $e) {
            error_log($e->getMessage());
            return null;
        }

        $res = $result[0];
        $pass = $res['password'];
        $salt = $res['salt'];

        $enc = md5($salt.$password);

        return $pass == $enc;
    }

    /**
     * gets all registered users
     * @return array of User objects
     */
    public static function getAll() {

        $arr = array();

        try {
            $db = dbConn::getInstance();
            $result = $db->select('users', array('id', 'name'));
            $db->disconnect();
        } catch(Exception $e) {
            error_log($e->getMessage());
            return null;
        }

        foreach($result as $res) {
            array_push($arr, self::getInstance($res['id'], $res['name']));
        }

        return $arr;
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
            } while(self::saltExists($salt));

        } else {
            $salt = (string) $salt;
        }

        $pass = md5($salt.$password);
        return array($pass, $salt);
    }


    /**
     * checks if a certain salt has already been used
     * @param string $salt
     * @return bool
     */
    private static function saltExists($salt) {
        $salt = (string) $salt;

        $db = dbConn::getInstance();
        $results = $db->select('users', array('salt'), array('salt' => $salt));
        $db->close();

        return count($results) > 0;
    }

    //</editor-fold>
}

?>
