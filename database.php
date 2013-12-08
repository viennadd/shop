<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-6
 * Time: 下午10:44
 */

    function dbConnect($username = "s1110297", $password = "11102974")
    {
        $db =
            "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP) " .
            "(HOST = oracleacademy.ouhk.edu.hk)(PORT=8998)) " .
            "(CONNECT_DATA=(SERVER=DEDICATED) " .
            "(SID=db1011)))";

        $connection = oci_connect($username, $password, $db);

        if (!$connection) {
            $e = oci_error();
            echo $e['message']; //print error message
        } else {
            return $connection;
        }

    }


