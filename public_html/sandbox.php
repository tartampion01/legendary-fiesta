<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>

<script type="text/javascript">
    
    setTimeout(checkConnectionStatus, 1000);
    
    function doesConnectionExist() {
        var xhr = new XMLHttpRequest();
        var file = "assets/images/exists.png"; //image path in your project
        file = "https://www.betainterlivraison.camionbeaudoin.com/assets/images/exists.png";
        var randomNum = Math.round(Math.random() * 10000);
        xhr.open('HEAD', file + "?rand=" + randomNum, false);
        try {
            xhr.send(null);
            if (xhr.status >= 200 && xhr.status < 304) {
                return true;
            } else {
                return false;
            }
        } catch (e) {
            return false;
        }
    }

    function checkConnectionStatus()
    {
        res = doesConnectionExist();
        
        if( res )
            document.getElementById("lInt").innerHTML = "true";
        else
            document.getElementById("lInt").innerHTML = "false";
        
        setTimeout(checkConnectionStatus, 1000);
    }
    
</script>
<body>
    <script src="assets/js/livraison-rest.js" type="text/javascript"></script>
    <div name='menu' class='page_menu layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">SANDBOX</br>
            <label id='lInt'></label>
        </div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?></div>
           <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
    
<div id="contenu">
    <form action="sandbox.php" method="POST">
        <?php
            try {
          //      IL_Session::w(IL_SessionVariables::USERNAME,"Oups je n'aurais pas du archiver ça!");
          //  
          //      echo IL_Session::r(IL_SessionVariables::USERNAME);
          //      echo IL_Session::r(IL_SessionVariables::LEVEL); // no exception but returns false

                $prout = new IL_Livraison(null);
                $prout->load(1);
                //$prout->test();
            }
            catch (Exception $e) {
                echo $e;
                echo "Purée!!!!";
            }
          ?>
        <div class="GpcMenuWrapper" name="rien">
            <ul class="GpcMenu FacetedNavigation">
                <!-- MARQUE -->
                <li class="GpcMenuCategory expanded">
                    <a class="GpcMenuCategoryTitle" tabindex="">dateLivraison</a>
                    <ul class="dateLivraison" style="">
                        <?PHP $results = selectLivraisonsDisctinctCriteria('dateLivraison', ' id_livraison>0 ', 'COUNT', 'DESC' ); ?>
                            <?PHP foreach($results as $key => $value){ ?>
                            <li class="GpcMenuItem filter-link" data-field='dateLivraison' data-value='<?PHP echo $key ?>' data-custom-criteria=' id_livraison>0 ' data-selected="false">
                                <?PHP echo "<a class='GpcItemTitle' href='javascript:void(0);'>$key <span class='GpcMenuItemCount'>($value)</span></a>";} ?>
                            </li>
                    </ul>
                </li>
            </ul>
        </div>
        <button onclick="crotte();return false">Haha connections</button>
    </form>
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
    <script>
    $( document ).ready(function() {
    
        // On page load, trigger corresponding menu item
        $("li[data-value='International']").trigger('click');
    });
    </script>
</body>
</html>

