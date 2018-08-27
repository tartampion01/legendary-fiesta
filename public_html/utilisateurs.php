<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<body>
    <div name='menu' class='page_menu layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">UTILISATEURS</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo $_SESSION["username"]; ?>!</div>
           <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
<div id="contenu">
    <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

        }
        else
        {
            // EDIT OR NEW USER
            if( isset( $_REQUEST["id_user"] ))
            {
                $username = $password = $passwordconfirmation = "";
                $admin = $livreur = 0;
                
                $id_user = $_REQUEST["id_user"];
                if( $id_user == "new" )
                {
                    
                }
                else
                {
                    $user = new IL_Users();
                    $user->load($id_user);
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
                    <div class="userInfo">
                        <table>
                            <tbody>
                                <tr hidden="">
                                    <td class="label">
                                        <div class="fieldLabel">ID</div>
                                    </td>
                                    <td class="field">
                                        <input name="ID" value="" readonly="" maxlength="10" class="input" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Nom d'utilisateur</div>
                                    </td>
                                    <td class="field">
                                        <input name="username" value="<?php echo $username; ?>" maxlength="30" class="input" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Mot de passe</div>
                                    </td>
                                    <td class="field">
                                        <input name="password" value="<?php echo $password; ?>" maxlength="255" class="input" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Confirmez</div>
                                    </td>
                                    <td class="field">
                                        <input name="password2" value="" maxlength="255" class="input" type="password">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        <div class="fieldLabel">Groupes</div>
                                    </td>
                                    <td class="field">
                                        <ul name="groupes" data-serializer="checkboxlist" class="input" type="checkboxlist">
                                            <li>
                                                <input name="administrateurs" type="checkbox" value="<?php echo $admin; ?>">
                                                <label>administrateurs</label>
                                            </li>
                                            <li>
                                                <input name="livreurs" type="checkbox" value="<?php echo $admin; ?>">
                                                <label>livreurs</label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="buttonStyle buttonMedium" onclick="dsAjaxV2.eventCommitContainer(event, 'sauvegarder')">Sauvegarder</button>
                        <button class="buttonStyle buttonMedium" onclick="location.href='?page=gestionUtilisateurs'">Annuler</button>
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
                            echo '<tr name="0" class="serializable hoverable" onclick="">';
                            echo '<td>';
                            echo '<form action="utilisateurs.php" method="post">';
                            echo '<input id="hidUserId" name="hidUserId" type="hidden" value="' . $row["id_user"] . '" />';
                            echo '<input name="username" value=' . $row["username"] . ' readonly="" maxlength="30" class="input" type="text" />';
                            echo '<a name="edit" class="" href="utilisateurs.php?id_user=' . $row["id_user"] . '"><img src="assets/images/pencil-edit-button.png" alt=""/></a>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                    </tbody>
                    </table>
                    <button class="newUser buttonStyle buttonLarge" onclick="window.location.href='utilisateurs.php?id_user=new'">Nouvel utilisateur</button>
                    <?php }
                    else
                        echo "Aucun utilisateur trouvé.";
            }
        }
        ?>
    </div>
</div>
    
<footer id="pied">
    <div class="bottomBanner">
        <div class="copyright"></div>
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
