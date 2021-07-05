<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    $username = "hasan";
    $password = "xyz";
    $con=oci_connect($username, $password);
    if (!$con) {
        $m = oci_error();
        trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
    }
?>