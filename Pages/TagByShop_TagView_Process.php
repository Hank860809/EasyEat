<?php
session_start();

if (!(isset($_SESSION ['LoginUserID']))) {
    header('location:../index.php');
}

$PageName = "店家標籤資料";
$AddPage = "TagByShop_Edit.php";
$EditPage = "TagByShop_Edit.php";
$DeletePage = "TagByShop_TagView.php";
$BackPage = "TagByShop_ShopView.php";

$ColumnHeader1 = "標籤ID";
$ColumnHeader2 = "標籤名稱";
$ColumnHeader3 = "啟用";
$ColumnHeader4 = "建立時間";
$ColumnHeader5 = "建立者";
$ColumnHeader6 = "更新時間";
$ColumnHeader7 = "更新者";
$ColumnHeader8 = "動作";
$ColumnHeader9 = "店家ID";

$Column1 = "TagID";
$Column2 = "TagName";
$Column3 = "Active";
$Column4 = "CreatedDate";
$Column5 = "CreatedUserName";
$Column6 = "UpdateUserName";
$Column7 = "UpdateDate";
$Column9 = "ShopID";

$HiddenColumn1 = "";
$HiddenColumn2 = "";
$HiddenColumn3 = "";
$HiddenColumn4 = "";
$HiddenColumn5 = "";
$HiddenColumn6 = "";
$HiddenColumn7 = "";
$HiddenColumn8 = "";
$HiddenColumn9 = "hidden";

$ShopID = 0;
$TagID = 0;
$TagName = "";

require'../DataBase/DBFunction.php';
$obj = new DbFunction();

//ShopID
if(!empty($_GET[$Column9])){
    $ShopID = intval($_GET[$Column9]);
}

//刪除
if (isset($_GET[$Column1]) && isset($_GET[$Column2]) && isset($_GET[$Column9])) {
    
    $TagID = intval($_GET[$Column1]);
    $TagName = $_GET[$Column2];
    $ShopID = intval($_GET[$Column9]);
    $status = true;
    
    //=================刪除前檢查=================
    
    //=================執行刪除=================
    if($status === true){
        $sql = " Delete TagByShop "
              ." Where ShopID = ? and TagID = ?;";
        $params = array($ShopID, $TagID); 
        $res = $obj->SQLExcute($sql, $params);
        
        if ($res === false) { 
            die($obj->formatErrors(sqlsrv_errors()));
        }

        $obj->setMessage($ColumnHeader2.":[".$TagName."] 刪除成功！", "success");
    }
}

//=================取得店家標籤資料=================
$sql = " Select ts.ShopID as ShopID, s.ShopName as ShopName, ts.TagID as TagID, t.TagName as TagName, ts.Active as Active, "
      ." ISNULL(CASE WHEN CONVERT(DATE, ts.CreatedDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), ts.CreatedDate, 111) END, '') as CreatedDate, isnull(u.UserName,'') as CreatedUserName, "
      ." ISNULL(CASE WHEN CONVERT(DATE, ts.UpdateDate) = '1900-01-01' THEN '' ELSE CONVERT(CHAR(10), ts.UpdateDate, 111) END, '') as UpdateDate, isnull(u2.UserName,'') as UpdateUserName "
      ." From TagByShop as ts Inner Join Shop as s on ts.ShopID = s.ShopID inner join "
      ." Tag as t on ts.TagID = t.TagID left join "
      ." [user] as u on u.UserID = ts.CreatedUserID left join "
      ." [user] as u2 on u2.UserID = ts.UpdateUserID "
      ." Where ts.ShopID = ?";
$params = array($ShopID);
$stmt_TagByShop = $obj->GetData($sql, $params);
 
if ($stmt_TagByShop === false){
    die($obj->formatErrors(sqlsrv_errors()));
}
    
?>
