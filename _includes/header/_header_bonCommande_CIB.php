<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(dirname(__DIR__).'/commonIncludes.php');

// Personne de 'loggé'
if( IL_Session::r(IL_SessionVariables::USERNAME) == false )
{
    // get asked page
    IL_Session::w(IL_SessionVariables::ASKED_PAGE,htmlspecialchars(basename($_SERVER['PHP_SELF'])));
    header('Location: ' . "../CIB/login.php");
}

// Load logged user
if(isset($_COOKIE['username'])) {
    $user = new IL_Users();
    $user->load(0, '', $_COOKIE['username']);   
}
?>

<html  xmlns="http://www.w3.org/1999/xhtml" lang="fr-CA" xml:lang="fr-CA">
<?PHP
    // Don't show errors on webpage
    error_reporting(0);
    // Show errors on webpage
    //error_reporting(E_ALL);

    $NOMPAGE = htmlspecialchars(basename($_SERVER['PHP_SELF']));
    // REQUIRED BY ALL PAGES
    // COMMON INCLUDES --> DB / FUNCTIONS / OBJECTS
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
?>
<head>
    <title>
        <?PHP IL_Header::getPageTitle($NOMPAGE); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="text/json" class="communicator">[{"nop":""}]</script>
    <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    <link rel="stylesheet" type="text/css" href="../assets/css/style_bonCommande.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/bootstrap.css" />
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<!--    <script type="application/javascript" src="../../public_html/assets/js/jquery.min.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/dsTools/dsSwissKnife.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/dsTools/dsAjaxCommunicator.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/dsTools/dsAjaxV2.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/dsTools/dsValueFormatter.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/container.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/animator.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/popup.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/sweetalert2/promise-polyfill.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/localforage.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/offline/offline.min.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/jSignature/jSignature.min.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/utilities.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/livraison.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/jquery.tmpl.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/awesomplete/awesomplete.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/stupidtable.js"></script>
    <script type="application/javascript" src="../../public_html/assets/js/jquery.twbsPagination.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/fontawesome/all.css">
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/animator.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/utilisateurs.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/login.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/popup.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/layout_normal.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/livraison.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/livraisons-horsligne.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/offline/offline-theme-chrome.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/offline/offline-language-french.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/offline/offline-language-french-indicator.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/awesomplete/awesomplete.css" />
    <link rel="stylesheet" type="text/css" href="../../public_html/assets/css/recherche.css" />-->
    <link rel="stylesheet" href='<?PHP echo $NOMPAGE ?>' />
</head>
    
    <!--<div class="offline-ui"></div>-->
    <div class="loading" style="display: none;">Loading&#8230;</div>