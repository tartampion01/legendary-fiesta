<?php
class IL_Utils
{
    public static function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }
    
    /**
     * 
     * @param type $username
     * @param type $password
     * @return type returns -1 if username/password combination is invalid
     * @ 0 = user
     * @ 1 = admin
     * @ 2 = user & admin
     */
    public static function login($username, $password)
    {
        $conn = IL_Database::getConn();
        $sql = "SELECT level FROM users WHERE username='$username' AND password='$password'";

        $level = -1;
        try
        {
            $level = $conn->query($sql)->fetch_object()->level;
            if( $level == NULL ) // username password combination is invalid
                $level = -1;
        }
        catch (Exception $e) {
            //echo $e;
        }

        return $level;
    }
    
    public static function getUserMenu($level)
    {
        switch($level)
        {
            // USER
            case 0: echo '<a href="livraison.php" class="menuitem offline_hide"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class="menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class="menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php" class="menuitem offline_hide"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <button name="logout" class="menuitem offline_hide" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            // ADMIN
            case 1: echo '<a href="livraison.php" class= "menuitem offline_hide"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php" class="menuitem offline_hide"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <a href="utilisateurs.php" class="menuitem offline_hide"><button name="utilisateurs" class=""><div class="label">Utilisateurs</div></button></a>
                          <button name="logout" class="menuitem offline_hide" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            default:echo '<a href="livraison.php" class= "menuitem offline_hide"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php" class="menuitem offline_hide"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <button name="logout" class="menuitem offline_hide" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
        }
    }
    
    /***
     * For autocomplete
     */
    public static function getDistinctDestinataires(){
        
        $destinataires = "";
        $option_o = "<option>";
        $option_c = "</option>";
        
        $conn = IL_Database::getConn();
        $sql = "SELECT * FROM viewDestinataires";
        
        $result = mysqli_query($conn, $sql);
        
        try
        {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $destinataires .= $option_o .  $row["destinataire"] . $option_c;
                }
            }
        }
        catch (Exception $e) {
            //echo $e;
        }

        return $destinataires == "" ? $option_o . $option_c : $destinataires;
    }
    
}
?>