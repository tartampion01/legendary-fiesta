<?php
class IL_Users{
    public $id = 0;
    public $username = '';
    public $level = '';
    public $actif = true;
    public $password = '';
    public $hash_key = '';
    
    public function load($id = 0, $hash_key = '', $username){
        $database = new IL_Database();
        $conn = $database->getConn();
        
        if($id>0){
            $id = mysqli_real_escape_string($conn, $id);
            $sql = "SELECT users FROM clients WHERE client_id=$id";
        }
        elseif($hash_key != ''){
            $hash_key = mysqli_real_escape_string($conn, $hash_key);
            $sql = "SELECT * FROM users WHERE hash_key='$hash_key'";
        }
        elseif($username != '')
        {
            $username = mysqli_real_escape_string($conn, $username);
            $sql = "SELECT * FROM users WHERE username='$username'";
        }
        else
            return false;

        $result = mysqli_query($conn, $sql);
        $r = mysqli_fetch_array($result);
    
        $this->id = $r['id_user'];
        $this->username = $r['username'];
        $this->level = $r['level'];
        $this->actif = $r['actif'] == 1;

        return true;
    }
    
    public function save(){
        $database = new IL_Database();
        $conn = $database->getConn();
        
        $nom = mysqli_real_escape_string($conn, $this->username);
        $actif = mysqli_real_escape_string($conn, $this->actif);
        $level = mysqli_real_escape_string($conn, $this->level);       
        $password = password_hash(mysqli_real_escape_string($conn, $this->password),PASSWORD_DEFAULT);
        
        $sql = "UPDATE users SET nom='$nom',level='$level',actif='$actif',numero_apt='$numero_apt',"
                . "password='$password' WHERE id_user=".$this->id;
        
        mysqli_query($conn, $sql);
        
        return true;
    }
    
    /**
     * Clients : create, Disposable if customer is on checkout and orders without creating account
     * @param    bool
     * @return   bool
     */
    public function create($disposable = 0){
        global $conn;
        
        $username = mysqli_real_escape_string($conn, $this->username);
        $level = mysqli_real_escape_string($conn, $this->level);
        $actif = mysqli_real_escape_string($conn, $this->actif);
        $password = password_hash(mysqli_real_escape_string($conn, $this->password),PASSWORD_DEFAULT);
        $hash_key = mysqli_real_escape_string($conn, $this->getHashKey());
        
        $sql = "INSERT INTO users(username,level,actif,password,hash_key) ";
        $sql .= "VALUES('$username','$level','$actif','$password','$hash_key')";

        mysqli_query($conn, $sql);
        $this->id = $conn->insert_id;
        
        return true;
    }
    
    private function getHashKey($randomIdLength = 10){
        //generate a random id encrypt it and store it in $rnd_id 
        $rnd_id = crypt(uniqid(rand(),1)).crypt(uniqid(rand(),1)); 

        //to remove any slashes that might have come 
        $rnd_id = strip_tags(stripslashes($rnd_id)); 

        //Removing any . or / and reversing the string 
        $rnd_id = str_replace(".","p",$rnd_id); 
        $rnd_id = str_replace("$","s",$rnd_id); 
        $rnd_id = str_replace("/","s",$rnd_id); 
        $rnd_id = strrev($rnd_id); 

        //finally I take the first n characters from the $rnd_id 
        $rnd_id = substr($rnd_id, 0, $randomIdLength); 

        return $rnd_id;
    }
    
    public function updatePassword($newPassword)
    {
        $this->password = $newPassword;
        
        return $this->save();
    }
    
    public static function getAllUsers()
    {
        global $conn;
        $sql = "SELECT * FROM users WHERE actif=1";

        return mysqli_query($conn, $sql);
    }
}
?>