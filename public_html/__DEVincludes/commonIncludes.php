<?php

// Don't show errors on webpage
error_reporting(0);
// Show errors on webpage
//error_reporting(E_ALL);

$applicationConfig = parse_ini_file(dirname(__DIR__).'/__DEVconfigs/application.ini');

// CONNECTION DB
require_once(dirname(__DIR__) . '/__DEVincludes/objects/database.php');
// FUNCTIONS
require_once(dirname(__DIR__) . '/__DEVincludes/functions/dbFunctions.php');
// OBJECTS
require_once(dirname(__DIR__) . '/__DEVincludes/objects/IL_Errors.php');

require_once(dirname(__DIR__) . '/__DEVincludes/objects/IL_Session.php');
require_once(dirname(__DIR__) . '/__DEVincludes/objects/IL_Users.php');
require_once(dirname(__DIR__) . '/__DEVincludes/objects/IL_PageLink.php');
require_once(dirname(__DIR__) . '/__DEVincludes/objects/IL_Email.php');
require_once(dirname(__DIR__) . '/__DEVincludes/objects/IL_Livraison.php');

// UTILS
require_once(dirname(__DIR__). '/__DEVincludes/objects/IL_Utils.php');

?>