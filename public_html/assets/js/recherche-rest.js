$( document ).ready(function() {

    fetchRecords();

    $('.sortable').on('click', function() {
        $('.up', this).toggle();
        $('.down', this).toggle();
    });
});

function fetchRecords() {
    
    // Show loading spinner
    $('.loading').show();
    
    var params = {};
    
    $.ajax({
        url: 'api/read.php',
        type: "GET",
        data: 'params='+JSON.stringify(params),
        dataType: 'json',
        async: true,
        success: function(data){
            
            if(data.records != null) {
                if(data.records.length > 0) {
                    
                    $("#resultsTemplate").tmpl( data.records ).appendTo(".results-container");
                    
                    $(".results-table").stupidtable();
                    
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
            //$('.results-container').html(error);
        }
    });
}