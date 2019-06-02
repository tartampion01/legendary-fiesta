$( document ).ready(function() {

    var postData = {};
    postData.filterRows = null;
    postData.sortBy = null;
    postData.orderBy = null;

    var ID_LIVRAISON = -1;
    var CLICKED_TR = null;
    var SIGNATURE_TD = null;
    var CLICKED_NAME = null;
    var CLICKED_TIME = null;
    
    var $sigdiv = $('.jSignature');
    
    window.addEventListener('load', function() {
        if(!navigator.onLine) {
            loadOfflineData();
        }
        else
        {
            fetchRecords(postData);
        }
    });
    
    window.addEventListener('offline', function() {
        loadOfflineData();
    });
    
    window.addEventListener('online', function() {
        if(navigator.onLine) {
            if( JSON.parse(window.localStorage.getItem('ELITE_DAY_DATA')) == null )
                fetchRecords(postData);
        }
    });
    
    // Bind click on add an item row (filters)
    $('.addItemFilter').on('click', function() {
        btn = $(this);
        var itemRowCount = $(btn).attr('data-item-row');
        itemRowCount++
        var data = [
            { counter: itemRowCount }
        ];
        $('.addItemFilter.firstItemRow').attr('data-item-row', itemRowCount);
        $("#filtersTemplate").tmpl(data).appendTo(".cloneDestination");
    });
    
    // Bind click on remove an item row (filters)
    $('body').on('click', '.removeItem', function() {
        var btn = $(this);
        var itemRowCount = $('.addItemFilter.firstItemRow').attr('data-item-row');
        itemRowCount--;
        var itemRow = $(btn).attr('data-item-row');
        $('.itemRow' + itemRow).remove();
        $('.addItemFilter.firstItemRow').attr('data-item-row', itemRowCount);
        
        $('.btnSearch').trigger('click');
    });
    
    // Bind click on order by column headers
    /*
    $('.sortable').on('click', function() {
        var self = $(this);
        
        var sortBy = self.attr('data-order-by');
        var orderBy = self.find('.sortIcon:visible').attr('data-order');
        
        postData.sortBy = sortBy;
        postData.orderBy = orderBy;
        
        $('.sortable').css({'color': 'black', 'font-weight': '700'});
        self.css({color: 'white', 'font-weight': '100'});
        $('.up', this).toggle();
        $('.down', this).toggle();
        
        fetchRecords(postData);
    });
    */
    
    // Bind click on result rows (to edit page)
    $('body').on('click', '.results-container tr', function() {

        var row = $(this);
        
        ID_LIVRAISON = row.find('.isHidden').find('span').html();

        CLICKED_TR = $(this);
        SIGNATURE_TD = CLICKED_TR.find('.signature').find('td');
        CLICKED_NAME = CLICKED_TR.find('.nomSignataire').find('span');
        CLICKED_TIME = CLICKED_TR.find('.dateLivraison').find('span');
        
        //id_livraison = row.find('.'
        overlay(true);
        
        // Affiche la div pour la signature avec nom déjà présent
        $('#tbNomSignataire').val(CLICKED_NAME.text());
        $sigdiv.jSignature('reset');
        
        // Afficher la div avec le canvas
        //$('#divCentreeSignature').attr('style','visibility:visible;background-color: white; width: 50%; height: 260px;margin:auto;padding:3px;border-width:2px;border-color:black;z-index:2;position:relative;');
        $('#divCentreeSignature').attr('style','visibility:visible;background-color: white; margin:auto;padding:3px;border-width:2px;border-color:black;z-index:2;position:fixed;left:50%;transform: translate(-50%, 0);top:1px;');
        $('#tbNomSignataire').focus();
        
        //console.log($('.jSignature').jSignature());
        // Destroy the signature plugin instance
        $sigdiv.jSignature('enable');
        
        //window.location.href = '/livraison-edit.php?id_livraison=' + id_livraison + '&r=' + Math.floor((Math.random() * 100000000000) + 1);
        
    });
    
    $('#btnSignatureAnnule').click(function(){
        overlay(false);
        $('#divCentreeSignature').attr('style','visibility:hidden;');
    });
    
    $('#btnSignatureOK').click(function(){
        overlay(false);
        
        // Récupérer signature data et mettre dans Bonne cellule 'signature'...
        $('#divCentreeSignature').attr('style','visibility:hidden;');
        
        var datapair = $('.jSignature').jSignature('getData', 'base30');
        var i = new Image();
        i.src = 'data:' + datapair[0] + ',' + datapair[1];
        i.name = 'HALABELLEIMAGEDESIGNATURE'; // *** TO BE REMOVED OR MODIFIED ***
        i.id = 'HALABELLEIMAGEDESIGNATURE'; // *** TO BE REMOVED OR MODIFIED ***
        $('.dumpSignature').empty(); // *** TO BE REMOVED ***
        $(i).appendTo($('.dumpSignature')); // append the image (base30) to DOM.
        $('.jSignature').removeClass('active');
        $sigdiv.jSignature('disable');
        
        var fakeSignature = $('.converter');

        var html;
        fakeSignature.jSignature();
        try {
            fakeSignature.jSignature("importData", i.src);
            svg = fakeSignature.jSignature("getData","svg")[1];

            imgSRC = '<span id="imgSRC" style="display:none;">' + i.src + '</span>';
            signature = '<div class="svgSignature"><svg viewBox="0 0 600 150">' + svg + '</svg></div>';
            
            SIGNATURE_TD.context.cells[6].innerHTML = imgSRC + signature;
        }
        catch(error) {
            //alert('Error found');
            html = '<span>Erreur</span>';
            $(this).empty();
            $(html).appendTo(this);
            //console.log(this);
        }
        
        // NOM SIGNATAIRE
        var nomSignataire = $("#tbNomSignataire").val();
        CLICKED_NAME.text(nomSignataire);
        
        // DATE
        var d = new Date();
        var strDate = d.getFullYear() + "-" + ((d.getMonth()+1) < 10 ? "0" + (d.getMonth()+1): d.getMonth()+1 ) + "-" + d.getDate();
        var strHeure = " " + d.getHours() + ":" + ((d.getMinutes()) < 10 ?"0"+d.getMinutes():d.getMinutes()) + ":" + ((d.getSeconds()) < 10 ?"0"+d.getSeconds():d.getSeconds());
        
        CLICKED_TIME.text(strDate + strHeure);
        
        // SAUVEGARDE DB OU LOCALFORAGE
        
        $('tr.serializable').each(function() {

            var id = $(this).find('.isHidden').find('span').html();
            var date = $(this).find('.dateLivraison').find('span').html();
            var nomSignataire = $(this).find('.nomSignataire').find('span').html();
            var signature = $(this).find('#imgSRC').text();
            
            if( ID_LIVRAISON == id ){
                var postData = {
                    id_livraison: id,
                    dateLivraison: date,
                    nomSignataire: nomSignataire,
                    signature: signature
                };

                // Check connection is up/down
                if(Offline.state == 'up' && navigator.onLine) {
                    // Create livraison over ajax
                    url = 'api/update-livraisonElite.php';

                    $.ajax({
                        type: "GET",
                        url: url,
                        data: {'postData': JSON.stringify(postData)},
                        //contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        async: true,
                        cache: false,
                        success: function(data){
                            console.log(data);

                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Livraison enregistrée!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            //location.reload();
                            var pData = {};
                            pData.filterRows = null;
                            pData.sortBy = null;
                            pData.orderBy = null;
                            fetchRecords(pData);
                        },
                        error: function(errMsg) {
                            console.log(errMsg);
                        }
                    });

                    console.log(postData);
                }
                else if(Offline.state == 'down' || !navigator.onLine) {
                    //alert('Connection is DOWN');
                    // Store de query into localForage
                    insertQueryIntoLocalForage(postData);
                    
                    //update localStorage with Signature data
                    json = JSON.parse(window.localStorage.getItem('ELITE_DAY_DATA'));
                    
                    for(var i = 0; i < json.length; i++) {
                        if( json[i].id_livraison == id ){
                            json[i].nomSignataire = nomSignataire;
                            json[i].signature     = signature;
                            json[i].dateLivraison = date;
                        }
                    }
                    
                    window.localStorage.setItem('ELITE_DAY_DATA', JSON.stringify(json));
                }
            }
        })
    });
});

