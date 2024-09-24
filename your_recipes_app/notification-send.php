<?php include_once('includes/header.php'); ?>

<?php

    error_reporting(0);

    if (isset($_GET['id'])) {
        $ID = clean($_GET['id']);
    } else {
        $ID = clean("");
    }
            
    $sql_query = "SELECT * FROM tbl_fcm_template WHERE id = '$ID'";
    $template_result = mysqli_query($connect, $sql_query);
    $data   = mysqli_fetch_assoc($template_result);

    $setting_qry    = "SELECT * FROM tbl_settings WHERE id = '1'";
    $setting_result = mysqli_query($connect, $setting_qry);
    $settings_row   = mysqli_fetch_assoc($setting_result);

    $provider = $settings_row["providers"];

    $oneSignalAppId = $settings_row['onesignal_app_id'];
    $oneSignalRestApiKey = $settings_row['onesignal_rest_api_key'];
    $fcmNotificationTopic = $settings_row['fcm_notification_topic'];

    $redirect = 'Location:notification.php';

    if (isset($_POST['submit'])) {
        $title = $_POST["title"];
        $message = $_POST["message"];

        if ($_POST["post_id"] == "") {
            $postId = "0";
        } else {
            $postId = $_POST["post_id"];
        }

        $link = $_POST['link'];

        $actualLink = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);
        $bigImage = $actualLink.'/upload/notification/'.$data['image'];

        $generateRandomId = rand(1000, 9999);
        $uniqueId = "$generateRandomId";

        if ($provider == 'onesignal') {
            ONESIGNAL($uniqueId,  $title, $message, $bigImage, $link, $postId, $oneSignalAppId, $oneSignalRestApiKey, $redirect);
        } else if ($provider == 'firebase') {
            $fcmOAuthToken = getFirebaseOAuthToken();
            FCM_V1($uniqueId, $title, $message, $bigImage, $link, $postId, $fcmOAuthToken, $fcmNotificationTopic, $redirect);
        }

    }

?>

    <section class="content">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="notification.php">Manage Notification</a></li>
            <li class="active">Send Notification</a></li>
        </ol>

        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form method="post" id="form_validation" enctype="multipart/form-data">
                        <div class="card corner-radius">
                            <div class="header">
                                <h2>SEND NOTIFICATION</h2>
                            </div>
                            <div class="body">

                                <div class="row clearfix">

                                    <?php if ($provider == 'onesignal') { ?>

                                        <?php if ($oneSignalAppId == '0' || $oneSignalRestApiKey == '0') { ?>
                                            <div class="col-sm-12">
                                                <p><b>OneSignal App ID</b> or <b>OneSignal Rest API Key</b> have not been configured, put your OneSignal App ID or OneSignal Rest API Key in the <a href="settings.php"><b>Settings menu</b></a> in the admin panel.</p>
                                            </div>
                                        <?php } else { ?>

                                            <input type="hidden" name="post_id" id="post_id" value="0" required>

                                            <div class="form-group col-sm-12">
                                                <div class="font-12">Title</div>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $data['title']; ?>" required/>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-12">
                                                <div class="font-12">Message</div>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="message" id="message" placeholder="Message" value="<?php echo $data['message']; ?>" required/>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="font-12 ex1">Image</div>
                                                <div class="form-group">
                                                    <input type="file" class="dropify-image" data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/notification/<?php echo $data['image']; ?>" data-show-remove="false" disabled/>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-12">
                                                <div class="font-12">Link (Optional)</div>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="link" id="link" placeholder="https://google.com" value="<?php echo $data['link']; ?>" />
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <button class="button button-rounded waves-effect waves-float pull-right" type="submit" name="submit">SEND NOW</button>
                                            </div>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <?php if (file_exists("service-account.json")) { ?>

                                            <?php if (getFirebaseProjectId() == 'invalid') { ?>

                                                <div class="col-sm-12">
                                                    <p>Invalid Project Id in the service-account.json</p>
                                                </div>

                                            <?php } else { ?>

                                                <input type="hidden" name="post_id" id="post_id" value="0" required>

                                                <div class="form-group col-sm-12">
                                                    <div class="font-12">Title</div>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $data['title']; ?>" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-12">
                                                    <div class="font-12">Message</div>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="message" id="message" placeholder="Message" value="<?php echo $data['message']; ?>" required/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="font-12 ex1">Image</div>
                                                    <div class="form-group">
                                                        <input type="file" class="dropify-image" data-max-file-size="5M" data-allowed-file-extensions="jpg jpeg png gif" data-default-file="upload/notification/<?php echo $data['image']; ?>" data-show-remove="false" disabled/>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-12">
                                                    <div class="font-12">Link (Optional)</div>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="link" id="link" placeholder="https://google.com" value="<?php echo $data['link']; ?>" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <button class="button button-rounded waves-effect waves-float pull-right" type="submit" name="submit">SEND NOW</button>
                                                </div>

                                            <?php } ?>

                                        <?php } else { ?>

                                            <div class="col-sm-12">
                                                <p>Missing <b>service-account.json</b> file, please complete the Firebase Cloud Messaging setup in order to send push notification using Firebase</p>
                                            </div>

                                        <?php } ?>

                                    <?php } ?>
                                        
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

<?php include_once('includes/footer.php'); ?>