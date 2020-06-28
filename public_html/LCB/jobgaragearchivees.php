<?php require_once(dirname(__DIR__) . '/../_includes/header/_header_bonCommande_LCB.php');?>
<script type="text/javascript">
    
    // WRITE JS VARIABLE WITH PHP SESSION VALUE
    <?php echo "var succ = '" . IL_Session::r(IL_SessionVariables::SUCCURSALE) . "';" ?>
        
    var timerDelay = 6000000;

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
        var av = document.getElementById('tbAV_' + rowId).value;
        var vendeur = document.getElementById('tbVendeur_' + rowId).value;
        var fournisseur = document.getElementById('tbFournisseur_' + rowId).value;
        var heure = document.getElementById('tbHeure_' + rowId).value;
        var date = document.getElementById('tbDate_' + rowId).value;
        var transport = document.getElementById('ddTransport_' + rowId).value;
        var datePrevue = document.getElementById('tbDatePrevue_' + rowId).value;
        var AMouPM = document.getElementById('rbAM_' + rowId).checked ? "AM" : "PM";
        var commentaire = document.getElementById('tbCommentaire_' + rowId).value;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
                showJobGarage();
            }
        };

        var dataToAdd = "&oper=updateLigne&1=" + rowId + "&2=" + jobGarage + "&3=" + av + "&4=" + vendeur + "&5=" + fournisseur + "&6=" + heure + "&7=" + date + "&8=" + transport + "&9=" + datePrevue + "&10=" + AMouPM + "&11=" + commentaire;
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
        document.getElementById('tbCommentaire').value = '';
        document.getElementById('tbDatePrevue').value = '';
        document.getElementById('cbStatutJob').value = 'A commander';
        document.getElementById('tbTransport').value = 'Notre chauffeur';
        document.getElementById('rbAM').checked  = true;
        document.getElementById('rbPM').checked  = false;
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
    
    function updateStatutReceptionnee(checkbox, pkJobGarage){
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                showJobGarage();
            }
        };
        
        var dataToAdd = "&oper=updateStatutReceptionnee&1=" + pkJobGarage + "&2=" + (checkbox.checked?1:0);
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

        xhttp.open("GET", "callJobGarage.php?succ=" + succ  + "&oper=readArchive", true);
        xhttp.send();
    }
    
    function deleteArchive(pkJobGarage)
    {
        clearTimeout(showJobGarage);
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("divSauvegarde").innerHTML = this.responseText;
            }
        };
        
        var dataToAdd = "&oper=deleteFromArchive&pk=" + pkJobGarage;
        xhttp.open("GET", "callJobGarage.php?succ=" + succ + dataToAdd, true);
        xhttp.send();
        
        showJobGarage();
    }
    
    function confirmerSuppression(noCommande)
    {
        return confirm("Supprimer job [ " + noCommande + " ] ?");
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
        var av = document.getElementById('tbAV').value;
        var vendeur = document.getElementById('tbVendeur').value;
        var fournisseur = document.getElementById('tbFournisseur').value;
        var heure = document.getElementById('tbHeure').value;
        var date = document.getElementById('tbDate').value;
        var transport = document.getElementById('tbTransport').value;
        var statut = document.getElementById('cbStatutJob').value;
        var datePrevue = document.getElementById('tbDatePrevue').value;
        var commentaire = document.getElementById('tbCommentaire').value;
        
        var dataToAdd = "&oper=add&1=" + jobGarage + "&2=" + av + "&3=" + vendeur + "&4=" + fournisseur + "&5=" + heure + "&6=" + date + "&7=" + transport + "&8=" + statut + "&9=" + datePrevue +  "&10=" + commentaire;
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
    
    function highlightRadioAM(ceci)
    {
        //alert( ceci.id.replace('AM','PM') + 'label' );
        document.getElementById(ceci.id + 'label').style.backgroundColor = "#66FF99";
        document.getElementById(ceci.id.replace('AM','PM') + 'label').style.backgroundColor = "#C5C5C5";
    }
    
    function highlightRadioPM(ceci)
    {
        //alert( ceci.id.replace('PM','AM') + 'label' );
        document.getElementById(ceci.id.replace('PM','AM') + 'label').style.backgroundColor = "#C5C5C5";
        document.getElementById(ceci.id + 'label').style.backgroundColor = "#CC9966";
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
    <form id="frm" name="frm" action=""> 
        <table style="width:100%;">
            <tr>
                <td style="width:45%;text-align:left;"><img style="width: 388px; height: 81px;" src="../assets/images/LOGO_inter/logo_C5C5C5_<?php echo IL_Session::r(IL_SessionVariables::SUCCURSALE); ?>.png" alt=""/></td>            
                <td style="width:45%;text-align:center;">
                    <label class="h1bonCommande">Jobs Garage Archivées</label>
                </td>
                <td style="width:10%;text-align:right;" valign="middle">    
                    
                    <table class="tableMenuTop">
                        <tr>
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
        <table id="tableJobGarage" class="tableData" cellspacing="0" cellpadding="0"></table>
    </form>

    <!--<a href='https://interlivraison.reseaudynamique.com/boncommande/boncommande.php?succ=LCB'>LCB</a>-->
<br>
    </div>
</body>
</html>