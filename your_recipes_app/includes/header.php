<?php include_once ('session.php'); ?>
<?php include_once ('config.php'); ?>
<?php include_once ('constant.php'); ?>
<?php include_once ('strings.php'); ?>
<?php include_once ('functions.php'); ?>

<?php

    $sqlLicense = "SELECT * FROM tbl_license ORDER BY id DESC LIMIT 1";
    $licenseResult = $connect->query($sqlLicense);
    $row = $licenseResult->fetch_assoc();
    $itemId = $row['item_id'];

    if ($itemId != $envatoItemId) {
        $error =<<<EOF
        <script>
        alert('Please Verify your Purchase Code to Continue Using Admin Panel');
        window.location = 'verify.php';
        </script>
EOF;
        echo $error;
    }

?>

<?php

    $sqlSettings = "SELECT * FROM tbl_settings WHERE id = '1'";
    $resultSettings = $connect->query($sqlSettings);
    $settings_row = $resultSettings->fetch_assoc();

    $username = $_SESSION['user'];
    $sqlUser = "SELECT id, username, email FROM tbl_admin WHERE username = '$username'";
    $userResult = $connect->query($sqlUser);
    $data = $userResult->fetch_assoc();
            
?>

<!DOCTYPE html>
<html>
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $app_name; ?></title>

    <?php include_once ('assets/css.min.php'); ?>

</head>

<body class="theme-blue poppins">

    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="dashboard.php"><div class="uppercase"><?php echo $app_name; ?></div></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="notification.php"><i class="material-icons">notifications</i></a></li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="admin-edit.php?id=<?php echo $data['id']; ?>"><i class="material-icons">person</i>Profile</a></li>
                            <li><a href="logout.php"><i class="material-icons">power_settings_new</i>Logout</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->

<?php include_once ('sidebar.php'); ?>

    