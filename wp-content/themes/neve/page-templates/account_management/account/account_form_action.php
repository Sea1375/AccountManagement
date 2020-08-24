<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    $act_accountId = $_POST['accountId'];
    $act_addressCheck = $_POST['addressCheck'];
    $act_noticeSMS = $_POST['noticeSMS'];
    $act_noticeEmail = $_POST['noticeEmail'];

    if(isset($act_addressCheck) && (isset($act_noticeSMS) || isset($act_noticeEmail))) {
        
        $act_notif_sms = isset($act_noticeSMS) ? 'Y' : 'N';
        $act_notif_email = isset($act_noticeEmail) ? 'Y' : 'N';
        
        $act_auto = $_POST['actAuto'];
        $act_pulse_check_freq = $act_auto == 'N' ? $_POST['frequency'] : '';

        $act_first_name = $_POST['firstName'];
        $act_last_name = $_POST['lastName'];
        $act_address_line1 = $_POST['streetLine1'];
        $act_address_line2 = $_POST['streetLine2'];
        $act_city = $_POST['city'];
        $act_state_province = $_POST['stateProvince'];
        $act_postal_code = $_POST['postalCode'];
        $act_country = $_POST['country'];
        //$act_email = $_POST['emailAddress'];
        $act_birth_year = $_POST['birthYear'];
        $act_phone = $_POST['mobileNumber'];
        $current_time = date("Y-m-d h:m:s");

        $sql = "SELECT ACT_ID FROM account WHERE ACT_USER_ID = '" . $act_accountId . "'";
        $act_id = $wpdb->get_var($sql);
        $act_wp_login = 's' . str_pad($act_id, 6 , '0' , STR_PAD_LEFT);

        $act_trail_code = $act_accountId . ' ' . $act_first_name  . ' ' . $act_last_name  . ' ' . $act_address_line1  . ' ' . $act_address_line2  . ' ' . $act_city  . ' ' .
            $act_state_province . ' ' . $act_postal_code  . ' ' . $act_country  . ' ' . $act_birth_year  . ' ' . $act_phone  . ' ' . $act_notif_sms  . ' ' .
            $act_notif_email . ' ' . $act_pulse_check_freq  . ' ' . $act_pulse_check_freq  . ' ' . $act_auto  . ' ' . $current_time;

        $sql = "UPDATE ACCOUNT SET ACT_FIRST_NAME = '" . $act_first_name . "', 
            ACT_LAST_NAME = '" . $act_last_name . "', 
            ACT_ADDRESS_LINE1 = '" . $act_address_line1 . "', 
            ACT_ADDRESS_LINE2 = '" . $act_address_line2 . "', 
            ACT_CITY = '" . $act_city . "', 
            ACT_STATE_PROVINCE = '" . $act_state_province . "', 
            ACT_POSTAL_CODE = '" . $act_postal_code . "', 
            ACT_COUNTRY = '" . $act_country . "', 
            ACT_BIRTH_YEAR = '" . $act_birth_year . "',
            ACT_PHONE = '" . $act_phone . "', 
            ACT_NOTIF_SMS = '" . $act_notif_sms . "', 
            ACT_NOTIF_EMAIL = '" . $act_notif_email . "', 
            ACT_PULSE_CHECK_FREQ = '" . $act_pulse_check_freq . "', 
            ACT_AUTO_PULSE_CHECK = '" . $act_auto . "',
            ACT_WP_LOGIN = '" . $act_wp_login . "',
            ACT_TRAIL_CODE = '" . $act_trail_code . "',
            ACT_LAST_UPDATE = '" . $current_time . "' WHERE ACT_USER_ID = '" . $act_accountId . "'";

        $wpdb->query($sql); 
        echo "Successful";
        
    } else {
        echo "Error";
    }
?>
