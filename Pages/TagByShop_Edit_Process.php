<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "店家標籤資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "TagByShop_TagView.php";

$ColumnHeader1 = "標籤ID";
$ColumnHeader2 = "標籤名稱";
$ColumnHeader3 = "啟用";
$ColumnHeader4 = "店家ID";
$ColumnHeader5 = "店家名稱";

$Column1 = "TagID";
$Column2 = "TagName";
$Column3 = "Active";
$Column4 = "ShopID";
$Column5 = "ShopName";

$OptionValue1 = "選擇標籤";

$ButtonAdd = "TagByShopAdd";
$ButtonUpdate = "TagByShopUpdate";

//後端變數
$isUpdate = false;
$TagID = 0;
$TagName = "";
$Active = "Y";
$ShopID = 0;
$ShopName = "";
$LoginUserID = 0;
$TagIDTemp = 0;


//TagID
if(!empty($_GET[$Column1])){
    $TagIDTemp = intval($_GET[$Column1]);
}

//ShopID
if(!empty($_GET[$Column4])){
    $ShopID = intval($_GET[$Column4]);
}

//TagID
if(!empty($_POST[$Column1])){
    $TagID = intval($_POST[$Column1]);
}

//TagName
if(!empty($_POST[$Column2])){
    $TagName = $_POST[$Column2];
}

//Active
if(empty($_POST[$Column3])){
    $Active = "N";
}

//LoginUserID
if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = intval($_SESSION ['LoginUserID']);
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//新增
if (!empty($_POST[$ButtonAdd])) {

    $sql = " Insert into TagByShop(TagID, ShopID, Active, CreatedUserID) "
          ." Values(?, ?, ?, ?); ";
    $params = array($TagID, $ShopID, $Active, $LoginUserID); 
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
    if($TagIDTemp == $TagID){
        $sql = " Update TagByShop "
              ." Set Active = ?, UpdateUserID = ?, UpdateDate = getdate() "
              ." Where ShopID = ? and TagID = ?; ";
        $params = array($Active, $LoginUserID, $ShopID, $TagID); 
    }
    else{
        $sql = " Delete TagByShop "
              ." Where ShopID = ? and TagID = ?; ";
        $sql .= " Insert into TagByShop(ShopID, TagID, Active, CreatedUserID) "
               ." Values(?, ?, ?, ?); ";
        $params = array($ShopID, $TagIDTemp, $ShopID, $TagID, $Active, $LoginUserID);
    }    
    $res = $obj->SQLExcute($sql, $params);

    if ($res  === false) {
        $obj->setMessage("資料更新失敗！", "danger");
    }
    else{
       $obj->setMessage("資料更新成功！", "success"); 
    }
    
}

//從查詢畫面點擊 新增 按鈕進入此頁面
//取得要編輯的店家標籤資料
if (!empty($_GET[$Column4])) {
    $ShopID = $_GET[$Column4];
    
    $sql = " Select s.ShopID as ShopID, s.ShopName as ShopName  From Shop as s"
          ." Where s.ShopID = ?; ";
    $params = array($ShopID); 
    $stmt_TagByShopByID = $obj->GetData($sql, $params);
    
    if ($stmt_TagByShopByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_TagByShopByID, SQLSRV_FETCH_ASSOC)){
        $ShopName = $row[$Column5];
    }
}

//從查詢畫面點擊 編輯 按鈕進入此頁面
//取得要編輯的店家標籤資料
if (!empty($_GET[$Column1]) && !empty($_GET[$Column4])) {
    $isUpdate = true;
    $TagID = $_GET[$Column1];
    $ShopID = $_GET[$Column4];
    
    $sql = " Select ts.ShopID as ShopID, s.ShopName as ShopName, ts.TagID as TagID, t.TagName as TagName, ts.Active as Active "
          ." From TagByShop as ts Inner Join Tag as t on ts.TagID = t.TagID inner join "
          ." Shop as s on ts.ShopID = s.ShopID "
          ." Where ts.TagID = ? and ts.ShopID = ?; ";
    $params = array($TagID, $ShopID); 
    $stmt_TagByShopByID = $obj->GetData($sql, $params);
    
    if ($stmt_TagByShopByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_TagByShopByID, SQLSRV_FETCH_ASSOC)){
        $TagID = intval($row[$Column1]);
        $TagName = $row[$Column2];
        $Active = $row[$Column3];
        $ShopName = $row[$Column5];
    }
}

//取得該店家未使用的標籤資料
$sql = " Select TagID, TagName From Tag "
      ." Where Active = 'Y' and " 
      ." TagID NOT in (Select TagID From TagByShop Where ShopID = ?);";
$params = array($ShopID); 
$stmt_Tag = $obj->GetData($sql, $params);

if ($stmt_Tag === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

?>
