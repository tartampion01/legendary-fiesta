<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../_includes/objects/database.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/../_includes/objects/IL_Livraison.php');

// instantiate database and product object
$database = new IL_Database();
$db = $database->getConnection();

// initialize object
$livraison = new IL_Livraison($db);

// get posted data
$data = json_decode($_POST['postData']);

// set product property values
$livraison->dateLivraison = $data->tbDate;
$livraison->destinataire = $data->tbDestinataire;
$livraison->nomSignataire = $data->tbNomSignataire;
$livraison->signature = $data->signature;
$livraison->noEmploye = $data->noEmploye;
$livraison->colis = $dat->colis;

// create the product
if($livraison->create()){
    echo '{';
        echo '"message": "Product was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create product."';
    echo '}';
}
?>