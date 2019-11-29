<?php
require 'UserFeedback_Edit_Process.php'
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        
        <?php require 'CSS_Setting.php' ?>

        <title>EasyEat 後臺管理 - <?php if(!$isUpdate) echo "新增"; else echo "編輯" ?><?php echo $PageName;?></title>
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
                    <div class="row">
                        <div class="col-lg-12">
                           <?php if(isset($_SESSION ['message'])):?>
                            <div class="alter alert-<?=$_SESSION ['msg_type']?>">
                                <?php 
                                    echo $_SESSION ['message'];
                                    unset($_SESSION ['message']);
                                    unset($_SESSION ['msg_type']);
                                ?>
                            </div>
                            <?php endif;?> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><?php echo "檢視"; ?><?php echo $PageName;?></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-10">

                                            <div class="form-group"> <!-- 使用者名稱 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader3;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column3;?>" id="<?php echo $Column3;?>" disabled>   
                                                    <?php else:?> <!-- 修改 -->
                                                    <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" value="<?php echo $UserName //修改變數?>" disabled>  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 使用者名稱 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 訊息內容 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader4;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <textarea class="form-control" name="<?php echo $Column4;?>" id="<?php echo $Column4;?>" disabled><?php echo $UserMessage //修改變數?></textarea>  
                                                    <?php else:?> <!-- 修改 -->
                                                    <textarea class="form-control" name="<?php echo $Column4;?>" id="<?php echo $Column4;?>" disabled ><?php echo $UserMessage //修改變數?></textarea>  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 訊息內容 -->	

                                        </div> 	

                                        <br><br>		

                                        <div class="form-group"> 
                                            <div class="col-lg-4">

                                            </div>
                                            <div class="col-lg-6"><br><br>
                                                <a href="<?php echo $BackPage;?>"> <p class="btn">返回</p></a>
                                            </div>
                                        </div>		
                                    </div> <!-- row -->
                                </div> <!-- panel-body -->
                            </div> <!-- panel -->
                        </div> <!-- col-lg-12 -->
                    </div> <!-- row -->
                </div> <!-- page-wrapper -->
            </div> <!-- wrapper -->
           
            <?php require 'JavaScript_Setting.php' ?>
            <script>
                
            </script>
        </form>
    </body>

</html>
