<?php

/**
 * Handles all communication with the dabase server
 *
 * @author brecht.bonte
 */
class dbConn {
    
    //<editor-fold desc="- connection -">

    private $db;

    public function connect() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DB);

        if(mysqli_connect_errno ($this->db)) {
            throw new Exception('Connection failed: ' . mysqli_connect_error($this->db));
        }
    }

    public function disconnect() {
        $this->db->close();
    }

    public static function getInstance() {
        $var = new dbConn();
        $var->connect();
        return $var;
    }

    //</editor-fold>

    /**
     * Insert values into a table
     * @param string $table table where values should be inserted
     * @param array $values assoc array with key => param name and value => value
     */
    public function insert($table, $values) {
        $table = (string) $table;
        $values = (array) $values;

        if(count($values) == 0) return;

        $values = $this->quoteVals($values);

        $params = sprintf('(`%s`)', implode('`,`', array_keys($values)));
        $vals = sprintf('(%s)', implode(',', array_values($values)));

        $query = sprintf('insert into %s %s values %s', $table, $params, $vals);
        $result = $this->execute($query);

        return $result;
    }

    /**
     * returns specified values from the database
     * @param string $table table from which values should be selected
     * @param array $fields parameters that should be selected
     * @param array $where assoc array with key => param name and value => value, containing conditions for the select statement
     * @return array
     */
    public function select($table, $fields = array(), $where = array()) {
        $table = (string) $table;
        $fields = (array) $fields;
        $where = (array) $where;

        $params = count($fields) == 0? '*' : implode(',', $fields);
        $wheres = $this->buildWhere($where);

        $query = sprintf('select %s from %s%s', $params, $table, $wheres);
        $result = $this->execute($query);

        $results = array();
        while(($res = mysqli_fetch_assoc($result))) {
            array_push($results, $res);
        }

        return $results;
    }


    /**
     * executes a query to the mysql server
     * @param string $query
     * @return Bool or mysqli_result object
     */
    public function execute($query) {
        $query = (string) $query;

        if($this->db == null) {
            throw new Exception('Not connected to the database');
        }

        $result = mysqli_query($this->db, $query);
        if(mysqli_errno ($this->db)) {
            throw new Exception('Query failed: ' . mysqli_error($this->db));
        }

        if($this->db->insert_id != 0) {
            return $this->db->insert_id;
        }
        return $result;
    }





    /**
     * puts quotes arround all values that are strings
     * @param array $values
     * @return array
     */
    private function quoteVals($values) {
        $values = (array) $values;

        foreach($values as $key => $val) {
            if(is_string($val)) {
                $values[$key] = "'" . $this->db->real_escape_string($val) . "'";
            }
        }

        return $values;
    }

    /**
     * builds a string from the array containing the where clauses
     * @param array $where assoc array where key => param name and value => value
     */
    private function buildWhere($where) {
        $where = (array) $where;
        $whereStr = '';

        foreach($where as $key => $value) {
            if($whereStr == '') {
                $whereStr = ' where';
            } else {
                $whereStr .= ' and';
            }
            $whereStr .= sprintf(' %s=%s', $key, is_string($value)? "'" . $this->db->real_escape_string($value) . "'" : $value);
        }

        return $whereStr;
    }
    
}
?>
