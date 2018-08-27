<?php

// Don't show errors on webpage
//error_reporting(0);
// Show errors on webpage
error_reporting(E_ALL);
    
$applicationConfig = parse_ini_file(dirname(__DIR__).'/_configs/application.ini');

// CONNECTION DB
require_once(dirname(__DIR__). '/_includes/objects/database.php');
// FONCTIONS
require_once(dirname(__DIR__). '/_includes/functions/dbFunctions.php');
// OBJECTS
require_once(dirname(__DIR__). '/_includes/objects/IL_PageLink.php');
require_once(dirname(__DIR__). '/_includes/objects/IL_Email.php');
require_once(dirname(__DIR__). '/_includes/objects/IL_Users.php');

// Utils
require_once(dirname(__DIR__). '/_includes/objects/IL_Utils.php');

// "GLOBALES" useless si tout est static dans IL_Utils...
$G_IL_Utils = new IL_Utils();
?>