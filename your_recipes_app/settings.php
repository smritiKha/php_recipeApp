<?php include_once('includes/header.php'); ?>
<script src="assets/plugins/ckeditor/ckeditor.js"></script>

<?php

    $ID =  clean("1");

    $server_url = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);
    $applicationId = $settings_row['package_name'];
    $plain_text = $server_url.'_applicationId_'.$applicationId;
    $encode = base64_encode(base64_encode(base64_encode($plain_text)));

    if(isset($_POST['submit'])) {

        $sql_query = "SELECT * FROM tbl_settings WHERE id = '$ID'";
        $img_res = mysqli_query($connect, $sql_query);
        $img_row=  mysqli_fetch_assoc($img_res);

        $data = array(
            'app_fcm_key' => $_POST['app_fcm_key'],
            'api_key' => $_POST['api_key'],
            'package_name' => $_POST['package_name'],
            'onesignal_app_id' => $_POST['onesignal_app_id'],
            'onesignal_rest_api_key' => $_POST['onesignal_rest_api_key'],
            'providers' => $_POST['providers'],
            'fcm_notification_topic' => $_POST['fcm_notification_topic'],
            'privacy_policy' => $_POST['privacy_policy'],
            'youtube_api_key' => $_POST['youtube_api_key'],
            'more_apps_url' => $_POST['more_apps_url']
        );

        $update_setting = update('tbl_settings', $data, "WHERE id = '$ID'");

        if ($update_setting > 0) {
            $_SESSION['msg'] = "Changes saved...";
            header('Location:settings.php');
            exit;
        }
    }

?>


    <section class="content">

        <ol class="breadcrumb breadcrumb-offset">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Settings</a></li>
        </ol>

       <div class="container-fluid" id="fade-in">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <form method="post" id="form_validation" enctype="multipart/form-data">
                    <div class="card corner-radius">
                        <div class="header">
                            <h2>SETTINGS</h2>
                            <div class="header-dropdown m-r--5">
                                <button type="submit" name="submit" class="button button-rounded btn-offset bg-blue waves-effect">UPDATE</button>
                            </div>
                        </div>

                        <div class="body">

                            <?php if(isset($_SESSION['msg'])) { ?>
                            <div class='alert alert-info alert-dismissible corner-radius' role='alert'>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>&nbsp;&nbsp;</button>
                                <?php echo $_SESSION['msg']; ?>
                            </div>
                            <?php unset($_SESSION['msg']); } ?>  

                            <div class="row clearfix">
                                <div class="col-sm-12" style="font-size: 16px;"><b>KEYS & IDS</b></div>
                                
                                <!-- <div class="col-sm-12">
                                    <div class="alert alert-info alert-dismissible corner-radius bottom-offset">
                                        <p style="margin-top: -3px;">applicationId (Package Name) and Server Key configuration moved to Apps menu</p>
                                        <a href="apps.php"><button type="button" class="button-light button-rounded waves-effect" style="margin-top: 10px;">OPEN APPS MENU</button></a>
                                    </div>
                                </div> -->

                                <input type="hidden" class="form-control" name="package_name" id="package_name" value="<?php echo $settings_row['package_name'];?>" required>

                                <input type="hidden" class="form-control" value="<?php echo $encode; ?>" required>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>Rest API Key</b></div>
                                            <input type="text" class="form-control" name="api_key" id="api_key" value="<?php echo $settings_row['api_key'];?>" required readonly>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-api-key">Where I have to put my API Key?</a> | <a href="api-key.php"><span class="label label-rounded bg-blue">CHANGE API KEY</span></a></div>
                                    </div>
                                </div>

                                <input type="hidden" class="form-control" name="youtube_api_key" id="youtube_api_key" value="<?php echo $settings_row['youtube_api_key'];?>" required>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>More Apps Url</b></div>
                                            <input type="text" class="form-control" name="more_apps_url" id="more_apps_url" value="<?php echo $settings_row['more_apps_url'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><font color="#337ab7">More apps url for other apps</font></div>
                                    </div>
                                </div>

                                <div class="col-sm-12" style="font-size: 16px;"><br><b>PUSH NOTIFICATION</b></div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <div class="font-12"><b>Provider</b></div>
                                                <select class="form-control show-tick" name="providers" id="providers">
                                                        <?php if ($settings_row['providers'] == 'onesignal') { ?>
                                                            <option value="onesignal" selected="selected">OneSignal</option>
                                                            <option value="firebase">Firebase Cloud Messaging (FCM)</option>
                                                        <?php } else { ?>
                                                            <option value="onesignal">OneSignal</option>
                                                            <option value="firebase" selected="selected">Firebase Cloud Messaging (FCM)</option>
                                                        <?php } ?>
                                                </select>
                                        <div class="help-info pull-left"><font color="#337ab7">Choose your provider for sending push notification</font></div>
                                    </div>
                                </div>

                                <input type="hidden" class="form-control" name="app_fcm_key" id="app_fcm_key" value="<?php echo $settings_row['app_fcm_key'];?>" required>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>FCM Notification Topic</b></div>
                                            <input type="text" class="form-control" name="fcm_notification_topic" id="fcm_notification_topic" value="<?php echo $settings_row['fcm_notification_topic'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><font color="#337ab7">FCM notification topic must be written in lowercase without space (use underscore)</font></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>OneSignal APP ID</b></div>
                                            <input type="text" class="form-control" name="onesignal_app_id" id="onesignal_app_id" value="<?php echo $settings_row['onesignal_app_id'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-onesignal">Where do I get my OneSignal app id?</a></div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12"><b>OneSignal Rest API Key</b></div>
                                            <input type="text" class="form-control" name="onesignal_rest_api_key" id="onesignal_rest_api_key" value="<?php echo $settings_row['onesignal_rest_api_key'];?>" required>
                                        </div>
                                        <div class="help-info pull-left"><a href="" data-toggle="modal" data-target="#modal-onesignal">Where do I get my OneSignal Rest API Key?</a></div>
                                    </div>
                                </div>                     

                                <div class="col-sm-12" style="font-size: 16px;"><br><b>PRIVACY</b></div>
                                <div class="col-sm-12">
                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <div class="font-12 ex1" style="margin-bottom: 6px;"><b>Privacy Policy</b></div>
                                            <textarea class="form-control" name="privacy_policy" id="privacy_policy" class="form-control" cols="60" rows="10" required><?php echo $settings_row['privacy_policy'];?></textarea>

                                            <?php if ($ENABLE_RTL_MODE == 'true') { ?>
                                            <script>                             
                                                CKEDITOR.replace( 'privacy_policy' );
                                                CKEDITOR.config.contentsLangDirection = 'rtl';
                                            </script>
                                            <?php } else { ?>
                                            <script>                             
                                                CKEDITOR.replace( 'privacy_policy' );
                                                CKEDITOR.config.height = 300; 
                                            </script>
                                            <?php } ?>

                                        </div>
                                    </div>

                                </div>

                            </div>

                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
            
        </div>

    </section>

<?php include_once('includes/footer.php'); ?>