<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;
    
    $account_id = $_POST['accountId'];
    $ctc_id = $_POST['ctc_id'];
    $sql = "DELETE FROM CONTACT WHERE CTC_ID = " . $ctc_id;
    $wpdb->query($sql);

    $sql = "DELETE FROM SCHEDULE WHERE SCH_ACCOUNT_ID = '" . $account_id . "' AND SCH_CONTACT_ID = '" . $ctc_id . "'";
    $wpdb->query($sql);
?>