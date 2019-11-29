<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

//前端變數
$PageName = "種類資料";
$AddPage = "Kind_Edit.php";
$EditPage = "Kind_Edit.php";
$DeletePage = "Kind_View.php";
$BackPage = "";

$ColumnHeader1 = "種類ID";
$ColumnHeader2 = "種類名稱";
$ColumnHeader3 = "啟用";
$ColumnHeader4 = "建立時間";
$ColumnHeader5 = "建立者";
$ColumnHeader6 = "更新時間";
$ColumnHeader7 = "更新者";
$ColumnHeader8 = "動作";

$Column1 = "KindID";
$Column2 = "KindName";
$Column3 = "Active";
$Column4 = "CreatedDate";
$Column5 = "CreatedUserName";
$Column6 = "UpdateUserName";
$Column7 = "UpdateDate";

$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "";
$HiddenColumn4 = "";
$HiddenColumn5 = "";
$HiddenColumn6 = "";
$HiddenColumn7 = "";
$HiddenColumn8 = "";


require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//刪除
if (isset($_GET[$Column1]) && isset($_GET[$Column2])) {
    
    $KindID = $_GET[$Column1];
    $KindName = $_GET[$Column2];
    $status = true;
    
    //=================刪除前檢查=================
    //檢查店家
    $sql = "Select 1 "
          ." From Shop "
          ." Where KindID = ?;";
    $params = array($KindID);
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }

    if ($row_count > 0) {
        $obj->setMessage($ColumnHeader2.":[".$DistrictName."] 已被使用，無法刪除！", "warning");
        $status = false;
    }
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete Kind "
              ." Where KindID = ?;";
        $params = array($KindID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$KindName."] 刪除成功！", "success");
    }
}

//=================取得行政區資料=================
$sql = " Select k.KindID as KindID, k.KindName as KindName, k.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, k.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), k.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, k.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), k.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From  Kind as k  left join "
      ." [user] as u on u.UserID = k.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = k.UpdateUserID ;";
$stmt_Kind = $obj->GetData($sql);

if ($stmt_Kind === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
