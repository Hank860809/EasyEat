<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "城市資料";
$AddPage = "City_Edit.php";
$EditPage = "City_Edit.php";
$DeletePage = "City_View.php";
$BackPage = "";

$ColumnHeader1 = "城市ID";
$ColumnHeader2 = "城市名稱";
$ColumnHeader3 = "地區ID";
$ColumnHeader4 = "地區名稱";
$ColumnHeader5 = "啟用";
$ColumnHeader6 = "建立時間";
$ColumnHeader7 = "建立者";
$ColumnHeader8 = "更新時間";
$ColumnHeader9 = "更新者";
$ColumnHeader10 = "動作";

$Column1 = "CityID";
$Column2 = "CityName";
$Column3 = "AreaID";
$Column4 = "AreaName";
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
    
    $CityID = $_GET[$Column1];
    $CityName = $_GET[$Column2];
    $status = true;
    
    //=================刪除前檢查=================
    //檢查行政區
    $sql = " Select 1 "
          ." From District "
          ." Where CityID = ?;";
    $params = array($CityID);
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }

    if ($row_count > 0) {
        $obj->setMessage($ColumnHeader2.":[".$CityName."] 已被使用，無法刪除！", "warning");
        $status = false;
    }
    
    //檢查店家
    $sql = "Select 1 "
          ." From Shop "
          ." Where CityID = ?;";
    $params = array($CityID);
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }

    if ($row_count > 0) {
        $obj->setMessage($ColumnHeader2.":[".$CityName."] 已被使用，無法刪除！", "warning");
        $status = false;
    }
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete City "
              ." Where CityID = ?;";
        $params = array($CityID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$CityName."] 刪除成功！", "success");
    }
}

//=================取得城市資料=================
$sql = " Select c.CityID as CityID, c.CityName as CityName, a.AreaID as AreaID, a.AreaName as AreaName, c.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, c.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), c.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, c.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), c.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From City as c Inner Join Area as a on c.AreaID = a.AreaID left join "
      ." [user] as u on u.UserID = c.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = c.UpdateUserID "
      ." Order By c.CityID; ";
$stmt_City = $obj->GetData($sql);

if ($stmt_City === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
