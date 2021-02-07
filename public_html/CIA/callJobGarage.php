<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(dirname(__DIR__).'/../_includes/commonIncludes_CIA_CIMO.php');

// NO LOGIN NO NOTHING'
if( IL_Session::r(IL_SessionVariables::USERNAME) == false )
{}
else // On a un utilisateur connecté/authentifié
{
    $succursale = $_GET["succ"];
    $operation  = $_GET["oper"];
    //echo "OPERATION= " . $operation;

    switch ($operation)
    {
        case "read": echo IL_Utils::getJobGarage($succursale);
                     break;
        case "readArchive": echo IL_Utils::getJobGarageArchive($succursale);
                            break;
        case "add":  echo IL_Utils::addJobGarage($_GET["1"], $_GET["2"], $_GET["3"], $_GET["4"], $_GET["5"], $_GET["6"], $_GET["7"], $_GET["8"], $_GET["9"], $_GET["10"], $_GET["11"], $succursale);
                     break;
        case "del":  echo IL_Utils::deleteJobGarage($_GET["pk"]);
                     break;
        case "deleteFromArchive":  echo IL_Utils::deleteJobGarageFromArchive($_GET["pk"]);
                                   break;                 
        case "updateStatut": echo IL_Utils::updateStatutJobGarage($_GET["1"],$_GET["2"]);
                             break;
        case "updateStatutReceptionnee": echo IL_Utils::updateStatutReceptionneeJobGarage($_GET["1"],$_GET["2"]);
                             break;
           // updateLigne                                         rowId       jobGarage   av          vendeur     fournisseur heure       date        transport   datePrevue  AMouPM       commentaire;
        case "updateLigne": echo IL_Utils::updateLigneJobGarage($_GET["1"], $_GET["2"], $_GET["3"], $_GET["4"], $_GET["5"], $_GET["6"], $_GET["7"], $_GET["8"], $_GET["9"], $_GET["10"], $_GET["11"],$succursale);
                            break;
    }
}
?>