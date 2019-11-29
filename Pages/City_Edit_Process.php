<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "城市資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "City_View.php";

$ColumnHeader1 = "城市ID";
$ColumnHeader2 = "城市名稱";
$ColumnHeader3 = "地區ID";
$ColumnHeader4 = "地區名稱";
$ColumnHeader5 = "啟用";

$Column1 = "CityID";
$Column2 = "CityName";
$Column3 = "AreaID";
$Column4 = "AreaName";
$Column5 = "Active";

$OptionValue1 = "選擇地區";

$ButtonAdd = "CityAdd";
$ButtonUpdate = "CityUpdate";

//後端變數
$isUpdate = false;
$CityID = "";
$CityName = "";
$AreaID = "";
$AreaName = "";
$Active = "Y";
$LoginUserID = "";

if(!empty($_GET[$Column1])){
    $CityID = $_GET[$Column1];
}

if(!empty($_POST[$Column2])){
    $CityName = $_POST[$Column2];
}

if(!empty($_POST[$Column3])){
    $AreaID = $_POST[$Column3];
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

    $sql = " Insert into City(CityName, AreaID, Active, CreatedUserID) "
          ." Values(?, ?, ?, ?); ";
    $params = array($CityName, $AreaID, $Active, $LoginUserID); 
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

    $sql = " Update City "
          ." Set CityName = ?, AreaID = ?, Active = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where CityID = ?; ";
    $params = array($CityName, $AreaID, $Active, $LoginUserID, $CityID); 
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
    
    $sql = " Select c.CityID as CityID, c.CityName as CityName, a.AreaID as AreaID, a.AreaName as AreaName, c.Active as Active "
          ." From city as c Inner Join Area as a on c.AreaID = a.AreaID "
          ." Where c.CityID = ?; ";
    $params = array($CityID); 
    $stmt_CityByID = $obj->GetData($sql, $params);
    
    if ($stmt_CityByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_CityByID, SQLSRV_FETCH_ASSOC)){
        $CityName = $row[$Column2];
        $AreaID = $row[$Column3];
        $AreaName = $row[$Column4];
        $Active = $row[$Column5];
    }
}

//取得地區資料
$sql = " Select * From Area; ";
$stmt_Area = $obj->GetData($sql);

if ($stmt_Area === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

?>
