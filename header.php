<?php
session_start();
include_once('database.php');
$salt = "OUHK_DB_ASSIGNMENT";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo basename($_SERVER["SCRIPT_FILENAME"], '.php');?></title>

    <link rel="stylesheet" type="text/css" href="dist/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap_yeti.min.css">

</head>
<body class="container">


<div class="row">
    <?php
    include_once('menu.php');
    ?>
</div>

<div class="row">
    <div class="col-md-4"></div>

<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-5
 * Time: 下午9:29
 */

    function getUserStatus() {
        if (isset($_SESSION['userid'])) {
            return $_SESSION['userid'];
        } else {
            return "visitor";
        }
    }

    function userLogin($userid, $password) {
        $connection = Database::dbConnect();

        global $salt;
        $password = md5($password.$salt);

        $statement = oci_parse($connection, 'select type from "User" where id = :bv_userid and password = :bv_password');

        oci_bind_by_name($statement, "bv_userid", $userid);
        oci_bind_by_name($statement, "bv_password", $password);

        // echo $userid.$password;
        if (oci_execute($statement)) {

            $result = oci_fetch_assoc($statement);

            if ($result) {
                echo "<h1>Login Success.</h1>";
                $_SESSION['usertype'] = $result['TYPE'];
                $_SESSION['userid'] = $userid;
                $_SESSION['password'] = $password;
                header("Location: index.php");
            } else {
                echo "<h1>User ID and Password is not match.</h1>";
            }
        }
    }

    function is_image($path) {
        $a = getimagesize($path);
        $image_type = $a[2];

        if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
        {
            return true;
        }
        return false;
    }


?>