<?php
/**
 * Created by PhpStorm.
 * User: vienna
 * Date: 13-12-7
 * Time: 下午5:38
 */

include_once('header.php');

unset($_SESSION['userid']);
unset($_SESSION['password']);
unset($_SESSION['usertype']);

header("Location: index.php");