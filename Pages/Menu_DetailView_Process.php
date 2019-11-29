<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "菜單資料";
$AddPage = "Menu_Edit.php";
$EditPage = "Menu_Edit.php";
$DeletePage = "Menu_DetailView.php";
$BackPage = "Menu_ShopView.php";

$ColumnHeader1 = "菜單ID";
$ColumnHeader2 = "產品名稱";
$ColumnHeader3 = "價格";
$ColumnHeader4 = "建立時間";
$ColumnHeader5 = "建立者";
$ColumnHeader6 = "更新時間";
$ColumnHeader7 = "更新者";
$ColumnHeader8 = "動作";
$ColumnHeader9 = "店家ID";
$ColumnHeader10 = "序列號";

$Column1 = "MenuID";
$Column2 = "ProductName";
$Column3 = "Price";
$Column4 = "CreatedDate";
$Column5 = "CreatedUserName";
$Column6 = "UpdateDate";
$Column7 = "UpdateUserName";
$Column9 = "ShopID";
$Column10 = "SerialNo";

$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "";
$HiddenColumn4 = "";
$HiddenColumn5 = "";
$HiddenColumn6 = "";
$HiddenColumn7 = "";
$HiddenColumn8 = "";
$HiddenColumn9 = "hidden";
$HiddenColumn10 = "hidden";

$MenuID = 0;
$ProductName = "";
$ShopID = 0;
$SerialNo = 0;
$LoginUserID = 0;

require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//ShopID
if(!empty($_GET[$Column9])){
    $ShopID = intval($_GET[$Column9]);
}

//LoginUserID
if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = intval($_SESSION ['LoginUserID']);
}

//刪除
if (isset($_GET[$Column1]) && isset($_GET[$Column2]) && isset($_GET[$Column10])) {
    
    $MenuID = intval($_GET[$Column1]);
    $ProductName = $_GET[$Column2];
//    $ShopID = intval($_GET[$Column9]);
    $SerialNo = intval($_GET[$Column10]);
    $status = true;
    
    //=================刪除前檢查=================
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete MenuDetail "
              ." Where MenuID = ? and SerialNo = ?;";
        $params = array($MenuID, $SerialNo); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$ProductName."] 刪除成功！", "success");
    }
}

//=================取得店家菜單資料=================
$sql = " Select m.ShopID as ShopID, s.ShopName as ShopName, m.MenuID as MenuID, md.SerialNo, md.ProductName as ProductName, md.Price as Price, "
      ." ISNULL(CASE WHEN CONVERT(DATE, md.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), md.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, md.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), md.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From Menu as m Inner Join MenuDetail as md on m.MenuID = md.MenuID inner join "
      ." Shop as s on m.ShopID = s.ShopID left join "
      ." [user] as u on u.UserID = md.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = md.UpdateUserID "
      ." Where m.ShopID = ?";
$params = array($ShopID);
$stmt_Menu = $obj->GetData($sql, $params);
 
if ($stmt_Menu === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

$row_count = sqlsrv_num_rows($stmt_Menu);
if ($row_count === false) {
    die($obj->formatErrors(sqlsrv_errors()));
}

//不存在菜單主檔就新增一筆
if ($row_count == 0) {
    $sql = " Delete Menu "
          ." Where ShopID = ?; ";
    $sql .= " Insert into Menu(ShopID, CreatedUserID) "
          ." Values(?, ?); ";
    $params = array($ShopID, $ShopID, $LoginUserID);
    $res = $obj->SQLExcute($sql, $params);
        
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
}

$sql = " Select MenuID From Menu Where ShopID = ?";
$params = array($ShopID);
$res = $obj->GetData($sql, $params);

if ($res === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)){
    $MenuID = $row[$Column1];
}
    
    
?>
