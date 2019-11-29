<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "訂單資料";
$AddPage = "Order_DetailView.php";
$EditPage = "Order_DetailView.php";
$DeletePage = "Order_ListView.php";
$BackPage = "Order_ShopView.php";

$ColumnHeader1 = "訂單ID";
$ColumnHeader2 = "總金額";
$ColumnHeader3 = "總數量";
$ColumnHeader4 = "建立時間";
$ColumnHeader5 = "建立者";
$ColumnHeader6 = "更新時間";
$ColumnHeader7 = "更新者";
$ColumnHeader8 = "動作";
$ColumnHeader9 = "店家ID";
$ColumnHeader10 = "群組號";
$ColumnHeader11 = "啟用";

$Column1 = "OrderID";
$Column2 = "TotalPrice";
$Column3 = "TotalQty";
$Column4 = "CreatedDate";
$Column5 = "CreatedUserName";
$Column6 = "UpdateUserName";
$Column7 = "UpdateDate";
$Column9 = "ShopID";
$Column10 = "OrderNo";
$Column11 = "Active";

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
$HiddenColumn11 = "";

$OrderID = 0;
$TotalPrice = 0;
$TotalQty = 0;
$ShopID = 0;
$OrderNo = 0;
$LoginUserID = 0;

require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//ShopID
if(!empty($_GET[$Column9])){
    $ShopID = $_GET[$Column9];
}

//LoginUserID
if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = intval($_SESSION ['LoginUserID']);
}

//刪除
if (isset($_GET[$Column1])) {
    
    $OrderID = intval($_GET[$Column1]);
    $status = true;
    
    //=================刪除前檢查=================
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete UserOrderHistory "
               ." Where OrderID = ?; ";
        $sql .= " Delete OrderDetail "
               ." Where OrderID = ?; ";
        $sql .= " Delete [Order] "
             ." Where OrderID = ?; ";
        $params = array($OrderID, $OrderID, $OrderID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader1.":[".$OrderID."] 刪除成功！", "success");
    }
}

//=================取得店家訂單資料=================
$sql = " Select o.OrderID as OrderID, o.ShopID as ShopID, o.TotalPrice as TotalPrice, o.TotalQty as TotalQty, o.OrderNo as OrderNo, o.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, o.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), o.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, o.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), o.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From [Order] as o Inner Join Shop as s on o.ShopID = s.ShopID left join "
      ." [user] as u on u.UserID = o.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = o.UpdateUserID "
      ." Where o.ShopID = ?";
$params = array($ShopID);
$stmt_Order = $obj->GetData($sql, $params);
 
if ($stmt_Order === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

$row_count = sqlsrv_num_rows($stmt_Order);
if ($row_count === false) {
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
