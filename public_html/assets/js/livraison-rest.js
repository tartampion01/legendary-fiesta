$( document ).ready(function() {
    // VAR _N est définie dans les pages d'affichage des camions neufs et usagés 1=new 0=used 2=remorque-all 3=remorque-di-mond 4=remorque-doepker
    // je mets ça pour être certain qu'on à rien d'autre que 0 ou 1
    if( (_N != 1) && (_N != 0) && ( _N != 2 ) && ( _N != 3 ) && ( _N != 4 ))
        _N = 1;
    
    // To set the scrollTo after search events
    maxwidth = $('html').css('max-width');

    // Bind click event on each filter link
    $('.filter-link').each(function(){
        
        $(this).on('click', function() {
            
            var selected = $(this).data('selected');

            if(selected == true) {
                $(this).data('selected', false);
                $(this).removeClass('selected');
                //$('.filter-link').show();
                
                // Check if at leat we have a custom criteria
                var customCriteria = '';
                $('.GpcMenuCategory .filter-link.selected').each(function() {
                    if(customCriteria == '')
                        customCriteria = $(this).data('custom-criteria');
                });
                
                if(customCriteria == '') {
                    if( _N == 1 )
                        customCriteria = ' (marque="international" AND DisplayOnWebSite=1) or (marque="isuzu" AND DisplayOnWebSite=1) or marque="kalmar" AND ';
                    else if( _N == 2)
                        customCriteria = ' engine="-" AND (marque="doepker" or marque="di-mond" or marque="asetrail") AND ';
                    else if( _N == 3)
                        customCriteria = ' engine="-" AND marque="di-mond" AND ';
                    else if( _N == 4)
                        customCriteria = ' engine="-" AND marque="doepker" AND ';
                    else
                        customCriteria = '';
                }

                if( _N == 3 || _N == 4)
                    _N = 2;
                     
                //fetchRecords(field, value, customCriteria, true, _N);
                fetchRecords('', '', customCriteria, true, _N);
            }
            else {
                $(this).addClass('selected');
                $(this).data('selected', true);
                
                // Get search params
                var field = $(this).attr('data-field');
                var value = $(this).attr('data-value');
                
                var customCriteria = $(this).data('custom-criteria');
                
                fetchRecords(field, value, customCriteria, true, _N);
            }
        });
    });
    
    // Bind click event on limit per page links
    $('.limit-per-page').on('click', function() {
        $('.limit-per-page').removeClass('selected');
        $(this).addClass('selected');
        
        var field = $('.GpcMenu').find('li.selected').data('field');
        var value = $('.GpcMenu').find('li.selected').data('value');
        var customCriteria = $('.GpcMenu').find('li.selected').data('custom-criteria');
        
        if(field == undefined) {
            field = '';
        }
        if(value == undefined) {
            value = '';
        }
        if(customCriteria == undefined) {
            if( _N == 1 )
                customCriteria = ' (marque="international" AND DisplayOnWebSite=1) or (marque="isuzu" AND DisplayOnWebSite=1) or marque="kalmar" AND ';
            else if( _N == 2)
                customCriteria = ' engine="-" AND (marque="doepker" or marque="di-mond" or marque="asetrail") AND ';
            else if( _N == 3)
                customCriteria = ' engine="-" AND marque="di-mond" AND ';
            else if( _N == 4)
                customCriteria = ' engine="-" AND marque="doepker" AND ';
            else
                customCriteria = '';
        }
        
        if( _N == 3 || _N == 4)
            _N = 2;
        
        fetchRecords(field, value, customCriteria, true, _N);
    });
    
    // Bind click event on search sorting dropdown
    $('.search-sorting').on('change', function() {
        var field = $('.GpcMenu').find('li.selected').data('field');
        var value = $('.GpcMenu').find('li.selected').data('value');
        var customCriteria = $('.GpcMenu').find('li.selected').data('custom-criteria');
        
        if(field == undefined) {
            field = '';
        }
        if(value == undefined) {
            value = '';
        }
        if(customCriteria == undefined) {
            if( _N == 1 )
                customCriteria = ' (marque="international" AND DisplayOnWebSite=1) or (marque="isuzu" AND DisplayOnWebSite=1) or marque="kalmar" AND ';
            else if( _N == 2)
                customCriteria = ' engine="-" AND (marque="doepker" or marque="di-mond" or marque="asetrail") AND ';
            else if( _N == 3)
                customCriteria = ' engine="-" AND marque="di-mond" AND ';
            else if( _N == 4)
                customCriteria = ' engine="-" AND marque="doepker" AND ';
            else
                customCriteria = '';
        }
        
        if( _N == 3 || _N == 4)
            _N = 2;
        
        fetchRecords(field, value, customCriteria, true, _N);
    });
    
    // On document load, search for all products (with default customCriteria)
    //fetchRecords('', '', 'engine <> "-" AND marque <> "asetrail" and marque <> "doepker" AND ', true);
});

