<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php'); ?>
<script type="text/javascript">
    function loadForm()
    {
        // set control date to current on body load
        document.getElementById('tbDate').valueAsDate = new Date();
    }
</script>
<body onload="loadForm();">
    <?php
        $message = "";
    ?>
    <script type="text/javascript">
    function checkDate()
    {
        var tbDate = document.getElementById("tbDate");
        var dateError = document.getElementById("dateValidation"); // SPAN
        
        if( tbDate.value == "" )
        {
            //dateError.style.visibility = "visible";
            //tbDate.style.color = "RED";
            return false;
        }
        else{
            //dateError.style.visibility = "hidden";
            //tbDate.style.color = "BLACK";
            return true;
        }
    }
    </script>
    <div name='menu' class='page_menu layout_normal base_layout base_page serializable'>
        <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
        <div id="entete" class="row">
            <div id="menu" class="col-xs-3 col-sm-2">
                <!--<a href="<?php //echo "default.php?r=".mt_rand(0, 999999999); ?>" class="home-link">-->
                <a href="default.php" class="home-link">
                    <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
                </a>
            </div>
            <div id="titre" class="col-xs-6 col-sm-8">menu</div>
            <div id="user" class="col-xs-3 col-sm-2">
                <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?>
                    [<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>]
                </div>
                <a href="#" class="offline_hide">
                    <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
                </a>
            </div>
        </div>
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST")
            {
                if( isset($_POST["btnAddFeuilleDeRoute"]) )
                {
                    $succ = IL_Session::r(IL_SessionVariables::SUCCURSALE);
                    $tbClients = $_POST["tbClient"];
                    $i = 0;
                    $errNB = 0;
                    
                    //print_r($_POST);
                    
                    // Loop dans les controles générés dynamiquement (ou pas!!)
                    // Ajouter ligne de livraison pour chaque ligne
                    foreach( $tbClients as $client )
                    {
                        $employeInfo = explode( ':', $_POST["cboUserNames"]); // --> id_user:username
                        $employeId = $employeInfo[0];
                        $employe = $employeInfo[1];
                        
                        $date = $_POST["tbDate"];
                        $facture = $_POST["tbFacture"];
                        $colis = $_POST["tbColis"];
                        
                        $new_id = IL_Utils::addFeuilleDeRoute($succ, $employeId, $employe, $date, $client, $facture[$i], $colis[$i]);
                        
                        $i++;
                        
                        if( $new_id == 0 )
                            $errNB = $errNB + 1;
                        
                    }
                    
                    if( $errNB == 0 )
                    {
                        $message = "Feuille de route ajoutée avec succès";
                        
                        $string  = '<script type="text/javascript">';
                        $string .= 'window.location="livraisonElite.php"';
                        $string .= '</script>';

                        echo $string;
                    }                    
                    else
                        $message = "Erreur dans la création de la feuille de route";
                }
            }
            else
            {
                
            }
        
        ?>
    <div id="contenu">
        <div name='mod_livraison' class='module_livraison base_module awesomplete col-lg-offset-2 col-lg-8 serializable' >
            <form method="POST" action="feuillederoute.php">
                <span class="label error"><?php echo $message; ?></span>
                <hr/>
                <section>
                    <div class="row">                        
                        <div class="col-xs-6">
                            <div class="row">
                                <div class="col-xs-12 label">Date de livraison :&nbsp;
                                    <input type="date" name="tbDate" id="tbDate" required="required" onblur="return checkDate();" ></input>
                                    <span style="visibility: hidden;" class="error" id="dateValidation" id="dateError">&nbsp;Choisissez une date</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="row label">
                                <div class="col-xs-12 label">Livreur :&nbsp;
                                    <select id="cboUserNames" name="cboUserNames">
                                        <?php
                                            if( IL_Session::r(IL_SessionVariables::LEVEL) == iUserLEvel::LIVREUR )
                                                echo "<option value='" . IL_Session::r(IL_SessionVariables::ID_USER) . ":" . IL_Session::r(IL_SessionVariables::USERNAME) . "'>" . IL_Session::r(IL_SessionVariables::USERNAME) . "</option>";
                                            else
                                                echo IL_Utils::getUsersDropDownForSuccursale(IL_Session::r(IL_SessionVariables::SUCCURSALE), iUserLEvel::LIVREUR);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section name="livraisons" class="cloneDestination serializable">
                    <div name="row1" class="row clonable serializable">
                        <div class="col-xs-3">
                            <div class="row">
                                <div class="label">
                                    Client
                                </div>
                                <div class="">
                                    <input type="text" name="tbClient[]" id="tbClient1" value="" maxlength="100" class="input" list="dlClients"></input>
                                    <datalist id="dlClients" name="dlClients">
                                        <?php echo IL_Utils::GetClientsViewData(IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="row">
                                <div class="label">
                                    #facture
                                </div>
                                <div class="">
                                    <input type="text" name="tbFacture[]" id="tbFacture1" value="" autocomplete="off" maxlength="50" class="input"></input>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="row">
                                <div class="label">
                                    Nb Colis
                                </div>
                                <div class="">
                                    <input type="text" name="tbColis[]" id="tbColis1" value="" maxlength="50" autocomplete="off" class="input"></input>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3 center">
                            <div class="row">
                                <div class="label">
                                    &nbsp;<br/>
                                    <i name="moins" class="removeItem buttonStyle fas fa-minus" style="display: none;"></i>
                                    <i name="plus" class="addItem firstItemRow buttonStyle fas fa-plus" data-item-row="1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <br/>
                <input type="submit" id="btnAddFeuilleDeRoute" onclick="return checkDate();" name="btnAddFeuilleDeRoute" value="Créer feuille de route" class="button"/>
                <br/>
                <br/>
            </form>
        </div>
    </div>
    
<footer id="pied">
    <div class="bottomBanner">
        <div class="copyright">
            <!--<div>
                <input type="button" id="checkLocalForageSync" class="btn-check-localforage-sync large green button" value="Synchroniser les données" />
            </div>-->
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
    <!-- Start : Javascript template -->
    <script id="itemTemplate" type="text/x-jquery-tmpl">
        <div class="row clonable cloned serializable itemRow${counter}">
            <div class="col-xs-3">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="tbClient[]" id="tbClient${counter}" value="" maxlength="20"  class="input"></input><br>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="tbFacture[]" id="tbFacture${counter}" value="" maxlength="20"  class="input"></input><br>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="tbColis[]" id="tbColis${counter}" value="" maxlength="20"  class="input"></input>
                    </div>
                </div>
            </div>
            <div class="col-xs-3 center">
                <div class="row">
                    <div class="col-xs-12">
                        <i name="moins" class="removeItem buttonStyle fas fa-minus" data-item-row="${counter}"></i>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <!-- End : Javascript template -->
</body>
</html>
