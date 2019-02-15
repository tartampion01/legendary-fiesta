<?php require_once(dirname(__DIR__) . '/../_includes/header/_header_bonCommande.php');?>
<script type="text/javascript">
    
    // WRITE JS VARIABLE WITH PHP SESSION VALUE
    <?php echo "var succ = '" . IL_Session::r(IL_SessionVariables::SUCCURSALE) . "';" ?>
        
    var timerDelay = 5000;
    
    function updateTimer(ceci)
    {
        timerDelay = ceci.value;
        clearTimeout(updateBonCommandes);
        setTimeout(updateBonCommandes, timerDelay);
    }
    
    function ClearTopData()
    {
        document.getElementById('tbBonCommande').value = '';
        document.getElementById('tbFournisseur').value = '';
        document.getElementById('tbAV').value = '';
        document.getElementById('tbHeure').value = '';
        document.getElementById('tbDate').value = '';
        //document.getElementById('cbStatut').value = '';
        document.getElementById('tbCommentaire').value = '';
    }
    
    function updateStatut(dropDown, pkBonCommande){
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
                //ClearTopData();
            }
        };
        
        var dataToAdd = "&oper=updateStatut&1=" + pkBonCommande + "&2=" + dropDown.value;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showBonCommandes();
    }
    
    function showBonCommandes() {

        var xhttp;
        if (succ == "") {
            document.getElementById("tbBonCommandes").innerHTML = "";
            return;
        }
        
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tbBonCommandes").innerHTML = this.responseText;
            }
        };

        xhttp.open("GET", "callBonCommande.php?succ=" + succ  + "&oper=read", true);
        xhttp.send();
    }
    
    function deleteRow(pkBonCommande)
    {
        clearTimeout(showBonCommandes);
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
            }
        };
        
        var dataToAdd = "&oper=del&pk=" + pkBonCommande;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showBonCommandes();
    }
    
    function ajouterBonCommande() {
        
        document.getElementById("divSauvegarde").innerHTML = "";
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("divSauvegarde").innerHTML = this.responseText;
                ClearTopData();
            }
        };
        
        var bonCommande = document.getElementById('tbBonCommande').value;
        var fournisseur = document.getElementById('tbFournisseur').value;
        var av = document.getElementById('tbAV').value;
        var heure = document.getElementById('tbHeure').value;
        var date = document.getElementById('tbDate').value;
        //var chauffeur = document.getElementById('tbChauffeur').value;
        var chauffeur = document.getElementById('ddChauffeur').value;
        alert(chauffeur);
        var statut = document.getElementById('cbStatut').value;
        var commentaire = document.getElementById('tbCommentaire').value;
        
        var dataToAdd = "&oper=add&1=" + bonCommande + "&2=" + fournisseur + "&3=" + av + "&4=" + heure + "&5=" + date + "&6=" + chauffeur + "&7=" + statut + "&8=" + commentaire;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showBonCommandes();
    }    
    
    //setTimeout(showBonCommandes(succ), 5000);
    //var t = setInterval(showBonCommandes,1000);
    
    var updateBonCommandes = function(){
        showBonCommandes();
        setTimeout(updateBonCommandes, timerDelay);
    };
    setTimeout(updateBonCommandes, 1000);
    
</script>

