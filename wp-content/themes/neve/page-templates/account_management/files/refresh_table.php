<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $account_id = $_POST['accountId'];
    
    $sql = "SELECT FIL_ID, FIL_NAME, FIL_SIZE, FIL_LAST_UPLOAD_DATE FROM files WHERE FIL_ACCOUNT_ID = '" . $account_id . "'";
    $results = $wpdb->get_results($sql);

    if( count($results) ) {
        $table_html = "<tr><th>File Name</th><th>Last Upload Date</th><th>Size(KB)</th></tr>";
    }

    $fil_ids = array();
    foreach($results as $result) {
        array_push($fil_ids, $result->FIL_ID);

        $subname = explode ("_", $result->FIL_NAME)[2];  

        $table_html = $table_html . '<tr onclick="row_click(this)"><td>' . $subname . '</td>';
        $table_html = $table_html . '<td>' . $result->FIL_LAST_UPLOAD_DATE . '</td>';
        $table_html = $table_html . '<td>' . $result->FIL_SIZE . '</td></tr>';
    }
    
    $sql = "SELECT ACT_PLAN FROM account WHERE ACT_ID = '" . $account_id . "'";
    $plan_code = $wpdb->get_var($sql);

    $sql = "SELECT PLN_MAX_STORAGE FROM plan WHERE PLN_CODE = '" . $plan_code . "'";
    $capacity = round($wpdb->get_var($sql) / 1024, 3);

    $sql = "SELECT FIL_SIZE FROM files WHERE FIL_ACCOUNT_ID = '" . $account_id . "'";
    $results = $wpdb->get_results($sql);

    $used = 0;
    foreach($results as $result) {
        $used = $used + $result->FIL_SIZE;
    }
    $used = round($used / 1024, 3);
    $available = round($capacity - $used, 3);

    $result = array(
        'ids' => $fil_ids,
        'tableContent' => $table_html,
        'capacity' => $capacity,
        'used' => $used,
        'available' => $available,
    );
    //print_r($result);
    echo json_encode($result, JSON_FORCE_OBJECT);
?>