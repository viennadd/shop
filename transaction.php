<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-8
 * Time: 下午11:23
 */
include_once('header.php');
if (!isset($_SESSION['usertype'])) {
    echo "<h1>Permission denied.</h1>";
    exit();
}
?>



<div class="col-md-4">

    <?php
        $connection = dbConnect();
        if (isset($_POST['buy'])) { // user request to buy product, show transaction submitted status
            echo "<h4>Your order is waiting for payment.</h4>";

            $statement = oci_parse($connection, 'insert into "TRANSACTION" ("USERID", "PRODUCTID", "QUANTITY") '.
                                                'values (:bv_userid, :bv_productid, :bv_quantity)');
            oci_bind_by_name($statement, "bv_userid", $_SESSION['userid']);
            oci_bind_by_name($statement, "bv_productid", $_POST['buy']);
            oci_bind_by_name($statement, "bv_quantity", $_POST['quantity']);

            if (oci_execute($statement)) {
                $amount = $_POST['quantity'] * $_POST['price'];
                echo <<<SUCC_INSERT
                    <div class="row">
                        <div class="col-md-7">
                            <br/>
                            <img src="upload/{$_POST['image']}" class="img-thumbnail" style="max-height:200px; max-width:200px;"/>
                        </div>
                        <div class="col-md-5">
                            <br/>
                            <div><strong>Product Name: </strong><br/>{$_POST['product_name']}</div>
                            <div><strong>Quantity: </strong><br/>{$_POST['quantity']}</div>
                            <div><strong>Product Price: </strong><br/>\${$_POST['price']}</div>
                            <div><strong>Total Amount: </strong><br/>\${$amount}</div>
                        </div>
                    </div>
SUCC_INSERT;
            }
//            } else {
//                $e = oci_error($statement);
//                echo $e['message'];
//            }

        } else {                    // only request to view transaction

            if (strcmp($_SESSION['usertype'], "admin") == 0) {  // administration view all transaction.

            } else {                                            // normal user view themselves.

            }
        }
    ?>

</div><!-- <div class="col-md-4">-->

<?php
include_once('footer.php');
?>