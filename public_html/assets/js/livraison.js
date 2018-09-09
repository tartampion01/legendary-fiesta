$( document ).ready(function() {
    
    var $sigdiv = $('.jSignature');
    $sigdiv.jSignature();
    $sigdiv.jSignature('disable');
    
    var edit_page = false;
    
    // Check if we are in livraison-edit
    if($('.dumpSignature.edit').length) {
        $sigdiv.jSignature("importData", $('.dumpSignature img').attr('src'));
        edit_page = true;
    }
    
    // Bind click on "Faire signer le client" button
    $('.btnSign').on('click', function() {
        var btn = $(this);
        
        if($(btn).data('action') == 'doSignature') {
            btn.html('Accepter');
            btn.data('action', 'acceptSignature');
            
            $('.btnClear, .btnSave').attr('disabled', 'disabled');
            $('.jSignature').removeClass('disabled');
            $('.signPad').addClass('active');
            
            //console.log($('.jSignature').jSignature());
            // Destroy the signature plugin instance
            $sigdiv.jSignature('enable');
        
            // Enable the signature plugin
            //$('.jSignature').jSignature();
        }
        else if($(btn).data('action') == 'acceptSignature') {
            btn.html('Faire signer le client');
            btn.data('action', 'doSignature');
            
            $('.btnClear, .btnSave').attr('disabled', null);
            $('.jSignature').addClass('disabled');
            $('.signPad').removeClass('active');
            
            // Append the signature in a temp element
            var datapair = $('.jSignature').jSignature('getData', 'base30');
            var i = new Image();
            i.src = 'data:' + datapair[0] + ',' + datapair[1];
            i.name = 'HALABELLEIMAGEDESIGNATURE'; // *** TO BE REMOVED OR MODIFIED ***
            i.id = 'HALABELLEIMAGEDESIGNATURE'; // *** TO BE REMOVED OR MODIFIED ***
            $('.dumpSignature').empty(); // *** TO BE REMOVED ***
            $(i).appendTo($('.dumpSignature')); // append the image (base30) to DOM.
            $('.jSignature').removeClass('active');
            $sigdiv.jSignature('disable');
        }
    });
    
    // Bind click on add an item row
    $('.addItem').on('click', function() {
        btn = $(this);
        var itemRowCount = $(btn).attr('data-item-row');
        itemRowCount++
        var data = [
            { counter: itemRowCount }
        ];
        $('.addItem.firstItemRow').attr('data-item-row', itemRowCount);
        $("#itemTemplate").tmpl(data).appendTo(".cloneDestination");
    });
    
    // Bind click on remove an item row
    $('body').on('click', '.removeItem', function() {
        var btn = $(this);
        var itemRowCount = $('.addItem.firstItemRow').attr('data-item-row');
        itemRowCount--;
        var itemRow = $(btn).attr('data-item-row');
        $('.itemRow' + itemRow).remove();
        $('.addItem.firstItemRow').attr('data-item-row', itemRowCount);
    });
    
    // Bind click on "Effacer la signature" button
    $('.btnClear').on('click', function() {
        // Destroy the signature plugin instance
        $sigdiv.jSignature('reset');
        
        // *** TO BE REMOVED ***
        $('.dumpSignature').empty();
    });
    
    // Bind click on "Sauvegarder" button
    $('.btnSave').on('click', function() {
        // Grabbing form data
        var postData = {
            tbDate: $('#tbDate').val(),
            tbEmploye: $('#tbEmploye').val(),
            tbDestinataire: $('#tbDestinataire').val(),
            tbNomSignataire: $('#tbNomSignataire').val(),
            signature: $('.dumpSignature img').attr('src')
        };
        
        var array_colis = [];
        $('.cloneDestination .clonable').each(function() {
            tmpItem = {
                facture: $(this).find('input[name^="tbNoFacture"]').val(),
                colis: $(this).find('input[name^="tbNoColis"]').val()
            };
            array_colis.push(tmpItem);
        });
        postData.array_colis = array_colis;
        
        // Check connection is up/down
        if(Offline.state == 'up') {
            
            // Create livraison over ajax
            if(edit_page == true) {
                url = 'api/update-livraison.php';
                postData.id_livraison = $('#id_livraison').val();
            }
            else {
                url = 'api/create-livraison.php';
            }
            
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
                    
                    //location.reload();
                },
                error: function(errMsg) {
                    console.log(errMsg);
                }
            });

            console.log(postData);
        }
        else if(Offline.state == 'down') {
            
            // Store de query into localForage
            insertQueryIntoLocalForage(postData);
        }
        
        // After posting, clear form data (if not edit page)
        if(edit_page == false) {
            tbEmploye: $('#tbEmploye').val('');
            tbDestinataire: $('#tbDestinataire').val('');
            tbNomSignataire: $('#tbNomSignataire').val('');
            $('.clonable').find('input[name^="tbNoFacture"]').val('');
            $('.clonable').find('input[name^="tbNoColis"]').val('');
            $('.cloned').remove();
            $('.addItem.firstItemRow').attr('data-item-row', 1);
            // Destroy the signature plugin instance
            $sigdiv.jSignature('reset');

            // *** TO BE REMOVED ***
            $('.dumpSignature').empty();
        }
    });
    
});

function insertQueryIntoLocalForage(postData) {
    
    var timestamp = new Date().valueOf();
    localforage.setItem('query-'+timestamp, postData).then(function (value) {
        // Do other things once the value has been saved.
        console.log(value);
    }).catch(function(err) {
        // This code runs if there were any errors
        console.log(err);
    });
}

function pushQueriesFromLocalForage() {
    
    var defer = $.Deferred();
    
    $('.loading').show();
    
    localforage.iterate(function(value, key, iterationNumber) {
        // Resulting key/value pair -- this callback
        // will be executed for every item in the
        // database.
        
        // Create livraison over ajax
        $.ajax({
            type: "GET",
            url: "api/create-livraison.php",
            data: {'postData': JSON.stringify(value)},
            //contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            success: function(data){
                
                // Remove item from localForage
                localforage.removeItem(key).then(function() {
                    // Run this code once the key has been removed.
                    console.log('Key is cleared!');
                }).catch(function(err) {
                    // This code runs if there were any errors
                    console.log(err);
                });
            },
            error: function(errMsg) {
                console.log(errMsg);
            }
        });

        console.log([key, value]);
    }, function(err) {
        if (!err) {
            console.log('Iteration has completed');
            
            defer.resolve('DONE');
        }
        else
            defer.resolve('ERROR');
    });
    
    return defer.promise();
}