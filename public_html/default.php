<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php'); ?>
<body>
        <?php
            if(isset($_POST["btnDelete"]))
            {
                $conn = IL_Database::getConn();
                
                $sql = "DELETE from livraisons";
                $result = mysqli_query($conn, $sql);
                
                $sql = "DELETE from colisLivraison";
                $result = mysqli_query($conn, $sql);
                
                echo "<label style='font-size:42px'><b>Il me fait plaisir de vous annoncer que la suppresion a été effectuée avec joie et vigueur.</b><label>";
                
            }
        ?>
        <div name='menu' class='page_menu layout_normal base_layout base_page serializable'>
        <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
        <div id="entete" class="row">
            <div id="menu" class="col-xs-3 col-sm-2">
                <a href="<?php echo "default.php?r=".mt_rand(0, 999999999); ?>" class="home-link">
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
    <div id="contenu">
        <div class="menufloat">
            <?php 
                IL_Utils::getUserMenu(IL_Session::r(IL_SessionVariables::LEVEL)); ?>        
        </div>
    </div>
        <!--<a href="sandbox.php">SANDBOX</a><br>-->
        <!--<a href="viewdb.php">VIEWDB</a><br>-->
    <form method="POST" action="default.php">
        <!--<input type="submit" value="Delete livraisons and colis" id="btnDelete" name="btnDelete">-->
    </form>
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
