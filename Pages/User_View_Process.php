<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

//前端變數
$PageName = "使用者資料";
$AddPage = "User_Edit.php";
$EditPage = "User_Edit.php";
$DeletePage = "User_View.php";
$BackPage = "";

$ColumnHeader1 = "使用者ID";
$ColumnHeader2 = "使用者名稱";
$ColumnHeader3 = "啟用";
$ColumnHeader4 = "建立時間";
$ColumnHeader5 = "建立者";
$ColumnHeader6 = "更新時間";
$ColumnHeader7 = "更新者";
$ColumnHeader8 = "動作";

$Column1 = "UserID";
$Column2 = "UserName";
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
    
    $UserID = $_GET[$Column1];
    $UserName = $_GET[$Column2];
    $status = true;
    
    //=================刪除前檢查=================
    //檢查使用者
    $sql = "Select 1 "
          ." From UserOrderHistory "
          ." Where UserID = ?;";
    $params = array($UserID);
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }

    if ($row_count > 0) {
        $obj->setMessage($ColumnHeader2.":[".$UserName."] 已被使用，無法刪除！", "warning");
        $status = false;
    }
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete [User] "
              ." Where UserID = ?;";
        $params = array($UserID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$UserName."] 刪除成功！", "success");
    }
}

//=================取得行政區資料=================
$sql = " Select u.UserID as UserID, u.UserName as UserName, u.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, u.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), u.CreatedDate, 111) END, '') as CreatedDate, isnull(u1.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, u.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), u.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From  [User] as u left join "
      ." [user] as u1 on u1.UserID = u.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = u.UpdateUserID ;";
$stmt_User = $obj->GetData($sql);

if ($stmt_User === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
