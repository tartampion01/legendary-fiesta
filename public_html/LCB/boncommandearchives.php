<?php require_once(dirname(__DIR__) . '/../_includes/header/_header_bonCommande_CIL.php');?>
<script type="text/javascript">
    
    // WRITE JS VARIABLE WITH PHP SESSION VALUE
    <?php echo "var succ = '" . IL_Session::r(IL_SessionVariables::SUCCURSALE) . "';" ?>
        
    var timerDelay = 60000;
    var TIMER;
    var _dateChoisie = null;
    
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
    function deselectionner(){
        for (var i = 0; i < document.frm.radioEdit.length; i++) {
            document.frm.radioEdit[i].checked = false;
            document.getElementById('btnAjouter_' + document.frm.radioEdit[i].value).className = 'boutonSaveLigneHidden';
            document.getElementById("row_" + document.frm.radioEdit[i].value).className = '';
        }
        
        updateBonCommandes();
    }
    function ClearTopData(){        
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

        xhttp.open("GET", "callBonCommande.php?succ=" + succ  + "&oper=readArchive&archive=1&dateChoisie=" + _dateChoisie, true);
        xhttp.send();
    }
    function deleteRow(pkBonCommande){
        clearTimer(showBonCommandes);
        
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
                showBonCommandes();
            }
        };
        
        var endroitPickup = document.getElementById('tbEndroitPickup').value;
        var bonCommande = document.getElementById('tbBonCommande').value;
        var noConfirmation = document.getElementById('tbNoConfirmation').value;
        var commandePar = document.getElementById('tbCommandePar').value;
        var contactFournisseur = document.getElementById('tbContactFournisseur').value;
        var date = document.getElementById('tbDate').value;
        var directiveSpeciale = document.getElementById('tbDirectiveSpeciale').value;
        var statut = document.getElementById('cbStatut').value;
        
        var dataToAdd = "&oper=add&1=" + endroitPickup + "&2=" + bonCommande + "&3=" + noConfirmation + "&4=" + commandePar + "&5=" + contactFournisseur + "&6=" + date + "&7=" + directiveSpeciale + "&8=" + statut;
        xhttp.open("GET", "callBonCommande.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        //showBonCommandes();
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
    function getDate(ceci){
        var d = new Date();
        var vMois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        var mois = vMois[d.getMonth()];
        var jour = d.getDate();
        document.getElementById(ceci.id).value = jour + ' ' + mois;
    }
    function updateTimer(ceci){
        timerDelay = ceci.value;
        clearTimer();
        updateBonCommandes();
    }
    function getDateJour(){
        return new Date().toDateInputValue();
    }
    function clearTimer(){
        clearTimeout(TIMER);
    }
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
                <td style="width:30%;text-align:center;"><img alt='LOGO' style="width: 262px; height: 110px;" src="../assets/images/LOGO_inter/logo_FFFF99_<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>.png" alt=""/></td>
                <td style="width:50%;text-align:center;">
                    <label class="h1bonCommande">Bons de commande Archivés</label>
                </td>
                <td style="width:20%;text-align:right;" valign="middle">
                    <table class="tableMenuTop">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="tableMenuTopReload">Reload
                                </br>
                                    <img src="../assets/images/iconeRefresh.png" alt="" style="width:24px; height: 24px;cursor: pointer; vertical-align: bottom;" title="Reload" onclick="javascript:location.reload();"/>
                            </td>
                            <td class="tableMenuTopLogout">Logout
                                </br>
                                    <input class="boutonLogout" type="button" alt="Ajouter" onclick="javascript:window.location.replace('logout.php');" Title="Logout" alt="Logout">
                            </td>                            
                        </tr>
                        <tr>
                            <td style="padding-top: 5px" colspan="5">
                                <a href="boncommande.php">Retour</a>
                            </td>
                        </tr>
                    </table>
                </td>
        </table>        
        <hr>
        <table id="tbBonCommandes" class="tableData" cellspacing="0" cellpadding="0"></table>
    </form>

    <!--<a href='https://interlivraison.reseaudynamique.com/boncommande/boncommande.php?succ=CIB'>CIB</a>-->
<br>
    </div>
</body>
</html>