<?PHP

class IL_Header{
    /*
     * public static function getPageTitle($pageName)
     */    
    public static function getPageTitle($pageName)
    {   
        $title = "";
        
        switch($pageName){
            case "default.php":$title = "Inter Livraison - Accueil";break;
            case "horsligne.php":$title = "Inter Livraison - Hors Ligne";break;
            case "livraisin.php":$title = "Inter Livraison";break;
            case "login.php":$title = "Inter Livraison - Connexion";break;
            case "logout.php":$title = "Inter Livraison - Logout";break;
            case "rechercher.php":$title = "Inter Livraison - Rechercher";break;
            case "utilisateurs.php":$title = "Inter Livraison - Utilisateurs";break;
            default:;
        }
        
        echo $title == "" ? "INTER-Livraison" : $title;
    }
    
}
?>