<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;
    $account_id=$_POST['accountId'];
    $contact_id=$_POST['contactId'];
    $confirm = $_POST['actAuto'];
    $date=$_POST['date'];
    $sql = "INSERT INTO confirm (CNF_ACCOUNT_ID, CNF_CONTACT_ID, CNF_ANSWER, CNF_CONF_DATE) 
                VALUES ('$account_id', '$contact_id', '$confirm',  '$date')";
    $wpdb->query($sql);
?>
