<?php

class DBConnect {

    private $ImgDBURL = "http://52.187.36.171/testcam/"; //圖片儲存路徑 http://52.187.36.171/testcam/
    private $ImgSaveURL = "../../testcam/"; //圖片儲存路徑
    
    private static $UseDataBase = "mssql"; //使用 mssql or mysql
    
    /* MSSQL 連線參數 */
    private $MSSQL_host = "127.0.0.1"; //資料庫位置
    private $MSSQL_port = "0"; //資料庫位置
    private $MSSQL_user = "sa"; //資料庫帳號
    private $MSSQL_pass = "1234"; //資料庫密碼
    private $MSSQL_dbname = "easyeat"; //資料庫名稱
    private $MSSQL_connection; //連線資訊
    
    /* MySQL 連線參數 */
    private $MySQL_host = "127.0.0.1"; //資料庫位置
    private $MySQL_port = "3306"; //資料庫位置
    private $MySQL_user = "root"; //資料庫帳號
    private $MySQL_pass = ""; //資料庫密碼
    private $MySQL_dbname = "easyeat"; //資料庫名稱
    private $MySQL_connection; //連線資訊
   

    //建構子
    public function __construct() {

        if (self::$UseDataBase == "mssql") { //MSSQL 連線設定
            $connectionInfo = array("Database" => $this->MSSQL_dbname, "UID" => $this->MSSQL_user, "PWD" => $this->MSSQL_pass, "CharacterSet" => "UTF-8");
            $this->MSSQL_connection = sqlsrv_connect($this->MSSQL_host, $connectionInfo);
            
            if ($this->MSSQL_connection) {
                return true;
            } else {
                die(print_r(sqlsrv_errors(), true));
                return false;
            }
        } else { //MySQL 連線設定
        }
    }

    //取得連線資訊
    public function getConnection() {
        if (self::$UseDataBase == "mssql") { //回傳MSSQL 連線設定
            return $this->MSSQL_connection;
        } else { //回傳MySQL 連線設定
        }
    }
    
    public function GetImgSaveURL(){
        return $this->ImgSaveURL;
    }
    
    public function GetImgDBURL(){
        return $this->ImgDBURL;
    }
}

?>
