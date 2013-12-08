<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-5
 * Time: 下午9:01
 */

?>
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">XX Shop</a>
    </div>
    <div class="navbar-collapse collapse navbar-inverse-collapse menu">
        <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>

            <?php
                if (!isset($_SESSION['userid'])) {
                    echo
                    '<li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>';
                } else {
                    echo
                    '<li><a href="logout.php">Logout</a></li>
                    <li><a href="transaction.php">View Transaction</a></li>';
                }

                if (isset($_SESSION['usertype']))
                    if (strcmp($_SESSION['usertype'], "admin") == 0) {
                        echo
                        '<li><a href="add_product.php">Add Product</a></li>';
                    }
            ?>

        </ul>


    </div><!-- /.nav-collapse -->
</div><!-- /.navbar -->
