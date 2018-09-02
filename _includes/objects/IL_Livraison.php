<?php
class IL_Livraison{
    // database connection and table name
    private $conn;
    private $table_name = "livraisons";
    
    public $id_livraison  = 1;
    public $dateLivraison = ""; // TIMESTAMP
    public $dateHumain    = ""; // VARCHAR
    public $destinataire  = "";
    public $nomSignataire = "";
    public $signature     = "";
    public $noEmploye     = "";
    
    public $colis = array(); // TABLE livraisonsColis contient fkColis = colis.id_colis AND fkLivraison = livraisons.id_livraison
                             // la table colis contient les champs facture et colis
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    public function load($id = 0){
        $conn = IL_Database::getConn();
                
        if( $id > 0 ){
            $id = mysqli_real_escape_string($conn, $id);
            $sql = "SELECT * FROM livraisons WHERE id_livraison=$id";
        }
        elseif( $id == 0 )
        {
            $sql = "SELECT * FROM livraisons";
        }
        else
            return false;

        $result = mysqli_query($conn, $sql);
        $r = mysqli_fetch_array($result);
    
        $this->id_livraison = $r['id_livraison'];
        $this->dateLivraison = $r['dateLivraison'];
        $this->dateHumain = $r['dateHumain'];
        $this->destinataire = $r['destinataire'];
        $this->nomSignataire = $r['nomSignataire'];
        $this->signature = $r['signature'];
        $this->noEmploye = $r['noEmploye'];
        
        $this->loadColis();
        
        //var_dump($this);
        
        return true;
    }

