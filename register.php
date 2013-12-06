
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <?php
    include_once('header.php');
    ?>
</head>
<body class="container">


<div class="row">
    <?php
    include_once('menu.php');
    ?>
</div>

<div class="row">
    <div class="col-md-4"></div>

<div class="col-md-4">

    <?php if (!isset($_POST['submit'])) { ?>

        <form class="form-horizontal" method="post" action="register.php">
            <fieldset>
                <div id="legend" class="">
                    <legend class="">Regiater</legend>
                </div>
                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">User ID</label>
                    <div class="controls">
                        <input type="text" placeholder="User ID" class="form-control" name="userid">
                        <span class="help-block">Supporting help text</span>
                    </div>
                </div>



                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Password</label>
                    <div class="controls">
                        <input type="password" placeholder="Password" class="form-control" name="password">
                        <p class="help-block">Supporting help text</p>
                    </div>
                </div>

                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Password (Repeat)</label>
                    <div class="controls">
                        <input type="password" placeholder="Password" class="form-control" name="password_repeat">
                        <p class="help-block">Supporting help text</p>
                    </div>
                </div>

                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Full name</label>
                    <div class="controls">
                        <input type="text" placeholder="Full name" class="form-control" name="full_name">
                        <p class="help-block">Supporting help text</p>
                    </div>
                </div>

                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Contact phone</label>
                    <div class="controls">
                        <input type="text" placeholder="Contact phone" class="form-control" name="phone">
                        <p class="help-block">Supporting help text</p>
                    </div>
                </div>



                <div class="control-group">

                    <!-- Textarea -->
                    <label class="control-label">Address</label>
                    <div class="controls">
                        <div class="textarea">
                            <textarea type="" class="form-control" name="address"> </textarea>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>

                    <!-- Button -->
                    <div class="controls">
                        <button class="btn btn-primary" type="submit" name="submit" value="submit">Submit</button>
                    </div>
                </div>

            </fieldset>
        </form>

    <?php } else {
        //include_once('database.php');

        $db =
            "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP) " .
            "(HOST = oracleacademy.ouhk.edu.hk)(PORT=8998)) " .
            "(CONNECT_DATA=(SERVER=DEDICATED) " .
            "(SID=db1011)))";
        $conn = oci_connect($userID, $password, $db);
        if (!$conn) {
            $e = oci_error();
            echo $e['message']; //print error message
        }

        $statement = oci_parse($conn, 'insert into "User" (id, username, password, phone, address)'.
                                                     "values (:bv_userid, :bv_username, :bv_password, :bv_phone, :bv_address)");

        oci_bind_by_name($statement, "bv_userid", $_POST['userid']);
        oci_bind_by_name($statement, "bv_username", $_POST['full_name']);
        oci_bind_by_name($statement, "bv_password", $_POST['password']);
        oci_bind_by_name($statement, "bv_phone", $_POST['phone']);
        oci_bind_by_name($statement, "bv_address", $_POST['address']);

//        $statement = oci_parse($conn, 'select * from "User"');

        if (oci_execute($statement)) {
            echo "<h1>register success.</h1>";
        } else {
            $e = oci_error();
            echo htmlentities($e['message']);
        }

        ?>


    <?php } ?>

</div><!-- <div class="col-md-4">-->

<div class="col-md-4"></div>
</div>


</body>

<script src="dist/js/bootstrap.min.js"></script>
</html>


<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-5
 * Time: 下午5:31
 */

?>