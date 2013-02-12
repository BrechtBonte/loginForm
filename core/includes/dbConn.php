<?php

/**
 * Handles all communication with the dabase server
 *
 * @author brecht.bonte
 */
class dbConn {

    /**
     * Insert values into a table
     * @param string $table table where values should be inserted
     * @param array $values assoc array with key => param name and value => value
     */
    public static function insert($table, $values) {
        $table = (string) $table;
        $values = (array) $values;

        if(count(values) == 0) return;

        $values = self::quoteVals($values);

        $params = sprintf('(`%s`)', implode('`,`', array_keys($values)));
        $vals = sprintf('(%s)', implode(',', array_values($values)));

        $query = sprintf('insert into %s %s values %s', $table, $params, $vals);
        $result = execute($query);

        return $result;
    }

    /**
     * returns specified values from the database
     * @param string $table table from which values should be selected
     * @param array $fields parameters that should be selected
     * @param array $where assoc array with key => param name and value => value, containing conditions for the select statement
     * @return array
     */
    public static function select($table, $fields = array(), $where = array()) {
        $table = (string) $table;
        $values = (string) $values;
        $where = (string) $where;

        $params = count($fields) == 0? '*' : implode(',', $fields);
        $wheres = self::buildWhere($where);

        $query = sprintf('select %s from %s%s', $params, $table, $wheres);
        $result = execute($query);

        $results = array();
        while(($res = mysqli_fetch_assoc($result))) {
            array_push($res);
        }

        return $results;
    }


    /**
     * executes a query to the mysql server
     * @param string $query
     * @return Bool or mysqli_result object
     */
    public static function execute($query) {
        $query = (string) $query;

        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DB);

        if(mysqli_connect_errno ()) {
            throw new Exception('Connection failed: ' . mysqli_connect_error());
        }

        $result = mysqli_query($query);
        if(mysqli_errno ()) {
            throw new Exception('Query failed: ' . mysqli_error());
        }

        if($db->insert_id != 0) {
            return $db->insert_id;
        }
        return $result;

        $db->close();
    }





    /**
     * puts quotes arround all values that are strings
     * @param array $values
     * @return array
     */
    private static function quoteVals($values) {
        $values = (array) $values;

        foreach($values as $key => $val) {
            if(is_string($val)) {
                $values[$key] = "'" . $val . "'";
            }
        }

        return $values;
    }

    /**
     * builds a string from the array containing the where clauses
     * @param array $where assoc array where key => param name and value => value
     */
    private static function buildWhere($where) {
        $whereStr = '';

        foreach($where as $key => $value) {
            if($whereStr == '') {
                $whereStr = ' where';
            } else {
                $whereStr .= ' and';
            }
            $whereStr .= sprintf(' %s=%s', $key, is_string($value)? "'" . $value . "'" : $value);
        }
    }
    
}
?>
