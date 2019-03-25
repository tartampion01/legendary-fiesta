<?php
class IL_Database{
 
    // specify your own database credentials
//    private $host     = "127.0.0.1";
//    private $db_name  = "reseaudynamique";
//    private $username = "reseaudynamique";
//    private $password = "TT67xgw!**";
//    public  $conn;
     
    private $host     = "127.0.0.1";
    private $db_name  = "interlivraison";
    private $username = "interlivraison";
    private $password = "TT67xgw!**";
    public  $conn;
    
    // get the database connection
    public static function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
    
    public static function getConn()
    {
        $db = new IL_Database();
        $db->conn = null;        
        
        try{
            $db->conn = mysqli_connect($db->host, $db->username, $db->password, $db->db_name);            
        }catch(Exception $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $db->conn;
    }
}
?>