<?php
require 'Order_Edit_Process.php'
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
                                <div class="panel-heading"><?php if(!$isUpdate) echo "新增"; else echo "編輯"; ?><?php echo $PageName;?></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            
                                            <div class="form-group"> <!-- 店家名稱 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader8;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="form-control" name="<?php echo $Column8;?>" id="<?php echo $Column8;?>" disabled value="<?php echo $ShopName //修改變數?>">  
                                                </div>
                                            </div> <!-- 店家名稱 -->	

                                            <br><br>

                                            <div class="form-group"> <!-- 商品名稱 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader2;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" disabled value="<?php echo $ProductName //修改變數?>">  
                                                </div>
                                            </div> <!-- 商品名稱 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 價格 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader3;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="form-control" name="<?php echo $Column3;?>" id="<?php echo $Column3;?>" value="<?php echo $Price //修改變數?>" type="number" min="0">
                                                </div>
                                            </div> <!-- 價格 -->	  
                                            
                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 數量 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader4;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="form-control" name="<?php echo $Column4;?>" id="<?php echo $Column4;?>" value="<?php echo $Qty //修改變數?>" type="number" min="0">
                                                </div>
                                            </div> <!-- 數量 -->	
                                            
                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 備註 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader6;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="form-control" name="<?php echo $Column6;?>" id="<?php echo $Column6;?>" value="<?php echo $Remark //修改變數?>">
                                                </div>
                                            </div> <!-- 備註 -->	
                                        </div> 	

                                        <br><br>		

                                        <div class="form-group"> 
                                            <div class="col-lg-4">

                                            </div>
                                            <div class="col-lg-6"><br><br>
                                                <input type="submit" class="btn btn-primary" name="<?php echo $ButtonUpdate;?>" value="更新">
                                                <a href="<?php echo $BackPage;?>?<?php echo $Column1;?>=<?php echo $OrderID;?>&<?php echo $Column7;?>=<?php echo $ShopID;?>&Back='Y"> <p class="btn">返回</p></a>
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
