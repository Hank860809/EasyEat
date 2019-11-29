<?php
session_start();

if (!isset($_SESSION ['LoginUserID'])) {
    header('location:../index.php');
}

//前端變數
$PageName = "使用者資料";
$AddPage = "";
$EditPage = "";
$DeletePage = "";
$BackPage = "User_View.php";

$ColumnHeader1 = "使用者ID";
$ColumnHeader2 = "使用者名稱";
$ColumnHeader3 = "使用者帳號";
$ColumnHeader4 = "使用者密碼";
$ColumnHeader5 = "Email";
$ColumnHeader6 = "啟用";
$ColumnHeader7 = "手機";

$Column1 = "UserID";
$Column2 = "UserName";
$Column3 = "Account";
$Column4 = "Password";
$Column5 = "Email";
$Column6 = "Active";
$Column7 = "CellPhone";

$OptionValue1 = "選擇使用者群組";

$ButtonAdd = "UserAdd";
$ButtonUpdate = "UserUpdate";

//後端變數
$isUpdate = false;
$UserID = "";
$UserName = "";
$Account = "";
$Password = "";
$Email = "";
$Active = "Y";
$CellPhone = "";
$LoginUserID = "";

if(!empty($_GET[$Column1])){
    $UserID = $_GET[$Column1];
}

if(!empty($_POST[$Column2])){
    $UserName = $_POST[$Column2];
}

if(!empty($_POST[$Column3])){
    $Account = $_POST[$Column3];
}

 if(!empty($_POST[$Column4])){
    $Password = $_POST[$Column4];
}

if(!empty($_POST[$Column5])){
    $Email = $_POST[$Column5];
}

if(empty($_POST[$Column6])){
    $Active = "N";
}

if(!empty($_POST[$Column7])){
    $CellPhone = $_POST[$Column7];
}

if(!empty($_SESSION ['LoginUserID'])){
    $LoginUserID = $_SESSION ['LoginUserID'];
}

require '../DataBase/DBFunction.php';
$obj = new DbFunction();

//新增
if (!empty($_POST[$ButtonAdd])) {
    
    if (!(mb_strlen($Account, mb_detect_encoding($Account)) == strlen($Account))) {
        $obj->setMessage("帳號欄位請輸入 英文字母 或 數字！", "danger");
        return;
    }
    
    $sql = " Select 1 From [User] "
          ." Where Account = ?; ";
    $params = array($Account); 
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        $obj->setMessage("資料新增失敗！", "danger");
    }
    
    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) {
        $obj->setMessage("資料新增失敗！", "danger");
    }
    
    if ($row_count > 0) {
        $obj->setMessage("資料新增失敗-使用者帳號已經存在！", "danger");
        return;
    }
    
    $sql = " Insert into [User](UserName, Account, Password, Email, CellPhone, Active, CreatedUserID) "
          ." Values(?, ?, ?, ?, ?, ?, ?); ";
    $params = array($UserName, $Account, $Password, $Email, $CellPhone, $Active, $LoginUserID); 
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

    $sql = " Update [User] "
          ." Set UserName = ?, Password = ?, Email = ?, CellPhone = ?, Active = ?, UpdateUserID = ?, UpdateDate = getdate() "
          ." Where UserID = ?; ";
    $params = array($UserName, $Password, $Email, $CellPhone, $Active, $LoginUserID, $UserID); 
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
    $UserID = $_GET[$Column1];
    
    $sql = " Select u.UserID as UserID, u.UserName as UserName, u.Account as Account, u.[Password] as [Password], u.Email as Email, u.Active as Active "
          ." From [User] as u "
          ." Where u.UserID = ?; ";
    $params = array($UserID); 
    $stmt_UserByID = $obj->GetData($sql, $params);
    
    if ($stmt_UserByID === false){
        die($obj->formatErrors(sqlsrv_errors()));
    }
    
    while ($row = sqlsrv_fetch_array($stmt_UserByID, SQLSRV_FETCH_ASSOC)){
        $UserName = $row[$Column2];
        $Account = $row[$Column3];
        $Password = $row[$Column4];
        $Email = $row[$Column5];
        $Active = $row[$Column6];
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
