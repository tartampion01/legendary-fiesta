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

$stmt = $livraison->readCountFilter($_GET['params']);

$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // decode search parameters
    $params = json_decode($_GET['params']);
        
    $returnArray = array();
    
    if(isset($params->field)) {
        
        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            $tmpArray = array(
                "field" => $row[$params->field],
                "count" => $row['COUNT']
            );
            
            array_push($returnArray, $tmpArray);
        }
    }
    
    echo json_encode($returnArray);
}
else{
    echo json_encode(
        array("message" => "Aucun résultat n'a été trouvé pour votre recherche.")
    );
}
?>