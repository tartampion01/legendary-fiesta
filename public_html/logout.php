<?php
require_once(dirname(__DIR__).'/_includes/commonIncludes.php');

setcookie("username", "", time()-3600);

IL_Session::w(IL_SessionVariables::USERNAME,false);
IL_Session::w(IL_SessionVariables::ID_USER,false);
IL_Session::w(IL_SessionVariables::LEVEL,false);
IL_Session::w(IL_SessionVariables::SUCCURSALE,false);

IL_Session::destroy();

header('Location: ' . "login.php");
?>