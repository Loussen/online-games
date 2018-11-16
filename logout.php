<?php
/**
 * Created by PhpStorm.
 * User: fhasanli
 * Date: 11/5/2018
 * Time: 11:26 AM
 */

ob_start(); session_start();
include_once 'includes/functions.php';
//sec_session_start();

// Unset all session values
$_SESSION = array();

// get session parameters
$params = session_get_cookie_params();

// Delete the actual cookie.
setcookie(session_name(),
    '', time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]);

// Destroy session
session_destroy();
header('Location: '.$_SERVER['HTTP_REFERER']);