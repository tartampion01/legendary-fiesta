<?php require_once(dirname(__DIR__) . '/__DEVincludes/header/_header.php');?>
<!--<script type="application/javascript" src="assets/js/livraison.js"></script>-->
<body>
    <div name='livraison' class='page_livraison layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row" style="margin-top: 0px;">
        <div id="menu" class="col-xs-3 col-sm-2">
            <!--<a href="<?php //echo "default.php?r=".mt_rand(0, 999999999); ?>" class="home-link">-->
            <a href="default.php" class="home-link">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">LIVRAISON</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?>
            [<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>]</div>
            <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
    
    <div id="contenu">
        <div name='mod_livraison' class='module_livraison base_module awesomplete col-lg-offset-2 col-lg-8 serializable' >
            <section>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="text" name="tbDate" id="tbDate" value="<?php //echo $date; ?>" readonly="" maxlength="200"  class="input "></input>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="text" name="tbEmploye" placeholder="Employé" id="tbEmploye" value="" maxlength="10"  class="input "></input>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section name="factures" class="cloneDestination serializable">
                <div name="row1" class="row clonable serializable">
                    <div class="col-xs-5">
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="text" name="tbNoFacture[]" placeholder="Facture" id="tbNoFacture1" value="" maxlength="50"  class="input"></input><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="text" name="tbNoColis[]" placeholder="Colis" id="tbNoColis1" value="" maxlength="20"  class="input"></input>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="row">
                            <div class="col-xs-12">
                                <i name="moins" class="removeItem buttonStyle fas fa-minus" style="display: none;"></i>
                                <i name="plus" class="addItem firstItemRow buttonStyle fas fa-plus" data-item-row="1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="awesomplete">
                            <input name="tbDestinataire" placeholder="Destinataire" id="tbDestinataire" value="" list="listeClients" maxlength="100" class="input awesomplete" autocomplete="off" aria-autocomplete="list" type="text">
                        </div>
                        <datalist id="listeClients"><?php echo IL_Utils::getDistinctDestinataires(IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?></datalist>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="tbNomSignataire" placeholder="Nom du signataire" id="tbNomSignataire" value="" autocomplete="off" maxlength="200" class="input "></input>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div style="display: none;">
                        <input type="text" name="signature" value="" maxlength="1024"  class="input "></input>
                    </div>
                    <div class="col-md-12">
                        <div name='mod_signature' class='module_signature base_module serializable' >
                            <div id="signature_mod_signature" class="signPad">
                                <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1em !important; margin-bottom:1em !important;"></div>
                                <div id="jSignature" style="margin: 0px; padding: 0px; border: medium none; height: 150px; width: 100%; touch-action: none;" class="jSignature disabled" width="600" height="150"></div>
                                <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1.5em !important; margin-bottom:1.5em !important; position: relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row buttons">
                    <div class="col-xs-offset-1 col-xs-5 col-md-offset-1 col-md-5">
                        <button name="btnSign" class="btnSign" data-action="doSignature" onclick="return false;"><i class="fas fa-edit"></i> Faire signer le client</button>
                    </div>
                    <div class="col-xs-5 col-md-5">
                        <button name="btnClear" class="btnClear"><i class="far fa-trash-alt"></i> Effacer la signature</button>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6">
                        <button type="submit" name="btnSave" class="btnSave"><i class="far fa-save"></i> Sauvegarder</button>
                        <input type="hidden" name="succursale" id="succursale" value="<?php echo $user->succursale; ?>" maxlength="25"></input>
                    </div>
                </div>
            </section>
            
            <div class="dumpSignature" style="display: none; margin: 0px; padding: 0px; border: medium none; height: 150px; width: 100%; touch-action: none; background-color: transparent;">
                
            </div>            
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
    <script>
        var e = document.getElementById('tbDate');
        // Si vide on met la date, sinon PHP récupère la date postée et la remet dans le textbox
        if( e.value.localeCompare("") == 0 )
            tbDate.value = dsSwissKnife.prettyPrint('date',new Date());
    </script>

    <!-- Start : Javascript template -->
    <script id="itemTemplate" type="text/x-jquery-tmpl">
        <div class="row clonable cloned serializable itemRow${counter}">
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="tbNoFacture[]" id="tbNoFacture${counter}" value="" maxlength="20"  class="input"></input><br>
                    </div>
                </div>
            </div>
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="tbNoColis[]" id="tbNoColis${counter}" value="" maxlength="20"  class="input"></input><br>
                    </div>
                </div>
            </div>
            <div class="col-xs-2 center">
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
