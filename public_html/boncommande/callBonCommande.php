<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(dirname(__DIR__).'/../_includes/commonIncludes.php');

$succursale = $_GET["succ"];
$operation  = $_GET["oper"];
//echo "OPERATION= " . $operation;

switch ($operation)
{
    case "read": echo IL_Utils::getBonCommande($_GET["succ"]);
                 break;                 
    case "add":  echo IL_Utils::addBonCommande($_GET["1"], $_GET["2"], $_GET["3"], $_GET["4"], $_GET["5"], $_GET["6"], $_GET["7"], $_GET["8"], $succursale);
                //public static function addBonCommande($bonCommande, $fournisseur, $av, $heure, $date, $chauffeur, $statut, $commentaire, $succursale){
    case "del":  echo IL_Utils::deleteBonCommande($_GET["pk"]);
                 break;
    case "updateStatut": echo IL_Utils::updateStatut($_GET["1"],$_GET["2"]);
                         break;
}
?>