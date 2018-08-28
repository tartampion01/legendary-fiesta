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
            $('.dumpSignature').empty(); // *** TO BE REMOVED ***
            $(i).appendTo($('.dumpSignature')); // append the image (SVG) to DOM.
            
            $('.jSignature').removeClass('active');
            $sigdiv.jSignature('disable');
        }
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
        alert('Save');
    });
    
});