<body>
    <div name='bonCommande' class='base_page_boncommande serializable'>
    <form action=""> 
        <table>
            <tr>
                <td style="width:33%;text-align:center;">&nbsp;</td>
                <td style="width:33%;text-align:center;">
                    <label class="h1bonCommande">Bons de commande</label>
                </td>
                <td style="width:33%;text-align:right;" valign="middle">                    
                    <select title="Auto refresh" class="inputCombo" onchange="updateTimer(this);">
                        <option value="5000">5 secondes</option>
                        <option value="60000">1min</option>
                        <option value="300000">5min</option>
                        <option value="600000">10min</option>
                    </select>
                    
                </td>
        </table>
            
            
        <datalist id="dl" name="dl"><?php echo IL_Utils::getAutoComplete('fournisseurBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?></datalist>         
        <div id="divSauvegarde" name="divSauvegarde"></div>
        <table id="tbEntrerBonCommande" class="tableHaut">
            <tr>
                <td class="bonCommande"># de commande</td>
                <td class="fournisseur">Fournisseur</td>
                <td class="av">AV</td>
                <td class="heure">Heure</td>
                <td class="date">Date</td>
                <td class="chauffeur">Chauffeur</td>
                <td class="statut">Statut</td>
                <td class="commentaire">Commentaire</td>
                <td class="ajouter"></td>
            </tr>
            <tr>
                <td class="bonCommande"><input type="text" class="input" id="tbBonCommande" name="tbBonCommande"></td>
                <td class="fournisseur">
                    <input type="text" class="input" name="tbFournisseur" id="tbFournisseur" list="dlFournisseur">
                    <datalist class="input" id="dlFournisseur" name="dlFournisseur">
                        <?php echo IL_Utils::getAutoComplete('fournisseurBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>
                <td class="av">
                    <input type="text" class="input av" id="tbAV" name="tbAV" list="dlAV">
                    <datalist id="dlAV" name="dlAV">
                        <?php echo IL_Utils::getAutoComplete('aviseur', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>
                <td class="heure"><input type="text" class="input" id="tbHeure" name="tbHeure"></td>
                <td class="date"><input type="text" class="input" id="tbDate" name="tbDate"></td>
                <td class="chauffeur">
                    <!-- A retravailler
                    <input type="text" class="input chauffeur" id="tbChauffeur" name="tbChauffeur" list="dlChauffeur">
                    <datalist id="dlChauffeur" name="dlChauffeur">
                        <?php //echo IL_Utils::getAutoComplete('chauffeur', 1, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                    <input type="hidden" id="hidChauffeur" name="hidChauffeur" list="dlChauffeurUrl">
                    <input type="text" class="input chauffeur" id="tbChauffeurUrl" name="tbChauffeurUrl" list="dlChauffeurUrl">
                    <datalist id="dlChauffeurUrl" name="dlChauffeurUrl">
                        <?php //echo IL_Utils::getAutoComplete('chauffeurUrl', 1, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                    -->
                    <select id="ddChauffeur" class="inputCombo">
                        <option value="https://my31.geotab.com/">Jean-Guy</option>
                        <option value="https://my31.geotab.com/">Claude</option>
                        <option value="https://my31.geotab.com/">Daniel</option>
                        <option value="https://my31.geotab.com/">René</option>
                        <option value="https://my31.geotab.com/">Sylvain</option>
                        <option value="https://my31.geotab.com/">Benoit</option>
                        <option value="https://my31.geotab.com/">Éric</option>
                    </select>
                <td class="statut">
                    <!--DATALIST
                    <input type="text" class="input" id="tbStatut" name="tbStatut" list="dlStatut">                    
                    <datalist id="dlStatut" name="dlStatut">
                        <?php //echo IL_Utils::getAutoComplete('statutBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>-->
                    <select class="inputCombo" id="cbStatut"><option>En cours</option><option>Attribué</option><option>Reçu</option></select>
                </td>
                <td class="commentaire"><textarea rows="1" cols="40" type="text" class="input" id="tbCommentaire" name="tbCommentaire"></textarea></td>
                <td class="ajouter">
                    <div class="tooltip">
                        <input class="boutonAjout" type="button" alt="Ajouter" onclick="ajouterBonCommande();">
                        <span class="tooltiptext">Ajouter</span>
                    </div>
                </td>
            </tr>
        </table>
        </br>
        <table id="tbBonCommandes" class="tableData"></table>
    </form>

    <!--<a href='https://interlivraison.reseaudynamique.com/boncommande/boncommande.php?succ=CIB'>CIB</a>-->
<br>
    </div>
</body>
</html>