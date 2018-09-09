$( document ).ready(function() {

    var postData = {};
    postData.filterRows = null;
    postData.sortBy = null;
    postData.orderBy = null;
    
    fetchRecords(postData);
    
    // Bind click on add an item row (filters)
    $('.addItem').on('click', function() {
        btn = $(this);
        var itemRowCount = $(btn).attr('data-item-row');
        itemRowCount++
        var data = [
            { counter: itemRowCount }
        ];
        $('.addItem.firstItemRow').attr('data-item-row', itemRowCount);
        $("#filtersTemplate").tmpl(data).appendTo(".cloneDestination");
    });
    
    // Bind click on remove an item row (filters)
    $('body').on('click', '.removeItem', function() {
        var btn = $(this);
        var itemRowCount = $('.addItem.firstItemRow').attr('data-item-row');
        itemRowCount--;
        var itemRow = $(btn).attr('data-item-row');
        $('.itemRow' + itemRow).remove();
        $('.addItem.firstItemRow').attr('data-item-row', itemRowCount);
        
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
    $('.btnSearch').on('click', function() {
        
        //var postData = {};
        var filterRows = [];
        $('.cloneDestination .clonable').each(function() {
            var field = $(this).find('select[name^="field"]').val();
            var comparator = $(this).find('select[name^="comparator"]').val();
            var value = $(this).find('input[name^="value"]').val();
            
            tmpfilter = {
                field: field,
                comparator: comparator,
                value: value,
                whereString: '(' + ''+field+'' + ' '+comparator+' ' + ' '+value+' ' + ')'
            };
            filterRows.push(tmpfilter);
        });
        postData.filterRows = filterRows;
        
        
        fetchRecords(postData);
    });
    
    // Bind click on result rows (to edit page)
    $('body').on('click', '.results-container tr', function() {
        var row = $(this);
        var id_livraison = row.find('.isHidden').find('span').html();
        window.location.href = '/livraison-edit.php?id_livraison=' + id_livraison;
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
        limitPerPage : 20,
        filterRows: postData.filterRows,
        sortBy: postData.sortBy,
        orderBy: postData.orderBy
    };
    
    $.ajax({
        url: 'api/read.php',
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
                    
                    // Setup sortable table
                    //$(".results-table").stupidtable();
                    
                    // Setup jSignature
                    var fakeSignature = $('.converter');
                    $('td.signature').each(function() {
                        var _data = $(this).find('.jSignature').html();
                        fakeSignature.jSignature();
                        fakeSignature.jSignature("importData", _data);
                        svg = fakeSignature.jSignature("getData","svg")[1];
                        var html = '<div class="svgSignature"><svg viewBox="0 0 600 150">' + svg + '</svg></div>';
			$(html).appendTo(this);
                    });
                    
                    // Get total page count
                    var totalPages = Math.ceil(data.countRows / 20);
                    
                    $('.pageNo').html('page ' + currentPage + ' / ' + totalPages);
                    
                    // Set paginator control
                    $pagination = $('.pagination')
                    $pagination.twbsPagination('destroy');
                    $pagination.twbsPagination($.extend({}, {
                        startPage: currentPage,
                        totalPages: totalPages,
                        visiblePages: 0,
                        first: ' ',
                        prev: ' ',
                        next: ' ',
                        last: ' ',
                        initiateStartPageClick: false,
                        firstClass: 'col buttonStyle align-center pull-left fas fa-fast-backward',
                        prevClass: 'col buttonStyle align-center pull-left fas fa-backward',
                        nextClass: 'col buttonStyle align-center fas fa-forward',
                        lastClass: 'col buttonStyle align-center pull-right fas fa-fast-forward',
                        onPageClick: function (event, page) {
                            
                            fetchRecords(postData);
                            
                            // Scroll page to top of search results
                            /*var scrollTo = '.GpcMenuWrapper';
                            if(maxwidth == '640px')
                                scrollTo = '.GpcPagedResultCount';
                            $('html, body').animate({
                                scrollTop: $(scrollTo).offset().top
                            }, 750);*/
                        }
                    }));
                    
                    
                    $('.loading').hide();
                }
                else {
                    alert('Aucune livraison');
                }
            }
            else {
                alert(data.message);
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