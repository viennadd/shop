<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-6
 * Time: 下午10:44
 */
class Database {
    private static $connection;
    static function dbConnect($username = "s1110297", $password = "11102974")
    {
        // session_start();

        if (is_null(self::$connection)) {
            $db =
                "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP) " .
                "(HOST = oracleacademy.ouhk.edu.hk)(PORT=8998)) " .
                "(CONNECT_DATA=(SERVER=DEDICATED) " .
                "(SID=db1011)))";

            self::$connection = oci_connect($username, $password, $db);
//            echo "new one ";
        }

//        echo "reuse";
        return self::$connection;

    }
}


