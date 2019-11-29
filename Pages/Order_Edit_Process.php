<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "訂單資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "Order_DetailView.php";

$ColumnHeader1 = "訂單ID";
$ColumnHeader2 = "產品名稱";
$ColumnHeader3 = "價格";
$ColumnHeader4 = "數量";
$ColumnHeader5 = "小計";
$ColumnHeader6 = "備註";
$ColumnHeader7 = "店家ID";
$ColumnHeader8 = "店家名稱";
$ColumnHeader9 = "序列號";

$Column1 = "OrderID";
$Column2 = "ProductName";
$Column3 = "Price";
$Column4 = "Qty";
$Column5 = "SubTotal";
$Column6 = "Remark";
$Column7 = "ShopID";
$Column8 = "ShopName";
$Column9 = "SerialNo";

$OptionValue1 = "";

$ButtonAdd = "";
$ButtonUpdate = "OrderDetailUpdate";

//後端變數
$isUpdate = false;
$OrderID = 0;
$ProductName = "";
$Price = 0;
$Qty = 0;
$SubTotal = 0;
$Remark = "";
$ShopID = 0;
$ShopName = "";
$SerialNo = 0;
$LoginUserID = 0;

//OrderID
if(!empty($_GET[$Column1])){
    $OrderID = intval($_GET[$Column1]);
}

//SerialNo
if(!empty($_GET[$Column9])){
    $SerialNo = intval($_GET[$Column9]);
}

//ShopID
if(!empty($_GET[$Column7])){
    $ShopID = intval($_GET[$Column7]);
}

//ShopName
if(!empty($_POST[$Column7])){
    $ShopID = $_POST[$Column7];
}

//ShopName
if(!empty($_POST[$Column8])){
    $ShopName = $_POST[$Column8];
}

//ProductName
if(!empty($_POST[$Column2])){
    $ProductName = $_POST[$Column2];
}

//Price
if(!empty($_POST[$Column3])){
    $Price = intval($_POST[$Column3]);
}

//Qty
if(!empty($_POST[$Column4])){
    $Qty = intval($_POST[$Column4]);
}

//Remark
if(!empty($_POST[$Column6])){
    $Remark = $_POST[$Column6];
}

//LoginUserID
if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = intval($_SESSION ['LoginUserID']);
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//更新
if (!empty($_POST[$ButtonUpdate])) {
    $SubTotal = intval($Price) * intval($Qty);
    $sql = " Update OrderDetail "
          ." Set Price = ?, Qty = ?, SubTotal = ?, Remark = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where OrderID = ? and SerialNo = ?; ";
    $params = array($Price, $Qty, $SubTotal, $Remark, $LoginUserID, $OrderID, $SerialNo); 
    $res = $obj->SQLExcute($sql, $params);

    if ($res  === false) {
        $obj->setMessage("資料更新失敗！", "danger");
    }
    else{
        $sql = " Update [Order] "
              ." Set TotalPrice = (Select sum(SubTotal) From OrderDetail Where OrderID = ?), "
              ." TotalQty = (Select sum(Qty) From OrderDetail Where OrderID = ?), UpdateUserID = ?, UpdateDate = getdate() "
              ." Where OrderID = ?; ";
        $params = array($OrderID, $OrderID, $LoginUserID, $OrderID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res  === false) {
            $obj->setMessage("資料更新失敗！", "danger");
        }
        else{
            $obj->setMessage("資料更新成功！", "success");
        }         
    }
    
    
    
}

//從查詢畫面點擊 編輯 按鈕進入此頁面
//取得要編輯的訂單品項資料
if (!empty($_GET[$Column1]) && !empty($_GET[$Column9])) {
    $isUpdate = true;
    $OrderID = intval($_GET[$Column1]);
    $SerialNo = intval($_GET[$Column9]);
    
    $sql = " Select o.ShopID as ShopID, s.ShopName as ShopName, od.OrderID as OrderID, od.ProductName as ProductName, od.Price as Price, od.Qty as Qty, od.SubTotal as SubTotal, od.Remark as Remark "
          ." From [Order] as o Inner Join OrderDetail as od on o.OrderID = od.OrderID inner join "
          ." Shop as s on o.ShopID = s.ShopID "
          ." Where od.OrderID = ? and od.SerialNo = ?; ";
    $params = array($OrderID, $SerialNo); 
    $stmt_OrderDetailByID = $obj->GetData($sql, $params);
    
    if ($stmt_OrderDetailByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_OrderDetailByID, SQLSRV_FETCH_ASSOC)){
        $ShopID = $row[$Column7];
        $ShopName = $row[$Column8];
        $ProductName = $row[$Column2];
        $Price = intval($row[$Column3]);
        $Qty = intval($row[$Column4]);
        $Remark = $row[$Column6];   
    }
}

?>
