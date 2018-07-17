<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<body>
    <div name='menu' class='page_menu layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php?page=menu">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">menu</div>

        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo $_SESSION["username"]; ?></div>
            <a href="javascript:void()" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="ajaxEventV2(this, 'logout')">Déconnexion</div>
            </a>
        </div>
    </div>
<div id="contenu">
    <div class="menufloat">
        <a href="default.php?page=livraison" class="menuitem"><button name="livrer" class=""><div class="label">Livrer</div></button></a>
        <a href="default.php?page=livraisons_offline" class="menuitem"><button name="livraisons_offline" class=""><div class="label">Hors Ligne</div></button></a>
        <a href="default.php?page=recherche" class="menuitem offline_hide"><button name="recherche" class=""><div class="label">Rechercher</div></button></a>
        <a href="default.php?page=gestionUtilisateurs" class="menuitem offline_hide"><button name="utilisateurs" class=""><div class="label">Utilisateurs</div></button></a>
        <button name="logout" class="menuitem offline_hide" onclick="dsAjaxV2.eventTiny(event)"><div class="label">Déconnexion</div></button>
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
