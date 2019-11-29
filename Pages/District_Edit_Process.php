<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "行政區資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "District_View.php";

$ColumnHeader1 = "行政區ID";
$ColumnHeader2 = "行政區名稱";
$ColumnHeader3 = "城市ID";
$ColumnHeader4 = "城市名稱";
$ColumnHeader5 = "啟用";

$Column1 = "DistrictID";
$Column2 = "DistrictName";
$Column3 = "CityID";
$Column4 = "CityName";
$Column5 = "Active";

$OptionValue1 = "選擇城市";

$ButtonAdd = "DistrictAdd";
$ButtonUpdate = "DistrictUpdate";

//後端變數
$isUpdate = false;
$DistrictID = "";
$DistrictName = "";
$CityID = "";
$CityName = "";
$Active = "Y";
$LoginUserID = "";

if(!empty($_GET[$Column1])){
    $DistrictID = $_GET[$Column1];
}

if(!empty($_POST[$Column2])){
    $DistrictName = $_POST[$Column2];
}

if(!empty($_POST[$Column3])){
    $CityID = $_POST[$Column3];
}

if(empty($_POST[$Column5])){
    $Active = "N";
}

if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = $_SESSION ['LoginUserID'];
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//新增
if (!empty($_POST[$ButtonAdd])) {

    $sql = " Insert into District(DistrictName, CityID, Active, CreatedUserID) "
          ." Values(?, ?, ?, ?); ";
    $params = array($DistrictName, $CityID, $Active, $LoginUserID); 
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

    $sql = " Update District "
          ." Set DistrictName = ?, CityID = ?, Active = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where DistrictID = ?; ";
    $params = array($DistrictName, $CityID, $Active, $LoginUserID, $DistrictID); 
    $res = $obj->SQLExcute($sql, $params);

    if ($res  === false) {
        $obj->setMessage("資料更新失敗！", "danger");
    }
    else{
       $obj->setMessage("資料更新成功！", "success"); 
    }
    
}


//從查詢畫面點1擊編輯按鈕進入此頁面
//取得要編輯的城市資料
if (!empty($_GET[$Column1])) {
    $isUpdate = true;
    $CityID = $_GET[$Column1];
    
    $sql = " Select d.DistrictID as DistrictID, d.DistrictName as DistrictName, c.CityID as CityID, c.CityName as CityName, c.Active as Active "
          ." From District as d Inner Join city as c on d.CityID = c.CityID "
          ." Where d.DistrictID = ?; ";
    $params = array($DistrictID); 
    $stmt_DistrictByID = $obj->GetData($sql, $params);
    
    if ($stmt_DistrictByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_DistrictByID, SQLSRV_FETCH_ASSOC)){
        $DistrictName = $row[$Column2];
        $CityID = $row[$Column3];
        $CityName = $row[$Column4];
        $Active = $row[$Column5];
    }
}

//取得地區資料
$sql = " Select * From City "
      ." Where Active = 'Y'; ";
$stmt_City = $obj->GetData($sql);

if ($stmt_City === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

?>
