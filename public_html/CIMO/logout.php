<?php
require_once(dirname(__DIR__).'/../_includes/commonIncludes_CIA_CIMO.php');

IL_Session::w(IL_SessionVariables::USERNAME,false);

IL_Session::destroy();

setcookie("USERNAME", "", time()-3600);

header('Location: ' . "login.php");
?>