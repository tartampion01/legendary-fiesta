<?php
require_once(dirname(__DIR__).'/__DEVincludes/commonIncludes.php');

setcookie('USERNAME', "", time()-3600);
setcookie('SUCCURSALE', "", time()-3600);
setcookie('ID_USER', "", time()-3600);
setcookie('LEVEL', "", time()-3600);

IL_Session::w(IL_SessionVariables::USERNAME,false);
IL_Session::w(IL_SessionVariables::SUCCURSALE,false);
IL_Session::w(IL_SessionVariables::ID_USER,false);
IL_Session::w(IL_SessionVariables::LEVEL,false);

IL_Session::destroy();

header('Location: ' . "login.php");

//var_dump($_SESSION);
//echo '</br>';
//var_dump($_COOKIE);

?>