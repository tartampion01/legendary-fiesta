<?php
require_once(dirname(__DIR__).'/_includes/commonIncludes.php');
  try {
      IL_Session::w(IL_SessionVariables::USERNAME,"Oups je n'aurais pas du archiver ça!");
  
      echo IL_Session::r(IL_SessionVariables::USERNAME);
      echo IL_Session::r(IL_SessionVariables::LEVEL); // no exception but returns false
  }
  catch (Exception $e) {
      echo $e;
      echo "Purée!!!!";
  }
?>