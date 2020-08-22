<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $ctc_first_name = $_POST['firstName'];
    $ctc_last_name = $_POST['lastName'];
    $ctc_email = $_POST['emailAddress'];
    $ctc_phone = $_POST['mobileNumber'];
    $ctc_country = $_POST['country'];
    $ctc_type = $_POST['typeOfContact'];
    $ctc_userid = $_POST['userID'];
    $ctc_password = $_POST['password'];
    $ctc_message = $_POST['message'];
    $ctc_account_id = $_POST['accountId'];
    $ctc_wp_user_id = get_current_user_id();
    
    $sql = "SELECT CTC_ID FROM CONTACT WHERE CTC_ACCOUNT_ID = '" . $ctc_account_id . "'AND CTC_EMAIL = '" . $ctc_email. "'";
    $result = $wpdb->get_var($sql);
    
    if($result != null) {
        $current_time = date("Y-m-d h:m:s");
        $sql = "UPDATE contact SET CTC_FIRST_NAME = '" . $ctc_first_name . "', 
            CTC_LAST_NAME = '" . $ctc_last_name . "', 
            CTC_EMAIL = '" . $ctc_email . "', 
            CTC_COUNTRY = '" . $ctc_country . "', 
            CTC_TYPE = '" . $ctc_type . "', 
            CTC_PASSWORD = '" . $ctc_password . "', 
            CTC_MESSAGE = '" . $ctc_message . "', 
            CTC_ACCOUNT_ID = '" . $ctc_account_id . "', 
            CTC_WP_USER_ALIAS = '" . $ctc_userid . "', 
            CTC_LAST_UPDATE = '" . $current_time . "' WHERE CTC_ID = '" . $result . "'";
        $wpdb->query($sql);
        echo "updated"; 
    } else {
        $sql = "INSERT INTO contact (CTC_FIRST_NAME, CTC_LAST_NAME, CTC_EMAIL, CTC_COUNTRY, CTC_TYPE, CTC_PASSWORD, CTC_MESSAGE, CTC_ACCOUNT_ID, CTC_WP_USER_ALIAS, CTC_CREATION_DATE) 
                VALUES ('$ctc_first_name', '$ctc_last_name', '$ctc_email', '$ctc_country', '$ctc_type', '$ctc_password', '$ctc_message', '$ctc_account_id', '$ctc_userid', CURRENT_TIMESTAMP)";
        $wpdb->query($sql);
        echo "inserted";
    }

?>
