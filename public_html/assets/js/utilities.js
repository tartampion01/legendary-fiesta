/* Offline/Online checking*/
$(function(){

    var 
        $online = $('.online'),
        $offline = $('.offline');

    Offline.options = {requests: false};
        
    Offline.on('confirmed-down', function () {
        $online.fadeOut(function () {
            $offline.fadeIn();
        });
    });

    Offline.on('confirmed-up', function () {
        $offline.fadeOut(function () {
            $online.fadeIn();
        });
        
        pushQueriesFromLocalForage().done(function(data) {
            
            if(data == 'DONE') {
                console.log('DONE');
                $('.loading').hide();
            }            
        });
    });

});

