<?php require_once(dirname(__DIR__) . '/../_includes/header/_header_bonCommande_CIB.php');?>
<script type="text/javascript">
    
    // WRITE JS VARIABLE WITH PHP SESSION VALUE
    <?php echo "var succ = '" . IL_Session::r(IL_SessionVariables::SUCCURSALE) . "';" ?>
        
    var timerDelay = 60000;

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
            updateJobGarage();
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
        
        updateJobGarage();
    }
    
    function saveRow(rowId){
        
        var jobGarage = document.getElementById('tbJobGarage_' + rowId).value;
        var vendeur = document.getElementById('tbVendeur_' + rowId).value;
        var fournisseur = document.getElementById('tbFournisseur_' + rowId).value;
        var heure = document.getElementById('tbHeure_' + rowId).value;
        var date = document.getElementById('tbDate_' + rowId).value;
        var datePrevue = document.getElementById('tbDatePrevue_' + rowId).value;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
                showJobGarage();
            }
        };

        var dataToAdd = "&oper=updateLigne&1=" + rowId + "&2=" + jobGarage + "&3=" + vendeur + "&4=" + fournisseur + "&5=" + heure + "&6=" + date + "&7=" + datePrevue;
        xhttp.open("GET", "callJobGarage.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showJobGarage();
        
    }    
    
    function ClearTopData()
    {
        document.getElementById('tbJobGarage').value = '';
        document.getElementById('tbVendeur').value = '';
        document.getElementById('tbFournisseur').value = '';
        document.getElementById('tbHeure').value = '';
        document.getElementById('tbDate').value = '';
        document.getElementById('tbDatePrevue').value = '';
    }
    
    function updateStatut(dropDown, pkJobGarage){
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showJobGarage();
            }
        };
        
        var dataToAdd = "&oper=updateStatut&1=" + pkJobGarage + "&2=" + dropDown.value;
        xhttp.open("GET", "callJobGarage.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
    }
    
    function showJobGarage() {

        var xhttp;
        if (succ == "") {
            document.getElementById("tableJobGarage").innerHTML = "";
            return;
        }
        
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tableJobGarage").innerHTML = this.responseText;
            }
        };

        xhttp.open("GET", "callJobGarage.php?succ=" + succ  + "&oper=read", true);
        xhttp.send();
    }
    
    function deleteRow(pkJobGarage)
    {
        clearTimeout(showJobGarage);
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
            }
        };
        
        var dataToAdd = "&oper=del&pk=" + pkJobGarage;
        xhttp.open("GET", "callJobGarage.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showJobGarage();
    }
    
    function confirmerSuppression(noCommande)
    {
        return confirm("Supprimer [ " + noCommande + " ] ?");
    }
    
    function ajouterJobGarage() {
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                ClearTopData();
                showJobGarage();
            }
        };
        
        var jobGarage = document.getElementById('tbJobGarage').value;
        var vendeur = document.getElementById('tbVendeur').value;
        var fournisseur = document.getElementById('tbFournisseur').value;
        var heure = document.getElementById('tbHeure').value;
        var date = document.getElementById('tbDate').value;
        var statut = document.getElementById('cbStatutJob').value;
        var datePrevue = document.getElementById('tbDatePrevue').value;
        
        var dataToAdd = "&oper=add&1=" + jobGarage + "&2=" + vendeur + "&3=" + fournisseur + "&4=" + heure + "&5=" + date + "&6=" + statut + "&7=" + datePrevue;
        xhttp.open("GET", "callJobGarage.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showJobGarage();
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
        updateJobGarage();
    }
    
    function clearTimer()
    {
        clearTimeout(TIMER);
    }
    
    var TIMER;
    var updateJobGarage = function(){
        showJobGarage();
        TIMER = setTimeout(updateJobGarage, timerDelay);
    };
    //setTimeout(updateJobGarage, 1000);
    
</script>

