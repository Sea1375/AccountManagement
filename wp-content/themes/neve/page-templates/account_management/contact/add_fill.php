<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $ctc_id = $_POST['ctc_id'];
    $sql = "SELECT CTC_FIRST_NAME, CTC_LAST_NAME, CTC_EMAIL, CTC_PHONE, CTC_COUNTRY, CTC_TYPE, CTC_PASSWORD, CTC_MESSAGE FROM CONTACT WHERE CTC_ID = '" . $ctc_id . "'";
    $results = $wpdb->get_results($sql);
    echo json_encode($results[0], JSON_FORCE_OBJECT);
?>