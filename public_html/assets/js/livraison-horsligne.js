$(document).ready(function() {
    
    localforage.length().then(function(numberOfKeys) {
        // Outputs the length of the database.
        if(numberOfKeys == 0) {
            $('.nodata').show();
        }
        else {
            $('.nodata').hide();
            
            // Empty out the div that will hold the generated content
            $(".results-container").empty();
            
            // Iterate over localForage
            localforage.iterate(function(value, key, iterationNumber) {
                // Append data to template
                $("#resultsTemplate").tmpl( value ).appendTo(".results-container");
                
            }).then(function() {
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
            }).catch(function(err) {
                // This code runs if there were any errors
                console.log(err);
            });
        }
    }).catch(function(err) {
        // This code runs if there were any errors
        console.log(err);
    });
    
});