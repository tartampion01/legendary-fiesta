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

                <div class="crits animListRow cloneDestination">
                    <div name="row0" class="row clonable serializable">
                        <div class="col-xs-4">
                            <select name="field" id="field1" value="dateLivraison" class="input">
                                <option value="dateLivraison" selected="">Date de livraison</option>
                                <option value="facture"># facture</option>
                                <option value="destinataire">Destinataire</option>
                                <option value="colis"># colis</option>
                                <option value="nomSignataire">Nom du signataire</option>
                                <!--<option value="signature">Signature</option>-->
                                <option value="noEmploye"># employé</option>
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <select name="comparator" id="comparator1" value="like" class="input">
                                <option value="like" selected="">contient</option>
                                <option value="=">=</option>
                                <option value="<">&lt;</option>
                                <option value=">">&gt;</option>
                            </select>
                        </div>
                        <div class="col-xs-5">
                            <input type="text" name="value" id="value1" value="" maxlength="200" class="input">
                            <i name="delete" class="buttonStyle fas fa-minus" style="display: none;"></i>
                        </div>
                    </div>
                    
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-xs-5">
                        <i name="plus" class="addItemFilter firstItemRow buttonStyle fas fa-plus pull-left" data-item-row="1"></i>
                    </div>
                    <div class="col-xs-7">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-4 col-xs-4">
                        <button class="btnSearch"><i class="fas fa-search"></i> Rechercher</button>
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
                            <th class="dateLivraison sortable" data-order-by="dateLivraison">Date de livraison<span class="sortIcon down" data-order="ASC">▼</span><span class="sortIcon up" data-order="DESC" style="display: none;">▲</span></th>
                            <th class="noFacture sortable" data-order-by="facture"># facture<span class="sortIcon down" data-order="ASC">▼</span><span class="sortIcon up" data-order="DESC" style="display: none;">▲</span></th>
                            <th class="destinataire sortable" data-order-by="destinataire">Destinataire<span class="sortIcon down" data-order="ASC">▼</span><span class="sortIcon up" data-order="DESC" style="display: none;">▲</span></th>
                            <th class="noColis sortable" data-order-by="colis"># colis<span class="sortIcon down" data-order="ASC">▼</span><span class="sortIcon up" data-order="DESC" style="display: none;">▲</span></th>
                            <th class="nomSignataire sortable" data-order-by="nomSignataire">Nom du signataire<span class="sortIcon down" data-order="ASC">▼</span><span class="sortIcon up" data-order="DESC" style="display: none;">▲</span></th>
                            <th class="signature">Signature</th>
                            <th class="noEmploye sortable" data-order-by="noEmploye"># employé<span class="sortIcon down" data-order="ASC">▼</span><span class="sortIcon up" data-order="DESC" style="display: none;">▲</span></th>
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

                    <div class="col pageNo"></div>
                    <ul class="pagination" id="pagination" style="text-align: right; padding: 0; margin: 0;"></ul>

                </div>
            </div>
        </div>
    </div>

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
            <td class="dateLivraison"><span name="dateLivraison" class="input " data-sort-value="${dateTimestamp}">${dateLivraison}</span></td>
            <td class="facture"><span name="facture" class="input ">${facture}</span></td>
            <td class="destinataire"><span name="destinataire" class="input ">${destinataire}</span></td>
            <td class="noColis"><span name="colis" class="input ">${colis}</span></td>
            <td class="nomSignataire"><span name="nomSignataire" class="input ">${nomSignataire}</span></td>
            <td class="signature"><span class="input svgSignature jSignature" style="display: none;">${signature}</span></td>
            <td class="noEmploye"><span name="noEmploye" class="input ">${noEmploye}</span></td>
        </tr>
    </script>
    
    <script id="filtersTemplate" type="text/x-jquery-tmpl">
        <div class="row clonable cloned serializable itemRow${counter}">
            <div class="col-xs-4">
                <select name="field" id="field${counter}" value="dateLivraison" class="input">
                    <option value="dateLivraison" selected="">Date de livraison</option>
                    <option value="facture"># facture</option>
                    <option value="destinataire">Destinataire</option>
                    <option value="colis"># colis</option>
                    <option value="nomSignataire">Nom du signataire</option>
                    <!--<option value="signature">Signature</option>-->
                    <option value="noEmploye"># employé</option>
                </select>
            </div>
            <div class="col-xs-3">
                <select name="comparator" id="comparator${counter}" value="like" class="input">
                    <option value="like" selected="">contient</option>
                    <option value="=">=</option>
                    <option value="<">&lt;</option>
                    <option value=">">&gt;</option>
                </select>
            </div>
            <div class="col-xs-5">
                <input type="text" name="value" id="value${counter}" value="" maxlength="200" class="input">
                <i name="delete" class="removeItem buttonStyle fas fa-minus" data-item-row="${counter}"></i>
            </div>
        </div>
    </script>
    <!-- End : Javascript template -->