<?php
require 'City_Edit_Process.php'
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

                                            <div class="form-group"> <!-- 城市名稱 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader2;?><span id="" style="font-size:11px;color:red">*</span>	</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" required="required">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" required="required" value="<?php echo $CityName //修改變數?>">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 城市名稱 -->	

                                            <br><br>

                                            <div class="form-group"> <!-- 地區 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader4;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="<?php echo $Column3;?>" id="<?php echo $Column3;?>" required="required" >
                                                        <?php if(!$isUpdate):?>  <!-- 新增 -->
                                                            <option VALUE=""><?php echo $OptionValue1;?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_Area, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <option VALUE="<?php echo $row[$Column3]; ?>"><?php echo $row[$Column4]; ?></option>
                                                            <?php endwhile;?>  
                                                        <?php else:?>  <!-- 修改 -->
                                                            <option VALUE="<?php echo $AreaID; //修改變數?>"><?php echo $AreaName; //修改變數?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_Area, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <?php if($row[$Column3] == $AreaID): //修改變數
                                                                        continue;
                                                                     else:
                                                                ?>
                                                                    <option VALUE="<?php echo $row[$Column3]; ?>"><?php echo $row[$Column4]; ?></option>
                                                                <?php endif;?>
                                                            <?php endwhile;?>  
                                                        <?php endif;?>
                                                    </select>				
                                                </div>
                                            </div> <!-- 地區 -->	 

                                            <br><br>								

                                            <div class="form-group"> <!-- 啟用 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader5;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input type="checkbox" name="<?php echo $Column5;?>" id="<?php echo $Column5;?>" class="checkbox-inline" checked="true">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <?php if($Active === "Y"):?>
                                                            <input type="checkbox" name="<?php echo $Column5;?>" id="<?php echo $Column5;?>" class="checkbox-inline" checked="true">
                                                        <?php else:?>
                                                            <input type="checkbox" name="<?php echo $Column5;?>" id="<?php echo $Column5;?>" class="checkbox-inline">
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
