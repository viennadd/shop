

<?php
include_once('header.php');
if (isset($_SESSION['usertype'])) {
    echo "<h1>You need Logout first.</h1>";
    exit();
}
?>


<div class="col-md-4">

    <?php if (!isset($_POST['submit'])) { ?>

        <form method="post" action="register.php" id="regForm" onsubmit="return checkFields()">
            <fieldset>
                <div id="legend" class="">
                    <legend class="">Regiater</legend>
                </div>
                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">User ID</label>
                    <div class="controls">
                        <input type="text" placeholder="User ID" class="form-control" name="userid" required="">
                        <span class="label label-warning"></span>
                    </div>
                </div>



                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Password</label>
                    <div class="controls">
                        <input type="password" id="password" placeholder="Password" class="form-control" name="password" required="">
                        <p class="label label-warning"></p>
                    </div>
                </div>

                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Password (Repeat)</label>
                    <div class="controls">
                        <input type="password" id="password2" placeholder="Password" class="form-control" name="password_repeat" required="">
                        <p class="label label-warning"></p>
                    </div>
                </div>

                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Full name</label>
                    <div class="controls">
                        <input type="text" placeholder="Full name" class="form-control" name="full_name" required="">
                        <p class="label label-warning"></p>
                    </div>
                </div>

                <div class="control-group">

                    <!-- Text input-->
                    <label class="control-label" for="input01">Contact phone</label>
                    <div class="controls">
                        <input type="text" placeholder="Contact phone" class="form-control" name="phone">
                        <p class="label label-warning"></p>
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
        include_once('database.php');

        $conn = Database::dbConnect();


        $statement = oci_parse($conn, 'select id from "User" where id = :bv_userid');
        oci_bind_by_name($statement, "bv_userid", $_POST['userid']);

        if (oci_execute($statement)) {
            $nRow = 0;
            while (oci_fetch_assoc($statement))
                $nRow++;

            if ($nRow >= 1) {
                echo("User Id already exist.");
                exit();
            }
        }


        if (strcmp($_POST['password'], $_POST['password_repeat']) != 0) {
            echo("password need repeat exactly.");
            exit();
        }


        $statement = oci_parse($conn, 'insert into "User" (id, username, password, phone, address)'.
                                                     "values (:bv_userid, :bv_username, :bv_password, :bv_phone, :bv_address)");

//        $statement = oci_parse($conn, 'insert into "User" (id, username, password, phone, address, type)'.
//            "values (:bv_userid, :bv_username, :bv_password, :bv_phone, :bv_address, :bv_type)");

        $hash_password = md5($_POST['password'].$salt);

        oci_bind_by_name($statement, "bv_userid", $_POST['userid']);
        oci_bind_by_name($statement, "bv_username", $_POST['full_name']);
        oci_bind_by_name($statement, "bv_password", $hash_password);
        oci_bind_by_name($statement, "bv_phone", $_POST['phone']);
        oci_bind_by_name($statement, "bv_address", $_POST['address']);
//        oci_bind_by_name($statement, "bv_type", $admin = "admin");

        if (oci_execute($statement)) {
            echo "<h1>register success.</h1>";
        } else {
            echo "<h1>register failed.</h1>";
            $e = oci_error($statement);
            echo $e['message'];
        }

        ?>


    <?php } ?>

</div><!-- <div class="col-md-4">-->

<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-5
 * Time: 下午5:31
 */
include_once('footer.php');
?>

<script src="dist/js/jquery.validate.min.js"></script>
<script>

    function checkFields() {
        if ($("#password").val().length < 5) {
            alert("length of password need >= 5 digits.")
            return false;
        }

        if (! ($("#password").val() === $("#password2").val())) {
            alert("Password need repeat twice exactly.")
            return false;
        }



        return true;
    }


</script>