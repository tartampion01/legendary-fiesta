$( document ).ready(function() {

    var postData = {};
    postData.filterRows = null;
    postData.sortBy = null;
    postData.orderBy = null;
    
    var $sigdiv = $('.jSignature');
    
    fetchRecords(postData);
    
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
    
    // Bind click on search button    
    //$('.btnSearch').on('click', function() {
    $(window).load(function() {
        fetchRecords(postData);
        //console.log(postData);
    });
    
    // Bind click on result rows (to edit page)
    $('body').on('click', '.results-container tr', function() {

        var row = $(this);
        var id_livraison = row.find('.isHidden').find('span').html();
        
        $('#tbNomSignataire').val('');
        $sigdiv.jSignature('reset');
        
        // Afficher la div avec le canvas
        $('#divCentreeSignature').attr('style','visibility:visible;background-color: white; width: 50%; height: 260px;margin:auto;padding:3px;border-width:2px;border-color:black;');
        
        //console.log($('.jSignature').jSignature());
        // Destroy the signature plugin instance
        $sigdiv.jSignature('enable');
        
        //window.location.href = '/livraison-edit.php?id_livraison=' + id_livraison + '&r=' + Math.floor((Math.random() * 100000000000) + 1);
        
    });
    
    $('#btnSignatureOK').click(function(){
        // TODO Récupérer signature data et mettre dans Bonne cellule 'signature'...
        $('#divCentreeSignature').attr('style','visibility:hidden;');
    });
    
});

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
        limitPerPage : 50,
        filterRows: postData.filterRows,
        sortBy: postData.sortBy,
        orderBy: postData.orderBy
    };
    
    $.ajax({
        url: 'api/read.php?succursale=' + SUCCURSALE + '&NOEMPLOYE=' + NOEMPLOYE,
        type: "GET",
        data: 'params='+JSON.stringify(params),
        dataType: 'json',
        async: true,
        success: function(data){
            
            if(data.records != null) {
                if(data.records.length > 0) {
                    
                    // Empty out the div that will hold the generated content
                    $(".results-container").empty();
                    
                    // Append data to template
                    $("#resultsTemplate").tmpl( data.records ).appendTo(".results-container");
                    //console.log(data.records);
                    // Setup sortable table
                    //$(".results-table").stupidtable();
                    
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
                            html = '<span>Purée il n\'y a rien ici...</span>';
                            $(this).empty();
                            $(html).appendTo(this);
                            //console.log(this);
                        }
                    });
                    
                    
                    $('.loading').hide();
                }
                else {
                    alert('Aucune livraison');
                }
            }
            else {
                //$(".results-container").empty().html(data.error);
                $(".results-container").empty().html('<tr><td colspan="7">Il y a une erreur dans les données!</td></tr>');
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