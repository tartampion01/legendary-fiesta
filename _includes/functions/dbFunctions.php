<?php
//require_once('class.phpmailer.php');
//require_once('class.smtp.php');
//require_once('clients.php');
//require_once('tcpdf.php');
//require_once('tcpdf_parser.php');

function getSuccursales($arraySuccursale)
{
    $succ = new RD_Succursales();
    $return_succ = array();
    
    foreach($arraySuccursale as $IdSuc){
        //echo "---->>>>>" . $IdSuc . "<<<<<<<<<<<<<<";
        $return_succ = $succ->load($IdSuc);
    }
    
    return $return_succ;
}

/**
 * @param int $id <p>inventory.id</p>
 * @param string $fieldCriteria <p>inventory.[fieldCriteria]</p>
 * @param string $value <p>where inventory.[fieldCriteria] = value</p>
 * @return mysqli_result Retourne les camions neufs pour un champ passé en paramètre
 */
function getNewTruck($id, $fieldCriteria='', $value='')
{
    $conn = Database::getConn();
        
    $sql = $fieldCriteria == "" ? "SELECT * FROM inventory WHERE id=".$id . " and DisplayOnWebSite=1" : "SELECT * FROM inventory WHERE $fieldCriteria='$value' and DisplayOnWebSite=1";

    return mysqli_query($conn, $sql);
}

function selectNewTrucksDisctinctCriteria($field, $customCriteria, $orderBy, $order)
{
    $conn = Database::getConn();
    
    //$sql = "SELECT COUNT($field) AS COUNT,$field FROM inventory WHERE DisplayOnWebSite=1 GROUP BY $field ORDER BY " . $field;
    $sql = "SELECT COUNT($field) AS COUNT,$field FROM inventory WHERE $customCriteria DisplayOnWebSite=1 GROUP BY $field ORDER BY $orderBy $order";
//echo $sql;
    $result = mysqli_query($conn, $sql);
    
    $fieldArray = array();
    $countArray = array();
            
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {
            array_push($fieldArray, $row[$field]);
            array_push($countArray, $row['COUNT']);
        }
    }

    return array_combine($fieldArray, $countArray);
}

function selectUsedTrucksDisctinctCriteria($field, $customCriteria)
{
    $conn = Database::getConn();
    //$sql = "SELECT COUNT($field) AS COUNT,$field FROM inventory WHERE DisplayOnWebSite=1 GROUP BY $field ORDER BY " . $field;
    $sql = "SELECT COUNT($field) AS COUNT,$field FROM trucks GROUP BY $field ORDER BY COUNT DESC";
//echo $sql;
    $result = mysqli_query($conn, $sql);
    
    $fieldArray = array();
    $countArray = array();
            
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {
            array_push($fieldArray, $row[$field]);
            array_push($countArray, $row['COUNT']);
        }
    }

    return array_combine($fieldArray, $countArray);
}