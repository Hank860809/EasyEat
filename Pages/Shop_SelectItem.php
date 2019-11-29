<?php
require '../DataBase/DBFunction.php';
$obj = new DbFunction();

if (!empty($_POST["AreaID"])) {
    $AreaID= intval($_POST['AreaID']);
    $sql = " Select CityID, CityName From City Where AreaID = ?;";
    $params = array($AreaID); 
    $stmt = $obj->GetData($sql, $params);

    if ($stmt === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $str;
    
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $str .= '<option VALUE="'.$row['CityID'].'">'.$row['CityName'].'</option>';
    }
    
    echo $str;
}

if (!empty($_POST["CityID"])) {
    $CityID= intval($_POST['CityID']);
    $sql = " Select DistrictID, DistrictName From District Where CityID = ?;";
    $params = array($CityID); 
    $stmt = $obj->GetData($sql, $params);

    if ($stmt === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $str;
    
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $str .= '<option VALUE="'.$row['DistrictID'].'">'.$row['DistrictName'].'</option>';
    }
    
    echo $str;
}

?>