function overlay(show)
{
    var docHeight = $(document).height();
    var op = 0.0;
    
    if( show ){
        op = 0.4;
        $("body").append("<div id='overlay'></div>");
        
        $("#overlay")
        .height(docHeight)
        .css({
            'opacity' : op,
            'position': 'absolute',
            'top': 0,
            'left': 0,
            'background-color': 'black',
            'width': '100%',
            'z-index': '1'
         });
    }
    else
        $('#overlay').remove();
}

function fetchRecords(postData) {
    
    // Show loading spinner
    $('.loading').show();
    
    // Get the current page
    var currentPage = 1;
    if(typeof $pagination !== 'undefined'/* && resetPage == false*/)
        currentPage = $pagination.twbsPagination('getCurrentPage');
    else
        currentPage = 1;
    
    var params = {
        currentPage : currentPage,
        limitPerPage : 100,
        filterRows: postData.filterRows,
        sortBy: postData.sortBy,
        orderBy: postData.orderBy
    };
    
    $.ajax({
        url: 'api/read.php?SUCCURSALE=' + SUCCURSALE + '&NOEMPLOYE=' + NOEMPLOYE,
        type: "GET",
        data: 'params='+JSON.stringify(params),
        dataType: 'json',
        async: true,
        success: function(data){
            
            if(data.records != null) {
                if(data.records.length > 0) {
                    
                    window.localStorage.setItem("ELITE_DAY_DATA",JSON.stringify(data.records));
                    
                    // Empty out the div that will hold the generated content
                    $(".results-container").empty();
                    
                    // Append data to template
                    $("#resultsTemplate").tmpl( data.records ).appendTo(".results-container");
                    //console.log(data.records);
                    
                    // Setup jSignature
                    var fakeSignature = $('.converter');
                    $('td.signature').each(function() {

                        var _data = $(this).find('.jSignature').html();
                        
                        var html;
                        fakeSignature.jSignature();
                        try {
                            fakeSignature.jSignature("importData", _data);
                            svg = fakeSignature.jSignature("getData","svg")[1];

                            html = '<div class="svgSignature"><svg viewBox="0 0 600 150">' + svg + '</svg></div>';
                            $(html).appendTo(this);
                        }
                        catch(error) {
                            //alert('Error found');
                            html = '<span class="puree"></span>';
                            $(this).empty();
                            $(html).appendTo(this);
                            //console.log(this);
                        }
                    });
                    
                    $('.loading').hide();
                    
                }
                else {
                    $(".results-container").empty().html('<tr><td colspan="6">Feuille de route vide</td></tr>');
                    $('.loading').hide();
                }
            }
            else {
                //$(".results-container").empty().html(data.error);
                $(".results-container").empty().html('<tr><td colspan="6">Feuille de route vide</td></tr>');
                $('.loading').hide();
            }
            console.log(data);
        },
        error: function(xhr, status, error) {
            $('.results-container').html(error.message);
            $('.loading').hide();
            console.log(xhr, status, error);
        }
    });
}

