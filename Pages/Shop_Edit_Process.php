<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "店家資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "Shop_View.php";

$ColumnHeader1 = "店家ID";
$ColumnHeader2 = "店家名稱";
$ColumnHeader3 = "地區ID";
$ColumnHeader4 = "地區名稱";
$ColumnHeader5 = "城市ID";
$ColumnHeader6 = "城市名稱";
$ColumnHeader7 = "行政區ID";
$ColumnHeader8 = "行政區名稱";
$ColumnHeader9 = "地址";
$ColumnHeader10 = "電話1";
$ColumnHeader11 = "電話2";
$ColumnHeader12 = "座標X";
$ColumnHeader13 = "座標X_整數";
$ColumnHeader14 = "座標X_小數";
$ColumnHeader15 = "座標Y";
$ColumnHeader16 = "座標Y_整數";
$ColumnHeader17 = "座標Y_小數";
$ColumnHeader18 = "封面圖片";
$ColumnHeader19 = "營業開始時間";
$ColumnHeader20 = "營業開始時間_時";
$ColumnHeader21 = "營業開始時間_分";
$ColumnHeader22 = "營業結束時間";
$ColumnHeader23 = "營業結束時間_時";
$ColumnHeader24 = "營業結束時間_分";
$ColumnHeader25 = "休息開始時間";
$ColumnHeader26 = "休息開始時間_時";
$ColumnHeader27 = "休息開始時間_分";
$ColumnHeader28 = "休息結束時間";
$ColumnHeader29 = "休息結束時間_時";
$ColumnHeader30 = "休息結束時間_分";
$ColumnHeader31 = "啟用";
$ColumnHeader32 = "種類ID";
$ColumnHeader33 = "種類名稱";

$Column1 = "ShopID";
$Column2 = "ShopName";
$Column3 = "AreaID";
$Column4 = "AreaName";
$Column5 = "CityID";
$Column6 = "CityName";
$Column7 = "DistrictID";
$Column8 = "DistrictName";
$Column9 = "Address";
$Column10 = "Tel1";
$Column11 = "Tel2";
$Column12 = "LocationX";
$Column13 = "LocationX1";
$Column14 = "LocationX2";
$Column15 = "LocationY";
$Column16 = "LocationY1";
$Column17 = "LocationY2";
$Column18 = "CoverImg";
$Column19 = "StartTime";
$Column20 = "StartTime1";
$Column21 = "StartTime2";
$Column22 = "EndTime";
$Column23 = "EndTime1";
$Column24 = "EndTime2";
$Column25 = "RestStartTime";
$Column26 = "RestStartTime1";
$Column27 = "RestStartTime2";
$Column28 = "RestEndTime";
$Column29 = "RestEndTime1";
$Column30 = "RestEndTime2";
$Column31 = "Active";
$Column32 = "KindID";
$Column33 = "KindName";


$OptionValue1 = "選擇地區";
$OptionValue2 = "選擇城市";
$OptionValue3 = "選擇行政區";
$OptionValue4 = "選擇種類";

$ButtonAdd = "ShopAdd";
$ButtonUpdate = "ShopUpdate";

//後端變數
$isUpdate = false;
$ShopID = 0;
$ShopName = "";
$AreaID = 0;
$AreaName = "";
$CityID = 0;
$CityName = "";
$DistrictID = 0;
$DistrictName = "";
$Address = "";
$Tel1 = "";
$Tel2 = "";
$LocationX = 0;
$LocationX1 = 0;
$LocationX2 = 0;
$LocationY = 0;
$LocationY1 = 0;
$LocationY2 = 0;
$CoverImg = "";
$StartTime = "";
$StartTime1 = "";
$StartTime2 = "";
$EndTime = "";
$EndTime1 = "";
$EndTime2 = "";
$RestStartTime = "";
$RestStartTime1 = "";
$RestStartTime2 = "";
$RestEndTime = "";
$RestEndTime1 = "";
$RestEndTime2 = "";
$Active = "Y";
$LoginUserID = "";
$KindID = 0;
$KindName = "";
$ImgName = "";
$ImgExtension = "";
$ImgInfo;
$save_filePath = "";
$save_DirPath = "";


