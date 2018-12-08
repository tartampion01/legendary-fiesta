<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<body>
    <div name='menu' class='page_gestionUtilisateurs page_gestionUtilisateurs_modifier page_menu layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">UTILISATEURS</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?></div>
           <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
<div id="contenu">
    <form action="utilisateurs.php" method="POST">
    <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // NEW or UPDATE?
            if( isset($_POST["btnSauvegarder"]) )
            {
                $errorMessage = "";
                $username = $password = $passwordconfirmation = "";
                $admin = $livreur = 0;
                $user = new IL_Users();

                if( isset($_POST["hidID"]))
                {
                    $id_user = $_POST["hidID"];
                    $username = $_POST["tbUsername"];
                    $password = $_POST["tbPassword"];
                    $passwordconfirmation = $_POST["tbPasswordConfirmation"];
                    $admin = $_POST["cbAdmin"];
                    $livreur = $_POST["cbLivreur"];
                    $level = -1;
                    
//                    echo $username . "<br>";
//                    echo $password . "<br>";
//                    echo $passwordconfirmation . "<br>";
//                    echo $admin . "<br>";
//                    echo $livreur . "<br>";
//                    echo $_POST["hidID"] . "<br>";
                    
                    // LEVEL
                    if( $admin == 0 && $livreur == 0 )
                        $errorMessage = "Veuillez choisir un groupe";
                    else
                    {
                        if( $admin == 0 && $livreur == 1 )
                            $level = 0;
                        if( $admin == 1 && $livreur == 0 )
                            $level = 1;
                        if( $admin == 1 && $livreur == 1 )
                            $level = 2;
                    }
                    
                    if( $level != -1 ){
                        if( $username != "" ){
                            if( $password != "" && $passwordconfirmation != ""){
                                if( strcmp($password,$passwordconfirmation) == 0 ){
                                    
                                    $user->username = $username;
                                    $user->actif = 1;
                                    $user->level = $level;
                                    $user->password = $password;
                                    
                                    // CREATE
                                    if($_POST["hidID"] == "new" )
                                    {
                                        $user->create();
                                        $id_user = $user->id;
                                        if( $id_user == 0 )
                                        {
                                            $id_user = "new";
                                            $errorMessage = "Un utilisateur avec ce nom existe déjà";
                                        }
                                        else {
                                            $errorMessage = "L'utilisateur à été crée";
                                            $id_user = "new";
                                            $username = "";
                                            $admin = 0;
                                            $livreur = 0;
                                        }
                                            
                                    }
                                    // UPDATE
                                    else
                                    {
                                        $id_user = $_POST["hidID"];
                                        $user->id = $id_user;
                                        $user->save();
                                        $errorMessage = "L'utilisateur à été modifié";
                                    }
                                }
                                else
                                    $errorMessage = "Le mot de passe et la confirmation ne correspondent pas";
                            }
                            else
                                $errorMessage = "Le mot de passe ne peut être vide";
                        }
                        else
                            $errorMessage = "Veuillez entrer un nom d'utilisateur";
                    }
                }?>
                    <div class="userInfo module_liste base_module">
                        <table>
                            <thead>
                                <tr>
                                    <?php if( $id_user == "new" ){ ?>
                                        <th colspan="2" class="username">Nouvel utilisateur</th>
                                    <?php } else { ?>
                                        <th colspan="2" class="username">Modifier un utilisateur</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr hidden="">
                                    <td class="label">
                                        <div class="fieldLabel">ID</div>
                                    </td>
                                    <td class="field">
                                        <input name="hidID" id="hidID" value="<?php echo $id_user?>" readonly="" maxlength="10" class="input" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="username" colspan="2" style="color: #cc0000;">
                                        <?php echo $errorMessage; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Nom d'utilisateur</div>
                                    </td>
                                    <td class="field">
                                        <input name="tbUsername" value="<?php echo $username; ?>" maxlength="50" class="input" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Mot de passe</div>
                                    </td>
                                    <td class="field">
                                        <input name="tbPassword" value="" maxlength="255" class="input" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Confirmez</div>
                                    </td>
                                    <td class="field">
                                        <input name="tbPasswordConfirmation" value="" maxlength="255" class="input" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Groupes</div>
                                    </td>
                                    <td class="field">
                                        <ul name="groupes" data-serializer="checkboxlist" class="input" type="checkboxlist">
                                            <li>
                                                <input type="hidden" id="cbAdmin" name="cbAdmin" value="0">
                                                <input type="checkbox" id="cbAdmin" name="cbAdmin" title="" value="1" <?php if( $admin == 1 ) {echo " checked";} ?>>
                                                <label>administrateurs</label>
                                            </li>
                                            <li>
                                                <input type="hidden" id="cbLivreur" name="cbLivreur" value="0">
                                                <input type="checkbox" id="cbLivreur" name="cbLivreur" title="" value="1" <?php if( $livreur == 1 ) {echo " checked";} ?>>
                                                <label>livreurs</label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br />
                    <input class="buttonStyle buttonMedium" type="submit" id="btnSauvegarder" name="btnSauvegarder" value="Sauvegarder" />
                    <?php if( $id_user != "new" ){ ?>
                    <a class="buttonStyle buttonMedium" href="utilisateurs?supprimer=<?php echo base64_encode($id_user); ?>" onclick="return confirm('Confirmer la suppression...?');">Supprimer</a>
                    <?php } ?>
                    <a class="newUser buttonStyle buttonLarge" href="utilisateurs.php">Retour</a>
                <?php 
            }            
        }
        else
        {
            // EDIT OR NEW USER
            if( isset( $_REQUEST["id_user"] ))
            {
                $errorMessage = "";
                $username = $password = $passwordconfirmation = "";
                $admin = $livreur = 0;
                
                $id_user = $_REQUEST["id_user"];
                
                if( $id_user == "new" )
                {
                    
                }
                else
                {
                    // We have an ID
                    $id_user = base64_decode($_REQUEST["id_user"]);
                    $user = new IL_Users();
                    $user->load($id_user,'','');
                    $username = $user->username;

                    switch( $user->level )
                    {
                        case 0: $admin = 0;
                                $livreur = 1;
                            break;
                        case 1: $admin = 1;
                                $livreur = 0;
                            break;
                        case 2: $admin = 1;
                                $livreur = 1;
                            break;
                    }
                }
                ?>
                    <div class="userInfo module_liste base_module">
                        <table>
                            <thead>
                                <tr>
                                    <?php if( $id_user == "new" ){ ?>
                                        <th colspan="2" class="username">Nouvel utilisateur</th>
                                    <?php } else { ?>
                                        <th colspan="2" class="username">Modifier un utilisateur</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr hidden="" style="display: none;">
                                    <td class="label">
                                        <div class="fieldLabel">ID</div>
                                    </td>
                                    <td class="field">
                                        <input name="hidID" id="hidID" value="<?php echo $id_user?>" readonly="" maxlength="10" class="input" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="username" colspan="2" style="border: none;">
                                        <?php echo $errorMessage; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Nom d'utilisateur</div>
                                    </td>
                                    <td class="field">
                                        <input name="tbUsername" value="<?php echo $username; ?>" maxlength="50" class="input" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Mot de passe</div>
                                    </td>
                                    <td class="field">
                                        <input name="tbPassword" value="" maxlength="255" class="input" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Confirmez</div>
                                    </td>
                                    <td class="field">
                                        <input name="tbPasswordConfirmation" value="" maxlength="255" class="input" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Groupes</div>
                                    </td>
                                    <td class="field">
                                        <ul name="groupes" data-serializer="checkboxlist" class="input" type="checkboxlist">
                                            <li>
                                                <input type="hidden" id="cbAdmin" name="cbAdmin" value="0">
                                                <input type="checkbox" id="cbAdmin" name="cbAdmin" title="" value="1" <?php if( $admin == 1 ) {echo " checked";} ?>>
                                                <label> administrateurs</label>
                                            </li>
                                            <li>
                                                <input type="hidden" id="cbLivreur" name="cbLivreur" value="0">
                                                <input type="checkbox" id="cbLivreur" name="cbLivreur" title="" value="1" <?php if( $livreur == 1 ) {echo " checked";} ?>>
                                                <label> livreurs</label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br />
                    <input class="buttonStyle buttonMedium" type="submit" id="btnSauvegarder" name="btnSauvegarder" value="Sauvegarder" />
                    <?php if( $id_user != "new" ){ ?>
                    <a class="buttonStyle buttonMedium" href="utilisateurs?supprimer=<?php echo base64_encode($id_user); ?>" onclick="return confirm('Confirmer la suppression...?');">Supprimer</a>
                    <?php } ?>
                    <a class="buttonStyle buttonLarge" href="utilisateurs.php">Retour</a>
                    
        <?php
            }
            // DELETE
            elseif( isset($_REQUEST["supprimer"]))
            {
                $id_user = base64_decode($_REQUEST["supprimer"]);
                $user = new IL_Users();
                $user->load($id_user,'','');
                $username = $user->username;
                $user->delete();
                
                ?>
                <div class="userInfo module_liste base_module">
                    <table>                            
                        <tbody>
                            <tr hidden="">
                                <td class="label">
                                    <div class="fieldLabel">ID</div>
                                </td>
                            </tr>
                            <tr>
                                <th class="username">
                                    L'utilisateur [&nbsp;<b><?php echo $username; ?></b>&nbsp;] a été supprimé
                                </th>
                            </tr>
                            <tr>
                                <td class="username">
                                    <a class="newUser buttonStyle buttonLarge" href="utilisateurs.php">Retour</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            // SHOW ALL USERS
            else
            { ?>
                <div name="lst_users" class="module_liste base_module serializable">
                    <table>
                        <thead>
                            <tr>
                                <th class="ID isHidden">ID</th>
                                <th class="username">Nom d'utilisateur</th>
                                <th class="edit"></th>
                            </tr>
                        </thead>
                    <tbody>
                    <?php
                        $conn = IL_Database::getConn();
                        $sql = "SELECT * FROM users WHERE actif=1";

                        $users = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($users) > 0){
                            while($row = mysqli_fetch_assoc($users)) {
                                echo '<tr name="0" onclick="window.location.href=\'utilisateurs.php?id_user=' . base64_encode($row["id_user"]) . '\'" class="serializable hoverable">';
                                echo '<td>';
                                echo '<input id="hidUserId" name="hidUserId" type="hidden" value="' . $row["id_user"] . '" />';
                                echo '<input name="tbUsername" value="' . $row["username"] . '" readonly="" maxlength="100" class="input" type="text" />';
                                echo '</td>';
                                echo '<td>';
                                echo '<a name="edit" class="" href="utilisateurs.php?id_user=' . base64_encode($row["id_user"]) . '"><img src="assets/images/pencil-edit-button.png" alt=""/></a>';
                                echo '</td>';
                                echo '</tr>';
                            } ?>
                    </tbody>
                    </table>
                    <?php }
                    else
                        echo "Aucun utilisateur trouvé.";
            }
        }
        ?>
            </div>
        <a class="newUser buttonStyle buttonLarge" href="utilisateurs.php?id_user=new">Nouvel utilisateur</a>
    </form>
</div>
    
<footer id="pied">
    <div class="bottomBanner">
        <div class="copyright">
            <div>
                <input type="button" id="checkLocalForageSync" class="btn-check-localforage-sync large green button" value="Synchroniser les données" />
            </div>
        </div>
    </div>
</footer>
    </div>
    <div id="showLoading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
        <!--img src="wait.png"-->
    </div>
    <div id="ajax" style="display:none;">
        <script type="text/json" class="communicator">[{"nop":""}]</script>
        <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    </div>
</body>
</html>
