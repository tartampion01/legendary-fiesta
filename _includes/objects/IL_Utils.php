<?php

interface iUserLevel
{
    const LIVREUR  = 0;
    const ADMIN    = 1;
    const COMPTOIR = 2;
}

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
     * @ 2 = comptoir
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
    
    public static function getUserMenu($level, $succursale)
    {
        switch($level)
        {
            // USER
            case 0: echo '<a href="feuillederoute.php" class="menuitem offline_hide utilisateurs"><button name="feuillederoute" class=""><div class="label">Remplir feuille</div></button></a>' .
                         '<a href="livraisonElite.php" class="menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Feuille de route</div></button></a>' .
                         '<a href="livraison.php" class="menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                         '<a href="rechercher.php" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>' .
                         '<button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            // ADMIN
            case 1: echo '<a href="feuillederoute.php" class="menuitem offline_hide utilisateurs"><button name="feuillederoute" class=""><div class="label">Remplir feuille</div></button></a>' .
                         '<a href="livraisonElite.php" class= "menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Feuille de route</div></button></a>' .
                         '<a href="rechercher.php" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>' .
                         '<a href="utilisateurs.php" class="menuitem offline_hide utilisateurs"><button name="utilisateurs" class=""><div class="label">Utilisateurs</div></button></a>' .
                         '<a href="livraison.php" class= "menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                         '<button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            // COMPTOIR -> Affiche la page de livraison normale + recherche
            case 2: echo '<a href="livraison.php" class="menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                         '<a href="rechercher.php" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>' .
                         '<button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
            default:echo '<a href="livraison.php"" class= "menuitem offline_hide livraison"><button name="livrer" class=""><div class="label">Livrer</div></button></a>' .
                          '<a href="rechercher.php"" class="menuitem offline_hide recherche"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
                          <button name="logout" class="menuitem offline_hide logout" onclick="window.location.href=\'logout.php\'"><div class="label">Déconnexion</div></button>';
                    break;
        }
    }
    
    /***
     * RETURNS OPTIONS WITH value=id_user and option text=username
     */
    public static function getUsersDropDownForSuccursale($succursale, $level)
    {
        $sql = "SELECT id_user, username FROM users WHERE succursale='$succursale' AND level='$level'";
        $data = "";
        $option_o = "<option value='";
        $option_c = "</option>";
        
        $conn = IL_Database::getConn();

        $result = mysqli_query($conn, $sql);

        try
        {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $data .= $option_o .  $row["id_user"] . ":" . $row["username"] . "'>" . $row["username"] . $option_c;
                }
            }
        }
        catch (Exception $e) {
            //echo $e;
        }

        return $data == "" ? $option_o . $option_c : $data;
    }
    
    /***
     * 
     */
    public static function addFeuilleDeRoute($succursale, $employeId, $employe, $date, $client, $facture, $colis )
    {
        $conn = IL_Database::getConn();
        
        $succursale = mysqli_real_escape_string($conn, $succursale);
        $employeId = mysqli_real_escape_string($conn, $employeId);
        $employe = mysqli_real_escape_string($conn, $employe);
        $date = mysqli_real_escape_string($conn, $date);
        $client = mysqli_real_escape_string($conn, $client);
        $facture = mysqli_real_escape_string($conn, $facture);
        $colis = mysqli_real_escape_string($conn, $colis);

        $sql = "INSERT INTO livraisons(succursale, id_user, noEmploye, dateLivraison, destinataire, facture, colis) ";
        $sql .= "VALUES('$succursale','$employeId','$employe','$date','$client','$facture','$colis')";

        //echo $sql;
        mysqli_query($conn, $sql);
        
        return $conn->insert_id;
    }
    
    /***
     * For autocomplete
     */
    public static function getDistinctDestinataires($succursale=null){
        
        $destinataires = "";
        $option_o = "<option>";
        $option_c = "</option>";
        
        $conn = IL_Database::getConn();            // Si on a une succursale on filtre selon
        $sql = "SELECT * FROM viewDestinataires" . (is_null($succursale) ? "" : " WHERE succursale='$succursale'");
        
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
    
    public static function getBonCommandeWithoutDriver($succursale){
        
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
                    
                    $data .= "<tr class='border_bottom' id='row_" . $pkBonCommande . "' class=''>";
                    $data .= "<td id='cbEdit_" . $pkBonCommande . "' class='edit'><input title='Modifier cette ligne' type='radio' id='radioEdit' name='radioEdit' class='chkEditRow' onclick='editMode(this," . $pkBonCommande . ");' value='" . $pkBonCommande . "' alt='Modifier'></td>";
                    $data .= "<td class='bonCommande'><input type='text' id='tbBonCommande_" . $pkBonCommande . "' class='tbBonCommande' maxlength='6' value='" . $row["bonCommande"] . "'></input></td>";
                    $data .= "<td class='fournisseur'><input type='text' id='tbFournisseur_" . $pkBonCommande . "' class='tbFournisseur' list='dlFournisseur' value='" . $row["fournisseur"] . "'></input></td>";
                    $data .= "<td class='av'><input type='text' id='tbAV_" . $pkBonCommande . "' class='tbAffichage av' list='dlAV' value='" . $row["av"] . "'></input></td>";
                    $data .= "<td class='heure'><input type='text' id='tbHeure_" . $pkBonCommande . "' class='tbHeure' value='" . $row["heure"] . "'></input></td>";
                    $data .= "<td class='date'><input type='text' id='tbDate_" . $pkBonCommande . "' class='tbDate' value='" . $row["date"] . "'></input></td>";
                    
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
                    //$data .= '<td class="textarea"><textarea rows="1" cols="60" id="tbCommentaire_' . $pkBonCommande . '">' . htmlspecialchars($row["commentaire"]) . '</textarea></td>';
                    $data .= '<td class="commentaire"><input type="text" id="tbCommentaire_' . $pkBonCommande . '" class="tbCommentaireElargi" value="' . htmlspecialchars($row["commentaire"]) . '"></input></td>';
                    $data .= "<td class='ajouter'>" . "<input title='Sauvegarder la ligne' id='btnAjouter_" . $pkBonCommande . "' type='button' class='boutonSaveLigneHidden' onclick='saveRow(" . $row["pkBonCommande"] . ");' alt='Sauvegarder'>";
                    $data .= "<input type='button' title='Enlever la ligne' class='boutonDelete' onclick='if( confirmerSuppression(\"" . $row["bonCommande"] . "\"))deleteRow(" . $row["pkBonCommande"] . ");' alt='Supprimer'></td></tr>";
                }
                
                $data .= '<tr class=""><td class="edit">
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
    
    public static function getJobGarage($succursale){
        
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
                    <td class="jg edit"></td>
                    <td class="jg jobGarage"># de job</td>
                    <td class="jg vendeur">Vendeur</td>
                    <td class="jg fournisseur">Fournisseur</td>
                    <td class="jg heure">Heure</td>
                    <td class="jg date">Date</td>
                    <td class="jg statut">Statut</td>
                    <td class="jg datePrevue">Date prévue</td>
                    <td class="jg ajouter"></td>
                </tr>';
              
        $conn = IL_Database::getConn();
        mysqli_set_charset($conn,"utf8");
        
        $sql = "SELECT pkJobGarage, jobGarage, fournisseur, vendeur, heure, date, receptionnee,statut, commentaire, datePrevue, archive FROM jobs_garage WHERE succursale='$succursale' AND archive=0";
        //echo $sql;
        $result = mysqli_query($conn, $sql);
        
        try
        {
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                    $pkJobGarage = $row["pkJobGarage"];
                    
                    $data .= "<tr id='row_" . $pkJobGarage . "' class=''>";
                    $data .= "<td id='cbEdit_" . $pkJobGarage . "' class='jg edit'><input title='Modifier cette ligne' type='radio' id='radioEdit' name='radioEdit' class='chkEditRow' onclick='editMode(this," . $pkJobGarage . ");' value='" . $pkJobGarage . "' alt='Modifier'></td>";
                    $data .= "<td class='jg jobGarage'><input type='text' id='tbJobGarage_" . $pkJobGarage . "' class='jg tbJobGarage' maxlength='6' value='" . $row["jobGarage"] . "'></input></td>";
                    $data .= "<td class='jg vendeur'><input type='text' id='tbVendeur_" . $pkJobGarage . "' class='jg tbAffichage tbVendeur' list='dlAV' value='" . $row["vendeur"] . "'></input></td>";
                    $data .= "<td class='jg fournisseur'><input type='text' id='tbFournisseur_" . $pkJobGarage . "' class='jg tbFournisseur' list='dlFournisseur' value='" . $row["fournisseur"] . "'></input></td>";
                    $data .= "<td class='jg heure'><input type='text' id='tbHeure_" . $pkJobGarage . "' class='jg tbHeure' value='" . $row["heure"] . "'></input></td>";
                    $data .= "<td class='jg date'><input type='text' id='tbDate_" . $pkJobGarage . "' class='jg tbDate' value='" . $row["date"] . "'></input></td>";
                    
                    $statut = "";
                    if( $row['statut'] == 'Commandee')
                    {
                        $statut = '<select class="jg Commandee" onchange="updateStatut(this,\'' . $row["pkJobGarage"] . '\');">';
                        $statut .= '<option selected>Commandee</option><option>En cours</option><option>Bin job</option></select>';
                    }
                    elseif( $row['statut'] == 'En cours' )
                    {
                        $statut = '<select class="jg Encours" onchange="updateStatut(this,\'' . $row["pkJobGarage"] . '\');">';
                        $statut .= '<option>Commandee</option><option selected>En cours</option><option>Bin job</option></select>';
                    }
                    else
                    {
                        $statut = '<select class="jg Binjob" onchange="updateStatut(this,\'' . $row["pkJobGarage"] . '\');">';
                        $statut .= '<option>Commandee</option><option>En cours</option><option selected>Bin job</option></select>';
                    }
                    
                    $data .= "<td class='statut'>$statut</td>";
                    //$data .= '<td class="commentaire"><input type="text" id="tbCommentaire_' . $pkJobGarage . '" class="tbCommentaire" value="' . htmlspecialchars($row["commentaire"]) . '"></input></td>';
                    $data .= '<td class="datePrevue"><input type="date" id="tbDatePrevue_' . $pkJobGarage . '" class="jg tbDatePrevue" value="' . htmlspecialchars($row["datePrevue"]) . '"></input></td>';
                    
                    $data .= "<td class='ajouter'>" . "<input title='Sauvegarder la ligne' id='btnAjouter_" . $pkJobGarage . "' type='button' class='boutonSaveLigneHidden' onclick='saveRow(" . $row["pkJobGarage"] . ");' alt='Sauvegarder'>";
                    $data .= "<input type='button' title='Enlever la ligne' class='boutonDelete' onclick='if( confirmerSuppression(\"" . $row["jobGarage"] . "\"))deleteRow(" . $row["pkJobGarage"] . ");' alt='Supprimer'></td></tr>";
                }
                
                $data .= '<tr><td class="edit">
                              <img id="btnDeselectionner" style="visibility:hidden;" onclick="deselectionner();" src="../assets/images/iconeRemove.png" alt=""/></td>
                              <td class="jg jobGarage"></td>
                              <td class="jg fournisseur"></td>
                              <td class="jg vendeur"></td>
                              <td class="jg heure"></td>
                              <td class="jg date"></td>
                              <td class="jg statut"></td>
                              <td class="jg datePreveu"></td>
                              <td class="ajouter"></td></tr>';
            }
        }
        catch (Exception $e) {
            //echo $e;
        }
        
        return $data;
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
    
    public static function addJobGarage($jobGarage, $vendeur, $fournisseur, $heure, $date, $statut, $datePrevue, $succursale){
        
        $conn = IL_Database::getConn();
        
        $jobGarage = mysqli_real_escape_string($conn, $jobGarage);
        $vendeur = mysqli_real_escape_string($conn, $vendeur);
        $fournisseur = mysqli_real_escape_string($conn, $fournisseur);
        $heure = mysqli_real_escape_string($conn, $heure);
        $date = mysqli_real_escape_string($conn, $date);
        $statut = mysqli_real_escape_string($conn, $statut);
        $datePrevue = mysqli_real_escape_string($conn, $datePrevue);
        $succursale = mysqli_real_escape_string($conn, $succursale);

        $sql = "INSERT INTO jobs_garage(jobGarage,vendeur,fournisseur,heure,date,statut,datePrevue,succursale) ";
        $sql .= "VALUES('$jobGarage','$vendeur','$fournisseur','$heure','$date','$statut','$datePrevue','$succursale')";
        mysqli_query($conn, $sql);
        $this->id = $conn->insert_id;
        
        return "Job Garage ajoutée";
    }
    
    public static function deleteBonCommande($pkBonCommande)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE bon_commande SET archive=1 WHERE pkBonCommande='$pkBonCommande'");
        
        return "Bon de commande effacé";
    }
    
    public static function deleteJobGarage($pkJobGarage)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE jobs_garage SET archive=1 WHERE pkJobGarage='$pkJobGarage'");
        
        return "Job Garage effacée";
    }
    
    public static function updateStatut($pkBonCommande, $nouveauStatut)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE bon_commande SET statut='$nouveauStatut' WHERE pkBonCommande='$pkBonCommande'");
        
        return "Bon de commande modifié";
    }
    
    public static function updateStatutJobGarage($pkJobGarage, $nouveauStatut)
    {
        $conn = IL_Database::getConn();
        
        mysqli_query($conn, "UPDATE jobs_garage SET statut='$nouveauStatut' WHERE pkJobGarage='$pkJobGarage'");
        
        return "Statut de job modifié";
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
        
        return $sql;//"Bon de commande modifié";
    }
    
    public static function updateLigneJobGarage($pkJobGarage, $jobGarage, $vendeur, $fournisseur, $heure, $date, $datePrevue, $succursale)
    {
        $conn = IL_Database::getConn();
        
        $jobGarage = mysqli_real_escape_string($conn, $jobGarage);
        $vendeur = mysqli_real_escape_string($conn, $vendeur);
        $fournisseur = mysqli_real_escape_string($conn, $fournisseur);
        $heure = mysqli_real_escape_string($conn, $heure);
        $date = mysqli_real_escape_string($conn, $date);
        $datePrevue = mysqli_real_escape_string($conn, $datePrevue);
        $succursale = mysqli_real_escape_string($conn, $succursale);
        
        $sql = "UPDATE jobs_garage SET jobGarage='$jobGarage', vendeur='$vendeur', fournisseur='$fournisseur', heure='$heure', date='$date', datePrevue='$datePrevue', succursale='$succursale' WHERE pkJobGarage='$pkJobGarage'";

        mysqli_query($conn, $sql );
        
        return $sql;//"Bon de commande modifié";
    }
    
}
?>