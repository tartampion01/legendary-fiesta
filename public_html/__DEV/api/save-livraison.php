<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../_includes/objects/database.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../_includes/objects/IL_Livraison.php');

// instantiate database and product object
$database = new IL_Database();
//$db = $database->getConnection();
$conn = IL_Database::getConn();

// initialize object
$livraison = new IL_Livraison($conn);

// get posted data
$data = json_decode($_GET['postData']);

// set livraison property values
$livraison->dateLivraison = (isset($data->tbDate) ? $data->tbDate : '');
$livraison->destinataire = (isset($data->tbDestinataire) ? $data->tbDestinataire : '');
$livraison->nomSignataire = (isset($data->tbNomSignataire) ? $data->tbNomSignataire : '');
$livraison->signature = (isset($data->signature) ? $data->signature : '');
$livraison->noEmploye = (isset($data->noEmploye) ? $data->noEmploye : '');
$livraison->colis = (isset($data->array_colis) ? $data->array_colis : '');

// update the livraison
if($livraison->save($livraison)){
    echo '{';
        echo '"message": "La livraison a été mise à jour."';
    echo '}';
}
 
// if unable to update the livraison, tell the user
else{
    echo '{';
        echo '"message": "Impossible de mettre à jour la livraison."';
    echo '}';
}
?>