<?php
require 'Login_Process.php'
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        
        <?php require 'CSS_Setting.php' ?>
        <link href="../css/jquery.validate.css" rel="stylesheet" type="text/css"  />

        <title>EasyEat 後臺管理 登入頁面</title>
    </head>

    <body>
        <div class="container"> <!--div container start-->
            <br><br><br><br><br><br>
            <div class="col-md-4 col-md-offset-4"> <!--div col-md-4 start-->
                <div class="panel panel-primary"> <!--div panel-primary start-->
                    <div class="panel-heading">
                        <h3 class="panel-title">登入</h3>
                    </div>
                    <div class="panel-body"> <!--div panel-body start-->
                        <form action="" method="post"> <!--form post start-->
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="請輸入帳號"  id="Account" name="Account" type="text" autofocus autocomplete="off" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="請輸入密碼" id="Password" name="Password" type="password" value="">
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="登入" name="Login" >
                            </fieldset>
                        </form> <!--form post end-->
                    </div> <!--div panel-body end-->
                </div> <!--div panel-primary end-->
            </div> <!--div col-md-4 end-->
        </div> <!--div container end-->
        
        <?php require 'JavaScript_Setting.php' ?>
        <script src="../jquery/jquery-1.3.2.js" type="text/javascript"></script>
        <script src="../js/jquery.validate.js" type="text/javascript"></script>
        <script type="text/javascript">

        </script>
    </body>
</html>