function fetchRecords(field, value, customCriteria, resetPage, newOrOld) { // new == 1 old == 0
    
    // Show loading spinner
    $('.loading-overlay').show();

    var currentPage = 1;
    if(typeof $pagination !== 'undefined' && resetPage == false)
        currentPage = $pagination.twbsPagination('getCurrentPage');
    else
        currentPage = 1;
    var limitPerPage = $('.GpcPagerCountSelector').children('div.selected').html();

    // Get sortBy value
    var sortBy = $('.search-sorting option:selected').val();
    
    if( newOrOld == 3 || newOrOld == 4)
        newOrOld = 2;
    
    var params = {
        'field' : field,
        'value' : value,
        'customCriteria' : customCriteria,
        'sortBy' : sortBy,
        'currentPage' : currentPage,
        'limitPerPage' : limitPerPage,
        'arrayFilters' : getSearchTerms()
    };

    $.ajax({
        url: 'http://interlivraison.com/api/read.php?n=' + newOrOld,
        type: "GET",
        data: 'params='+JSON.stringify(params),
        dataType: 'json',
        async: true,
        success: function(data){

            if(data.records != null) {
                if(data.records.length > 0) {

                    // Empty out the div that will hold the generated content
                    $(".results-container").empty();
                    // Call the tmpl function, pass in the data and have it append to resultsTemplate
                    $("#resultsTemplate").tmpl( data.records ).appendTo(".results-container");

                    // Get total page count
                    var totalPages = Math.ceil(data.countRows / limitPerPage);
                    
                    // Set total records count
                    $('.GpcPagedResultTotalCount').html(data.countRows);
                    
                    if(limitPerPage > data.countRows)
                        limitPerPage = data.countRows;
                        
                    // Set page results current count
                    var resultsRange = '';
                    if(currentPage == 1)
                        resultsRange = '1 - ' + limitPerPage;
                    else if(currentPage == totalPages)
                        resultsRange = parseInt(limitPerPage * currentPage - limitPerPage + 1) + ' - ' + parseInt(data.countRows);
                    else
                        resultsRange = parseInt(limitPerPage * currentPage - limitPerPage + 1) + ' - ' + parseInt(limitPerPage * currentPage);
                    
                    $('.GpcPagedResultCurrentCount').html(resultsRange);
                    $('.GpcPagedResultCount').show();
                    
                    // Set paginator control
                    $pagination = $('.pagination')
                    $pagination.twbsPagination('destroy');
                    $pagination.twbsPagination($.extend({}, {
                        startPage: currentPage,
                        totalPages: totalPages,
                        visiblePages: 5,
                        first: '&lt;&lt;',
                        prev: 'Précédent',
                        next: 'Suivant',
                        last: '&gt;&gt;',
                        initiateStartPageClick: false,
                        onPageClick: function (event, page) {
                            
                            fetchRecords(field, value, customCriteria, false, newOrOld);
                            
                            // Scroll page to top of search results
                            var scrollTo = '.GpcMenuWrapper';
                            if(maxwidth == '640px')
                                scrollTo = '.GpcPagedResultCount';
                            $('html, body').animate({
                                scrollTop: $(scrollTo).offset().top
                            }, 750);
                        }
                    }));
                    
                    // Reset filter links count number
                    $(".GpcMenuCategory").each(function() {

                        var countField = $(this).find('.filter-link:first').data('field');
                        var countCustomCriteria = $(this).find('.filter-link:first').data('custom-criteria');
                        var countParams = {
                            'field' : countField,
                            'value' : value,
                            'customCriteria' : countCustomCriteria,
                            'searchType' : field,
                            'arrayFilters' : getSearchTerms()
                        };

                        $.ajax({
                            url: 'http://reseaudynamique.com/api/read-count-filter.php?n=' + newOrOld,
                            type: "GET",
                            data: 'params='+JSON.stringify(countParams),
                            dataType: 'json',
                            async: false,
                            success: function(dataCount){

                                if(Object.keys(dataCount).length) {

                                    // Update every filter links count
                                    $('.GpcMenuCategory').find('.filter-link[data-field="'+countField+'"]').each(function(index) {

                                        $(this).hide();

                                        for(i=0; i<dataCount.length; i++) {
                                            
                                            if (Object.values(dataCount[i]).indexOf($(this).attr('data-value').replace('%2B', '+')) > -1) {

                                                $(this).find('.GpcMenuItemCount').html('(' + dataCount[i].count + ')');
                                                $(this).show();
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    });
                }
                else {
                    $('.results-container').html('AUCUN PRODUIT');
                    $('.GpcPagedResultCount').show();
                }
            }
            else {
                $('.results-container').html(data.message);
                $('.GpcPagedResultCount').show();
            }
            
            /*$('html, body').animate({
                scrollTop: $(scrollTo).offset().top
            }, 750);*/

            // Hide loading spinner
            $('.loading-overlay').hide();
        },
        error: function(xhr, status, error) {
            $('.results-container').html(error);
        }
    });
}

function getSearchTerms() {
    
    var where = [];
    var counter = 0;
    
    $('.GpcMenuCategory .filter-link.selected').each(function() {
        
        var field = $(this).parents('ul').attr('class');
        var value = $(this).attr('data-value');
        
        var newElement = {};
        newElement.field = field;
        newElement.value = value;
        where.push(newElement);
        
        counter++;
    });
    
    //console.log(where);
    return where;
}

// Function that refresh the paginator control
function refreshPagination() {
    $('.pagination').empty();
    $('.pagination').removeData("twbs-pagination");
    $('.pagination').unbind("page");
}

$(window).on('resize', function() {
    // To set the scrollTo after search events
    maxwidth = $('html').css('max-width');
});