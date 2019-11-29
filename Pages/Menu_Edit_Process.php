<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "菜單資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "Menu_DetailView.php";

$ColumnHeader1 = "菜單ID";
$ColumnHeader2 = "產品名稱";
$ColumnHeader3 = "價格";
$ColumnHeader4 = "店家ID";
$ColumnHeader5 = "店家名稱";
$ColumnHeader6 = "序列號";

$Column1 = "MenuID";
$Column2 = "ProductName";
$Column3 = "Price";
$Column4 = "ShopID";
$Column5 = "ShopName";
$Column6 = "SerialNo";

$OptionValue1 = "";

$ButtonAdd = "MenuDetailAdd";
$ButtonUpdate = "MenuDetailUpdate";

//後端變數
$isUpdate = false;
$MenuID = 0;
$ProductName = "";
$Price = 0;
$ShopID = 0;
$ShopName = "";
$SerialNo = 0;
$LoginUserID = 0;

//MenuID
if(!empty($_GET[$Column1])){
    $MenuID = intval($_GET[$Column1]);
}

//ShopID
if(!empty($_GET[$Column4])){
    $ShopID = intval($_GET[$Column4]);
}

//ShopName 
if(!empty($_GET[$Column5])){
    $ShopName = intval($_GET[$Column5]);
}

//SerialNo
if(!empty($_GET[$Column6])){
    $SerialNo = intval($_GET[$Column6]);
}

//MenuID
if(!empty($_POST[$Column1])){
    $MenuID = intval($_POST[$Column1]);
}

//ProductName
if(!empty($_POST[$Column2])){
    $ProductName = $_POST[$Column2];
}

//Price
if(!empty($_POST[$Column3])){
    $Price = intval($_POST[$Column3]);
}

//LoginUserID
if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = intval($_SESSION ['LoginUserID']);
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//新增
if (!empty($_POST[$ButtonAdd])) {
    $sql = " Insert into MenuDetail(MenuID, ProductName, Price, CreatedUserID) "
          ." Values(?, ?, ?, ?); ";
    $params = array($MenuID, $ProductName, $Price, $LoginUserID);
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
    $sql = " Update MenuDetail "
          ." Set  ProductName = ?, Price = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where MenuID = ? and SerialNo = ?; ";
    $params = array($ProductName, $Price, $LoginUserID, $MenuID, $SerialNo); 
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
if (!empty($_GET[$Column1]) && !empty($_GET[$Column4])) {
    $MenuID = intval($_GET[$Column1]);
    $ShopID = intval($_GET[$Column4]);
    
    $sql = " Select m.ShopID as ShopID, s.ShopName as ShopName, m.MenuID as MenuID  "
          ." From Menu as m Inner Join Shop as s on m.ShopID = s.ShopID "
          ." Where m.MenuID = ?; ";
    $params = array($MenuID); 
    $stmt_MenuDetailByID = $obj->GetData($sql, $params);
    
    if ($stmt_MenuDetailByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_MenuDetailByID, SQLSRV_FETCH_ASSOC)){
        $ShopName = $row[$Column5];
    }
}

//從查詢畫面點擊 編輯 按鈕進入此頁面
//取得要編輯的店家標籤資料
if (!empty($_GET[$Column1]) && !empty($_GET[$Column4]) && !empty($_GET[$Column6])) {
    $isUpdate = true;
    $MenuID = intval($_GET[$Column1]);
    $ShopID = intval($_GET[$Column4]);
    $SerialNo = intval($_GET[$Column6]);
    
    $sql = " Select m.ShopID as ShopID, s.ShopName as ShopName, md.MenuID as MenuID, md.ProductName as ProductName, md.Price as Price "
          ." From Menu as m Inner Join MenuDetail as md on m.MenuID = md.MenuID inner join "
          ." Shop as s on m.ShopID = s.ShopID "
          ." Where md.MenuID = ? and md.SerialNo = ?; ";
    $params = array($MenuID, $SerialNo); 
    $stmt_MenuDetailByID = $obj->GetData($sql, $params);
    
    if ($stmt_MenuDetailByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_MenuDetailByID, SQLSRV_FETCH_ASSOC)){
        $ProductName = $row[$Column2];
        $Price = intval($row[$Column3]);
        $ShopName = $row[$Column5];
    }
}

?>
