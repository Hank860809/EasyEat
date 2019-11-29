<?php
require 'UserFeedback_View_Process.php'
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">

        <?php require 'CSS_Setting.php' ?>
        <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
        
        <title>EasyEat 後臺管理 - <?php echo $PageName;?></title>
    </head>

    <body>
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
                            <div class="panel-heading">
                                <?php echo $PageName;?>
                            </div> <!-- panel-heading -->

                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dt">
                                        <thead>
                                            <tr>
                                                <th <?php echo $HiddenColumn1;?>><?php echo $ColumnHeader1;?></th>
                                                <th <?php echo $HiddenColumn2;?>><?php echo $ColumnHeader2;?></th>
                                                <th <?php echo $HiddenColumn3;?>><?php echo $ColumnHeader3;?></th>
                                                <th <?php echo $HiddenColumn4;?>><?php echo $ColumnHeader4;?></th>
                                                <th <?php echo $HiddenColumn5;?>><?php echo $ColumnHeader5;?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            while ($row = sqlsrv_fetch_array($stmt_UserFeedback, SQLSRV_FETCH_ASSOC)): //修改變數
                                            ?>	
                                                <tr class="odd gradeX">
                                                    <td <?php echo $HiddenColumn1;?>><?php echo $row[$Column1]; ?></td>
                                                    <td <?php echo $HiddenColumn2;?>><?php echo $row[$Column2]; ?></td>
                                                    <td <?php echo $HiddenColumn3;?>><?php echo $row[$Column3]; ?></td>
                                                    <td <?php echo $HiddenColumn4;?>><?php echo $row[$Column4]; ?></td>
                                                    <td <?php echo $HiddenColumn5;?>>&nbsp;&nbsp;
                                                        <a href="<?php echo $EditPage;?>?<?php echo $Column1;?>=<?php echo $row[$Column1];?>"><p class="fa fa-edit"></p></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                                        
                                                    </td>
                                                </tr>

                                            <?php endwhile;?>   	           
                                        </tbody>
                                    </table>
                                </div> <!-- dataTable_wrapper -->

                                <div class="form-group">
                                    <div class="col-lg-2"><br>
                                         
                                    </div>
                                </div>	
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col-lg-12 -->
                </div> <!-- row -->
            </div> <!-- page-wrapper -->
        </div>  <!-- wrapper -->
        
        <?php require 'JavaScript_Setting.php' ?>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dt').DataTable({
                    responsive: true
                });
            });
        </script>
    </body>
</html>
