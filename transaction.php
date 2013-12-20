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

    <?php
        $connection = Database::dbConnect();
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
                    <div class="col-md-4">
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
                    </div><!-- <div class="col-md-4">-->
SUCC_INSERT;
            }
//            } else {
//                $e = oci_error($statement);
//                echo $e['message'];
//            }

        } else {                    // only request to view transaction

            // if admin change transaction status
            if (isset($_POST['tid']) && strcmp($_POST['x_tid'], "1") == 0) {
                $statement = oci_parse($connection, "update TRANSACTION set status = 'Payment Received' where id = '{$_POST['tid']}'");
                oci_execute($statement);
            }

            $query_string = <<<QUERY_STR
                    select u.ID as userid, u.ADDRESS as address, u.PHONE as phone, u.USERNAME as fullname,
                            p.type as type, p.imageurl, p.name, p.price, p.description,
                            t.id, t.quantity as quantity, t.status
                            from transaction t inner join "User" u
                            on t.userid = u.id inner join product p
                            on t.productid = p.id
QUERY_STR;



            if (strcmp($_SESSION['usertype'], "admin") != 0) {
                // administration view all transaction.
                // normal user view themselves.
                $query_string .= " where u.id = '{$_SESSION['userid']}'";
            }

            $statement = oci_parse($connection, $query_string);

            if (oci_execute($statement)) {

                // show change status button if it is admin
                $status_button = "";
                if (strcmp($_SESSION['usertype'], "admin") == 0)
                    $status_button = "<br><button type='submit' name='x_tid' value='1' class='btn-primary form-control'>This Transaction Payment Received</button>";



                echo '<div class="row"></div>';
                echo <<<TABLE_H

                    <table class="table table-hover" >
                            <thead>
                            </thead>
                            <tbody>
TABLE_H;
                while ($transaction = oci_fetch_assoc($statement)) {

                    $amount = $transaction['QUANTITY'] * $transaction['PRICE'];
                    $transaction['ID'] = strtoupper(bin2hex($transaction['ID']));

                    // show delivery message if it is admin
                    $delivery_msg = "";
                    if (strcmp($_SESSION['usertype'], "admin") == 0) {
                        $delivery_msg = <<<DELIVERY
                            <br/>
                            <div><font size="4px"><strong>Delivery Information</strong><br></font></div>
                            <div><strong>Full name: </strong><br/>{$transaction['FULLNAME']}</div>
                            <div><strong>Contact Phone: </strong><br/>{$transaction['PHONE']}</div>
                            <div><strong>Delivery Address: </strong><br/>{$transaction['ADDRESS']}</div>
                            <div><strong>Quantity: </strong><br/>{$transaction['QUANTITY']}</div>
                            <div><strong>Total Amount: </strong><br/>\${$amount}</div>
DELIVERY;
                    }

                    echo <<<TRANSACTION
                        <tr>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="tid" value="{$transaction['ID']}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <br/>
                                            <img src="upload/{$transaction['IMAGEURL']}" class="img-thumbnail" style="max-height:200px; max-width:200px;"/>
                                        </div>
                                        <div class="col-md-4">
                                            <br/>
                                            <div><font size="4px"><strong>Product Information</strong><br></font></div>
                                            <div><strong>Product Name: </strong><br/>{$transaction['NAME']}</div>
                                            <div><strong>Product Price: </strong><br/>\${$transaction['PRICE']}</div>
                                            <div><strong>Product Type: </strong><br/>{$transaction['TYPE']}</div>
                                            <div><strong>Product Description: </strong><br/>{$transaction['DESCRIPTION']}</div>
                                            <div><strong>Quantity: </strong><br/>{$transaction['QUANTITY']}</div>
                                            <div><strong>Total Amount: </strong><br/>\${$amount}</div>
                                            <br>
                                            <div><font size="4px"><strong>Payment Status</strong><br></font></div>
                                            <div>{$transaction['STATUS']}</div>
                                        </div>
                                        <div class="col-md-5">
                                            {$delivery_msg}
                                            <div>{$status_button}</div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
TRANSACTION;

                }

                echo "</tbody></table>";

            } else {

                echo oci_error($statement)['message'];
            }

        }
    ?>

<?php
include_once('footer.php');
?>