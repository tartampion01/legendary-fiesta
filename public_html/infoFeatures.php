<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<script type="text/javascript">
    var NOEMPLOYE = '<?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?>';
    var SUCCURSALE = '<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>';
</script>
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
        <div id="titre" class="col-xs-6 col-sm-8">Nouvelles fonctionalités</div>
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
                <div>
                    <ul>
                        <span>Pour permettre l'ajout de plusieurs factures/colis pour un même client à partir de la page</span>
                        <img src="assets/images/InfoAjoutClientFacture.jpg" alt=""/>
                        <li>Le bouton #1 Permet d'ajouter un ligne avec le même nom de client. Une fois celui-ci ajouté il ne peut être modifié.</li>
                        <li>Le bouton 'plus' #2 permet d'ajouter une ligne vide, ce comportement est le même qu'avant</li>
                        <li>La suppression demeure inchangée, le bouton 'moins' supprime la ligne correspondante</li>
                    </ul>
                    <hr>
                    <ul>
                        <b><span>Signature pour de multiples client</span></b><br>
                        <img src="assets/images/InfoSignatureMultiple1.jpg" alt=""/>
                        <li>Quand le même client est présent plusieurs fois sur la feuille, il est désormais possible de faire signer pour <b>tous</b> les colis en une fois</li>
                        <li>Cette option sera automatiquement cochée par défaut.</li>
                        <li>Il est possible de faire signer pour une seule facture en décochant la case verte.</li><br>
                        <img src="assets/images/InfoSignatureMultiple2.jpg" alt=""/>
                        <li>Ici Nous avons 3 signatures identiques et une individuelle pour le même client</li>
                        <li>Si un client n'est présent que sur une ligne, cette case ne s'affichera pas</li>
                    </ul>
                </div>
            </div>
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
</body>
</html>