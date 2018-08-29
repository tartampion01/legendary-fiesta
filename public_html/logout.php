<?php
require_once(dirname(__DIR__).'/_includes/commonIncludes.php');

IL_Session::destroy();
header('Location: ' . "login.php");
?>