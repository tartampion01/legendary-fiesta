<?php
require_once(dirname(__DIR__).'/_includes/commonIncludes.php');
  try {
      IL_Session::w(IL_SessionVariables::USERNAME,"Rejean Culé");
  
      echo IL_Session::r(IL_SessionVariables::USERNAME);
      echo IL_Session::r(IL_SessionVariables::LEVEL);
  }
  catch (Exception $e) {
      echo $e;
      echo "Purée!!!!";
  }
?>