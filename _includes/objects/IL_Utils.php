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
            case 0: echo '<a href="livraison.php?r='.mt_rand(0, 999999999). '" class="menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class="menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class="menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php?r='.mt_rand(0, 999999999). '" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            // ADMIN
            case 1: echo '<a href="livraison.php?r='.mt_rand(0, 999999999). '" class= "menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php?r='.mt_rand(0, 999999999). '" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <a href="utilisateurs.php?r='.mt_rand(0, 999999999). '" class="menuitem offline_hide utilisateurs"><button name="utilisateurs" class=""><div class="label">Utilisateurs</div></button></a>
                          <button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            default:echo '<a href="livraison.php?r='.mt_rand(0, 999999999). '"" class= "menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php?r='.mt_rand(0, 999999999). '"" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
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
    
    public static function getAutoComplete($nomListe, $useRank=0, $succursale){
        
        $data = "";
        $sql = "";
        $option_o = "<option value='";
        $option_c = "</option>";
        
        $conn = IL_Database::getConn();
        
        if( $useRank == 0 )
            $sql = "SELECT nomValeur FROM autocomplete WHERE nomListe='$nomListe' AND succursale='$succursale' ORDER BY nomValeur";
        else
            $sql = "SELECT nomValeur FROM autocomplete WHERE nomListe='$nomListe' AND succursale='$succursale' ORDER BY rank";    
        
        $result = mysqli_query($conn, $sql);

        try
        {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $data .= $option_o .  $row["nomValeur"] . "'>" . $option_c;
                }
            }
        }
        catch (Exception $e) {
            //echo $e;
        }

        return $data == "" ? $option_o . $option_c : $data;
    }
    
    public static function getBonCommande($succursale){
        
        /*
        $data = "<th># de commande</th>";
        $data .= "<th>Fournisseur</th>";
        $data .= "<th>AV</th>";
        $data .= "<th>Heure</th>";
        $data .= "<th>Date</th>";
        $data .= "<th>Chauffeur</th>";
        $data .= "<th>Statut</th>";
        $data .= "<th>Commentaire</th>";
        $data .= "<th>X</th>";
         * 
         */
        $data = '<tr class="trHeader">
                    <td class="edit"></td>
                    <td class="bonCommande"># de commande</td>
                    <td class="fournisseur">Fournisseur</td>
                    <td class="av">AV</td>
                    <td class="heure">Heure</td>
                    <td class="date">Date</td>
                    <td class="chauffeur">Chauffeur</td>
                    <td class="lienChauffeur"></td>
                    <td class="statut">Statut</td>
                    <td class="commentaire">Commentaire</td>
                    <td class="ajouter"></td>
                </tr>';
        $conn = IL_Database::getConn();
        mysqli_set_charset($conn,"utf8");
        
        $sql = "SELECT pkBonCommande, bonCommande, fournisseur, av, heure, date, chauffeur, statut, commentaire, archive FROM bon_commande WHERE succursale='$succursale' AND archive=0";
        
        $result = mysqli_query($conn, $sql);
        
        try
        {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $pkBonCommande = $row["pkBonCommande"];
                    
                    $data .= "<tr id='row_" . $pkBonCommande . "' class=''>";
                    $data .= "<td id='cbEdit_" . $pkBonCommande . "' class='edit'><input title='Modifier cette ligne' type='radio' id='radioEdit' name='radioEdit' class='chkEditRow' onclick='editMode(this," . $pkBonCommande . ");' value='" . $pkBonCommande . "' alt='Modifier'></td>";
                    $data .= "<td class='bonCommande'><input type='text' id='tbBonCommande_" . $pkBonCommande . "' class='tbBonCommande' maxlength='6' value='" . $row["bonCommande"] . "'></input></td>";
                    $data .= "<td class='fournisseur'><input type='text' id='tbFournisseur_" . $pkBonCommande . "' class='tbFournisseur' list='dlFournisseur' value='" . $row["fournisseur"] . "'></input></td>";
                    $data .= "<td class='av'><input type='text' id='tbAV_" . $pkBonCommande . "' class='tbAffichage av' list='dlAV' value='" . $row["av"] . "'></input></td>";
                    $data .= "<td class='heure'><input type='text' id='tbHeure_" . $pkBonCommande . "' class='tbHeure' value='" . $row["heure"] . "'></input></td>";
                    $data .= "<td class='date'><input type='text' id='tbDate_" . $pkBonCommande . "' class='tbDate' value='" . $row["date"] . "'></input></td>";
                    $data .= "<td class='chauffeur'><input type='text' id='tbChauffeur_" . $pkBonCommande . "' class='tbChauffeur' list='dlChauffeur' value='" . $row["chauffeur"] . "'></td>";
                    $data .= "<td class='lienChauffeur'><a href='https://my31.geotab.com/' target='_blank'><img src='../assets/images/iconePlanete.png' /></a></td>";
                    
                    $statut = "";
                    if( $row['statut'] == 'En cours')
                    {
                        $statut = '<select class="En cours" onchange="updateStatut(this,\'' . $row["pkBonCommande"] . '\');">';
                        $statut .= '<option selected>En cours</option><option>Attribue</option><option>Recu</option></select>';
                    }
                    elseif( $row['statut'] == 'Attribue' )
                    {
                        $statut = '<select class="Attribue" onchange="updateStatut(this,\'' . $row["pkBonCommande"] . '\');">';
                        $statut .= '<option>En cours</option><option selected>Attribue</option><option>Recu</option></select>';
                    }
                    else
                    {
                        $statut = '<select class="Recu" onchange="updateStatut(this,\'' . $row["pkBonCommande"] . '\');">';
                        $statut .= '<option>En cours</option><option>Attribue</option><option selected>Recu</option></select>';
                    }
                    
                    $data .= "<td class='statut'>$statut</td>";
                    $data .= '<td class="commentaire"><input type="text" id="tbCommentaire_' . $pkBonCommande . '" class="tbCommentaire" value="' . htmlspecialchars($row["commentaire"]) . '"></input></td>';
                    $data .= "<td class='ajouter'>" . "<input title='Sauvegarder la ligne' id='btnAjouter_" . $pkBonCommande . "' type='button' class='boutonSaveLigneHidden' onclick='saveRow(" . $row["pkBonCommande"] . ");' alt='Sauvegarder'>";
                    $data .= "<input type='button' title='Enlever la ligne' class='boutonDelete' onclick='deleteRow(" . $row["pkBonCommande"] . ");' alt='Supprimer'></td></tr>";
                }
                
                $data .= '<tr><td class="edit">
                              <img id="btnDeselectionner" style="visibility:hidden;" onclick="deselectionner();" src="../assets/images/iconeRemove.png" alt=""/></td>
                              <td class="bonCommande"></td>
                              <td class="fournisseur"></td>
                              <td class="av"></td>
                              <td class="heure"></td>
                              <td class="date"></td>
                              <td class="chauffeur"></td>
                              <td class="lienChauffeur"></td>
                              <td class="statut"></td>
                              <td class="commentaire"></td>
                              <td class="ajouter"></td></tr>';
            }
        }
        catch (Exception $e) {
            //echo $e;
        }
        
        return $data;
    }
    
    public static function addBonCommande($bonCommande, $fournisseur, $av, $heure, $date, $chauffeur, $statut, $commentaire, $succursale){
        
        $conn = IL_Database::getConn();
        
        $bonCommande = mysqli_real_escape_string($conn, $bonCommande);
        $fournisseur = mysqli_real_escape_string($conn, $fournisseur);
        $av = mysqli_real_escape_string($conn, $av);
        $heure = mysqli_real_escape_string($conn, $heure);
        $date = mysqli_real_escape_string($conn, $date);
        $chauffeur = mysqli_real_escape_string($conn, $chauffeur);
        $statut = mysqli_real_escape_string($conn, $statut);
        $commentaire = mysqli_real_escape_string($conn, $commentaire);
        $succursale = mysqli_real_escape_string($conn, $succursale);

        $sql = "INSERT INTO bon_commande(bonCommande,fournisseur,av,heure,date,chauffeur,statut,commentaire,succursale) ";
        $sql .= "VALUES('$bonCommande','$fournisseur','$av','$heure','$date','$chauffeur','$statut','$commentaire','$succursale')";

        mysqli_query($conn, $sql);
        $this->id = $conn->insert_id;
        
        return "Bon de commande ajouté";
    }
    
    public static function deleteBonCommande($pkBonCommande)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE bon_commande SET archive=1 WHERE pkBonCommande='$pkBonCommande'");
        
        return "Bon de commande effacé";
    }
    
    public static function updateStatut($pkBonCommande, $nouveauStatut)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE bon_commande SET statut='$nouveauStatut' WHERE pkBonCommande='$pkBonCommande'");
        
        return "Bon de commande modifié";
    }
    
    public static function updateLigne($pkBonCommande, $bonCommande, $fournisseur, $av, $heure, $date, $chauffeur, $commentaire, $succursale)
    {
        $conn = IL_Database::getConn();
        
        $bonCommande = mysqli_real_escape_string($conn, $bonCommande);
        $fournisseur = mysqli_real_escape_string($conn, $fournisseur);
        $av = mysqli_real_escape_string($conn, $av);
        $heure = mysqli_real_escape_string($conn, $heure);
        $date = mysqli_real_escape_string($conn, $date);
        $chauffeur = mysqli_real_escape_string($conn, $chauffeur);
        $commentaire = mysqli_real_escape_string($conn, $commentaire);
        $succursale = mysqli_real_escape_string($conn, $succursale);
        
        $sql = "UPDATE bon_commande SET bonCommande='$bonCommande', fournisseur='$fournisseur', av='$av', heure='$heure', date='$date', chauffeur='$chauffeur', commentaire='$commentaire', succursale='$succursale' WHERE pkBonCommande='$pkBonCommande'";

        mysqli_query($conn, $sql );
        
        return "Bon de commande modifié";
    }
}
?>