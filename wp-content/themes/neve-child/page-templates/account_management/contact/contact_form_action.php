<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $ctc_first_name = $_POST['firstName'];
    $ctc_last_name = $_POST['lastName'];
    $ctc_email = $_POST['emailAddress'];
    $ctc_phone = $_POST['mobileNumber'];
    $ctc_country = $_POST['country'];
    $ctc_type = $_POST['typeOfContact'];
    $ctc_wp_login = $_POST['userID'];
    $ctc_password = $_POST['password'];
    $ctc_message = $_POST['message'];
    $ctc_account_id = $_POST['accountId'];
    $ctc_wp_user_id = $ctc_type == 'INSIDER' ? get_current_user_id() : '';
    // $ctc_wp_user_alias = 'u' . str_pad($ctc_userid, 7 , '0' , STR_PAD_LEFT);
    $ctc_wp_user_alias = $ctc_wp_login;
    $ctc_trail_code = $ctc_account_id . ' ' .$ctc_first_name . ' ' . $ctc_last_name . ' ' . $ctc_email . ' ' . $ctc_country . ' ' . $ctc_type . ' ' .
        $ctc_password . ' ' . $ctc_message . ' ' . $ctc_account_id . ' ' . $ctc_wp_user_alias . ' ' .$ctc_wp_user_id ;

    $sql = "SELECT CTC_ID FROM CONTACT WHERE CTC_ACCOUNT_ID = '" . $ctc_account_id . "'AND CTC_EMAIL = '" . $ctc_email. "'";
    $result = $wpdb->get_var($sql);

    if($result != null) {
        $current_time = date("Y-m-d h:m:s");
        $ctc_trail_code = $ctc_trail_code . $current_time;

        $sql = "SELECT CTC_ID FROM contact WHERE CTC_ACCOUNT_ID = '" . $ctc_account_id . "'";
        $ctc_id = $wpdb->get_var($sql);

        $sql = "UPDATE contact SET CTC_FIRST_NAME = '" . $ctc_first_name . "',
            CTC_LAST_NAME = '" . $ctc_last_name . "', 
            CTC_EMAIL = '" . $ctc_email . "',
            CTC_PHONE = '" . $ctc_phone . "',
            CTC_COUNTRY = '" . $ctc_country . "', 
            CTC_TYPE = '" . $ctc_type . "',
            CTC_MESSAGE = '" . $ctc_message . "', 
            CTC_ACCOUNT_ID = '" . $ctc_account_id . "', 
            CTC_WP_USER_ALIAS = '" . $ctc_wp_user_alias . "',
            CTC_WP_USER_ID = '" . $ctc_wp_user_id . "',
            CTC_TRAIL_CODE = '" . $ctc_trail_code . "',
            CTC_LAST_UPDATE = '" . $current_time . "' WHERE CTC_ID = '" . $result . "'";
        $wpdb->query($sql);
        echo "updated";
    } else {
        $current_time = date("Y-m-d h:m:s");
        $ctc_trail_code = $ctc_trail_code . ' ' . $current_time;

        $sql = "SELECT MAX(CTC_ID) FROM contact";

        $ctc_id = $wpdb->get_var($sql) + 1;

        $sql = "INSERT INTO contact (CTC_ID, CTC_WP_LOGIN, CTC_FIRST_NAME, CTC_LAST_NAME, CTC_EMAIL, CTC_PHONE, CTC_COUNTRY, CTC_TYPE, CTC_PASSWORD, CTC_MESSAGE, CTC_ACCOUNT_ID, CTC_WP_USER_ALIAS, CTC_CREATION_DATE, CTC_LAST_UPDATE, CTC_TRAIL_CODE)
                VALUES ('$ctc_id','$ctc_wp_login','$ctc_first_name', '$ctc_last_name', '$ctc_email', '$ctc_phone', '$ctc_country', '$ctc_type', '$ctc_password', '$ctc_message', '$ctc_account_id', '$ctc_wp_user_alias', '$current_time', '$current_time', '$ctc_trail_code')";
        $wpdb->query($sql);
        echo "inserted";
    }

?>
