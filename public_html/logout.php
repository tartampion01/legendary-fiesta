<?php
$_SESSION["username"] = "";
$_SESSION["level"] = "";
session_unset();
session_destroy();

header('Location: ' . "login.php");
?>