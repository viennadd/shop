
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
<form class="form-horizontal">
    <fieldset>
        <div id="legend" class="">
            <legend class="">Regiater</legend>
        </div>
        <div class="control-group">

            <!-- Text input-->
            <label class="control-label" for="input01">User ID</label>
            <div class="controls">
                <input type="text" placeholder="User ID" class="form-control">
                <span class="help-block">Supporting help text</span>
            </div>
        </div>



        <div class="control-group">

            <!-- Text input-->
            <label class="control-label" for="input01">Password</label>
            <div class="controls">
                <input type="text" placeholder="Password" class="form-control">
                <p class="help-block">Supporting help text</p>
            </div>
        </div>

        <div class="control-group">

            <!-- Text input-->
            <label class="control-label" for="input01">Password (Repeat)</label>
            <div class="controls">
                <input type="text" placeholder="Password" class="form-control">
                <p class="help-block">Supporting help text</p>
            </div>
        </div>

        <div class="control-group">

            <!-- Text input-->
            <label class="control-label" for="input01">Full name</label>
            <div class="controls">
                <input type="text" placeholder="Full name" class="form-control">
                <p class="help-block">Supporting help text</p>
            </div>
        </div>

        <div class="control-group">

            <!-- Text input-->
            <label class="control-label" for="input01">Contact phone</label>
            <div class="controls">
                <input type="text" placeholder="Contact phone" class="form-control">
                <p class="help-block">Supporting help text</p>
            </div>
        </div>



        <div class="control-group">

            <!-- Textarea -->
            <label class="control-label">Address</label>
            <div class="controls">
                <div class="textarea">
                    <textarea type="" class="form-control"> </textarea>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"></label>

            <!-- Button -->
            <div class="controls">
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>

    </fieldset>
</form>

</div><!--    <div class="col-md-4">-->
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