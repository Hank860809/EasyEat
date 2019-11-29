<?php
require 'User_Edit_Process.php'
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

                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader2;?><span id="" style="font-size:11px;color:red">*</span>	</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" required="required">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" required="required" value="<?php echo $UserName //修改變數 ?>">  
                                                    <?php endif;?>
                                                </div>
                                            </div>	

                                            <br><br>
                                            
                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader3;?><span id="" style="font-size:11px;color:red">*</span>	</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input class="form-control" name="<?php echo $Column3;?>" id="<?php echo $Column3;?>" required="required" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')">   
                                                    <?php else:?> <!-- 修改 -->
                                                    <input class="form-control" name="<?php echo $Column3;?>" id="<?php echo $Column3;?>" required="required" value="<?php echo $Account //修改變數 ?>" disabled>  
                                                    <?php endif;?>
                                                </div>
                                            </div>	

                                            <br><br>
                                            
                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader4;?><span id="" style="font-size:11px;color:red">*</span>	</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input class="form-control" name="<?php echo $Column4;?>" id="<?php echo $Column4;?>" required="required" type="password">   
                                                    <?php else:?> <!-- 修改 -->
                                                    <input class="form-control" name="<?php echo $Column4;?>" id="<?php echo $Column4;?>" required="required" value="<?php echo $Password //修改變數 ?>" type="password">  
                                                    <?php endif;?>
                                                </div>
                                            </div>	

                                            <br><br>
                                            
                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader5;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input class="form-control" name="<?php echo $Column5;?>" id="<?php echo $Column5;?>" type="email" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')">   
                                                    <?php else:?> <!-- 修改 -->
                                                    <input class="form-control" name="<?php echo $Column5;?>" id="<?php echo $Column5;?>" value="<?php echo $Email //修改變數 ?>" type="email" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')">  
                                                    <?php endif;?>
                                                </div>
                                            </div>	

                                            <br><br>
                                            
                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader7;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input class="form-control" name="<?php echo $Column7;?>" id="<?php echo $Column7;?>" type="tel" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')">   
                                                    <?php else:?> <!-- 修改 -->
                                                    <input class="form-control" name="<?php echo $Column7;?>" id="<?php echo $Column7;?>" value="<?php echo $CellPhone //修改變數 ?>" type="tel" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[\u4e00-\u9fa5]/g,''))" onkeyup="this.value=this.value.replace(/[\u4e00-\u9fa5]/g,'')">  
                                                    <?php endif;?>
                                                </div>
                                            </div>	

                                            <br><br>

                                            <div class="form-group"> <!-- 啟用 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader6;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input type="checkbox" name="<?php echo $Column6;?>" id="<?php echo $Column6;?>" class="checkbox-inline" checked="true">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <?php if($Active === "Y"):?>
                                                            <input type="checkbox" name="<?php echo $Column6;?>" id="<?php echo $Column6;?>" class="checkbox-inline" checked="true">
                                                        <?php else:?>
                                                            <input type="checkbox" name="<?php echo $Column6;?>" id="<?php echo $Column6;?>" class="checkbox-inline">
                                                        <?php endif;?>
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 啟用 -->
                                            
                                        </div>	

                                        <br><br>		

                                        <div class="form-group">
                                            <div class="col-lg-4">

                                            </div>
                                            <div class="col-lg-6"><br><br>
                                                <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input type="submit" class="btn btn-primary" name="<?php echo $ButtonAdd;?>" value="建立">
                                                <?php else:?> <!-- 修改 -->
                                                    <input type="submit" class="btn btn-primary" name="<?php echo $ButtonUpdate;?>" value="更新">
                                                <?php endif;?>
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
