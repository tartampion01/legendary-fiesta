<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<script type="text/javascript">
    var NOEMPLOYE = '<?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?>';
    var SUCCURSALE = '<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>';
    var _recherche = null;
    var _dir = "asc";
</script>
<script type="application/javascript" src="assets/js/livraisonElite-rest.js"></script>
<body>
    <div name='menu' class='page_menu layout_normal base_layout base_page page_recherche serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <!--<a href="<?php //echo "default.php?r=".mt_rand(0, 999999999); ?>" class="home-link">-->
            <a href="default.php" class="home-link">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">Feuille de route</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?>
                [<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>]
            </div>
            <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
<div id="contenu">
    <div class="row section">
        <div class="col-xs-12">
            <div name="mod_liste" class="module_liste base_module serializable">
                <table id="tbLivraisons" class="results-table">
                    <thead>
                        <tr>
                            <th class="ID isHidden">ID</th>
                            <th class="delete">X</th>
                            <th class="dateLivraison" onclick="sortTable(2);">Date de livraison&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png" /></th>                            
                            <th class="destinataire" onclick="sortTable(3);">Destinataire&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png" /></th>
                            <th class="noFacture" onclick="sortTable(4);"># facture&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png" /></th>
                            <th class="noColis" onclick="sortTable(5);"># colis&nbsp;<img class="sortableArrows" src="../assets/images/sortable.png" /></th>
                            <th class="nomSignataire">Nom du signataire&nbsp;</th>
                            <th class="signature">Signature</th>
                        </tr>
                    </thead>
                    <tbody class="results-container">
                        <?php
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>       
</div>

    <div id="divCentreeSignature" style="visibility: hidden;position:relative;">
        Nom&nbsp;:&nbsp;<input id="tbNomSignataire" type="text" maxlength="50" autocomplete="off" style="width:450px;height:40px;font-size: 28px;"></br>
            <div name='mod_signature' class='module_signature base_module serializable' >
                <div id="signature_mod_signature" class="signPad">
                    <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1em !important; margin-bottom:1em !important;"></div>
                    <div id="jSignature" style="margin: 0px; padding: 0px; border: medium none; height: 150px; width: 100%; touch-action: none;" class="jSignature disabled" width="600" height="150"></div>
                    <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1.5em !important; margin-bottom:1.5em !important; position: relative;"></div>
                </div>
            </div>
            <div class="multipleClients" style="padding-top: 5px;">
                <input style="visibility: hidden" type="checkbox" class="multipleClients fatCheckBox" id="cbMultipleClients" name="cbMultipleClients" checked="checked" />&nbsp;&nbsp;
                <span style="visibility: hidden" class="multipleClients" id="spanMultiClients" name="spanMultiClients">Faire signer pour tous les colis de [
                    <b>
                        <span style="visibility: hidden" class="multipleClients" id="spanNomClient" name="spanNomClient"></span>
                    </b>
                    ]
                </span>
                </br>
            </div>
        <input type="button" id="btnSignatureAnnule" value="Annuler" style="width: 150px;height: 60px;font-size: 24px;color: red;" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" id="btnSignatureOK" value="Accepter"  style="width: 150px;height: 60px;font-size: 24px;color: green;" />
        <div class="dumpSignature" style="display: none; margin: 0px; padding: 0px; border: medium none; height: 150px; width: 100%; touch-action: none; background-color: transparent;"></div>
    </div>
    
    <div id="divConfirmDelete" style="visibility: hidden;position:relative;">
        </br>
        <span>&nbsp;&nbsp;&nbsp;Êtes vous certain de vouloir supprimer cette ligne?&nbsp;&nbsp;&nbsp;</span>
        </br>
        </br>
        <input type="button" id="btnDeleteNo" value="Non" style="width: 150px;height: 60px;font-size: 24px;color: red;" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" id="btnDeleteYes" value="Oui"  style="width: 150px;height: 60px;font-size: 24px;color: green;" />
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
    <div id="ajax" style="display:none;">
        <script type="text/json" class="communicator">[{"nop":""}]</script>
        <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    </div>
    
    <div class="converter" style="display: none;"></div>
</body>
</html>

    <!-- Start : Javascript template -->
    <script id="resultsTemplate" type="text/x-jquery-tmpl">
        <tr name="0" class="serializable hoverable">
            <td class="ID isHidden"><span name="ID" class="input ">${id_livraison}</span></td>
            <td class="delete"><img id="imgDelete" name="imgDelete" src="assets/images/iconeDelete.png" alt=""/></td>
            <td class="dateLivraison"><span name="dateLivraison" class="input " data-sort-value="${dateTimestamp}">${dateLivraison}</span></td>
            <td class="destinataire"><span name="destinataire" class="input ">${destinataire}</span></td>
            <td class="facture"><span name="facture" class="input ">${facture}</span></td>
            <td class="noColis"><span name="colis" class="input ">${colis}</span></td>
            <td class="nomSignataire"><span name="nomSignataire" class="input ">${nomSignataire}</span></td>
            <td class="signature"><span class="input svgSignature jSignature" style="display: none;">${signature}</span></td>            
        </tr>
    </script>
