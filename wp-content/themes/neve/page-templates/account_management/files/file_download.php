<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_FILES["file"])) {
            //$target_dir = 'e:/temp_uploads';
            $uploaded_temp_file = $_FILES["file"]["tmp_name"];
            $target_file_name = basename($_FILES["file"]["name"]);
            $target_file = $target_dir. '/' . $target_file_name;
            // move_uploaded_file($uploaded_temp_file, $target_file);

            // get presigned url for aws s3 file upload
            $cURLConnection = curl_init();
            $userId = 'u8737';
            $presigned_request_url = 'https://67qegqceo8.execute-api.us-east-1.amazonaws.com/v1/get-na-presignedurl?user=' . $userId .'&object=' . $target_file_name;
            echo $presigned_request_url.'<br>';
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

            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");


            echo $result;

            echo 'result: '.$result. ';';
        }
    }
?>
