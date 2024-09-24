<?php

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    require 'assets/plugins/php-jwt-main/src/JWT.php';
    require 'assets/plugins/php-jwt-main/src/Key.php';

   function insert($table, $data) {
        include 'includes/config.php';
        $fields = array_keys( $data );  
        $values = array_map(array($connect, 'real_escape_string'), array_values($data) );
        
        $sql = "INSERT INTO $table (".implode(",",$fields).") VALUES ('".implode("','", $values )."')";
        mysqli_query($connect, $sql);
    }

    function delete($table_name, $where_clause = '') {
        include 'includes/config.php';
        $whereSQL = '';
        if(!empty($where_clause)) {
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                $whereSQL = " WHERE ".$where_clause;
            } else {
                $whereSQL = " ".trim($where_clause);
            }
        }
        $sql = "DELETE FROM ".$table_name.$whereSQL;
        return mysqli_query($connect, $sql);

    }

    // Update Data, Where clause is left optional
    function update($table_name, $form_data, $where_clause = '') {

        include 'includes/config.php';
        // check for optional where clause
        $whereSQL = '';
        if(!empty($where_clause)) {
            // check to see if the 'where' keyword exists
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
                // not found, add key word
                $whereSQL = " WHERE ".$where_clause;
            } else {
                $whereSQL = " ".trim($where_clause);
            }
        }
        // start the actual SQL statement
        $sql = "UPDATE ".$table_name." SET ";

        // loop and build the column /
        $sets = array();
        foreach($form_data as $column => $value) {
             $sets[] = "`".$column."` = '".$value."'";
        }
        $sql .= implode(', ', $sets);

        // append the where statement
        $sql .= $whereSQL;
             
        // run and return the query result
        return mysqli_query($connect, $sql);
    }

    function clean($data) {
        include 'includes/config.php';
        $data = mysqli_real_escape_string($connect, $data);
        return $data; 
    }

    function encrypt($data) {
        $data = base64_encode(base64_encode(base64_encode($data)));
        return $data; 
    }

    function decrypt($data) {
        $data = base64_decode(base64_decode(base64_decode($data)));
        return $data; 
    }

    function FCM($uniqueId, $title, $message, $bigImage, $link, $postId, $fcmServerKey, $fcmNotificationTopic, $redirect) {

        $data = array(
            'to' => '/topics/' . $fcmNotificationTopic,
            'data' => array(
                'title' => $title,
                'message' => $message,
                'big_image' => $bigImage,
                'link' => $link,
                'post_id' => $postId,
                "unique_id"=> $uniqueId
            )
        );

        $header = array(
            'Authorization: key=' . $fcmServerKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }

        curl_close($ch);

        $_SESSION['msg'] = "FCM push notification sent...";
        header($redirect);
        //header('Location:index.php');
        exit; 

    }

    function FCM_V1($uniqueId, $title, $message, $bigImage, $link, $postId, $OAuthKey, $fcmNotificationTopic, $redirect) {

        $projectId = getFirebaseProjectId();
        $url = 'https://fcm.googleapis.com/v1/projects/'.$projectId.'/messages:send';

        $notification = array(
            "message" => array(
                "topic" => $fcmNotificationTopic,
                "notification" => array(
                    "title" => $title,
                    "body" => $message,
                    "image" => $bigImage
                ),
                "data" => array(
                    'title' => $title,
                    'message' => $message,
                    'big_image' => $bigImage,
                    'link' => $link,
                    'post_id' => $postId,
                    'unique_id' => $uniqueId
                ),
                "android" => array(
                    "notification" => array(
                    "click_action" => "OPEN_MAIN_ACTIVITY",
                    )
                )
            )
        );

        $header = array(
            'Authorization: Bearer ' . $OAuthKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }

        curl_close($ch);

        $_SESSION['msg'] = "FCM push notification sent...";
        header($redirect);
        exit; 

    }

    function ONESIGNAL($uniqueId, $title, $message, $bigImage, $link, $postId, $oneSignalAppId, $oneSignalRestApiKey, $redirect) {

        $content = array("en" =>  $message);

        $fields = array(
            'app_id' => $oneSignalAppId,
            'included_segments' => array('All'),                                            
            'data' => array(
                "foo" => "bar",
                "link" => $link,
                "post_id" => $postId,
                "unique_id" => $uniqueId
            ),
            'headings'=> array("en" => $title),
            'contents' => $content,
            'big_picture' => $bigImage         
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '. $oneSignalRestApiKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        $_SESSION['msg'] = "OneSignal push notification sent...";
        header($redirect);
        exit;       

    }

    function getFirebaseOAuthToken() {

        $jsonInfo = json_decode(file_get_contents("service-account.json"), true);

        $now_seconds = time();
        
        $privateKey = $jsonInfo['private_key'];
        
        $payload = [
            'iss' => $jsonInfo['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $jsonInfo['token_uri'],
            //Token to be expired after 1 hour
            'exp' => $now_seconds + (60 * 60),
            'iat' => $now_seconds
        ];
        
        $jwt = JWT::encode($payload, $privateKey, 'RS256');
        
        // create curl resource
        $ch = curl_init();
        
        // set post fields
        $post = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ];
        
        $ch = curl_init($jsonInfo['token_uri']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        
        // execute!
        $response = curl_exec($ch);
        
        // close the connection, release resources used
        curl_close($ch);
        
        // do anything you want with your response
        $jsonObj = json_decode($response, true);

        return $jsonObj['access_token'];
    }

    function getFirebaseProjectId() {
        if (file_exists("service-account.json")) {
            $actualLink = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);
            $url = $actualLink. "/service-account.json";
            $curl = curl_init($url);
            $header = array();
            $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
            $header[] = 'timeout: 20';
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
            $envatoRes = curl_exec($curl);
            curl_close($curl);
            $envatoRes = json_decode($envatoRes);
            $projectId = $envatoRes->project_id;
            if(is_null($projectId)) {
                return 'invalid';
            } else {
                return $projectId;
            }
        } else {
            return "invalid";
        }
    }

    function generateApiKey($chars = 45) {
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($characters), 0, $chars);
    }    

    function pagination($reload, $page, $keyword, $tpages) {

        $prevlabelDisabled  = "<div class='padding-pagination button-grey button-rounded'><span aria-hidden='true'>&larr;</span>&nbsp;&nbsp;Previous</div>";
        $prevlabel  = "<div class='padding-pagination button button-rounded waves-effect waves-float'><span aria-hidden='true'>&larr;</span>&nbsp;&nbsp;Previous</div>";
        
        $nextlabel  = "<div class='padding-pagination button button-rounded waves-effect waves-float'>Next&nbsp;&nbsp;<span aria-hidden='true'>&rarr;</span></div>";
        $nextlabelDisabled  = "<div class='padding-pagination button-grey button-rounded'>Next&nbsp;&nbsp;<span aria-hidden='true'>&rarr;</span></div>";
        
        $current = "<div class='padding-pagination'>Page $page of $tpages</div>";
        
        $out = "<ul class='pager'>";
        
        // previous
        if($page == 1) {
            $out.= "<li class='previous disabled'><a>".$prevlabelDisabled."</a></li>";
        }
        elseif($page == 2) {
            $out.= "<li class='previous'><a href='".$reload."'>".$prevlabel."</a></li>";
        } else {
            $out.= "<li class='previous'><a href='".$reload."?page=".($page-1)."&keyword=".$keyword."'>".$prevlabel."</a></li>";
        }
        
        // current
        $out.= "<li><a>".$current."</a></li>";
        
        // next
        if($page<$tpages) {
            $out.= "<li class='next'><a href='" . $reload . "?page=" .($page+1) . "&keyword=".$keyword." '>" . $nextlabel . "</a></li>";
        } else {
            $out.= "<li class='next disabled'><a>" . $nextlabelDisabled . "</a></li>";
        }
        
        $out.= "</ul>";
        
        return $out;
    }

    function remotefileSize($url) {
        //return byte
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_exec($ch);
        $filesize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($ch);
        if ($filesize) return $filesize;
    }

    function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count((array)$file_post['name']); 
        $file_keys = array_keys((array)$file_post);
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }  

    function reArrayFilesOld(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }

?>