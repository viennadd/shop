<?php
include_once('header.php');
if (!isset($_SESSION['usertype']) || strcmp($_SESSION['usertype'], "admin") != 0) {
    echo "<h1>Permission denied.</h1>";
    exit();
}

?>


<div class="col-md-4">

<?php if (!isset($_POST['submit'])) { ?>
    <form method="post" action="add_product.php" enctype="multipart/form-data">
        <fieldset>
            <div id="legend" class="">
                <legend class="">Add Product</legend>
            </div>

            <div class="control-group">

                <!-- Text input-->
                <label class="control-label" for="input01">Product Name</label>
                <div class="controls">
                    <input type="text" placeholder="Product Name" class="form-control" name="name">
                    <p class="help-block">Supporting help text</p>
                </div>
            </div>

            <div class="control-group">

                <!-- Select Basic -->
                <label class="control-label">Product Type</label>
                <div class="controls">
                    <select class="form-control" name="type">
                        <option>Enter</option>
                        <option>Your</option>
                        <option>Options</option>
                        <option>Here!</option></select>
                </div>

            </div>



            <div class="control-group">

                <!-- Prepended text-->
                <label class="control-label">Price</label>
                <div class="controls">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input class="form-control" placeholder="Price" id="prependedInput" type="number" name="price">
                    </div>
                    <p class="help-block">Supporting help text</p>
                </div>

            </div>

            <div class="control-group">
    <!--            <label class="control-label">File Button</label>-->

                <!-- File Upload -->
                <div class="controls">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                        <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="image"></span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>
            </div><div class="control-group">

                <!-- Textarea -->
                <label class="control-label">Description</label>
                <div class="controls">
                    <div class="textarea">
                        <textarea type="" class="form-control" name="description"> </textarea>
                    </div>
                </div>
            </div><div class="control-group">
                <label class="control-label"></label>

                <!-- Button -->
                <div class="controls">
                    <button class="btn btn-primary" name="submit" type="submit">Add This One</button>
                </div>
            </div>

        </fieldset>
    </form>

<?php } else {

    $connection = dbConnect();


    $hash_image = md5_file($_FILES["image"]["tmp_name"]);
    if (!file_exists("upload/" . $hash_image))
    {
        move_uploaded_file($_FILES["image"]["tmp_name"],
            "upload/" . $hash_image);
        // echo "Stored in: " . "upload/" . md5_file($_FILES["image"]["tmp_name"]);
    }

    $statement = oci_parse($connection, 'insert into "PRODUCT" ("NAME", "TYPE", description, price, imageUrl) '.
                                        "values (:bv_name, :bv_type, :bv_description, :bv_price, :bv_imageUrl)");
    oci_bind_by_name($statement, "bv_name", $_POST['name']);
    oci_bind_by_name($statement, "bv_type", $_POST['type']);
    oci_bind_by_name($statement, "bv_price", $_POST['price']);
    oci_bind_by_name($statement, "bv_description", $_POST['description']);
    oci_bind_by_name($statement, "bv_imageUrl", $hash_image);

    if (oci_execute($statement)) {
        echo "<h1>Product Added.</h1>";
    } else {
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
 * Date: 13-12-7
 * Time: 下午9:28
 */
include_once('footer.php');
?>
