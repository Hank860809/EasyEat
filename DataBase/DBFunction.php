<?php

require_once 'DBConnect.php'; //import DBConnect.php

class DbFunction {

    var $conn; //連線資訊
    private $ImgSaveURL;
    private $ImgDBURL;

    /**
     * 建構子
     */
    public function __construct() {
        $obj = new DBConnect();
        $this->conn = $obj->getConnection();
        $this->ImgSaveURL = $obj->GetImgSaveURL();
        $this->ImgDBURL = $obj->GetImgDBURL();
    }
   
    
    /**
     * 執行SQL語法
     * @param String $sql <p>SQL語法</p>
     * @param Array $params <p>對應參數<b>(選填)</b></p>
     * @param String $message <p>訊息內容<b>(選填)</b></p>
     * @param String $msgType <p>訊息型態<b>(選填)</b></p>
     * @return mixed <p>回傳查詢結果</p>
     */
    function SQLExcute($sql, $params = "") {   
        try{
            $stmt;
            
            if ($params == "")
                $stmt = sqlsrv_query($this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
            else
                $stmt = sqlsrv_query($this->conn, $sql, $params, array("Scrollable" => SQLSRV_CURSOR_KEYSET));
            
            if ($stmt === false) { 
                return false;
            } 

            return true;
            
        } catch (Exception $ex){
            echo "Error:".$ex;
            return false;
        }
    }
    
    /**
     * 取得資料
     * @param String $sql <p>SQL語法</p>
     * @param Array $params <p>對應參數<b>(選填)</b></p>
     * @param String $message <p>訊息內容<b>(選填)</b></p>
     * @param String $msgType <p>訊息型態<b>(選填)</b></p>
     * @return mixed <p>回傳查詢結果</p>
     */
    function GetData($sql, $params = "") {   
        try{
            $stmt;
            
            if ($params == "")
                $stmt = sqlsrv_query($this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
            else
                $stmt = sqlsrv_query($this->conn, $sql, $params, array("Scrollable" => SQLSRV_CURSOR_KEYSET));
            
            if ($stmt === false) {               
                return false;
            } 

            return $stmt;
            
        } catch (Exception $ex){
            echo "Error:".$ex;
            return false;
        }
    }
    
    /**
     * 回傳錯誤訊息內容
     * @param String $errors <p>錯誤訊息</p>
     */
    function formatErrors($errors){
        foreach($errors as $dictError){
            echo "Code:".$dictError["code"]."</br>";
            echo "SQLSTATE:".$dictError["SQLSTATE"]."</br>";
            echo "Message:".$dictError["message"]."</br>";
        }
    }
    
    /**
     * 設定顯示訊息
     * @param String $msg <p>訊息內容</p>
     * @param String $msgtype <p>訊息型態</p>
     */
    function setMessage($msg, $msgtype){
        $_SESSION ['message'] = "</br>".$msg."</br></br>";
        $_SESSION ['msg_type'] = $msgtype;
    }
    
    public function GetImgSaveURL(){
        return $this->ImgSaveURL;
    }
    
    public function GetImgDBURL(){
        return $this->ImgDBURL;
    }

}

?>