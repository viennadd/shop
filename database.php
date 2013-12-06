<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-6
 * Time: 下午10:44
 */

class database {
    private $connection;

    function __construct($username, $password)
    {
        $db =
            "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP) " .
            "(HOST = oracleacademy.ouhk.edu.hk)(PORT=8998)) " .
            "(CONNECT_DATA=(SERVER=DEDICATED) " .
            "(SID=db1011)))";

        if (!$this->connection) {
            $this->connection = oci_connect($username, $password, $db);
        }
    }

    function select($query) {
        $statement = oci_parse($this->connection, $query);

        oci_execute($statement);

        return oci_fetch_array($statement);
    }

    /**
     * @return resource
     */
    public function getConnection()
    {
        return $this->connection;
    }


} 