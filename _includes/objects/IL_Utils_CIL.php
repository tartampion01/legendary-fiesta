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
            case 0: echo '<a href="livraison.php" class="menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class="menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class="menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            // ADMIN
            case 1: echo '<a href="livraison.php" class= "menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <a href="utilisateurs.php" class="menuitem offline_hide utilisateurs"><button name="utilisateurs" class=""><div class="label">Utilisateurs</div></button></a>
                          <button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            default:echo '<a href="livraison.php" class= "menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          //<a href="horsligne.php" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          //<a href="horsligne.html" class= "menuitem offline_hide"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
                          '<a href="rechercher.php" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
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
    
    public static function getBonCommande($succursale, $archive, $dateChoisie, $searchQuery=""){
        
        $data = '<tr class="trHeader">';
        if( $archive == 0 )
            $data .= '<th class="edit"></td>
                      <th class="endroitPickup" onclick="sortTable(1)";>Endroit de P/UP&nbsp;<img class="sortableArrows"  src="../assets/images/sortable.png"></img></td>
                      <th class="bonCommande" onclick="sortTable(2)";>No. Commande&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png"></img></td>
                      <th class="noConfirmation" onclick="sortTable(3)";>No. Confirmation&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png"></img></td>
                      <th class="commandePar" onclick="sortTable(4)";>Commandé par&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png"></img></td>
                      <th class="contactFournisseur" onclick="sortTable(5);">Contact Fournisseur&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png"></img></td>
                      <th class="date">Date</td>
                      <th class="heure">Heure</td>
                      <th class="directiveSpeciale" onclick="sortTable(7)";>Directive spéciale&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png"></img></td>
                      <th class="statut">Statut</td>
                      <th class="ajouter"></td>
                    </tr>';
        else
            $data .= '<th class="endroitPickup">Endroit de P/UP</td>
                      <th class="bonCommande">No. Commande</td>
                      <th class="noConfirmation">No. Confirmation</td>
                      <th class="commandePar">Commandé par</td>
                      <th class="contactFournisseur">Contact Fournisseur</td>
                      <th class="date">Date</td>
                      <th class="heure">Heure</td>
                      <th class="directiveSpeciale">Directive spéciale</td>
                      <th class="statut">statut</td>
                      <th class="ajouter">DELETE</td>
                    </tr>';
        
        $conn = IL_Database::getConn();
        mysqli_set_charset($conn,"utf8");

        $dateQuery = ( $dateChoisie == 'null' ? "" : " AND DATE('$dateChoisie') = date");
        $dateQuery .= ( $archive == 1 ) ? ' ORDER BY DATE(date) DESC' : "";
        
        if( $searchQuery == "" )
            $sql = "SELECT pkBonCommande, endroitPickup, bonCommande, noConfirmation, commandePar, fournisseur, date, heure, directiveSpeciale, statut FROM bon_commande WHERE succursale='$succursale' AND archive=$archive " . $dateQuery;
        else
        {
            $sql = "SELECT pkBonCommande, endroitPickup, bonCommande, noConfirmation, commandePar, fournisseur, date, heure, directiveSpeciale, statut FROM bon_commande WHERE succursale='$succursale'";
            $sql .= " AND archive=$archive ";
            $sql .= " AND ( endroitPickup like '%$searchQuery%' ";
            $sql .= " OR bonCommande like '%$searchQuery%' ";
            $sql .= " OR noConfirmation like '%$searchQuery%' ";
            $sql .= " OR commandePar like '%$searchQuery%' ";
            $sql .= " OR fournisseur like '%$searchQuery%' ";
            $sql .= " OR directiveSpeciale like '%$searchQuery%' ";
            $sql .= " OR statut like '%$searchQuery%' )";
        }

        $result = mysqli_query($conn, $sql);
        
        try
        {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $pkBonCommande = $row["pkBonCommande"];
                    
                    // CSS selon statut
                    // À ramasser par défaut pas de couleur
                    // Remise -> Jaune
                    // Fait -> rouge
                    $cssRow = "";
                    $statut = $row['statut'];   // Pour éviter de lire l'objet plusieurs fois
                    $dropdownSTATUT = "";       // html de la dropdown affichée dans le tableau selon statut de la ligne
                    $disabled = "";             
                    $faitADMIN = "";            // Pour enlever l'option FAIT a une dropdown qu'un commis pourrait modifier
                    
                    // si user level == 0 (user) pas droit de modifier cette dropdown si elle le statut fait car seulement admin peut mettre statut fait
                    if( IL_Session::r(IL_SessionVariables::LEVEL) == 0 ){
                        if( $statut == "Fait" )
                        {
                            $disabled = "disabled";
                            $faitADMIN = "<option selected>Fait</option>";
                        }
                    }
                    else{
                        if( $statut == "Fait" )
                        {
                            $faitADMIN = "<option selected>Fait</option>";
                        }
                        else
                        {
                            $faitADMIN = "<option>Fait</option>";
                        }
                    }
                    if( $archive == 1 )
                        $disabled = "disabled";
                    
                    $dropdownSTATUT = '<select '. $disabled . ' onchange="updateStatut(this,\'' . $row["pkBonCommande"] . '\');">';
                    if( $statut == 'Remise'){
                        $dropdownSTATUT .= '<option>À ramasser</option><option selected>Remise</option>'.$faitADMIN.'</select>';
                        $cssRow = "remise";
                    }
                    elseif( $statut == 'Fait' ){
                        $dropdownSTATUT .= '<option>À ramasser</option><option>Remise</option>'.$faitADMIN.'</select>';
                        $cssRow = "fait";
                    }
                    else{
                        $dropdownSTATUT .= '<option selected>À ramasser</option><option>Remise</option>'.$faitADMIN.'</select>';
                        $cssRow = "aramasser";
                    }                    
                    
                    $data .= "<tr id='row_" . $pkBonCommande . "' class='$cssRow'>";
                    
                    if( $archive == 0 )
                        $data .= "<td id='cbEdit_" . $pkBonCommande . "' class='edit'><input title='Modifier cette ligne' type='radio' id='radioEdit' name='radioEdit' class='chkEditRow' onclick='editMode(this," . $pkBonCommande . ");' value='" . $pkBonCommande . "' alt='Modifier'></td>";
                    
                    $data .= "<td class='endroitPickup'><input type='text' id='tbEndroitPickup_" . $pkBonCommande . "' class='tbEndroitPickup' list='dlEndroitPickup' value='" . $row["endroitPickup"] . "'></input></td>";
                    $data .= "<td class='bonCommande'><input type='text' id='tbBonCommande_" . $pkBonCommande . "' class='tbBonCommande' value='" . $row["bonCommande"] . "'></input></td>";
                    $data .= "<td class='noConfirmation'><input type='text' id='tbNoConfirmation_" . $pkBonCommande . "' class='tbNoConfirmation' value='" . $row["noConfirmation"] . "'></input></td>";
                    $data .= "<td class='commandePar'><input type='text' id='tbCommandePar_" . $pkBonCommande . "' class='tbCommandePar' value='" . $row["commandePar"] . "'></input></td>";
                    $data .= "<td class='contactFournisseur'><input type='text' id='tbFournisseur_" . $pkBonCommande . "' class='tbFournisseur' list='dlFournisseur' value='" . $row["fournisseur"] . "'></input></td>";
                    $data .= "<td class='date'><input type='date' id='tbDate_" . $pkBonCommande . "' class='tbDate' value='" . $row["date"] . "'></input></td>";
                    $data .= "<td class='heure'><input type='text' disabled='disabled' id='tbHeure_" . $pkBonCommande . "' class='tbHeure' value='" . $row["heure"] . "'></input></td>";
                    $data .= "<td class='directiveSpeciale'><input type='text' id='tbDirectiveSpeciale_" . $pkBonCommande . "' class='tbDirectiveSpeciale' value='" . $row["directiveSpeciale"] . "'></td>";
                    
                    $data .= "<td class='statut'>$dropdownSTATUT</td>";                    
                    
                    if( $archive == 0 )
                    {
                        $data .= "<td class='ajouter'><input title='Sauvegarder la ligne' id='btnAjouter_" . $pkBonCommande . "' type='button' class='boutonSaveLigneHidden' onclick='saveRow(" . $row["pkBonCommande"] . ");' alt='Sauvegarder'>";
                        $data .= "<input type='button' title='Archiver la ligne' class='boutonDelete' onclick='archiveRow(" . $row["pkBonCommande"] . ");' alt='Supprimer'></td>";
                    }
                    else
                    {
                        $data .= "<td class='ajouter'><input type='button' title='Supprimer la ligne' class='boutonDelete' onclick='deleteRow(" . $row["pkBonCommande"] . ");' alt='Supprimer'></td>";
                    }
                    
                    $data .= "</tr>";
                }
                
                $data .= '<tr><td class="edit"><img id="btnDeselectionner" style="visibility:hidden;" onclick="deselectionner();" src="../assets/images/iconeRemove.png" alt=""/></td>';
                
                if( $archive == 0 )
                    $data .= '<td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td>';
                else
                    $data .= '<td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""></td>';
                
                $data .= '</tr>';
            }
        }
        catch (Exception $e) {
            //echo $e;
        }
        
        return $data;
    }
    
    public static function addBonCommande($endroitPickup, $bonCommande, $noConfirmation, $commandePar, $contactFournisseur, $date, $directiveSpeciale, $statut, $heure, $succursale){
        
        $conn = IL_Database::getConn();
        
        $endroitPickup = mysqli_real_escape_string($conn, $endroitPickup);
        $bonCommande = mysqli_real_escape_string($conn, $bonCommande);
        $noConfirmation = mysqli_real_escape_string($conn, $noConfirmation);
        $commandePar = mysqli_real_escape_string($conn, $commandePar);
        $contactFournisseur = mysqli_real_escape_string($conn, $contactFournisseur);
        $date = mysqli_real_escape_string($conn, $date);
        $directiveSpeciale = mysqli_real_escape_string($conn, $directiveSpeciale);
        $statut = mysqli_real_escape_string($conn, $statut);
        $heure = mysqli_real_escape_string($conn, $heure);
        $succursale = mysqli_real_escape_string($conn, $succursale);
        
        $sql = "INSERT INTO bon_commande(endroitPickup,bonCommande,noConfirmation,commandePar,fournisseur,date,directiveSpeciale,statut,heure, succursale) ";
        $sql .= "VALUES('$endroitPickup','$bonCommande','$noConfirmation','$commandePar','$contactFournisseur','$date','$directiveSpeciale','$statut','$heure','$succursale')";

        mysqli_query($conn, $sql);
        $this->id = $conn->insert_id;
        
        return "Bon de commande ajouté";
    }
    
    public static function archiveBonCommande($pkBonCommande)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE bon_commande SET archive=1 WHERE pkBonCommande='$pkBonCommande'");
        
        return "Bon de commande archivé";
    }
    
    public static function deleteBonCommande($pkBonCommande)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "DELETE FROM bon_commande WHERE pkBonCommande=$pkBonCommande");
        
        return "Bon de commande effacé";
    }
    
    public static function updateStatut($pkBonCommande, $nouveauStatut)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE bon_commande SET statut='$nouveauStatut' WHERE pkBonCommande='$pkBonCommande'");
        
        return "Bon de commande modifié";
    }
    
    public static function updateLigne($pkBonCommande, $endroitPickup, $bonCommande, $noConfirmation, $commandePar, $contactFournisseur, $date, $directiveSpeciale)
    {
        $conn = IL_Database::getConn();
        
        $endroitPickup = mysqli_real_escape_string($conn, $endroitPickup);
        $bonCommande = mysqli_real_escape_string($conn, $bonCommande);
        $noConfirmation = mysqli_real_escape_string($conn, $noConfirmation);
        $commandePar = mysqli_real_escape_string($conn, $commandePar);
        $contactFournisseur = mysqli_real_escape_string($conn, $contactFournisseur);
        $date = mysqli_real_escape_string($conn, $date);
        $directiveSpeciale = mysqli_real_escape_string($conn, $directiveSpeciale);
        
        $sql = "UPDATE bon_commande SET endroitPickup='$endroitPickup', bonCommande='$bonCommande', noConfirmation='$noConfirmation', commandePar='$commandePar', ";
        $sql .= "fournisseur='$contactFournisseur', date='$date', directiveSpeciale='$directiveSpeciale' WHERE pkBonCommande='$pkBonCommande'";

        mysqli_query($conn, $sql );
        
        return "Bon de commande modifié";
    }
}
?>