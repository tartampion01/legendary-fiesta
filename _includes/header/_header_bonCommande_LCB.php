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
    header('Location: ' . "../LCB/login.php");
}

// Load logged user
if(isset($_COOKIE['username'])) {
    $user = new IL_Users();
    $user->load(0, '', $_COOKIE['username']);   
}
?>

<html>
<?PHP
    // Don't show errors on webpage
    error_reporting(0);
    // Show errors on webpage
    //error_reporting(E_ALL);

    $NOMPAGE = htmlspecialchars(basename($_SERVER['PHP_SELF']));
    // REQUIRED BY ALL PAGES
    // COMMON INCLUDES --> DB / FUNCTIONS / OBJECTS
    header("Content-Type: text/html; charset=utf-8");
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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="application/javascript" src="../assets/js/sort_table.js"></script>
    
    <link rel="stylesheet" type="text/css" href="../assets/css/style_bonCommande_LCB.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">    
    <link rel="stylesheet" href='<?PHP echo $NOMPAGE ?>' />
</head>
<div class="loading" style="display: none;">Loading&#8230;</div>