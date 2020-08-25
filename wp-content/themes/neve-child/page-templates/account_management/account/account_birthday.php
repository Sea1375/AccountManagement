<?php
    include_once("../../../../../../wp-config.php");

    $selectedCountry = $_POST['country'];
    $sql = "SELECT CTR_AGE_MIN FROM COUNTRY WHERE CTR_DESC = '" . $selectedCountry . "'";

    $result = date('Y') - $wpdb->get_var($sql);
    echo $result;
    
?>