<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

//前端變數
$PageName = "行政區資料";
$AddPage = "District_Edit.php";
$EditPage = "District_Edit.php";
$DeletePage = "District_View.php";
$BackPage = "";

$ColumnHeader1 = "行政區ID";
$ColumnHeader2 = "行政區名稱";
$ColumnHeader3 = "城市ID";
$ColumnHeader4 = "城市名稱";
$ColumnHeader5 = "啟用";
$ColumnHeader6 = "建立時間";
$ColumnHeader7 = "建立者";
$ColumnHeader8 = "更新時間";
$ColumnHeader9 = "更新者";
$ColumnHeader10 = "動作";

$Column1 = "DistrictID";
$Column2 = "DistrictName";
$Column3 = "CityID";
$Column4 = "CityName";
$Column5 = "Active";
$Column6 = "CreatedDate";
$Column7 = "CreatedUserName";
$Column8 = "UpdateUserName";
$Column9 = "UpdateDate";

$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "hidden";
$HiddenColumn4 = "";
$HiddenColumn5 = "";
$HiddenColumn6 = "";
$HiddenColumn7 = "";
$HiddenColumn8 = "";
$HiddenColumn9 = "";
$HiddenColumn10 = "";

require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//刪除
if (isset($_GET[$Column1]) && isset($_GET[$Column2])) {
    
    $DistrictID = $_GET[$Column1];
    $DistrictName = $_GET[$Column2];
    $status = true;
    
    //=================刪除前檢查=================
    //檢查店家
    $sql = "Select 1 "
          ." From Shop "
          ." Where DistrictID = ?;";
    $params = array($DistrictID);
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }

    if ($row_count > 0) {
        $obj->setMessage($ColumnHeader2.":[".$DistrictName."] 已被使用，無法刪除！", "warning");
        $status = false;
    }
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete District "
              ." Where DistrictID = ?;";
        $params = array($DistrictID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$DistrictName."] 刪除成功！", "success");
    }
}

//=================取得行政區資料=================
$sql = " Select d.DistrictID as DistrictID, d.DistrictName as DistrictName, c.CityID as CityID, c.CityName as CityName, d.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, d.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), d.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, d.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), d.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From  District as d Inner Join City as c on d.CityID = c.CityID left join "
      ." [user] as u on u.UserID = d.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = d.UpdateUserID ;";
$stmt_District = $obj->GetData($sql);

if ($stmt_District === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
