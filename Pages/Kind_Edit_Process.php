<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "種類資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "Kind_View.php";

$ColumnHeader1 = "種類ID";
$ColumnHeader2 = "種類名稱";
$ColumnHeader3 = "啟用";

$Column1 = "KindID";
$Column2 = "KindName";
$Column3 = "Active";

$OptionValue1 = "";

$ButtonAdd = "KindAdd";
$ButtonUpdate = "KindUpdate";

//後端變數
$isUpdate = false;
$KindID = "";
$KindName = "";
$Active = "Y";
$LoginUserID = "";

if(!empty($_GET[$Column1])){
    $KindID = $_GET[$Column1];
}

if(!empty($_POST[$Column2])){
    $KindName = $_POST[$Column2];
}

if(empty($_POST[$Column3])){
    $Active = "N";
}

if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = $_SESSION ['LoginUserID'];
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//新增
if (!empty($_POST[$ButtonAdd])) {

    $sql = " Insert into Kind(KindName, Active, CreatedUserID) "
          ." Values(?, ?, ?); ";
    $params = array($KindName, $Active, $LoginUserID); 
    $res = $obj->SQLExcute($sql, $params);
    
    if ($res === false) { 
        $obj->setMessage("資料新增失敗！", "danger");
    }
    else{
        $obj->setMessage("資料新增成功！", "success");
    }
    
}

//更新
if (!empty($_POST[$ButtonUpdate])) {

    $sql = " Update Kind "
          ." Set KindName = ?, Active = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where KindID = ?; ";
    $params = array($KindName, $Active, $LoginUserID, $KindID); 
    $res = $obj->SQLExcute($sql, $params);

    if ($res  === false) {
        $obj->setMessage("資料更新失敗！", "danger");
    }
    else{
       $obj->setMessage("資料更新成功！", "success"); 
    }
    
}


//從查詢畫面點1擊編輯按鈕進入此頁面
//取得要編輯的城市資料
if (!empty($_GET[$Column1])) {
    $isUpdate = true;
    $KindID = $_GET[$Column1];
    
    $sql = " Select k.KindID as KindID, k.KindName as KindName, k.Active as Active  "
          ." From Kind as k "
          ." Where k.KindID = ?; ";
    $params = array($KindID); 
    $stmt_KindByID = $obj->GetData($sql, $params);
    
    if ($stmt_KindByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_KindByID, SQLSRV_FETCH_ASSOC)){
        $KindName = $row[$Column2];
        $Active = $row[$Column3];
    }
}

?>
