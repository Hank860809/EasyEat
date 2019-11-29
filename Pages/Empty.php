<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">

<!--        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/metisMenu.min.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../css/sb-admin-2.css" rel="stylesheet">-->
        
        <?php require 'CSS_Setting.php' ?>

        <title>EasyEat 後臺管理</title>
    </head>

    <body>
        <form method="post" >
            <div id="wrapper">

                <!-- 選單 -->
                <?php include('TopLeftBar.php') ?>

                <!--內容-->
                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                                <h4 class="page-header"> <?php echo "登入者:"." ".$_SESSION['LoginUserName'];?></h4>
                        </div>
                    </div>
                </div>

<!--            <script src="../jquery/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/metisMenu.min.js"></script>
            <script src="../js/sb-admin-2.js"></script>-->
            
            <?php require 'JavaScript_Setting.php' ?>

        </form>
    </body>
</html>
