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

// set product property values
$livraison->id_livraison  = (isset($data->id_livraison)  ? $data->id_livraison  : '');
$livraison->dateLivraison = (isset($data->dateLivraison) ? $data->dateLivraison : '');
$livraison->nomSignataire = (isset($data->nomSignataire) ? $data->nomSignataire : '');
$livraison->signature     = (isset($data->signature)     ? $data->signature     : '');

//var_dump($livraison);

// create the livraison
if($livraison->save_Elite($livraison)){
    echo '{';
        echo '"message": "La livraison a été modifiée."';
    echo '}';
}
 
// if unable to create the livraison, tell the user
else{
    echo '{';
        echo '"message": "Impossible de modifier de livraison."';
    echo '}';
}
?>