<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<script type="application/javascript" src="assets/js/recherche-rest.js"></script>
<body>
    <div name='menu' class='page_menu layout_normal base_layout base_page page_recherche serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">RECHERCHER</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?></div>
            <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
<div id="contenu">
    
    <!-- Search header -->
    <div class="row section">
        <div class="col-xs-offset-2 col-xs-8 col-md-offset-3 col-md-6">
            <div name="mod_rechercheCustom" class="module_rechercheCustom base_module container-fluid serializable">
                <div class="row headerStyle">
                    <div class="col-xs-4">Champ</div>
                    <div class="col-xs-3">Comparaison</div>
                    <div class="col-xs-3">Valeur</div>
                    <div class="col-xs-2">&nbsp;</div>
                </div>

                <div class="crits animListRow">
                    <div name="row0" class="row serializable">
                        <div class="col-xs-4">
                            <select name="field" value="dateLivraison" class="input">
                                <option value="dateLivraison" selected="">Date de livraison</option>
                                <option value="noFacture"># facture</option>
                                <option value="destinataire">Destinataire</option>
                                <option value="noColis"># colis</option>
                                <option value="nomSignataire">Nom du signataire</option>
                                <option value="signature">Signature</option>
                                <option value="noEmploye"># employé</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <select name="comparator" value="like" class="input">
                                <option value="like" selected="">contient</option>
                                <option value="egal">=</option>
                                <option value="pluspetit">&lt;</option>
                                <option value="plusgrand">&gt;</option>
                            </select>
                        </div>
                        <div class="col-xs-5">
                            <input type="text" name="value" value="" maxlength="200" class="input">
                            <i name="delete" class="buttonStyle fas fa-minus" style="display: none;"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <i name="plus" class="buttonStyle fas fa-plus pull-left"></i>
                        </div>
                        <div class="col-xs-7">&nbsp;</div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-offset-4 col-xs-4">
                        <button><i class="fas fa-search"></i> Rechercher</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Search results -->
    <div class="row section">
        <div class="col-xs-12">
            <div name="mod_liste" class="module_liste base_module serializable">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th class="ID isHidden">ID</th>
                            <th class="dateLivraison sortable" data-sort="string">Date de livraison<span class="sortIcon down">▼</span><span class="sortIcon up" style="display: none;">▲</span></th>
                            <th class="noFacture sortable" data-sort="int"># facture<span class="sortIcon down">▼</span><span class="sortIcon up" style="display: none;">▲</span></th>
                            <th class="destinataire sortable" data-sort="string">Destinataire<span class="sortIcon down">▼</span><span class="sortIcon up" style="display: none;">▲</span></th>
                            <th class="noColis sortable" data-sort="int"># colis<span class="sortIcon down">▼</span><span class="sortIcon up" style="display: none;">▲</span></th>
                            <th class="nomSignataire sortable" data-sort="string">Nom du signataire<span class="sortIcon down">▼</span><span class="sortIcon up" style="display: none;">▲</span></th>
                            <th class="signature">Signature</th>
                            <th class="noEmploye sortable" data-sort="string"># employé<span class="sortIcon down">▼</span><span class="sortIcon up" style="display: none;">▲</span></th>
                        </tr>
                    </thead>
                    <tbody class="results-container">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Search paging -->
    <div class="row section">
        <div name="mod_paginator" class="module_paginator base_module container serializable">
            <div class="">
                <div class="row">
                    <div class="col buttonStyle pull-left align-center fas fa-fast-backward" name="pageButton" disabled=""></div>
                    <div class="col buttonStyle pull-left align-center fas fa-backward" name="pageButton" disabled=""></div>

                    <div class="col pageNo">page 1 / 939</div>

                    <div class="col buttonStyle pull-right align-center fas fa-fast-forward" name="pageButton"></div>
                    <div class="col buttonStyle pull-right align-center fas fa-forward" name="pageButton"></div>
                </div>
            </div>
        </div>
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

    <!-- Start : Javascript template -->
    <script id="resultsTemplate" type="text/x-jquery-tmpl">
        <tr name="0" class="serializable hoverable">
            <td class="ID isHidden"><span name="ID" class="input ">${id_livraison}</span></td>
            <td class="dateLivraison"><span name="dateLivraison" class="input ">${dateLivraison}</span></td>
            <td class="noFacture"><span name="noFacture" class="input ">${noFacture}</span></td>
            <td class="destinataire"><span name="destinataire" class="input ">${destinataire}</span></td>
            <td class="noColis"><span name="noColis" class="input ">20</span></td>
            <td class="nomSignataire"><span name="nomSignataire" class="input ">${nomSignataire}</span></td>
            <td class="signature"><span class="input svgSignature"><img src="${signature}" /></span></td>
            <td class="noEmploye"><span name="noEmploye" class="input ">${noEmploye}</span></td>
        </tr>
    </script>
    <!-- End : Javascript template -->