<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "店家資料";
$AddPage = "Shop_Edit.php";
$EditPage = "Shop_Edit.php";
$DeletePage = "Shop_View.php";
$BackPage = "";

$ColumnHeader1 = "店家ID";
$ColumnHeader2 = "店家名稱";
$ColumnHeader3 = "地區ID";
$ColumnHeader4 = "地區名稱";
$ColumnHeader5 = "城市ID";
$ColumnHeader6 = "城市名稱";
$ColumnHeader7 = "行政區ID";
$ColumnHeader8 = "行政區名稱";
$ColumnHeader9 = "啟用";
$ColumnHeader10 = "建立時間";
$ColumnHeader11 = "建立者";
$ColumnHeader12 = "更新時間";
$ColumnHeader13 = "更新者";
$ColumnHeader14 = "動作";

$Column1 = "ShopID";
$Column2 = "ShopName";
$Column3 = "AreaID";
$Column4 = "AreaName";
$Column5 = "CityID";
$Column6 = "CityName";
$Column7 = "DistrictID";
$Column8 = "DistrictName";
$Column9 = "Active";
$Column10 = "CreatedDate";
$Column11 = "CreatedUserName";
$Column12 = "UpdateUserName";
$Column13 = "UpdateDate";

$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "hidden";
$HiddenColumn4 = "";
$HiddenColumn5 = "hidden";
$HiddenColumn6 = "";
$HiddenColumn7 = "hidden";
$HiddenColumn8 = "";
$HiddenColumn9 = "";
$HiddenColumn10 = "";
$HiddenColumn11 = "";
$HiddenColumn12 = "";
$HiddenColumn13 = "";
$HiddenColumn14 = "";

require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//刪除
if (isset($_GET[$Column1]) && isset($_GET[$Column2])) {
    
    $ShopID = $_GET[$Column1];
    $ShopName = $_GET[$Column2];
    $status = true;
    
    //=================刪除前檢查=================
    //檢查店家標籤
    $sql = " Select 1 "
          ." From TagByShop "
          ." Where ShopID = ?;";
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
        $obj->setMessage($ColumnHeader2.":[".$ShopName."] 已被使用，無法刪除！", "warning");
        $status = false;
    }
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete Menu "
              ." Where ShopID = ?;";
        $sql .= " Delete Shop "
              ." Where ShopID = ?;";
        $params = array($ShopID, $ShopID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$ShopName."] 刪除成功！", "success");
    }
}

//=================取得城市資料=================
$sql = " Select s.ShopID as ShopID, s.ShopName as ShopName, s.AreaID as AreaID, a.AreaName as AreaName, s.CityID as CityID, c.CityName as CityName, s.DistrictID as DistrictID, d.DistrictName as DistrictName, s.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, s.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), s.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, s.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), s.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName  "
      ." From Shop as s Inner Join Area as a on s.AreaID = a.AreaID inner join "
      ." City as c on s.CityID = c.CityID inner join"
      ." District as d on s.DistrictID = d.DistrictID left join "
      ." [user] as u on u.UserID = s.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = s.UpdateUserID; ";
$stmt_Shop = $obj->GetData($sql);

if ($stmt_Shop === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