    public function loadColis()
    {
        $conn = IL_Database::getConn();
        
        $sql = "SELECT facture, colis FROM colis AS c INNER JOIN livraisonsColis AS cl ON c.id_colis = cl.fk_colis WHERE cl.fk_livraison=$this->id_livraison";
        
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                $infoColis = array();
                $infoColis['facture'] = $row['facture'];
                $infoColis['colis'] = $row['colis'];
                array_push($this->colis, $infoColis);
            }
        }
    }
    
    public function test()
    {
        echo json_encode($this);
    }
    
    function read(){
        // select all query
        $query = ("SELECT * FROM livraisons");
 
        // prepare query statement
        $stmt = $this->conn->prepare($query);
 
        // execute query
        $stmt->execute();
 
        return $stmt;
    }
    
    function readTest($params){
        
        // decode search parameters
        $params = json_decode($params);
        
        // check for empty parameters (search for all products)
        //if(empty($params->field) && empty($params->value)) {
            // select all query
            //$query = "SELECT * FROM livraisons WHERE $params->customCriteria ORDER BY id_livraison LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            $query = "SELECT COUNT(dateLivraison) AS COUNT, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons WHERE id_livraison>0 GROUP BY dateLivraison ORDER BY dateLivraison DESC LIMIT 200";
            //$query = "SELECT * FROM livraisons WHERE id_livraison>0 GROUP BY dateLivraison ORDER BY COUNT DESC LIMIT 20";
            //echo $query;
            
            $where = '';
            /*$count = count($params->arrayFilters);
            for($i=0; $i<$count; $i++) {
                    
            }*/
            
            if($where == '') {
                //$query = "SELECT * FROM livraisons WHERE $params->customCriteria ORDER BY id_livraison LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
                $query = "SELECT COUNT(dateLivraison) AS COUNT, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons WHERE id_livraison>0 GROUP BY dateLivraison ORDER BY dateLivraison DESC LIMIT 200";
                //$query = "SELECT * FROM livraisons WHERE id_livraison>0 GROUP BY dateLivraison ORDER BY COUNT DESC LIMIT 20";
                //echo "#1". $query;
            }
            else {
                $query = "SELECT * FROM livraisons WHERE $where $params->customCriteria ORDER BY id_livraison LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
                //echo "#1 ". $query;
            }
        //}
        //else {
            
            $where = '';
            
            /*for($i=0; $i<count($params->arrayFilters); $i++) {
                $where .= $params->arrayFilters[$i]->field . ' = "' . $params->arrayFilters[$i]->value . '" AND ';
            }
            
            if($where != '') {
                // select filtered query
                $query = "SELECT * FROM livraisons WHERE $where $params->customCriteria ORDER BY id_livraison ".$params->sortBy." LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
                //echo $query;
            }
            else {
                // select filtered query
                $query = "SELECT * FROM livraisons WHERE $params->field = '$params->value' AND $params->customCriteria ORDER BY id_livraison ".$params->sortBy." LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            }*/
        //}
 //echo $query;
 
        $conn = IL_Database::getConn();
        
        $results = mysqli_query($conn, $query);
        
        // prepare query statement
        //$stmt = $conn->prepare($query);
        // execute query
        //$stmt->execute();
        
        return $results;
        
        
        /*
        $conn = IL_Database::getConn();
        
        //$sql = "SELECT COUNT($field) AS COUNT,$field FROM inventory WHERE DisplayOnWebSite=1 GROUP BY $field ORDER BY " . $field;
        $sql = "SELECT COUNT(dateLivraison) AS COUNT,dateLivraison FROM livraisons WHERE id_livraison>0 GROUP BY dateLivraison ORDER BY COUNT DESC LIMIT 20";
        //echo $sql;
        $result = mysqli_query($conn, $sql);

        $fieldArray = array();
        $countArray = array();

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)) {
                array_push($fieldArray, $row['dateLivraison']);
                array_push($countArray, $row['COUNT']);
            }
        }
        
        //echo json_encode(array_combine($fieldArray, $countArray));
        return json_encode(array_combine($fieldArray, $countArray));*/
    }
    
    function readTestCount($params){
        
        // decode search parameters
        $params = json_decode($params);
        
        if(empty($params->field) && empty($params->value)) {
            
            $where = '';
            
            for($i=0; $i<count($params->arrayFilters); $i++) {
                $where .= $params->arrayFilters[$i]->field . ' = "' . $params->arrayFilters[$i]->value . '" AND ';
            }
            
            if($where != '') {
                // select all query
                $queryCount = "SELECT * FROM livraisons WHERE $where $params->customCriteria ORDER BY id_livraison ".$params->sortBy;
            }
            else {
                // select all query
                $queryCount = "SELECT * FROM livraisons WHERE $params->customCriteria ORDER BY id_livraison ".$params->sortBy;
            }
        }
        else {
            
            $where = '';
            
            for($i=0; $i<count($params->arrayFilters); $i++) {
                $where .= $params->arrayFilters[$i]->field . ' = "' . $params->arrayFilters[$i]->value . '" AND ';
            }
            
            if($where != '') {
                // select filtered query
                $queryCount = "SELECT * FROM livraisons WHERE $where $params->customCriteria ORDER BY id_livraison ".$params->sortBy;
            }
            else {
                // select filtered query
                $queryCount = "SELECT * FROM livraisons WHERE $params->field = '$params->value' AND $params->customCriteria ORDER BY id_livraison ".$params->sortBy;
            }
        }
        //echo $queryCount;
        // prepare query statement
        $stmtCount = $this->conn->prepare($queryCount);
        // execute query
        $stmtCount->execute();
        
        return $stmtCount;
    }
    
    function readCountFilter($params) {
        
        // decode search parameters
        $params = json_decode($params);
        
        $where = '';
        
        if(isset($params->arrayFilters) && count($params->arrayFilters) > 0) {
            
            //$where = $params->searchType = "'$params->value' AND ";
            //$where = '';
            for($i=0; $i<count($params->arrayFilters); $i++) {
                $where .= $params->arrayFilters[$i]->field . ' = "' . $params->arrayFilters[$i]->value . '" AND ';
            }
            if($where == '') {
                $where = $params->searchType = "'$params->value' AND ";
            }
            //die($where);
        }
        
        /*if($params->value == '') {
            die('HERE');
        }*/
        
        //echo $where;
        if($params->searchType == 'marque') {
            //$query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM inventory WHERE $params->searchType = '$params->value' AND $params->customCriteria DisplayOnWebSite=1 GROUP BY $params->field ORDER BY COUNT DESC";
            $query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM livraisons WHERE $where $params->customCriteria  GROUP BY $params->field ORDER BY COUNT DESC";
            //echo 'QUERY #1'.$query;
        }
        if($params->searchType == 'Model') {
            //$query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM inventory WHERE $params->searchType = '$params->value' AND $params->customCriteria DisplayOnWebSite=1 GROUP BY $params->field ORDER BY COUNT DESC";
            $query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM livraisons WHERE $where $params->customCriteria GROUP BY $params->field ORDER BY COUNT DESC";
            //echo 'QUERY #2'.$query;
        }
        if($params->searchType == 'transtype') {
            //$query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM inventory WHERE $params->searchType = '$params->value' AND $params->customCriteria DisplayOnWebSite=1 GROUP BY $params->field ORDER BY COUNT DESC";
            $query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM livraisons WHERE $where $params->customCriteria GROUP BY $params->field ORDER BY COUNT DESC";
            //echo 'QUERY #3'.$query;
        }
        if($params->searchType == 'engine') {
            //$query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM inventory WHERE $params->searchType = '$params->value' AND $params->customCriteria DisplayOnWebSite=1 GROUP BY $params->field ORDER BY COUNT DESC";
            $query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM livraisons WHERE $where $params->customCriteria GROUP BY $params->field ORDER BY COUNT DESC";
            //echo 'QUERY #4'.$query;
        }
        if($params->searchType == '') {
            $query = "SELECT COUNT($params->field) AS COUNT, $params->field FROM livraisons WHERE $where $params->customCriteria GROUP BY $params->field ORDER BY COUNT DESC";
            //echo 'QUERY #4'.$query;
        }
        //echo $query;
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        
        return $stmt;
    }
    
    function create($livraison) {
        
        $sql = "INSERT INTO livraisons (dateLivraison, destinataire, nomSignataire, signature, noEmploye) VALUES (?,?,?,?,?)";
        $conn = IL_Database::getConn();
        //echo $livraison->signature;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $livraison->dateLivraison, $livraison->destinataire, $livraison->nomSignataire, $livraison->signature, $livraison->noEmploye);
        
        // execute query
        if($stmt->execute()){
            $insert_id = $stmt->insert_id;
            
            return true;
        }

        return false;
    }
    
    function save() {
        
        $conn = IL_Database::getConn();
        $sql = "UPDATE livraisons SET dateLivraison='$livraison->dateLivraison'" . 
                "destinataire='$livraison->destinataire'".
                "nomSignataire='$livraison->nomSignataire'".
                "signature='$livraison->signature'".
                "noEmploye='$livraison->noEmploye'".
                "WHERE id_livraison='$livraison->id_livraison".
                    
        $sql = "UPDATE users SET username='$username',level='$level',actif='$actif',password='$password' WHERE id_user=".$this->id;
        
        $result = mysqli_query($conn, $sql);
        
        $this->saveColis();

        return true;
    }
    
    function saveColis()
    {
        $conn = IL_Database::getConn();
        // DELETE associated colis and create new associations?
        $sql = "DELETE from livraisonsColis where fk_livraison='$this->id_livraison'";
        
        $result = mysqli_query($conn, $sql);
        
        foreach ($this->colis as $colis){
            $sql = "INSERT INTO livraisonsColis (fk_colis, fk_livraison VALUES (?,?,?,?,?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $livraison->id_livraison, 1);

            // execute query
            if($stmt->execute()){
                $insert_id = $stmt->insert_id;
            }
        }
        
    }
}
?>