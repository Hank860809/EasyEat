<?php
session_start();

if (isset($_POST['Login'])) {
    $account = $_POST['Account'];
    $password = $_POST['Password'];
    
    if (!(mb_strlen($account, mb_detect_encoding($account)) == strlen($account))) {
        echo "<script>alert('帳號欄位請輸入英文字母 或 數字！')</script>";
        return;
    }
    
    require '../DataBase/DBFunction.php';
    $obj = new DbFunction();  
    
    $sql = " Select UserID, UserName, Active "
          ." From [User] "
          ." Where Account=? and Password=?; "; 
    $params = array($account, $password); 
    $res = $obj->GetData($sql, $params);
    
    if ($res === false) { 
        echo "<script>alert('登入時發生錯誤！')</script>";
        die(formatErrors(sqlsrv_errors()));
    }

    $row_count = sqlsrv_num_rows($res);
    if ($row_count === false) { 
        echo "<script>alert('登入時發生錯誤！')</script>";
        die(formatErrors(sqlsrv_errors()));
    }
    if ($row_count == 0) { 
        echo "<script>alert('找不到登入者資料！')</script>";
    } 
    else {
        
        while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
            $UserID = intval($row['UserID']);
            $a = ($UserID != 1);
            $b = ($UserID !== 1);
            $c = ($UserID !== 1 || $UserID !== 2);
            if($row['Active'] !== "Y"){ //檢查是否啟用
                echo "<script>alert('帳號尚未啟用！')</script>";
            }
            else if ($UserID !== 1 and $UserID !== 2 and $UserID !== 3 and $UserID !== 4 and $UserID !== 5 and $UserID !== 6 and $UserID !== 7){ //尚未開發使用者群組，先用此方式過濾 
                echo "<script>alert('無系統管理員權限，無法登入！')</script>";
            }
            else{
                $_SESSION['LoginUserID'] = $row['UserID'];
                $_SESSION['LoginUserName'] = $row['UserName'];
                header('location:Empty.php');
            }
        }      
    }
}
?>