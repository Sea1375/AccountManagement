<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $account_id = $_POST['accountId'];
    $sql = "SELECT SCH_ID, SCH_FILE_ID, SCH_CONTACT_ID, SCH_TYPE, SCH_SCHEDULE_DATE, SCH_NB_DAYS, SCH_MESSAGE FROM schedule WHERE SCH_ACCOUNT_ID = '" . $account_id . "'";
    $results = $wpdb->get_results($sql);

    $table_html = "<tr><th>File Name</th><th>Recipient Name</th><th>Schedule</th></tr>";

    $sch_ids = array();
    foreach($results as $result) {
        array_push($sch_ids, $result->SCH_ID);

        $file_id = $result->SCH_FILE_ID;
        $recipient_id = $result->SCH_CONTACT_ID;
        if($result->SCH_TYPE == 'D') {
            $schedule = $result->SCH_SCHEDULE_DATE;
        } else if($result->SCH_TYPE == 'N') {
            $schedule = $result->SCH_NB_DAYS . ' days after';
        }
        
        $sql = "SELECT FIL_NAME FROM files WHERE FIL_ID = '" . $file_id . "'";
        $file_name = $wpdb->get_var($sql);

        $sql = "SELECT CTC_FIRST_NAME, CTC_LAST_NAME FROM contact WHERE CTC_ID = '" . $recipient_id . "'";
        $result = $wpdb->get_results($sql)[0];
        $recipient_name = $result->CTC_FIRST_NAME . ' ' . $result->CTC_LAST_NAME;

        $table_html = $table_html . '<tr onclick="schedule_click(this)"><td>' . $file_name . '</td><td>' . $recipient_name . '</td><td>' . $schedule . '</td></tr>';
    }
    $result = array(
        'ids' => $sch_ids,
        'tableContent' => $table_html,
    );
    echo json_encode($result, JSON_FORCE_OBJECT);
?>