//ShopID
if(!empty($_GET[$Column1])){
    $ShopID = $_GET[$Column1];
}

//ShopName
if(!empty($_POST[$Column2])){
    $ShopName = $_POST[$Column2];
}

//AreaID
if(!empty($_POST[$Column3])){
    $AreaID = $_POST[$Column3];
}

//CityID
if(!empty($_POST[$Column5])){
    $CityID = $_POST[$Column5];
}

//CityID
if(!empty($_POST[$Column7])){
    $DistrictID = $_POST[$Column7];
}

//Address
if(!empty($_POST[$Column9])){
    $Address = $_POST[$Column9];
}

//Tel1
if(!empty($_POST[$Column10])){
    $Tel1 = $_POST[$Column10];
}

//Tel2
if(!empty($_POST[$Column11])){
    $Tel2 = $_POST[$Column11];
}

//LocationX
//if(!empty($_POST[$Column13]) && !empty($_POST[$Column14])){
//    $LocationX = (double)($_POST[$Column13].".".$_POST[$Column14]);
//}
if(!empty($_POST[$Column12])){
    $LocationX = doubleval($_POST[$Column12]);
}

//LocationY
//if(!empty($_POST[$Column16]) && !empty($_POST[$Column17])){
//    $LocationY = (double)($_POST[$Column16].".".$_POST[$Column17]);
//}
if(!empty($_POST[$Column15])){
    $LocationY = doubleval($_POST[$Column15]);
}

//CoverImg
if(!empty($_POST[$Column18])){
    $CoverImg = $_POST[$Column18];
}
if(!empty($_FILES[$Column18])){
    $ImgInfo = pathinfo($_FILES[$Column18]["name"]);
}

//StartTime
if(!empty($_POST[$Column19])){
    $StartTime = (explode(":",$_POST[$Column19]))[0].(explode(":",$_POST[$Column19]))[1];
}
//if(!empty($_POST[$Column20]) && !empty($_POST[$Column21])){
//    $StartTime = $_POST[$Column20].$_POST[$Column21];
//}

//EndTime
if(!empty($_POST[$Column22])){
    $EndTime = (explode(":",$_POST[$Column22]))[0].(explode(":",$_POST[$Column22]))[1];
}
//if(!empty($_POST[$Column23]) && !empty($_POST[$Column24])){
//    $EndTime = $_POST[$Column23].$_POST[$Column24];
//}

//RestStartTime
if(!empty($_POST[$Column25])){
    $RestStartTime = (explode(":",$_POST[$Column25]))[0].(explode(":",$_POST[$Column25]))[1];
}
//if(!empty($_POST[$Column26]) && !empty($_POST[$Column27])){
//    $RestStartTime = $_POST[$Column26].$_POST[$Column27];
//}

//RestEndTime
if(!empty($_POST[$Column28])){
    $RestEndTime = (explode(":",$_POST[$Column28]))[0].(explode(":",$_POST[$Column28]))[1];
}
//if(!empty($_POST[$Column29]) && !empty($_POST[$Column30])){
//    $RestEndTime = $_POST[$Column26].$_POST[$Column27];
//}

//Active
if(empty($_POST[$Column31])){
    $Active = "N";
}

//KindID
if(!empty($_POST[$Column32])){
    $KindID = $_POST[$Column32];
}

//KindName
if(!empty($_POST[$Column33])){
    $KindName = $_POST[$Column33];
}

