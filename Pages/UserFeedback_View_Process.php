<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "使用者訊息資料";
$AddPage = "UserFeedback_Edit.php";
$EditPage = "UserFeedback_Edit.php";
$DeletePage = "UserFeedback_View.php";
$BackPage = "";

$ColumnHeader1 = "訊息ID";
$ColumnHeader2 = "使用者名稱";
$ColumnHeader3 = "訊息內容";
$ColumnHeader4 = "建立時間";
$ColumnHeader5 = "動作";

$Column1 = "MessageID";
$Column2 = "UserName";
$Column3 = "UserMessage";
$Column4 = "CreatedDate";
$Column5 = "";
$Column6 = "UserName";


$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "";
$HiddenColumn4 = "";
$HiddenColumn5 = "";

require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//刪除
if (isset($_GET[$Column1]) && isset($_GET[$Column2])) {
    
    $MessageID = $_GET[$Column1];
    $UserID = $_GET[$Column2];
    $status = true;
    
    //=================刪除前檢查=================
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete UserFeedback "
              ." Where MessageID = ?;";
        $params = array($MessageID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$UserID."] 訊息刪除成功！", "success");
    }
}

//=================取得城市資料=================
$sql = " Select uf.MessageID as MessageID, uf.UserID as UserID, u.UserName as UserName, "
      ." (CASE WHEN len(uf.UserMessage) > 10 THEN substring(uf.UserMessage,0,10) + '...' ELSE uf.UserMessage END) as UserMessage," 
      ." ISNULL(CASE WHEN CONVERT(DATE, uf.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), uf.CreatedDate, 111) END, '') as CreatedDate "
      ."From UserFeedback as uf Inner Join [User] as u on uf.UserID = u.UserID; ";
$stmt_UserFeedback = $obj->GetData($sql);

if ($stmt_UserFeedback === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
