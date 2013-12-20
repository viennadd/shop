<?php
include_once('header.php');
if (!isset($_SESSION['usertype']) || strcmp($_SESSION['usertype'], "admin") != 0) {
    echo "<h1>Permission denied.</h1>";
    exit();
}

?>


<div class="col-md-4">

<?php if (!isset($_POST['submit'])) { ?>
    <form method="post" action="add_product.php" enctype="multipart/form-data" onsubmit="return positivePrice();">
        <fieldset>
            <div id="legend" class="">
                <legend class="">Add Product</legend>
            </div>

            <div class="control-group">

                <!-- Text input-->
                <label class="control-label" for="input01">Product Name</label>
                <div class="controls">
                    <input type="text" id="product_name" placeholder="Product Name" class="form-control" name="name">
                    <p class="label label-warning"></p>
                </div>
            </div>

            <div class="control-group">

                <!-- Select Basic -->
                <label class="control-label">Product Type</label>
                <div class="controls">
                    <select class="form-control" name="type">
                        <option>Monitor</option>
                        <option>Mouse</option>
                        <option>Keyboard</option>
                        <option>SSD</option>
                        <option>Memory</option>
                    </select>
                </div>

            </div>



            <div class="control-group">

                <!-- Prepended text-->
                <label class="control-label">Price</label>
                <div class="controls">
                    <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input class="form-control" placeholder="Price" id="price" type="number" name="price" required="">
                    </div>
                    <p class="label label-warning"></p>
                </div>

            </div>

            <div class="control-group">
    <!--            <label class="control-label">File Button</label>-->

                <!-- File Upload -->
                <div class="controls">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                        <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" id="imagefile" required="" name="image"></span>
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

    $connection = Database::dbConnect();

    if (!is_image($_FILES["image"]["tmp_name"])) {
        echo "<h1>Product Image need a image file.</h1>";
        exit();
    }

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

<script>
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function positivePrice() {
        if (!isNumber($("#price").val())) {
            alert("Product Price Need input a number.");
            return false;
        }

        $("#price").val(eval(price.value));
        if (price.value <= 0) {
            alert("Positive Product price needed.");
            return false;

        }

        return true;
    }
</script>