if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = $_SESSION ['LoginUserID'];
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//新增
if (!empty($_POST[$ButtonAdd])) {

    $ImgName = $ImgInfo["filename"];
    if($ImgName !== ""){
        $ImgExtension = $ImgInfo["extension"];
        $rand_name = rand(1000, 9999);
        $ImgNameNew = time().$rand_name.".".$ImgExtension;
        $CoverImg = $obj->GetImgDBURL().$ImgNameNew;
        $save_DirPath = $obj->GetImgSaveURL();
        $save_filePath = $save_DirPath.$ImgNameNew;
        
        if(!is_dir($save_DirPath)){
            if(!mkdir($save_DirPath)){
                $obj->setMessage("圖片更新失敗！", "danger");
                return;    
            }
        }
        if(file_exists($save_filePath)){
            if(!unlink($save_filePath)){
                $obj->setMessage("圖片更新失敗！", "danger");
                return;
            }
        }
        if(!move_uploaded_file($_FILES[$Column18]["tmp_name"],$save_filePath)){
            $obj->setMessage("圖片更新失敗！", "danger");
            return;
        }
    }   
    
    $sql = " Insert into Shop(ShopName, KindID, AreaID, CityID, DistrictID, Address, Tel1, Tel2, LocationX, LocationY, CoverImg, StartTime, EndTime, RestStartTime, RestEndTime, Active, CreatedUserID) "
          ." Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
    $params = array($ShopName, $KindID, $AreaID, $CityID, $DistrictID, $Address, $Tel1, $Tel2, $LocationX, $LocationY, $CoverImg, $StartTime, $EndTime, $RestStartTime, $RestEndTime, $Active, $LoginUserID); 
    $res = $obj->SQLExcute($sql, $params);
    
    if ($res === false) { 
        $obj->setMessage("資料新增失敗！", "danger");
        return;
    }
    else{
        $obj->setMessage("資料新增成功！", "success");
    }
    
    
}

//更新
if (!empty($_POST[$ButtonUpdate])) {

    $ImgName = $ImgInfo["filename"];
    if($ImgName !== ""){
        $ImgExtension = $ImgInfo["extension"];
        $rand_name = rand(1000, 9999);
        $ImgNameNew = time().$rand_name.".".$ImgExtension;
        $CoverImg = $obj->GetImgDBURL().$ImgNameNew;
        $save_DirPath = $obj->GetImgSaveURL();
        $save_filePath = $save_DirPath.$ImgNameNew;
        
        if(!is_dir($save_DirPath)){
            if(!mkdir($save_DirPath)){
                $obj->setMessage("圖片更新失敗！", "danger");
                return;    
            }
        }
        if(file_exists($save_filePath)){
            if(!unlink($save_filePath)){
                $obj->setMessage("圖片更新失敗！", "danger");
                return;
            }
        }
        if(!move_uploaded_file($_FILES[$Column18]["tmp_name"],$save_filePath)){
            $obj->setMessage("圖片更新失敗！", "danger");
            return;
        }
    }  
    
    $sql = " Update Shop "
          ." Set ShopName = ?, KindID = ?, AreaID = ?, CityID = ?, DistrictID = ?, Address = ?, Tel1 = ?, Tel2 = ?, LocationX = ?, LocationY = ?, CoverImg = ?, StartTime = ?, EndTime = ?, RestStartTime = ?, RestEndTime = ?, Active = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where ShopID = ?; ";
    $params = array($ShopName, $KindID, $AreaID, $CityID, $DistrictID, $Address, $Tel1, $Tel2, $LocationX, $LocationY, $CoverImg, $StartTime, $EndTime, $RestStartTime, $RestEndTime, $Active, $LoginUserID, $ShopID); 
    $res = $obj->SQLExcute($sql, $params);

    if ($res  === false) {
        $obj->setMessage("資料更新失敗！", "danger");
        return;
    }
    else{
       $obj->setMessage("資料更新成功！", "success"); 
    }
    
}


