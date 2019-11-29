<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "使用者訊息資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "UserFeedback_View.php";

$ColumnHeader1 = "訊息ID";
$ColumnHeader2 = "使用者ID";
$ColumnHeader3 = "使用者名稱";
$ColumnHeader4 = "訊息內容";

$Column1 = "MessageID";
$Column2 = "UserID";
$Column3 = "UserName";
$Column4 = "UserMessage";

$OptionValue1 = "";

$ButtonAdd = "";
$ButtonUpdate = "";

//後端變數
$isUpdate = false;
$MessageID = 0;
$UserID = 0;
$UserName = "";
$UserMessage = "";
$LoginUserID = "";

if(!empty($_GET[$Column1])){
    $MessageID = $_GET[$Column1];
}

if(!empty($_POST[$Column2])){
    $UserID = $_POST[$Column2];
}

if(!empty($_POST[$Column3])){
    $UserName = $_POST[$Column3];
}

if(!empty($_POST[$Column4])){
    $UserMessage = $_POST[$Column4];
}

if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = $_SESSION ['LoginUserID'];
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//新增


//更新


//從查詢畫面點1擊編輯按鈕進入此頁面
//取得要編輯的城市資料
if (!empty($_GET[$Column1])) {
    $isUpdate = true;
    $MessageID = $_GET[$Column1];
    
    $sql = " Select uf.MessageID as MessageID, uf.UserID as UserID, u.UserName as UserName, uf.UserMessage as UserMessage, "
      ." ISNULL(CASE WHEN CONVERT(DATE, uf.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), uf.CreatedDate, 111) END, '') as CreatedDate "
      ."From UserFeedback as uf Inner Join [User] as u on uf.UserID = u.UserID; ";
    $params = array($MessageID); 
    $stmt_MessageByID = $obj->GetData($sql, $params);
    
    if ($stmt_MessageByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_MessageByID, SQLSRV_FETCH_ASSOC)){
        $UserID = $row[$Column2];
        $UserName = $row[$Column3];
        $UserMessage = $row[$Column4];
    }
}


?>
