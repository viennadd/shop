

<?php
include_once('header.php');
?>


<div class="container">

    <script>
        function typeChange() {
            document.getElementById("typeChange").submit();
        }
    </script>

    <form method="post" action="index.php" id="typeChange">
        <div class="row">

            <!-- Select Basic -->
            <div class="col-md-9" style="text-align: right;">
                <label class="control-label">Choose one type of Product</label>
            </div>
            <div class="col-md-3">
                <select class="form-control" name="type" onchange="typeChange();">
                    <?php
                    $connection = dbConnect();
                    $statement = oci_parse($connection, "select distinct type from PRODUCT");

                    if (!isset($_POST['type']))
                        echo "<option value='All' selected='selected'>All</option> \n";
                    else
                        echo "<option value='All'>All</option> \n";

                    if (oci_execute($statement)) {
                        while ($type = oci_fetch_assoc($statement)) {
                            if (isset($_POST['type']) &&
                                strcmp($type['TYPE'], $_POST['type']) == 0)
                                echo "<option value='{$type['TYPE']}' selected='selected'>{$type['TYPE']}</option> \n";
                            else
                                echo "<option value='{$type['TYPE']}'>{$type['TYPE']}</option> \n";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>



    <table class="table table-hover" >
        <thead>
        </thead>
        <tbody>
            <?php

            $connection = dbConnect();
            $statement = oci_parse($connection, "select * from PRODUCT");

            if (isset($_POST['type']) && strcmp($_POST['type'], "All") != 0) {
                $statement = oci_parse($connection, "select * from PRODUCT where TYPE = :bv_type");
                oci_bind_by_name($statement, "bv_type", $_POST['type']);
            }

            if (oci_execute($statement)) {

                $buy_button = "";
                if (isset($_SESSION['userid']))
                    $buy_button = <<<BUY

                        </form>
                            <br><br><button class="btn btn-info btn-sm" type="submit" name="buy">Buy This</button>
                        </form>
BUY;

                while ($products = oci_fetch_assoc($statement)) {
                    echo <<<ROW
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="upload\\{$products['IMAGEURL']}" class="img-thumbnail" style="max-height:200px; max-width:200px;"/>
                                        $buy_button
                                    </div>
                                    <div class="col-md-9">
                                            <div><strong>Product Name: </strong><br/>{$products['NAME']}</div>
                                            <div><strong>Product Type: </strong><br/>{$products['TYPE']}</div>
                                            <div><strong>Product Description: </strong><br/>{$products['DESCRIPTION']}</div>
                                            <div><strong>Product Price: </strong><br/>{$products['PRICE']}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
ROW;
                }
            }

            ?>
        </tbody>
    </table>

</div>

<?php
include_once('footer.php');
?>

<?php

/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-5
 * Time: 下午5:21
 */
?>