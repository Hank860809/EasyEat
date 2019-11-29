<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

//前端變數
$PageName = "標籤資料";
$AddPage = "Tag_Edit.php";
$EditPage = "Tag_Edit.php";
$DeletePage = "Tag_View.php";
$BackPage = "";

$ColumnHeader1 = "標籤ID";
$ColumnHeader2 = "標籤名稱";
$ColumnHeader3 = "啟用";
$ColumnHeader4 = "建立時間";
$ColumnHeader5 = "建立者";
$ColumnHeader6 = "更新時間";
$ColumnHeader7 = "更新者";
$ColumnHeader8 = "動作";

$Column1 = "TagID";
$Column2 = "TagName";
$Column3 = "Active";
$Column4 = "CreatedDate";
$Column5 = "CreatedUserName";
$Column6 = "UpdateUserName";
$Column7 = "UpdateDate";

$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "";
$HiddenColumn4 = "";
$HiddenColumn5 = "";
$HiddenColumn6 = "";
$HiddenColumn7 = "";
$HiddenColumn8 = "";


require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//刪除
if (isset($_GET[$Column1]) && isset($_GET[$Column2])) {
    
    $TagID = $_GET[$Column1];
    $TagName = $_GET[$Column2];
    $status = true;
    
    //=================刪除前檢查=================
    //檢查店家標籤
    $sql = "Select 1 "
          ." From TagByShop "
          ." Where TagID = ?;";
    $params = array($TagID);
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        die($obj->formatErrors(sqlsrv_errors()));
    }

    if ($row_count > 0) {
        $obj->setMessage($ColumnHeader2.":[".$TagName."] 已被使用，無法刪除！", "warning");
        $status = false;
    }
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete Tag "
              ." Where TagID = ?;";
        $params = array($TagID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$TagName."] 刪除成功！", "success");
    }
}

//=================取得行政區資料=================
$sql = " Select t.TagID as TagID, t.TagName as TagName, t.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, t.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), t.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, t.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), t.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From  Tag as t  left join "
      ." [user] as u on u.UserID = t.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = t.UpdateUserID ;";
$stmt_Tag = $obj->GetData($sql);

if ($stmt_Tag === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
