<?php
require 'Shop_Edit_Process.php'
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        
        <?php require 'CSS_Setting.php' ?>

        <title>EasyEat 後臺管理 - <?php if(!$isUpdate) echo "新增"; else echo "編輯" ?><?php echo $PageName;?></title>
    </head>

    <body>
        <form method="post" enctype="multipart/form-data"   >
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
                                                    <label><?php echo $ColumnHeader2;?><span id="" style="font-size:11px;color:red">*</span>	</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" required="required">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column2;?>" id="<?php echo $Column2;?>" required="required" value="<?php echo $ShopName //修改變數?>">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 店家名稱 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 種類 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader33;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="<?php echo $Column32;?>" id="<?php echo $Column32;?>" required="required">
                                                        <?php if(!$isUpdate):?>  <!-- 新增 -->
                                                            <option VALUE=""><?php echo $OptionValue4;?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_Kind, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <option VALUE="<?php echo $row[$Column32]; //修改變數?>"><?php echo $row[$Column33]; //修改變數?></option>
                                                            <?php endwhile;?>  
                                                        <?php else:?>  <!-- 修改 -->
                                                            <option VALUE="<?php echo $KindID; //修改變數?>"><?php echo $KindName; //修改變數?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_Kind, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <?php if($row[$Column32] == $KindID): //修改變數
                                                                        continue;
                                                                     else:
                                                                ?>
                                                                    <option VALUE="<?php echo $row[$Column32]; ?>"><?php echo $row[$Column33]; ?></option>
                                                                <?php endif;?>
                                                            <?php endwhile;?>  
                                                        <?php endif;?>
                                                    </select>				
                                                </div>
                                            </div> <!-- 種類 -->	 

                                            <br><br>

                                            <div class="form-group"> <!-- 地區 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader4;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="<?php echo $Column3;?>" id="<?php echo $Column3;?>" required="required">
                                                        <?php if(!$isUpdate):?>  <!-- 新增 -->
                                                            <option VALUE=""><?php echo $OptionValue1; //修改變數?></option>
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
                                            
                                            <div class="form-group"> <!-- 城市 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader6;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="<?php echo $Column5;?>" id="<?php echo $Column5;?>" required="required">
                                                        <?php if(!$isUpdate):?>  <!-- 新增 -->
                                                            <option VALUE=""><?php echo $OptionValue1; //修改變數?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_City, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <option VALUE="<?php echo $row[$Column5]; ?>"><?php echo $row[$Column6]; ?></option>
                                                            <?php endwhile;?>  
                                                        <?php else:?>  <!-- 修改 -->
                                                            <option VALUE="<?php echo $CityID; //修改變數?>"><?php echo $CityName; //修改變數?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_City, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <?php if($row[$Column3] == $CityID): //修改變數
                                                                        continue;
                                                                     else:
                                                                ?>
                                                                    <option VALUE="<?php echo $row[$Column5]; ?>"><?php echo $row[$Column6]; ?></option>
                                                                <?php endif;?>
                                                            <?php endwhile;?>  
                                                        <?php endif;?>
                                                    </select>				
                                                </div>
                                            </div> <!-- 城市 -->	 

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 行政區 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader8;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="<?php echo $Column7;?>" id="<?php echo $Column7;?>" required="required">
                                                        <?php if(!$isUpdate):?>  <!-- 新增 -->
                                                            <option VALUE=""><?php echo $OptionValue3; //修改變數?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_District, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <option VALUE="<?php echo $row[$Column7]; ?>"><?php echo $row[$Column8]; ?></option>
                                                            <?php endwhile;?>  
                                                        <?php else:?>  <!-- 修改 -->
                                                            <option VALUE="<?php echo $DistrictID; //修改變數?>"><?php echo $DistrictName; //修改變數?></option>
                                                            <?php while ($row = sqlsrv_fetch_array($stmt_District, SQLSRV_FETCH_ASSOC)): //修改變數?>
                                                                <?php if($row[$Column7] == $AreaID): //修改變數
                                                                        continue;
                                                                     else:
                                                                ?>
                                                                    <option VALUE="<?php echo $row[$Column7]; ?>"><?php echo $row[$Column8]; ?></option>
                                                                <?php endif;?>
                                                            <?php endwhile;?>  
                                                        <?php endif;?>
                                                    </select>				
                                                </div>
                                            </div> <!-- 行政區 -->	 

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 電話1 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader10;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column10;?>" id="<?php echo $Column10;?>" type="tel">   
                                                    <?php else:?> <!-- 修改 -->
                                                    <input class="form-control" name="<?php echo $Column10;?>" id="<?php echo $Column10;?>" value="<?php echo $Tel1 //修改變數?>" type="tel">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 電話1 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 電話2 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader11;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column11;?>" id="<?php echo $Column11;?>" type="tel">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column11;?>" id="<?php echo $Column11;?>" value="<?php echo $Tel2 //修改變數?>" type="tel">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 電話2 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 座標X -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader12;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column12;?>" id="<?php echo $Column12;?>" required="required" type="number" min="0" step="any" pattern="^\d*(\.\d{0,6})?$">       
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column12;?>" id="<?php echo $Column12;?>" value="<?php echo $LocationX //修改變數?>" required="required" type="number" min="0" step="any" pattern="^\d*(\.\d{0,6})?$">
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 座標X -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 座標Y -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader15;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column15;?>" id="<?php echo $Column15;?>" required="required" type="number" min="0" step="any" pattern="^\d*(\.\d{0,6})?$">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column15;?>" id="<?php echo $Column15;?>" value="<?php echo $LocationY //修改變數?>" required="required" type="number" min="0" step="any" pattern="^\d*(\.\d{0,6})?$">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 座標Y -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 營業開始時間 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader19;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column19;?>" id="<?php echo $Column19;?>" required="required" type="time" >   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column19;?>" id="<?php echo $Column19;?>" value="<?php echo $StartTime //修改變數?>" required="required" type="time">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 營業開始時間 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 營業結束時間 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader22;?><span id="" style="font-size:11px;color:red">*</span></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column22;?>" id="<?php echo $Column22;?>" required="required" type="time" >   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column22;?>" id="<?php echo $Column22;?>" value="<?php echo $EndTime //修改變數?>" required="required" type="time">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 營業結束時間 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 休息開始時間 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader25;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column25;?>" id="<?php echo $Column25;?>" type="time" >   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column25;?>" id="<?php echo $Column25;?>" value="<?php echo $RestStartTime //修改變數?>" type="time">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 休息開始時間 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 休息結束時間 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader28;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column28;?>" id="<?php echo $Column28;?>" type="time" >   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column28;?>" id="<?php echo $Column28;?>" value="<?php echo $RestEndTime //修改變數?>" type="time">  
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 休息結束時間 -->	

                                            <br><br>
                                            
                                            <div class="form-group"> <!-- 封面圖片 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader18;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                    <input class="form-control" name="<?php echo $Column18;?>" id="<?php echo $Column18;?>" type="file" accept=".jpg,.png,.jepg" >   
                                                    <?php else:?> <!-- 修改 -->
                                                        <input class="form-control" name="<?php echo $Column18;?>" id="<?php echo $Column18;?>" value="<?php echo $CoverImg //修改變數?>" type="file" accept=".jpg,.png,.jepg">
                                                        <?php if($CoverImg !== ""):?>
                                                        <a href="<?php echo $CoverImg;?>" target="_blank"> <p class="btn btn-primary">檢視圖片</p></a>
                                                        <?php endif;?>
                                                    <?php endif;?>
                                                </div>
                                            </div> <!-- 封面圖片 -->
                                            
                                            <br><br>

                                            <div class="form-group"> <!-- 啟用 -->
                                                <div class="col-lg-4">
                                                    <label><?php echo $ColumnHeader31;?></label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php if(!$isUpdate):?> <!-- 新增 -->
                                                        <input type="checkbox" name="<?php echo $Column31;?>" id="<?php echo $Column31;?>" class="checkbox-inline" checked="true">   
                                                    <?php else:?> <!-- 修改 -->
                                                        <?php if($Active === "Y"):?>
                                                            <input type="checkbox" name="<?php echo $Column31;?>" id="<?php echo $Column31;?>" class="checkbox-inline" checked="true">
                                                        <?php else:?>
                                                            <input type="checkbox" name="<?php echo $Column31;?>" id="<?php echo $Column31;?>" class="checkbox-inline">
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
                $(document).on('keydown', 'input[pattern]', function(e){
                    var input = $(this);
                    var oldVal = input.val();
                    var regex = new RegExp(input.attr('pattern'), 'g');

                    setTimeout(function(){
                    var newVal = input.val();
                    if(!regex.test(newVal)){
                        input.val(oldVal); 
                    }
                    }, 0);
                });
                $(document).on('change', '#AreaID', function(){
                   var areaid = $('#AreaID :selected').val();//注意:selected前面有個空格！
                   $.ajax({
                      url:"Shop_SelectItem.php",				
                      method:"POST",
                      data:{
                         AreaID:areaid
                      },					
                      success:function(res){					
                          $("#CityID").html(res);
                      }
                   })//end ajax
                });
                $(document).on('change', '#CityID', function(){
                   var cityid = $('#CityID :selected').val();//注意:selected前面有個空格！
                   $.ajax({
                      url:"Shop_SelectItem.php",				
                      method:"POST",
                      data:{
                         CityID:cityid
                      },					
                      success:function(res){					
                          $("#DistrictID").html(res);
                      }
                   })//end ajax
                }); 
            </script>
        </form>
    </body>

</html>
