<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "標籤資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "Tag_View.php";

$ColumnHeader1 = "標籤ID";
$ColumnHeader2 = "標籤名稱";
$ColumnHeader3 = "啟用";

$Column1 = "TagID";
$Column2 = "TagName";
$Column3 = "Active";

$OptionValue1 = "";

$ButtonAdd = "TagAdd";
$ButtonUpdate = "TagUpdate";

//後端變數
$isUpdate = false;
$TagID = "";
$TagName = "";
$Active = "Y";
$LoginUserID = "";

if(!empty($_GET[$Column1])){
    $TagID = $_GET[$Column1];
}

if(!empty($_POST[$Column2])){
    $TagName = $_POST[$Column2];
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

    $sql = " Insert into Tag(TagName, Active, CreatedUserID) "
          ." Values(?, ?, ?); ";
    $params = array($TagName, $Active, $LoginUserID); 
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

    $sql = " Update Tag "
          ." Set TagName = ?, Active = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where TagID = ?; ";
    $params = array($TagName, $Active, $LoginUserID, $TagID); 
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
    $TagID = $_GET[$Column1];
    
    $sql = " Select t.TagID as TagID, t.TagName as TagName, t.Active as Active  "
          ." From Tag as t "
          ." Where t.TagID = ?; ";
    $params = array($TagID); 
    $stmt_TagByID = $obj->GetData($sql, $params);
    
    if ($stmt_TagByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_TagByID, SQLSRV_FETCH_ASSOC)){
        $TagName = $row[$Column2];
        $Active = $row[$Column3];
    }
}

?>
