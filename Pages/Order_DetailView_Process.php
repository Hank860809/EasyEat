<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "訂單明細資料";
$AddPage = "Order_Edit.php";
$EditPage = "Order_Edit.php";
$DeletePage = "Order_DetailView.php";
$BackPage = "Order_ListView.php";

$ColumnHeader1 = "訂單ID";
$ColumnHeader2 = "商品名稱";
$ColumnHeader3 = "價格";
$ColumnHeader4 = "數量";
$ColumnHeader5 = "小計";
$ColumnHeader6 = "備註";
$ColumnHeader7 = "建立時間";
$ColumnHeader8 = "建立者";
$ColumnHeader9 = "更新時間";
$ColumnHeader10 = "更新者";
$ColumnHeader11 = "動作";
$ColumnHeader12 = "店家ID";
$ColumnHeader13 = "店家名稱";
$ColumnHeader14 = "序列號";

$Column1 = "OrderID";
$Column2 = "ProductName";
$Column3 = "Price";
$Column4 = "Qty";
$Column5 = "SubTotal";
$Column6 = "Remark";
$Column7 = "CreatedDate";
$Column8 = "CreatedUserName";
$Column9 = "UpdateDate";
$Column10 = "UpdateUserName";
$Column11 = "";
$Column12 = "ShopID";
$Column13 = "ShopName";
$Column14 = "SerialNo";

$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "";
$HiddenColumn4 = "";
$HiddenColumn5 = "";
$HiddenColumn6 = "";
$HiddenColumn7 = "";
$HiddenColumn8 = "";
$HiddenColumn9 = "";
$HiddenColumn10 = "";
$HiddenColumn11 = "";
$HiddenColumn12 = "hidden";
$HiddenColumn13 = "";
$HiddenColumn14 = "hidden";

$OrderID = 0;
$ProductName = "";
$Price = 0;
$Qty = 0;
$Remark = "";
$ShopID = 0;
$SerialNo = 0;
$LoginUserID = 0;

require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//OrderID
if (!empty($_GET[$Column1])) {
    $OrderID = intval($_GET[$Column1]);
}

//ShopID
if (!empty($_GET[$Column12])) {
    $ShopID = intval($_GET[$Column12]);
}


//LoginUserID
if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = intval($_SESSION ['LoginUserID']);
}

//新增
if (isset($_GET[$Column12]) && isset($_GET['Add'])) {
    
    $ShopID = intval($_GET[$Column12]);
    
    //新增一筆訂單
    $sql = " Insert into [Order](ShopID, Active, CreatedUserID) "
          ." Values(?, 'Y', ?);";
    $params = array($ShopID, $LoginUserID); 
    $res = $obj->SQLExcute($sql, $params);

    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    //查詢訂單ID
    $sql = " Select Top 1 OrderID From [Order] "
          ." Where ShopID = ? and CreatedUserID = ? "
          ." Order by OrderID DESC; ";
    $params = array($ShopID, $LoginUserID); 
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    if ($row_count > 0){
        $sql = " Select 1  From [OrderDetail] "
              ." Where OrderID = ?; ";
        $params = array($OrderID); 
        $res2 = $obj->GetData($sql, $params);

        if ($res2 === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }
        
        $row_count = sqlsrv_num_rows($res2);
        if ($row_count === false) {
            die($obj->formatErrors(sqlsrv_errors()));
        }
        
        if ($row_count == 0){
            while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)){
                $OrderID = intval($row['OrderID']);
            }
        }
        else{
            echo "<script>alert('查詢訂單明細檔時發生錯誤！')</script>";
        }
    }
    else{
        echo "<script>alert('查詢訂單主檔時發生錯誤！')</script>";
    }
    
    $sql = " Select m.MenuID as MenuID, m.ShopID as ShopID, md.ProductName, md.Price "
          ." From Menu as m inner join MenuDetail as md on m.MenuID = md.MenuID "
          ." Where m.ShopID = ?; ";
    $params = array($ShopID); 
    $res = $obj->GetData($sql, $params);

    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }

    if ($row_count > 0) {
        $sql = "";
        $params = array();
        
        //逐筆將菜單商品新增到訂單明細
        while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)){
            $sql .= " Insert into OrderDetail(OrderID, ProductName, Price, Qty, SubTotal, Remark, CreatedUserID) "
                   ." Values(?, ?, ?, ?, ?, ?, ?); ";
            array_push($params, $OrderID);
            array_push($params, $row[$Column2]);
            array_push($params, $row[$Column3]);
            array_push($params, 0);
            array_push($params, 0);
            array_push($params, "");
            array_push($params, $LoginUserID);
        }
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }
    }
    else{
        echo "<script>alert('產生訂單明細檔時發生錯誤！')</script>";
    }
}

//=================取得店家訂單資料=================
$sql = " Select o.ShopID as ShopID, s.ShopName as ShopName, od.OrderID as OrderID, od.SerialNo as SerialNo, od.ProductName as ProductName, od.Price as Price, od.Qty as Qty, od.SubTotal as SubTotal, od.Remark as Remark, "
      ." ISNULL(CASE WHEN CONVERT(DATE, od.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), od.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, od.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), od.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From [Order] as o inner join OrderDetail as od on o.OrderID = od.OrderID inner join "
      ." Shop as s on o.ShopID = s.ShopID left join "
      ." [user] as u on u.UserID = od.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = od.UpdateUserID "
      ." Where od.OrderID = ?";
$params = array($OrderID);
$stmt_Order = $obj->GetData($sql, $params);
 
if ($stmt_Order === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
