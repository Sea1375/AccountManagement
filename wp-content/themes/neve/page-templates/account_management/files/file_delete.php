<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST["filId"])) {

            $userId = $_POST['userId'];
            $filId = $_POST['filId'];

            $sql = "SELECT FIL_NAME FROM files WHERE FIL_ID = '" . $filId . "'";
            $target_file_name = $wpdb->get_var($sql);

            $cURLConnection = curl_init();

            // get presigned url for aws s3 file upload
            $cURLConnection = curl_init();
            
            $presigned_request_url = 'https://4x7vfzp6vj.execute-api.us-east-1.amazonaws.com/v1/stage-file?user=' . $userId .'&object=' . $target_file_name;
            echo $presigned_request_url.'<br>';
            curl_setopt($cURLConnection, CURLOPT_URL, $presigned_request_url);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            curl_exec($cURLConnection);
            curl_close($cURLConnection);
            
            $sql = "DELETE FROM files WHERE FIL_ID = '" . $filId . "'";
            $wpdb->query($sql);
            
            echo 'deleted';

        }
    }
?>
