<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(dirname(__DIR__).'/../_includes/commonIncludes_CIB.php');

// NO LOGIN NO NOTHING'
if( IL_Session::r(IL_SessionVariables::USERNAME) == false )
{}
else // On a un utilisateur connecté/authentifié
{
    $succursale = $_GET["succ"];
    $operation  = $_GET["oper"];

    switch ($operation)
    {
        case "read":              echo IL_Utils::getBonCommande($succursale);
                                  break;
        case "readArchive":       echo IL_Utils::getBonCommandeArchive($succursale);
                                  break;
        case "readWithoutDriver": echo IL_Utils::getBonCommandeWithoutDriver($succursale);
                                  break;
        case "add":               echo IL_Utils::addBonCommande($_GET["1"], $_GET["2"], $_GET["3"], $_GET["4"], $_GET["5"], $_GET["6"], $_GET["7"], $_GET["8"], $succursale);
                                  //public static function addBonCommande($bonCommande, $fournisseur, $av, $heure, $date, $chauffeur, $statut, $commentaire, $succursale){
        case "del":               echo IL_Utils::deleteBonCommande($_GET["pk"]);
                                  break;
        case "updateStatut":      echo IL_Utils::updateStatut($_GET["1"],$_GET["2"]);
                                  break;
        case "updateLigne":       echo IL_Utils::updateLigne($_GET["1"], $_GET["2"], $_GET["3"], $_GET["4"], $_GET["5"], $_GET["6"], $_GET["7"], $_GET["8"], $succursale);
                                  break;
    }
}
?>