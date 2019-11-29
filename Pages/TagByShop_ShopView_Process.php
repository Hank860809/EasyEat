<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "店家標籤資料";
$AddPage = "";
$EditPage = "TagByShop_TagView.php";
$DeletePage = "";
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

//=================取得店家資料=================
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
