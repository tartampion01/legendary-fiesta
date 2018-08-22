<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Personne de 'loggé'
if( !isset($_SESSION["username"]))
    header('Location: ' . "../login.php");

?>

<html  xmlns="http://www.w3.org/1999/xhtml" lang="fr-CA" xml:lang="fr-CA">
<?PHP
    // Don't show errors on webpage
    //error_reporting(0);
    // Show errors on webpage
    error_reporting(E_ALL);

    $NOMPAGE = htmlspecialchars(basename($_SERVER['PHP_SELF']));
    // REQUIRED BY ALL PAGES
    // COMMON INCLUDES --> DB / FUNCTIONS / OBJECTS
    require_once(dirname(__DIR__).'/commonIncludes.php');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <title>
        <?PHP IL_Header::getPageTitle($NOMPAGE); ?>
    </title>

    <script type="text/json" class="communicator">[{"nop":""}]</script>
    <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsSwissKnife.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsAjaxCommunicator.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsAjaxV2.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsValueFormatter.js"></script>
    <script type="application/javascript" src="assets/js/container.js"></script>
    <script type="application/javascript" src="assets/js/animator.js"></script>
    <script type="application/javascript" src="assets/js/popup.js"></script>
    
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/animator.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/utilisateurs.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/login.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/popup.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/layout_normal.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/livraison.css" />
    <link rel='canonical' href='<?PHP echo $NOMPAGE ?>' />
    
    <meta  http-equiv="Content-type"  content="text/html;charset=UTF-8" />
</head>