<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;
    
    $account_id = $_POST['account_id'];
    $fil_id = $_POST['fil_id'];
    $ctc_id = $_POST['ctc_id'];
    $selection = $_POST['selection'];
    
    if($selection == 'D') {
        $specific = $_POST['specific'];
        $after = '';
    } else {
        $specific = '';
        $after = $_POST['after'];
    }

    $message = $_POST['message'];
    $addOrUpdate = $_POST['addOrUpdate'];

    $sch_trail_code =$account_id . ' ' . $fil_id . ' ' . $ctc_id . ' ' . $selection . ' ' . $specific . ' ' . $after . ' ' . $message;
    if($addOrUpdate == 'add') {

        $sql = "INSERT INTO schedule (SCH_ACCOUNT_ID, SCH_FILE_ID, SCH_CONTACT_ID, SCH_TYPE, SCH_SCHEDULE_DATE, SCH_NB_DAYS, SCH_MESSAGE, SCH_TRAIL_CODE)
            VALUES ('$account_id', '$fil_id', '$ctc_id', '$selection', '$specific', '$after', '$message', '$sch_trail_code')";
    } else {
        $sql = "UPDATE schedule SET SCH_FILE_ID = '" . $fil_id . "', SCH_CONTACT_ID = '" . $ctc_id . "', SCH_TYPE = '" . $selection . "', SCH_SCHEDULE_DATE = '" . $specific . "', SCH_NB_DAYS = '" . $after . "', SCH_MESSAGE = '" . $message . "', SCH_TRAIL_CODE = '" . $sch_trail_code . "'  WHERE SCH_ID = '" . $addOrUpdate . "'";
    }
    $wpdb->query($sql);
    
    echo 'success';
?>
