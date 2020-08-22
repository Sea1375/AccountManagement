<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_FILES["file"])) {
            $account_id = $_POST['accountId'];
            $available = $_POST['available'] * 1024;
            $question = $_POST['question'];
            $answer = $_POST['answer'];

            $uploaded_temp_file = $_FILES["file"]["tmp_name"];
           
            $target_file_name = basename($account_id . '_' . time() . '_' . $_FILES["file"]["name"]);
            $target_file_size = $_FILES['file']['size'] / 1024;
            
            if($available < $target_file_size || $target_file_size > FILE_SIZE) {
                echo "File is too large.";
                exit;
            }
            
            $ext = explode('.', $_FILES["file"]["name"])[1];
            $extUpper = strtoupper($ext);
            $extLower = strtolower($ext);

            $sql = "SELECT EXT_CODE FROM EXTENSION WHERE EXT_CODE = '" . $extUpper . "' OR EXT_CODE = '" . $extLower . "'";

            echo $wpdb->get_var($sql);

            if($wpdb->get_var($sql) == null) {
                echo "This file extention is not supported.";
                exit;
            }
            $current_time = date("Y-m-d h:m:s");
            $fil_trail_code = $account_id . ' ' .  $target_file_name . ' ' . $target_file_size . ' ' . $account_id;
            $sql = "INSERT INTO files (FIL_ACCOUNT_ID, FIL_NAME, FIL_SIZE, FIL_LAST_UPLOAD_DATE, FIL_QUESTION, FIL_TRAIL_CODE)
                VALUES ('$account_id', '$target_file_name', '$target_file_size', '$current_time' , '$question', '$fil_trail_code')";
            $wpdb->query($sql);


            $filename = explode('.', $target_file_name)[0] . '.ntty';
            $nttyfile = fopen($filename, "w") or die("Unable to open file!");
            fwrite($nttyfile, $answer);
            fclose($nttyfile);

            $filename = "1.ntty";
            
            $files = Array($filename, $target_file_name);
            $filePaths = Array($filename, $uploaded_temp_file);

            for ($i = 0; $i < 2; $i++) {

                $cURLConnection = curl_init();
                $userId = 'u' . str_pad($account_id, 6 , '0' , STR_PAD_LEFT);
                $presigned_request_url = 'https://67qegqceo8.execute-api.us-east-1.amazonaws.com/v1/get-na-presignedurl?user=' . $userId .'&object=' . $files[$i];
                
                curl_setopt($cURLConnection, CURLOPT_URL, $presigned_request_url);
                curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

                $presigned_url = curl_exec($cURLConnection);
                curl_close($cURLConnection);

                $presigned_url = substr($presigned_url, 1, -1);
            
                $file_path = $filePaths[$i];

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

                unlink($filename);
            }
        }
    }
?>
