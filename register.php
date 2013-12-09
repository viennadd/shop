

<?php
include_once('header.php');
if (isset($_SESSION['usertype'])) {
    echo "<h1>You need Logout first.</h1>";
    exit();
}
?>


<div class="col-md-4">

    <?php if (!isset($_POST['submit'])) { ?>

        <form method="post" action="register.php">
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
        include_once('database.php');

        $conn = dbConnect();
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
            $e = oci_error();
            echo htmlentities($e['message']);
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