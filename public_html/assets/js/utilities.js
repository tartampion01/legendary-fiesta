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
        
        // Hide some menu items
        $('.menuitem.recherche, .menuitem.utilisateurs, .menuitem.logout').hide();
        
        // Change header home button href
        //$('.home-link').attr('href', 'default.html');
        //$('.menuitem.livraison').attr('href', 'livraison.html');
        
        //$('#logout').attr('onclick', 'return false');
        $('#logout').hide();
    });

    Offline.on('confirmed-up', function () {
        $offline.fadeOut(function () {
            $online.fadeIn();
        });
        
        pushQueriesFromLocalForage().done(function(data) {
            
            var message, type;
            
            if(data == 'DONE') {
                console.log('DONE');
                $('.loading').hide();
                message = 'Les données ont été synchronisées avec succès!';
                type = 'success';
            }
            else if(data == 'NO_DATA_TO_SYNC') {
                $('.loading').hide();
                message = 'Il n\'y avait aucune donnée à synchroniser!';
                type = 'info';
            }
            
            swal({
                position: 'top-end',
                type: type,
                title: message,
                showConfirmButton: false,
                timer: 3500
            });
        });
        
        // Show previously hidden menu items
        $('.menuitem.recherche, .menuitem.utilisateurs, .menuitem.logout').show();
        
        //$('.home-link').attr('href', 'default.php');
        //$('.menuitem.livraison').attr('href', 'livraison.php');
        
        //$('#logout').attr('onclick', 'window.location.href="logout.php"');
        $('#logout').show();
    });

});

$(document).ready(function() {
    // Set offline username (header)
    $('.offline-username').html(getCookie('username'));
    
    // Set offline date
    var currentdate = new Date(); 
    var datetime = currentdate.getFullYear() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    + currentdate.getDate() + " "  
                    + currentdate.getHours() + ":"  
                    + (currentdate.getMinutes() < 10 ? ('0' + currentdate.getMinutes()) : currentdate.getMinutes()) + ":" 
                    + (currentdate.getSeconds() < 10 ? ('0' + currentdate.getSeconds()) : currentdate.getSeconds());
    $('.offline-date').val(datetime);
    
    // Set offline listeClients from localStorage
    //$('.offline-listeClients').html(localStorage.getItem('listeClients'));
});

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
