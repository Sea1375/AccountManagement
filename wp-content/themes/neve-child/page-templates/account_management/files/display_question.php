<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $filId = $_POST['filId'];
    $sql = "SELECT FIL_QUESTION FROM FILES WHERE FIL_ID = '" . $filId . "'";
    $result = $wpdb->get_var($sql);
    echo $result;
?>