//從查詢畫面點1擊編輯按鈕進入此頁面
//取得要編輯的城市資料
if (!empty($_GET[$Column1])) {
    $isUpdate = true;
    $ShopID = $_GET[$Column1];
    
    $sql = " Select s.ShopID as ShopID, s.ShopName as ShopName, s.KindID as KindID, k.KindName as KindName, s.AreaID as AreaID, a.AreaName as AreaName, s.CityID as CityID, c.CityName as CityName, s.DistrictID as DistrictID, d.DistrictName as DistrictName, "
          ." s.[Address] as [Address], s.Tel1 as Tel1, s.Tel2 as Tel2, s.LocationX as LocationX, s.LocationY as LocationY, s.CoverImg as CoverImg, s.StartTime as StartTime, s.EndTime, s.RestStartTime as RestStartTime, s.RestEndTime as RestEndTime ,s.Active as Active "  
          ." From Shop as s Inner Join Area as a on s.AreaID = a.AreaID inner join "
          ." City as c on s.CityID = c.CityID inner join "
          ." District as d on s.DistrictID = d.DistrictID inner join "
          ." Kind as k on s.KindID = k.KindID "
          ." Where s.ShopID = ?; ";
    $params = array($ShopID); 
    $stmt_ShopByID = $obj->GetData($sql, $params);
    
    if ($stmt_ShopByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_ShopByID, SQLSRV_FETCH_ASSOC)){
        $ShopName = $row[$Column2];
        $AreaID = $row[$Column3];
        $AreaName = $row[$Column4];
        $CityID = $row[$Column5];
        $CityName = $row[$Column6];
        $DistrictID = $row[$Column7];
        $DistrictName = $row[$Column8];
        $Address = $row[$Column9];
        $Tel1 = $row[$Column10];
        $Tel2 = $row[$Column11];
        $LocationX = $row[$Column12];
        $LocationX1 = (explode(".",$row[$Column12]))[0];
        $LocationX2 = (explode(".",$row[$Column12]))[1];
        $LocationY = $row[$Column15];
        $LocationY1 = (explode(".",$row[$Column15]))[0];
        $LocationY2 = (explode(".",$row[$Column15]))[1];
        $CoverImg = $row[$Column18];
//        $StartTime = $row[$Column19];
        $StartTime1 = mb_substr($row[$Column19],0,2);
        $StartTime2 = mb_substr($row[$Column19],0,2);
        $StartTime = $StartTime1.":".$StartTime2;
//        $EndTime = $row[$Column22];
        $EndTime1 = mb_substr($row[$Column22],0,2);
        $EndTime2 = mb_substr($row[$Column22],0,2);
        $EndTime = $EndTime1.":".$EndTime2;
//        $RestStartTime = $row[$Column25];
        $RestStartTime1 = mb_substr($row[$Column25],0,2);
        $RestStartTime2 = mb_substr($row[$Column25],0,2);
        $RestStartTime = $RestStartTime1.":".$RestStartTime2;
//        $RestEndTime = $row[$Column28];
        $RestEndTime1 = mb_substr($row[$Column28],0,2);
        $RestEndTime2 = mb_substr($row[$Column28],0,2);
        $RestEndTime = $RestEndTime1.":".$RestEndTime2;
        $Active = $row[$Column31];
        $KindID = $row[$Column32];
        $KindName = $row[$Column33];        
    }
}

//取得種類資料
$sql = " Select * From Kind Where Active = 'Y'; ";
$stmt_Kind = $obj->GetData($sql);

if ($stmt_Kind === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

//取得地區資料
$sql = " Select * From Area; ";
$stmt_Area = $obj->GetData($sql);

if ($stmt_Area === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

//取得城市資料
$sql = " Select * From City Where Active = 'Y'; ";
$stmt_City = $obj->GetData($sql);

if ($stmt_City === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

//取得行政區資料
$sql = " Select * From District Where Active = 'Y'; ";
$stmt_District = $obj->GetData($sql);

if ($stmt_District === false){
    die($obj->formatErrors(sqlsrv_errors()));
}

?>
