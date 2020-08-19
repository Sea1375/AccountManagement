<?php

    include_once("../../../../../../wp-config.php");
    global $wpdb;

    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_FILES["file"])) {
            $account_id = $_POST['accountId'];
            $available = $_POST['available'] * 1024;

            $uploaded_temp_file = $_FILES["file"]["tmp_name"];
            $target_file_name = basename($account_id . '_' . time() . '_' . $_FILES["file"]["name"]);
            $target_file_size = $_FILES['file']['size'] / 1024;
            
            if($available < $target_file_size) {
                echo "File is too large.";
                exit;
            }
            
            $sql = "INSERT INTO files (FIL_ACCOUNT_ID, FIL_NAME, FIL_SIZE, FIL_LAST_UPLOAD_DATE) 
                VALUES ('$account_id', '$target_file_name', '$target_file_size', CURRENT_TIMESTAMP)";
            
            $wpdb->query($sql);
              
            // get presigned url for aws s3 file upload
            $cURLConnection = curl_init();
            $userId = 'u' . str_pad($account_id, 7 , '0' , STR_PAD_LEFT);
            
            $presigned_request_url = 'https://67qegqceo8.execute-api.us-east-1.amazonaws.com/v1/get-na-presignedurl?user=' . $userId .'&object=' . $target_file_name;
            
            curl_setopt($cURLConnection, CURLOPT_URL, $presigned_request_url);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            $presigned_url = curl_exec($cURLConnection);
            curl_close($cURLConnection);

            $presigned_url = substr($presigned_url, 1, -1);
            
            // upload file to the presigned url
            $file_path = $uploaded_temp_file;

            $p_file = fopen($file_path, "rb");
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($curl, CURLOPT_URL, $presigned_url);
            
            curl_setopt($curl, CURLOPT_PUT, 1);
            curl_setopt($curl, CURLOPT_INFILE, $p_file);
            curl_setopt($curl, CURLOPT_INFILESIZE, filesize($file_path));
            
            $result = curl_exec($curl);
            curl_close($curl);
            echo 'success';
        }
    }
?>
