$( document ).ready(function() {
    
    var $sigdiv = $('.jSignature');
    $sigdiv.jSignature();
    $sigdiv.jSignature('disable');
    
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
            var datapair = $('.jSignature').jSignature('getData', 'svgbase64');
            var i = new Image();
            i.src = 'data:' + datapair[0] + ',' + datapair[1];
            i.name = 'HALABELLEIMAGEDESIGNATURE'; // *** TO BE REMOVED OR MODIFIED ***
            i.id = 'HALABELLEIMAGEDESIGNATURE'; // *** TO BE REMOVED OR MODIFIED ***
            $('.dumpSignature').empty(); // *** TO BE REMOVED ***
            $(i).appendTo($('.dumpSignature')); // append the image (SVG) to DOM.
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
        $sigdiv.jSignature('clear');
        
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
        
        var itemRows = [];
        $('.cloneDestination .clonable').each(function() {
            tmpItem = {
                tbNoFacture: $(this).find('input[name^="tbNoFacture"]').val(),
                tbNoColis: $(this).find('input[name^="tbNoColis"]').val()
            };
            itemRows.push(tmpItem);
        });
        postData.itemRows = itemRows;
        
        var timestamp = new Date().valueOf();
        localforage.setItem('query-'+timestamp, postData).then(function (value) {
            // Do other things once the value has been saved.
            console.log(value);
        }).catch(function(err) {
            // This code runs if there were any errors
            console.log(err);
        });
        
        $.ajax({
            type: "POST",
            url: "api/create-livraison.php",
            data: {'postData': postData},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data){
                alert(data);
            },
            error: function(errMsg) {
                console.log(errMsg);
            }
        });
        
        //console.log(postData);
        
        
        // After posting, clear form data
        tbEmploye: $('#tbEmploye').val('');
        tbDestinataire: $('#tbDestinataire').val('')
        tbNomSignataire: $('#tbNomSignataire').val('');
        $('.clonable').find('input[name^="tbNoFacture"]').val(''),
        $('.clonable').find('input[name^="tbNoColis"]').val('')
        $('.cloned').remove();
        $('.addItem.firstItemRow').attr('data-item-row', 1);
        // Destroy the signature plugin instance
        $sigdiv.jSignature('clear');
        
        // *** TO BE REMOVED ***
        $('.dumpSignature').empty();
    });
    
});