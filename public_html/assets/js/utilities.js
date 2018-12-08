/* Offline/Online checking*/
$(function(){

    var 
        $online = $('.online'),
        $offline = $('.offline');

    Offline.options = {
        requests: false,
        reconnect: {
            initialDelay: 60,

            // How long should we wait between retries.
            delay: (1.5 * 440)
        }
    };
        
    Offline.on('confirmed-down', function () {
        /*$online.fadeOut(function () {
            $offline.fadeIn();
        });*/
        
        // Hide some menu items
        $('.menuitem.recherche, .menuitem.utilisateurs, .menuitem.logout').hide();
        
        //$('#logout').attr('onclick', 'return false');
        $('#logout').hide();
        
        // Cacher le bouton de synchronisation des données
        $('.btn-check-localforage-sync').hide();
    });


    Offline.on('confirmed-up', function () {
        /*$offline.fadeOut(function () {
            $online.fadeIn();
        });*/
        
        callPushQueriesFromLocalForage();
        
        // Show previously hidden menu items
        $('.menuitem.recherche, .menuitem.utilisateurs, .menuitem.logout').show();
        
        $('#logout').show();
        
        // Afficher le bouton de synchronisation des données
        $('.btn-check-localforage-sync').show();
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
    
    // Button pour forcer la synchronisation des données
    $('.btn-check-localforage-sync').on('click', function() {
        
        callPushQueriesFromLocalForage();
    });
});

function callPushQueriesFromLocalForage() {
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
}

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

/* service worker */
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/serviceworker.js').then(function(registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}

window.addEventListener('load', function() {
    if(navigator.onLine) {
        console.log('Connection is UP!!');
        
        // Show previously hidden menu items
        $('.menuitem.recherche, .menuitem.utilisateurs, .menuitem.logout').show();
        
        // Afficher le bouton de synchronisation des données
        $('.btn-check-localforage-sync').show();
        
        $('#logout').show();
    }
    else {
        console.log('Connection is DOWN!!');
        
        // Hide some menu items
        $('.menuitem.recherche, .menuitem.utilisateurs, .menuitem.logout').hide();
        
        // Cacher le bouton de synchronisation des données
        $('.btn-check-localforage-sync').hide();
        
        $('#logout').hide();
    }
});
/* service worker */
