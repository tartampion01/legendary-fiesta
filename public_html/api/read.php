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
 
$stmt = $livraison->readTest($_GET['params']);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){

    // products array
    $Livraisons_arr=array();
    $Livraisons_arr["records"]=array();
    
    // count rows
    $countRows = $stmtCount->rowCount();
    $Livraisons_arr["countRows"] = $countRows;
    
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $Livraisons_item=array(
            "id_livraison" => $id_livraison,
            "dateLivraison" => $dateLivraison,
            "dateHumain" => $dateHumain,
            "destinataire" => $destinataire,
            "nomSignataire" => $nomSignataire,
            "signature" => $signature,
            "noEmploye" => $noEmploye
        );
        
        array_push($Livraisons_arr["records"], $Livraisons_item);
    }
 
    echo json_encode($Livraisons_arr);
}
else{
    echo json_encode(
        array("message" => "Aucun résultat n'a été trouvé pour votre recherche.")
    );
}
?>