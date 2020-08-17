<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $account_id = $_POST['accountId'];

    $sql = "SELECT FIL_ID, FIL_NAME FROM files WHERE FIL_ACCOUNT_ID = '" . $account_id . "'";
    $results = $wpdb->get_results($sql);
    
    $fil_ids = array();
    foreach($results as $result) {
        array_push($fil_ids, $result->FIL_ID);
        $filename = $filename . '<tr onclick="filename_click(this)"><td>' . $result->FIL_NAME . '</td></tr>';
    }
    
    $sql = "SELECT CTC_ID, CTC_FIRST_NAME, CTC_LAST_NAME FROM contact WHERE CTC_ACCOUNT_ID = '" . $account_id . "'";
    $results = $wpdb->get_results($sql);

    $ctc_ids = array();
    foreach($results as $result) {
        array_push($ctc_ids, $result->CTC_ID);
        $recipient = $recipient . '<tr onclick="recipient_click(this)"><td>' . $result->CTC_FIRST_NAME . ' ' . $result->CTC_LAST_NAME . '</td></tr>';
    }

    $result = array(
        'fil_ids' => $fil_ids,
        'ctc_ids' => $ctc_ids,
        'filename' => $filename,
        'recipient' => $recipient,
    );
    echo json_encode($result, JSON_FORCE_OBJECT);
?>