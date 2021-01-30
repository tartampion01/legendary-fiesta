<?php require_once(dirname(__DIR__) . '/../_includes/header/_header_bonCommande_CIB.php');?>
<script type="text/javascript">
    
    // WRITE JS VARIABLE WITH PHP SESSION VALUE
    <?php echo "var succ = '" . IL_Session::r(IL_SessionVariables::SUCCURSALE) . "';" ?>
        
    var timerDelay = 60000;
    var _dir = "asc";
    
    function editMode(ceci, rowId){
        
        clearTimer();

        /* code for check box
        if( ceci.checked == true )
        {
            document.getElementById('btnAjouter_' + rowId).className = 'boutonSaveLigneVisible';
            document.getElementById('row_' + rowId).className = 'rowEdit';
        }
        else
        {
            document.getElementById('btnAjouter_' + rowId).className = 'boutonSaveLigneHidden';
            document.getElementById('row_' + rowId).className = '';
            updateBonCommandes();
        }*/
        
        // RADIO BUTTONS
        // Un seul bouton
        if( typeof document.frm.radioEdit.length == 'undefined' )
        {
            document.getElementById('btnAjouter_' + rowId).className = 'boutonSaveLigneVisible';
            document.getElementById("row_" + rowId).className = 'rowEdit';
            document.getElementById("btnDeselectionner").style.visibility = 'visible';
        }
        
        for (var i = 0; i < document.frm.radioEdit.length; i++) {
            if (document.frm.radioEdit[i].checked) {
                document.getElementById('btnAjouter_' + document.frm.radioEdit[i].value).className = 'boutonSaveLigneVisible';
                document.getElementById("row_" + document.frm.radioEdit[i].value).className = 'rowEdit';
                document.getElementById("btnDeselectionner").style.visibility = 'visible';
            }
            else{
                document.getElementById('btnAjouter_' + document.frm.radioEdit[i].value).className = 'boutonSaveLigneHidden';
                document.getElementById("row_" + document.frm.radioEdit[i].value).className = '';
                document.getElementById("btnDeselectionner").style.visibility = 'hidden;';
            }
        }
    }
    
    function deselectionner()
    {
        for (var i = 0; i < document.frm.radioEdit.length; i++) {
            document.frm.radioEdit[i].checked = false;
            document.getElementById('btnAjouter_' + document.frm.radioEdit[i].value).className = 'boutonSaveLigneHidden';
            document.getElementById("row_" + document.frm.radioEdit[i].value).className = '';
        }
        
        updateBonCommandes();
    }
    
    function saveRow(rowId){
        
        var bonCommande = document.getElementById('tbBonCommande_' + rowId).value;
        var fournisseur = document.getElementById('tbFournisseur_' + rowId).value;
        var av = document.getElementById('tbAV_' + rowId).value;
        var heure = document.getElementById('tbHeure_' + rowId).value;
        var date = document.getElementById('tbDate_' + rowId).value;
        //var chauffeur = document.getElementById('tbChauffeur_' + rowId).value;
        var chauffeur = "";
        var commentaire = document.getElementById('tbCommentaire_' + rowId).value;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
                showBonCommandes();
            }
        };

        var dataToAdd = "&oper=updateLigne&1=" + rowId + "&2=" + bonCommande + "&3=" + fournisseur + "&4=" + av + "&5=" + heure + "&6=" + date + "&7=" + chauffeur + "&8=" + commentaire;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showBonCommandes();
        
    }    
    
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("tableJobGarage");
        switching = true;
        // Set the sorting direction to ascending:

        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
          // Start by saying: no switching is done:
          switching = false;
          rows = table.rows;
          /* Loop through all table rows (except the
          first, which contains table headers): */
          // -2 because of empty row at bottom  
          for (i = 1; i < (rows.length - 2); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            //x = rows[i].getElementsByTagName("TD")[n];
            x = rows[i].cells[n].getElementsByTagName('input')[0].value;
            //y = rows[i + 1].getElementsByTagName("TD")[n];
            y = rows[i + 1].cells[n].getElementsByTagName('input')[0].value;

            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (_dir == "asc") {
              if (x.toLowerCase() > y.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
              }
            } else if (_dir == "desc") {
              if (x.toLowerCase() < y.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
              }
            }
          }
          if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount ++;
          } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && _dir == "asc") {
              _dir = "desc";
              switching = true;
            } else if( switchcount == 0 && _dir == "desc") {
                _dir = "asc";
                switching = true;
            }
          }
        }
        
    }
    
    function ClearTopData()
    {
        document.getElementById('tbBonCommande').value = '';
        document.getElementById('tbFournisseur').value = '';
        document.getElementById('tbAV').value = '';
        document.getElementById('tbHeure').value = '';
        document.getElementById('tbDate').value = '';
        //document.getElementById('tbChauffeur').value = '';
        //document.getElementById('cbStatut').value = '';
        document.getElementById('tbCommentaire').value = '';
    }
    
    function updateStatut(dropDown, pkBonCommande){
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showBonCommandes();
            }
        };
        
        var dataToAdd = "&oper=updateStatut&1=" + pkBonCommande + "&2=" + dropDown.value;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
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

        xhttp.open("GET", "callBonCommande.php?succ=" + succ  + "&oper=readWithoutDriver", true);
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
    
    function confirmerSuppression(noCommande)
    {
        return confirm("Supprimer PO " + noCommande + " ?");
    }
    
    function ajouterBonCommande() {
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                ClearTopData();
                showBonCommandes();
            }
        };
        
        var bonCommande = document.getElementById('tbBonCommande').value;
        var fournisseur = document.getElementById('tbFournisseur').value;
        var av = document.getElementById('tbAV').value;
        var heure = document.getElementById('tbHeure').value;
        var date = document.getElementById('tbDate').value;
        //var chauffeur = document.getElementById('tbChauffeur').value;
        var chauffeur = "";
        //var chauffeur = document.getElementById('ddChauffeur').value;
        var statut = document.getElementById('cbStatut').value;
        var commentaire = document.getElementById('tbCommentaire').value;
        
        var dataToAdd = "&oper=add&1=" + bonCommande + "&2=" + fournisseur + "&3=" + av + "&4=" + heure + "&5=" + date + "&6=" + chauffeur + "&7=" + statut + "&8=" + commentaire;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showBonCommandes();
    }    
    
    function addZero(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
    }

    function getHeure(ceci){
       var d = new Date()
       //alert( d.getHours() );
       //alert( d.getHours() );
       var heures = addZero(d.getHours());
       var minutes = addZero(d.getMinutes());

       document.getElementById(ceci.id).value = heures + ':' + minutes;
    }
    function getDate(ceci)
    {
        var d = new Date();
        var vMois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        var mois = vMois[d.getMonth()];
        var jour = d.getDate();
        document.getElementById(ceci.id).value = jour + ' ' + mois;
    }
    
    function updateTimer(ceci)
    {
        timerDelay = ceci.value;
        clearTimer();
        updateBonCommandes();
    }
    
    function clearTimer()
    {
        clearTimeout(TIMER);
    }
    
    var TIMER;
    var updateBonCommandes = function(){
        showBonCommandes();
        TIMER = setTimeout(updateBonCommandes, timerDelay);
    };
    //setTimeout(updateBonCommandes, 1000);
    
