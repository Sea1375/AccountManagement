<?php
    include_once("../../../../../../wp-config.php");
    global $wpdb;


    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, "https://staging-jdlandscaping-assets.s3.amazonaws.com/files/09d63d02-beb3-4a7e-8220-440baec268d6_4.jpg");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $result = curl_exec($ch);
    // curl_close($ch);
    

    // header('Content-Description: File Transfer');
    // header('Content-Type: application/octet-stream');
    // header('Content-Disposition: attachment; filename="1.jpg"');
    // header('Expires: 0');
    // header('Cache-Control: must-revalidate');
    // header('Pragma: public');
    // header('Content-Length: ' . filesize($file));
    // echo $result;
    // exit();
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        if(isset($_POST["filId"])) {
           
            $account_id = $_POST['userId'];
            $filId = $_POST['filId'];
            $answer = $_POST['answer'];

            $sql = "SELECT FIL_NAME FROM FILES WHERE FIL_ID = '" . $filId . "'";
           
            $target_file_name = $wpdb->get_var($sql);
            $userId = 's' . str_pad($account_id, 6 , '0' , STR_PAD_LEFT);

            // Keyword file upload
                $filename = explode('.', $target_file_name)[0] . '.o.ntty';

                $nttyfile = fopen($filename, "w") or die("Unable to open file!");
                fwrite($nttyfile, $answer);
                fclose($nttyfile);
                
                $cURLConnection = curl_init();
                $presigned_request_url = 'https://67qegqceo8.execute-api.us-east-1.amazonaws.com/v1/get-na-presignedurl?user=' . $userId .'&object=' . $filename;
                
                curl_setopt($cURLConnection, CURLOPT_URL, $presigned_request_url);
                curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

                $presigned_url = curl_exec($cURLConnection);
                curl_close($cURLConnection);

                $presigned_url = substr($presigned_url, 1, -1);
            
                $file_path = $filename;

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

                //unlink($filename);
               
            //file download
                $cURLConnection = curl_init();
                //$presigned_request_url = 'https://4x7vfzp6vj.execute-api.us-east-1.amazonaws.com/v1/stage-file?user=' . $userId .'&object=' . $target_file_name;
                $presigned_request_url = 'https://4x7vfzp6vj.execute-api.us-east-1.amazonaws.com/v1/check-last-status?activity=fct-stage-file&object=' . $target_file_name. '&user=' . $userId;
                curl_setopt($cURLConnection, CURLOPT_URL, $presigned_request_url);
                curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                echo $presigned_request_url;

                $presigned_url = curl_exec($cURLConnection);
                curl_close($cURLConnection);
                
                $presigned_url = substr($presigned_url, 1, -1);
                echo $presigned_url;
                //'https://staging-jdlandscaping-assets.s3.amazonaws.com/files/09d63d02-beb3-4a7e-8220-440baec268d6_4.jpg'
                echo json_encode(Array('url' => $presigned_url ));
                exit;
        }
    }
    echo 'error';
?>