function loadOfflineData()
{
    // If offline AND we have loaded data
    if( JSON.parse(window.localStorage.getItem('ELITE_DAY_DATA')) !== null )
    {
        // Empty out the div that will hold the generated content
        $(".results-container").empty();

        // Append data to template
        $("#resultsTemplate").tmpl( JSON.parse(window.localStorage.getItem('ELITE_DAY_DATA')) ).appendTo(".results-container");
        //console.log(data.records);

        // Setup jSignature
        var fakeSignature = $('.converter');
        $('td.signature').each(function() {

            var _data = $(this).find('.jSignature').html();

            var html;
            fakeSignature.jSignature();
            try {
                fakeSignature.jSignature("importData", _data);
                svg = fakeSignature.jSignature("getData","svg")[1];

                html = '<div class="svgSignature"><svg viewBox="0 0 600 150">' + svg + '</svg></div>';
                $(html).appendTo(this);
            }
            catch(error) {
                //alert('Error found');
                html = '<span class="puree"></span>';
                $(this).empty();
                $(html).appendTo(this);
                //console.log(this);
            }
        });

        $('.loading').hide();
    }
    else
    {
    }
}

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("tbLivraisons");
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
      // -1 because of empty row at bottom  
      for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        //x = rows[i].getElementsByTagName("TD")[n];
        x = rows[i].cells[n].getElementsByTagName('span')[0].innerHTML;
        //y = rows[i + 1].getElementsByTagName("TD")[n];
        y = rows[i + 1].cells[n].getElementsByTagName('span')[0].innerHTML;

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