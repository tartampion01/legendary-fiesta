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
        $conn = Database::getConn();
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
            case 0: echo '<a href="livraison.php" class="menuitem"><button name="livrer" class=""><div class="label">Livrer</div></button></a>
                          <a href="horsligne.php" class="menuitem"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          <a href="rechercher.php" class="menuitem offline_hide"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <button name="logout" class="menuitem offline_hide" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            // ADMIN
            case 1: echo '<a href="livraison.php" class="menuitem"><button name="livrer" class=""><div class="label">Livrer</div></button></a>
                          <a href="horsligne.php" class="menuitem"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          <a href="rechercher.php" class="menuitem offline_hide"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <a href="utilisateurs.php" class="menuitem offline_hide"><button name="utilisateurs" class=""><div class="label">Utilisateurs</div></button></a>
                          <button name="logout" class="menuitem offline_hide" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
        }
    }
    
}
?>