</script>

<body class="body bonCommande" onload="updateBonCommandes();">
    <div name='bonCommande' class='base_page_boncommande serializable'>
    <div style="position: fixed; width: 100%;text-align: right;">
        <a class="lienTexte" style="background-color: #96B4C1;" href="jobgarage.php?succ=<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>">&nbsp;Jobs garage&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <form id="frm" name="frm" action=""> 
        <table style="width:100%;background-color: #FFFF99;">
            <tr>
                <td style="width:40%;text-align:left;"><img style="width: 388px; height: 81px;" src="../assets/images/LOGO_inter/logo_FFFF99_<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>.png" alt=""/></td>            
                <td style="width:40%;text-align:center;">
                    <label class="h1bonCommande">Bons de commande</label>
                </td>
                <td style="width:20%;text-align:right;" valign="middle">    
                    
                    <table class="tableMenuTop">
                        <tr>
                            <td class="tableMenuTopGeoTab"><label style="font-size: small">Geotab</label>
                                </br>
                                <a href="https://my31.geotab.com/" target="_blank"><img src="../assets/images/iconePlanete.png"></a>
                            </td>
                            <td class="tableMenuTopRefresh"><label style="font-size: small">Auto refresh</label>
                                </br>                                
                                <select title="Auto refresh" class="inputCombo" onchange="updateTimer(this);">
                                    <option value="60000">1min</option>
                                    <option value="300000">5min</option>
                                    <option value="600000">10min</option>
                                    <option value="3600000">1h</option>
                                </select>
                            </td>
                            <td class="tableMenuTopReload"><label style="font-size: small">Reload</label>
                                </br>
                                    <img src="../assets/images/iconeRefresh.png" alt="" style="width:24px; height: 24px;cursor: pointer; vertical-align: bottom;" title="Reload" onclick="javascript:location.reload();"/>
                            </td>
                            <td class="tableMenuTopLogout"><label style="font-size: small">Logout</label>
                                </br>
                                    <input class="boutonLogout" type="button" alt="Ajouter" onclick="javascript:window.location.replace('logout.php');" Title="Logout" alt="Logout">
                            </td>                            
                        </tr>                        
                    </table>                    
                </td>
        </table>        
        <datalist id="dl" name="dl"><?php echo IL_Utils::getAutoComplete('fournisseurBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?></datalist>         
        <hr>
        <table id="tbEntrerBonCommande" class="tableHaut">
            <tr>            
                <td class="bonCommande"># de commande</td>
                <td class="fournisseur">Fournisseur</td>
                <td class="av">AV</td>
                <td class="heure">Heure</td>
                <td class="date">Date</td>
                <td class="statut">Statut</td>
                <td class="commentaire">Commentaire</td>
                <td class="ajouter"></td>
            </tr>
            <tr>
                <td class="bonCommande"><input type="text" class="tbBonCommande" maxlength="6" id="tbBonCommande" name="tbBonCommande"></td>
                <td class="fournisseur">
                    <input type="text" class="tbFournisseur" name="tbFournisseur" id="tbFournisseur" list="dlFournisseur">
                    <datalist class="input" id="dlFournisseur" name="dlFournisseur">
                        <?php echo IL_Utils::getAutoComplete('fournisseurBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>
                <td class="av">
                    <input type="text" class="tbAV" id="tbAV" name="tbAV" list="dlAV">
                    <datalist id="dlAV" name="dlAV">
                        <?php echo IL_Utils::getAutoComplete('aviseur', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>
                <td class="heure"><input type="text" class="tbHeure" id="tbHeure" onfocus="getHeure(this);" name="tbHeure"></td>
                <td class="date"><input type="text" class="tbDate" id="tbDate" onfocus="getDate(this);" name="tbDate"></td>
                <!--
                <td class="chauffeur">
                    <input type="text" class="tbChauffeur" id="tbChauffeur" name="tbChauffeur" list="dlChauffeur">
                    <datalist id="dlChauffeur" name="dlChauffeur">
                        <?php //echo IL_Utils::getAutoComplete('chauffeur', 1, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                    <!--
                    <select id="ddChauffeur" class="inputCombo">
                        <option value="https://my31.geotab.com/">Jean-Guy</option>
                        <option value="https://my31.geotab.com/">Claude</option>
                        <option value="https://my31.geotab.com/">Daniel</option>
                        <option value="https://my31.geotab.com/">René</option>
                        <option value="https://my31.geotab.com/">Sylvain</option>
                        <option value="https://my31.geotab.com/">Benoit</option>
                        <option value="https://my31.geotab.com/">Éric</option>
                    </select>
                </td>
                -->
                <td class="statut">                    
                    <!--DATALIST
                    <input type="text" class="input" id="tbStatut" name="tbStatut" list="dlStatut">                    
                    <datalist id="dlStatut" name="dlStatut">
                        <?php //echo IL_Utils::getAutoComplete('statutBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>-->
                    <select class="inputCombo" id="cbStatut"><option>En cours</option><option>Attribue</option><option>Recu</option></select>                    
                </td>
                <td class="commentaire"><textarea rows="1" class="" cols="60" type="text" class="input" id="tbCommentaire" name="tbCommentaire"></textarea></td>
                <td class="ajouter">
                    <div class="tooltip">
                        <input class="boutonAjout" type="button" alt="Ajouter" onclick="ajouterBonCommande();">
                        <span class="tooltiptext">Ajouter</span>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
        <table id="tbBonCommandes" class="tableData" cellspacing="0" cellpadding="0"></table>
    </form>

    <!--<a href='https://interlivraison.reseaudynamique.com/boncommande/boncommande.php?succ=CIB'>CIB</a>-->
<br>
    </div>
</body>
</html>