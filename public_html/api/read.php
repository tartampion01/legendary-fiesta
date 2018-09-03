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
 
$results = $livraison->readTest($_GET['params']);

if(mysqli_num_rows($results) > 0){
    
    $Livraisons_arr=array();
    $Livraisons_arr["records"]=array();

    // count rows
    $rowcount = mysqli_num_rows($results);
    //$countRows = $rowcount;
    $countRows = $livraison->readTestCount($_GET['params']);
    $countRows = mysqli_num_rows($countRows);
    $Livraisons_arr["countRows"] = $countRows;

    while($row = mysqli_fetch_assoc($results)) {
        
        $date = new DateTime($row['dateLivraison']);
        // "-2209078800"
        //echo $date->format("U");
        // false
        $date =  $date->getTimestamp();

        $Livraisons_item=array(
            "id_livraison" => $row['id_livraison'],
            "dateLivraison" => $row['dateLivraison'],
            "dateHumain" => $row['dateHumain'],
            "dateTimestamp" => $date,
            "destinataire" => $row['destinataire'],
            "nomSignataire" => $row['nomSignataire'],
            "signature" => $row['signature'],
            "noEmploye" => $row['noEmploye']
        );
        
        array_push($Livraisons_arr["records"], $Livraisons_item);
    }
    
    echo json_encode($Livraisons_arr);
}




/*
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
}*/
?>