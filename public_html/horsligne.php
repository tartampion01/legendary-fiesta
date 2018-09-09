<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<script type="application/javascript" src="assets/js/livraison-horsligne.js"></script>
<body>
    <div name='menu' class='page_livraisons_offline layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">LIVRAISON HORS LIGNE</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?></div>
            <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
<div id="contenu">
   
    <div id="here">
        <div data-reactroot="">
            <table>
                <thead>
                    <tr>
                        <th class="dateLivraison">Date de livraison</th>
                        <th class="noFacture"># facture</th>
                        <th class="destinataire">Destination</th>
                        <th class="noColis"># colis</th>
                        <th>Nom du signataire</th>
                        <th>Signature</th>
                        <th class="noEmploye"># employé</th>
                    </tr>
                </thead>
                <tbody class="results-container">
                        
                </tbody>
            </table>
            <div class="nodata"><span>Aucunes données hors connexion. Le serveur est à jour.</span></div>
        </div>
    </div>
    
</div>
    
<footer id="pied">
    <div class="bottomBanner">
        <div class="copyright"></div>
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
        <td class="dateLivraison"><span name="dateLivraison" class="input ">${tbDate}</span></td>
        <td class="noFacture"><span name="noFacture" class="input ">${array_colis[0]['facture']}</span></td>
        <td class="destinataire"><span name="destinataire" class="input ">${tbDestinataire}</span></td>
        <td class="noColis"><span name="noColis" class="input ">${array_colis[0]['colis']}</span></td>
        <td class="nomSignataire"><span name="nomSignataire" class="input ">${tbNomSignataire}</span></td>
        <td class="signature"><span class="input svgSignature jSignature" style="display: none;">${signature}</span></td>
        <td class="noEmploye"><span name="noEmploye" class="input ">${tbEmploye}</span></td>
    </tr>
</script>
