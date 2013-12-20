
<?php
include_once('header.php');
if (isset($_SESSION['usertype'])) {
    echo "<h1>You are already login.</h1>";
    exit();
}
?>

<div class="col-md-4">

<?php if (strcmp(getUserStatus(), "visitor") == 0 && !isset($_POST['submit'])) { ?>

    <form action="login.php" method="post">
        <fieldset>
            <div id="legend" class="">
                <legend class="">Login</legend>
            </div>
            <div class="control-group">

                <!-- Text input-->
                <label class="control-label" for="input01">User ID</label>
                <div class="controls">
                    <input type="text" placeholder="User ID" class="form-control" name="userid" required="">
                    <p class="label label-warning"></p>
                </div>
            </div>

            <div class="control-group">

                <!-- Text input-->
                <label class="control-label" for="input01">Password</label>
                <div class="controls">
                    <input type="password" placeholder="Password" class="form-control" name="password" required="">
                    <p class="label label-warning"></p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"></label>

                <!-- Button -->
                <div class="controls">
                    <button class="btn btn-primary" type="submit" name="submit">Login</button>
                </div>
            </div>

        </fieldset>
    </form>

<?php } if (strcmp(getUserStatus(), "visitor") != 0) {
        echo "<h1>You are logged in.</h1>";

      } else if (isset($_POST['submit'])) {

        userLogin($_POST['userid'], $_POST['password']);

    ?>


<?php }?>

</div><!-- <div class="col-md-4">-->

<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-7
 * Time: 下午12:07
 */
include_once('footer.php');
?>