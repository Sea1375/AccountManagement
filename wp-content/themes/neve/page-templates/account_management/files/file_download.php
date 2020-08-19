<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;

    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST["filId"])) {

            $account_id = $_POST['userId'];
            $filId = $_POST['filId'];

            $sql = "SELECT FIL_NAME FROM files WHERE FIL_ID = '" . $filId . "'";
            $target_file_name = $wpdb->get_var($sql);
            
            $cURLConnection = curl_init();
            
            $userId = 'u' . str_pad($account_id, 7 , '0' , STR_PAD_LEFT);
            $presigned_request_url = 'https://4x7vfzp6vj.execute-api.us-east-1.amazonaws.com/v1/stage-file?user=' . $userId .'&object=' . $target_file_name;

            curl_setopt($cURLConnection, CURLOPT_URL, $presigned_request_url);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

            $presigned_url = curl_exec($cURLConnection);
            curl_close($cURLConnection);

            //The resource that we want to download.
            $presigned_url = substr($presigned_url, 1, -1);
            echo $presigned_url;
            
            //The path & filename to save to.
            $saveTo = 'E:' . "\\" . $target_file_name;
            
            //Open file handler.
            $fp = fopen($saveTo, 'w+');
            
            //If $fp is FALSE, something went wrong.
            if($fp === false){
                throw new Exception('Could not open: ' . $saveTo);
            }
            
            //Create a cURL handle.
            $ch = curl_init($presigned_url);
            
            //Pass our file handle to cURL.
            curl_setopt($ch, CURLOPT_FILE, $fp);
            
            //Timeout if the file doesn't download after 20 seconds.
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            
            //Execute the request.
            curl_exec($ch);
            
            //If there was an error, throw an Exception
            if(curl_errno($ch)){
                throw new Exception(curl_error($ch));
            }
            
            //Get the HTTP status code.
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            //Close the cURL handler.
            curl_close($ch);
            
            //Close the file handler.
            fclose($fp);
            
            if($statusCode == 200){
                echo 'Downloaded!';
            } else{
                echo "Status Code: " . $statusCode;
            }
        }
    }
?>
