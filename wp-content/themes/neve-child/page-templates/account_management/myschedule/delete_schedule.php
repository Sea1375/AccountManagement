<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;
    
    $schedule_id = $_POST['schedule_id'];
    
    $sql = "DELETE FROM SCHEDULE WHERE SCH_ID = '" . $schedule_id . "'";
    $wpdb->query($sql);
    
    echo 'success';
?>