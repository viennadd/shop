<?php
include_once('header.php');
?>

<div class="container">
    <form method="post" action="index.php" id="typeChange">
        <div class="row">
            <!-- Select Basic -->
            <div class="col-md-12">

                <label class="control-label" for="type">Choose one type of Product
                   <select class="form-control form-horizontal" name="type" onchange="typeChange();" id="type">
                        <?php
                        $connection = Database::dbConnect();
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
                </label>
            </div>
        </div>


        <div class="row">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-btn">
                        <input type="hidden" name="order" value="ID" id="order_val">
                        <button id="order" type="button" onmouseover="$('.dropdown-toggle').dropdown()" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Sort By <?php echo isset($_POST['order']) ? $_POST['order'] : 'ID';?><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a onclick='$("#order")[0].innerHTML = "Sort By ID<span class=\"caret\">"; $("#order_val").val("ID")'>Sort By ID</a></li>
                            <li><a onclick='$("#order")[0].innerHTML = "Sort By PRICE<span class=\"caret\">"; $("#order_val").val("PRICE")'>Sort By Price</a></li>
                            <li><a onclick='$("#order")[0].innerHTML = "Sort By NAME<span class=\"caret\">"; $("#order_val").val("NAME")'>Sort By Name</a></li>
                        </ul>
                        <!-- Button and dropdown menu -->
                    </span>
                    <input type="search" placeholder="Keywords" name="keyword" class="form-control">
                    <span class="input-group-btn">
                        <input type="submit" value="Search" class="btn btn-primary" >
                    </span>
                </div>
            </div>
        </div>


    </form>
</div>

<div class="container">
    <table class="table table-hover" >
        <thead>
        </thead>
        <tbody>
            <?php

            $connection = Database::dbConnect();

            $keyword = isset($_POST['keyword']) ? '%'.$_POST['keyword'].'%' : '%';

            $query_string = 'select * from PRODUCT where "NAME" like :bv_keyword or "DESCRIPTION" like :bv_keyword';
            $order_string = '';
            $type_string = '';

            if (isset($_POST['order']))
                $order_string = ' ORDER BY '.$_POST['order'];



            if (isset($_POST['type']) && strcmp($_POST['type'], "All") != 0) {
                // echo $query_string.' and TYPE = :bv_type'.$order_string;
                $statement = oci_parse($connection, $query_string.' and TYPE = :bv_type'.$order_string);
                oci_bind_by_name($statement, "bv_type", $_POST['type']);
            } else {
                // echo $query_string.$order_string;
                $statement = oci_parse($connection, $query_string.$order_string);
            }

            oci_bind_by_name($statement, "bv_keyword", $keyword);

            if (oci_execute($statement)) {

                while ($products = oci_fetch_assoc($statement)) {

                    $products['ID'] = strtoupper(bin2hex($products['ID']));
                    $buy_button = "";
                    if (isset($_SESSION['userid'])) {
                        $buy_button = <<<BUY
                            <br><br>
                            <button class="btn btn-info btn-sm" type="button" onclick="setProductData(this.value)" name="buy" value="{$products['ID']}" data-toggle="modal" data-target="#myModal">
                                Buy This
                            </button>
BUY;
                    }

                    echo <<<ROW
                        <tr>
                            <td>
                                <div class="row" id="{$products['ID']}">
                                    <div class="col-md-3">
                                        <br/>
                                        <img src="upload/{$products['IMAGEURL']}" class="img-thumbnail" style="max-height:200px; max-width:200px;"/>
                                        $buy_button
                                    </div>
                                    <div class="col-md-9">
                                        <br/>
                                        <div><strong>Product Name: </strong><br/>{$products['NAME']}</div>
                                        <div><strong>Product Type: </strong><br/>{$products['TYPE']}</div>
                                        <div><strong>Product Description: </strong><br/>{$products['DESCRIPTION']}</div>
                                        <div><strong>Product Price: </strong><br/>\${$products['PRICE']}</div>

                                        <input type="hidden" value="{$products['PRICE']}" name="price">
                                        <input type="hidden" value="{$products['NAME']}" name="product_name">
                                        <input type="hidden" value="{$products['IMAGEURL']}" name="image">
                                    </div>
                                </div>
                            </td>
                        </tr>
ROW;
                }
            } else {
                echo oci_error($statement)['message'];
            }

            ?>
        </tbody>
    </table>

    <!-- Modal -->
    <form method="post" action="transaction.php">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog"  style="width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Please enter the quantity you want.</h4>
                </div>
                <div class="modal-body">
                    <div class="container" style="width: 600px;" id="product_data">

                    </div>
                </div>
                <div class="modal-footer">

                        Quantity: <input type="number" value="1" id="quantity" name="quantity">
                        <br/><br/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="confirm_buy_button" value="" name="buy">Buy It! </button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </form>

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

<script>
    function typeChange() {
        document.getElementById("typeChange").submit();
    }

    function setProductData(product_id) {
        html = document.getElementById(product_id).innerHTML;

        $("#product_data")[0].innerHTML = html;
        $("#product_data > div > button").remove();
        $("#quantity").val("1");
        $("#confirm_buy_button").val(product_id);
        $("#product_data > div.col-md-3").removeClass("col-md-3").addClass("col-md-5");
        $("#product_data > div.col-md-9").removeClass("col-md-9").addClass("col-md-7");
    }

    function confirmBuy() {

    }
</script>