<?php
    header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Pragma: no-cache"); // HTTP/1.0
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once(dirname(__DIR__).'/commonIncludes.php');

    // Personne de 'loggé' --> back to login
    if( IL_Session::r(IL_SessionVariables::USERNAME) == false )
        header('Location: ' . "../login.php");

    // Load logged user
    if(isset($_COOKIE['username'])){
        $user = new IL_Users();
        //$user->load(0, '', $_COOKIE['username'],0);
        $user->load(0, '', IL_Session::r(IL_SessionVariables::USERNAME),0);
    }
    else{}
    
    // Don't show errors on webpage
    //error_reporting(0);
    // Show errors on webpage
    error_reporting(E_ALL);

    $NOMPAGE = htmlspecialchars(basename($_SERVER['PHP_SELF']));
    // REQUIRED BY ALL PAGES
    // COMMON INCLUDES --> DB / FUNCTIONS / OBJECTS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" lang="fr-CA" xml:lang="fr-CA">
<head>
    <title><?PHP IL_Header::getPageTitle($NOMPAGE); ?></title>
    
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script type="text/json" class="communicator">[{"nop":""}]</script>
    <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    <script type="application/javascript" src="assets/js/jquery.min.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsSwissKnife.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsAjaxCommunicator.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsAjaxV2.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsValueFormatter.js"></script>
    <script type="application/javascript" src="assets/js/container.js"></script>
    <script type="application/javascript" src="assets/js/animator.js"></script>
    <script type="application/javascript" src="assets/js/popup.js"></script>
    <script type="application/javascript" src="assets/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="application/javascript" src="assets/js/sweetalert2/promise-polyfill.js"></script>
    <script type="application/javascript" src="assets/js/localforage.js"></script>
    <script type="application/javascript" src="assets/js/offline/offline.min.js"></script>
    <script type="application/javascript" src="assets/js/jSignature/jSignature.min.js"></script>
    <script type="application/javascript" src="assets/js/utilities.js"></script>
    <script type="application/javascript" src="assets/js/livraison.js"></script>
    <script type="application/javascript" src="assets/js/jquery.tmpl.js"></script>
    <script type="application/javascript" src="assets/js/awesomplete/awesomplete.js"></script>
    <script type="application/javascript" src="assets/js/stupidtable.js"></script>
    <script type="application/javascript" src="assets/js/jquery.twbsPagination.js"></script>
    
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome/all.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/animator.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/utilisateurs.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/login.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/popup.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/layout_normal.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/livraison.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/livraisons-horsligne.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/offline/offline-theme-chrome.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/offline/offline-language-french.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/offline/offline-language-french-indicator.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/awesomplete/awesomplete.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/recherche.css" />
        
    <link rel="stylesheet" href='<?PHP echo $NOMPAGE ?>' />
    
    <script type="application/javascript">
        // Set listeClients in localStoage
        //var listeClients = '<?php echo IL_Utils::getDistinctDestinataires() ?>';
        //localStorage.setItem('listeClients', listeClients);
    </script>
</head>
    
    <?php 
        //echo IL_Session::dump();
    ?>
    <!--<div class="offline-ui"></div>-->
    <div class="loading" style="display: none;">Loading&#8230;</div>