<?php require_once(dirname(__DIR__) . '/../_includes/header/_header_bonCommande_CIL.php');?>
<script type="text/javascript">
    
    // WRITE JS VARIABLE WITH PHP SESSION VALUE
    <?php echo "var succ = '" . IL_Session::r(IL_SessionVariables::SUCCURSALE) . "';" ?>
        
    var timerDelay = 5000;

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
        
        
        var endroitPickup = document.getElementById('tbEndroitPickup_' + rowId).value;
        var bonCommande = document.getElementById('tbBonCommande_' + rowId).value;
        var noConfirmation = document.getElementById('tbNoConfirmation_' + rowId).value;
        var commandePar = document.getElementById('tbCommandePar_' + rowId).value;
        var fournisseur = document.getElementById('tbFournisseur_' + rowId).value;
        var directiveSpeciale = document.getElementById('tbDirectiveSpeciale_' + rowId).value;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
                showBonCommandes();
            }
        };

        var dataToAdd = "&oper=updateLigne&1=" + rowId + "&2=" + endroitPickup + "&3=" + bonCommande + "&4=" + noConfirmation + "&5=" + commandePar + "&6=" + fournisseur + "&7=" + directiveSpeciale;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showBonCommandes();
        
    }    
    
    function ClearTopData()
    {        
        document.getElementById('tbEndroitPickup').value = '';
        document.getElementById('tbBonCommande').value = '';
        document.getElementById('tbNoConfirmation').value = '';
        document.getElementById('tbCommandePar').value = '';
        document.getElementById('tbContactFournisseur').value = '';
        document.getElementById('tbDirectiveSpeciale').value = '';
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

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                ClearTopData();
            }
        };
        
        var endroitPickup = document.getElementById('tbEndroitPickup').value;
        var bonCommande = document.getElementById('tbBonCommande').value;
        var noConfirmation = document.getElementById('tbNoConfirmation').value;
        var commandePar = document.getElementById('tbCommandePar').value;
        var contactFournisseur = document.getElementById('tbContactFournisseur').value;
        var directiveSpeciale = document.getElementById('tbDirectiveSpeciale').value;
        var statut = document.getElementById('cbStatut').value;
        
        var dataToAdd = "&oper=add&1=" + endroitPickup + "&2=" + bonCommande + "&3=" + noConfirmation + "&4=" + commandePar + "&5=" + contactFournisseur + "&6=" + directiveSpeciale + "&7=" + statut;
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

<body onload="updateBonCommandes();">
    <div name='bonCommande' class='base_page_boncommande serializable'>
    <form id="frm" name="frm" action=""> 
        <table>
            <tr>
                <td style="width:33%;text-align:center;"><img alt='LOGO JOLIETTE' style="width: 262px; height: 110px;" src="../assets/images/logo_C5C5C5_<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>.png" alt=""/></td>
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
                    &nbsp;
                    <img src="../assets/images/iconeRefresh.png" alt="" style="width:24px; height: 24px;cursor: pointer; vertical-align: bottom;" title="Reload" onclick="location.reload();"/>
                </td>
        </table>        
        <hr>
        <table id="tbEntrerBonCommande" class="tableHaut">
            <tr>            
                <td class="endroitPickup">Endroit de P/UP</td>
                <td class="bonCommande">No. Commande</td>
                <td class="noConfirmation">No. Confirmation</td>
                <td class="commandePar">Commandé par</td>
                <td class="contactFournisseur">Contact Fournisseur</td>
                <td class="directiveSpeciale">Directive spéciale</td>
                <td class="ajouter"></td>
            </tr>
            <tr>
                <td class="endroitPickup">
                    <input type="text" class="input" id="tbEndroitPickup" name="tbEndroitPickup" list="dlEndroitPickup">
                    <datalist id="dlEndroitPickup" name="dlEndroitPickup">
                        <?php echo IL_Utils::getAutoComplete('endroitPickup', 1, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>            
                <td class="bonCommande"><input type="text" class="input" id="tbBonCommande" name="tbBonCommande"></td>
                <td class="noConfirmation"><input type="text" class="input" id="tbNoConfirmation" name="tbNoConfirmation"></td>
                <td class="commandePar"><input type="text" class="input" id="tbCommandePar" name="tbCommandePar"></td>
                <td class="contactFournisseur">
                    <input type="text" class="input" id="tbContactFournisseur" name="tbContactFournisseur" list="dlFournisseur">
                    <datalist id="dlFournisseur" name="dlFournisseur">
                        <?php echo IL_Utils::getAutoComplete('fournisseur', 1, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>
                </td>
                <td class="directiveSpeciale"><input type="text" class="input tbCommentaire" id="tbDirectiveSpeciale" name="tbDirectiveSpeciale"><td>
                <td class="statut">
                    <!--DATALIST
                    <input type="text" class="input" id="tbStatut" name="tbStatut" list="dlStatut">                    
                    <datalist id="dlStatut" name="dlStatut">
                        <?php //echo IL_Utils::getAutoComplete('statutBonCommande', 0, IL_Session::r(IL_SessionVariables::SUCCURSALE)); ?>
                    </datalist>-->
                    <select class="inputCombo" id="cbStatut"><option>-</option><option>Ramassée</option><option>Annulée</option><option>Remise</option></select>
                </td>
                
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