<body onload="updateJobGarage();">
    <div name='bonCommande' class='base_page_boncommande serializable'>
    <div style="position: fixed; width: 100%;text-align: right;">
        <a class="lienTexte" href="boncommande.php?succ=<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>">&nbsp;Bons de commande&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <form id="frm" name="frm" action=""> 
        <table style="width:100%;">
            <tr>
                <td style="width:40%;text-align:left;"><img style="width: 388px; height: 81px;" src="../assets/images/logo_C5C5C5_<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>.png" alt=""/></td>            
                <td style="width:40%;text-align:center;">
                    <label class="h1bonCommande">Jobs Garage</label>
                </td>
                <td style="width:20%;text-align:right;" valign="middle">    
                    
                    <table class="tableMenuTop">
                        <tr>
                            <td class="tableMenuTopRefresh">Auto refresh
                                </br>                                
                                <select title="Auto refresh" class="inputCombo" onchange="updateTimer(this);">
                                    <option value="60000">1min</option>
                                    <option value="300000">5min</option>
                                    <option value="600000">10min</option>
                                    <option value="3600000">1h</option>
                                </select>
                            </td>
                            <td class="tableMenuTopReload">Reload
                                </br>
                                    <img src="../assets/images/iconeRefresh.png" alt="" style="width:24px; height: 24px;cursor: pointer; vertical-align: bottom;" title="Reload" onclick="javascript:location.reload();"/>
                            </td>
                            <td class="tableMenuTopLogout">Logout
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
                <td class="jg edit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="jg jobgarage"># de job</td>
                <td class="jg vendeur">Vendeur</td>
                <td class="jg fournisseur">Fournisseur</td>
                <td class="jg heure">Heure</td>
                <td class="jg date">Date</td>
                <td class="jg statut">Statut</td>
                <td class="jg datePrevue">Date Prevue</td>
                <td class="jg ajouter"></td>
            </tr>
            <tr>
                <td class="jg edit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td class="jg jobgarage"><input type="text" class="jg tbJobGarage" maxlength="6" id="tbJobGarage" name="tbJobGarage"></td>
                <td class="jg av">
                    <input type="text" class="jg tbVendeur" id="tbVendeur" name="tbVendeur" list="dlAV">
                    <datalist id="dlAV" name="dlAV">
                        <?php echo IL_Utils::getAutoComplete('vendeurJobGarage', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>
                <td class="jg fournisseur">
                    <input type="text" class="jg tbFournisseur" name="tbFournisseur" id="tbFournisseur" list="dlFournisseur">
                    <datalist class="jg input" id="dlFournisseur" name="dlFournisseur">
                        <?php echo IL_Utils::getAutoComplete('fournisseurJobGarage', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>
                
                <td class="heure"><input type="text" class="jg tbHeure" id="tbHeure" onfocus="getHeure(this);" name="tbHeure"></td>
                <td class="date"><input type="text" class="jg tbDate" id="tbDate" onfocus="getDate(this);" name="tbDate"></td>
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
                <td class="jg statut">                    
                    <!--DATALIST
                    <input type="text" class="input" id="tbStatut" name="tbStatut" list="dlStatut">                    
                    <datalist id="dlStatut" name="dlStatut">
                        <?php //echo IL_Utils::getAutoComplete('statutBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>-->
                    <select class="jg inputCombo" id="cbStatutJob"><option>Commandee</option><option>En cours</option><option>Bin job</option></select>                    
                </td>
                <td class="jg date"><input type="date" class="jg tbDatePrevue" id="tbDatePrevue" name="tbDate" value="<?php echo date('Y-m-d'); ?>"></td>
                <td class="jg ajouter">
                    <div class="jg tooltip">
                        <input class="jg boutonAjout" type="button" alt="Ajouter" onclick="ajouterJobGarage();">
                        <span class="jg tooltiptext">Ajouter</span>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
        <table id="tableJobGarage" class="tableData" cellspacing="0" cellpadding="0"></table>
    </form>

    <!--<a href='https://interlivraison.reseaudynamique.com/boncommande/boncommande.php?succ=CIB'>CIB</a>-->
<br>
    </div>
</body>
</html>