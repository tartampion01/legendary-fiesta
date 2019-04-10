<?php

require_once(dirname(__DIR__). '/objects/IL_Session.php');

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
    public $succursale    = "";
    public $facture       = "";
    public $colis         = "";
    
    //public $colis = array(); // TABLE livraisonsColis contient fkColis = colis.id_colis AND fkLivraison = livraisons.id_livraison
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
        $this->succursale = $r['succursale'];
        $this->facture = $r['facture'];
        $this->colis = $r['colis'];
        
        //$this->loadColis();
        
        //var_dump($this);
        
        return true;
    }

    public function loadColis()
    {
        $conn = IL_Database::getConn();
        
        $sql = "SELECT facture, colis FROM colisLivraison AS cl INNER JOIN livraisons AS l ON cl.fkLivraison = l.id_livraison WHERE cl.fkLivraison=$this->id_livraison";
        
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
    
    function feuilleDeRouteReadTest($params){
        
        // decode search parameters
        $params = json_decode($params);
        $noEmploye = $_GET("NOEMPLOYE");
        
        $sortBy = 'dateLivraison';
        if(!is_null($params->sortBy)) {
            $sortBy = $params->sortBy;
        }
        $orderBy = 'DESC';
        if(!is_null($params->orderBy)) {
            $orderBy = $params->orderBy;
        }
        
        if(is_null($params->filterRows)) {
            //$query = "SELECT COUNT(dateLivraison) AS COUNT, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons WHERE id_livraison>0 GROUP BY dateLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            //$query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons INNER JOIN colisLivraison ON livraisons.id_livraison = colisLivraison.fkLivraison WHERE id_livraison>0 GROUP BY colisLivraison.fkLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            $query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye, succursale FROM livraisons WHERE succursale='$succursale' AND noEmploye='$noEmploye' AND id_livraison>0 GROUP BY id_livraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
        }
        else {
            $where = '';
            for($i=0; $i<count($params->filterRows); $i++) {
                if($params->filterRows[$i]->comparator == 'like') {
                    $where .= 'AND ' . $params->filterRows[$i]->field . ' '.$params->filterRows[$i]->comparator.' "%' . $params->filterRows[$i]->value . '%"';
                }
                else {
                    $where .= 'AND ' . $params->filterRows[$i]->field . ' '.$params->filterRows[$i]->comparator.' "' . $params->filterRows[$i]->value . '"';
                }
            }
            //echo $where;
            //$query = "SELECT COUNT(dateLivraison) AS COUNT, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons WHERE id_livraison>0 $where GROUP BY dateLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            //$query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons INNER JOIN colisLivraison ON livraisons.id_livraison = colisLivraison.fkLivraison WHERE id_livraison>0 $where GROUP BY colisLivraison.fkLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            $query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye, succursale FROM livraisons WHERE succursale='$succursale' AND noEmploye='$noEmploye' AND id_livraison>0 $where GROUP BY id_livraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
        }
//echo $succursale;
//echo $query;
 
        $conn = IL_Database::getConn();
        
        $results = mysqli_query($conn, $query);
        
        return $results;
    }
    
    function readTest($params){
        
        // decode search parameters
        $params = json_decode($params);
        $succursale = IL_Session::r(IL_SessionVariables::SUCCURSALE);
        
        $sortBy = 'dateLivraison';
        if(!is_null($params->sortBy)) {
            $sortBy = $params->sortBy;
        }
        $orderBy = 'DESC';
        if(!is_null($params->orderBy)) {
            $orderBy = $params->orderBy;
        }
        
        if(is_null($params->filterRows)) {
            //$query = "SELECT COUNT(dateLivraison) AS COUNT, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons WHERE id_livraison>0 GROUP BY dateLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            //$query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons INNER JOIN colisLivraison ON livraisons.id_livraison = colisLivraison.fkLivraison WHERE id_livraison>0 GROUP BY colisLivraison.fkLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            $query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye, succursale FROM livraisons WHERE succursale='$succursale' AND id_livraison>0 GROUP BY id_livraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
        }
        else {
            $where = '';
            for($i=0; $i<count($params->filterRows); $i++) {
                if($params->filterRows[$i]->comparator == 'like') {
                    $where .= 'AND ' . $params->filterRows[$i]->field . ' '.$params->filterRows[$i]->comparator.' "%' . $params->filterRows[$i]->value . '%"';
                }
                else {
                    $where .= 'AND ' . $params->filterRows[$i]->field . ' '.$params->filterRows[$i]->comparator.' "' . $params->filterRows[$i]->value . '"';
                }
            }
            //echo $where;
            //$query = "SELECT COUNT(dateLivraison) AS COUNT, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons WHERE id_livraison>0 $where GROUP BY dateLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            //$query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons INNER JOIN colisLivraison ON livraisons.id_livraison = colisLivraison.fkLivraison WHERE id_livraison>0 $where GROUP BY colisLivraison.fkLivraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
            $query = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye, succursale FROM livraisons WHERE succursale='$succursale' AND id_livraison>0 $where GROUP BY id_livraison ORDER BY $sortBy $orderBy LIMIT ". ( ( $params->currentPage - 1 ) * $params->limitPerPage ) . ", $params->limitPerPage";
        }
//echo $succursale;
//echo $query;
 
        $conn = IL_Database::getConn();
        
        $results = mysqli_query($conn, $query);
        
        return $results;
    }
    
    function readTestCount($params){
        
        // decode search parameters
        $params = json_decode($params);
        $succursale = IL_Session::r(IL_SessionVariables::SUCCURSALE);
        
        if(is_null($params->filterRows)) {
            //$queryCount = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons INNER JOIN colisLivraison ON livraisons.id_livraison = colisLivraison.fkLivraison WHERE id_livraison>0 GROUP BY colisLivraison.fkLivraison ORDER BY dateLivraison DESC";
            $queryCount = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye, succursale FROM livraisons WHERE succursale='$succursale' AND id_livraison>0 GROUP BY id_livraison ORDER BY dateLivraison DESC";
        }
        else {
            $where = '';
            for($i=0; $i<count($params->filterRows); $i++) {
                if($params->filterRows[$i]->comparator == 'like') {
                    $where .= 'AND ' . $params->filterRows[$i]->field . ' '.$params->filterRows[$i]->comparator.' "%' . $params->filterRows[$i]->value . '%"';
                }
                else {
                    $where .= 'AND ' . $params->filterRows[$i]->field . ' '.$params->filterRows[$i]->comparator.' "' . $params->filterRows[$i]->value . '"';
                }
            }
            //$queryCount = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye FROM livraisons INNER JOIN colisLivraison ON livraisons.id_livraison = colisLivraison.fkLivraison WHERE id_livraison>0 $where GROUP BY colisLivraison.fkLivraison ORDER BY dateLivraison DESC";
            $queryCount = "SELECT colis, facture, id_livraison, dateLivraison, dateHumain, destinataire, nomSignataire, signature, noEmploye, succursale FROM livraisons WHERE succursale='$succursale' AND id_livraison>0 $where GROUP BY id_livraison ORDER BY dateLivraison DESC";
        }
//echo "SUCC=>$succursale query=" . $queryCount;

        $conn = IL_Database::getConn();
        
        $results = mysqli_query($conn, $queryCount);
        
        return $results;
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
        
        $error = false;
        $sql = "INSERT INTO livraisons (dateLivraison, destinataire, nomSignataire, signature, noEmploye, colis, facture, succursale) VALUES (?,?,?,?,?,?,?,?)";

        $conn = IL_Database::getConn();
        $stmt = $conn->prepare($sql);
        
        foreach ($this->colis as $postedColis) {
            $colis = (array)$postedColis; // pour convertr de stdClass
            
            $stmt->bind_param("ssssssss", $livraison->dateLivraison, $livraison->destinataire, $livraison->nomSignataire, $livraison->signature, $livraison->noEmploye, $colis["colis"], $colis["facture"], $livraison->succursale);
        
            // execute query
            if($stmt->execute()){
                $insert_id = $stmt->insert_id;
                $this->id_livraison = $insert_id;
            }
            else {
                $error = true;
                return;
            }
        }
        
        if(!$error)
            return true;
        else
            return false;
    }
    
    function save($livraison) {
        $arrayColis = (array)$livraison->colis[0]; // pour convertr de stdClass
        $colis = $arrayColis["colis"];
        $facture = $arrayColis["facture"];
        
        $conn = IL_Database::getConn();
        $sql = "UPDATE livraisons SET dateLivraison=?," . 
                " destinataire=?,".
                " nomSignataire=?,".
                " signature=?,".
                " noEmploye=?,".
                " colis=?,".
                " facture=?".
                " WHERE id_livraison=$livraison->id_livraison";
      
        //echo $sql;
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("sssssss", $livraison->dateLivraison, $livraison->destinataire, $livraison->nomSignataire, $livraison->signature, $livraison->noEmploye, $colis, $facture);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    function saveColis()
    {
        $conn = IL_Database::getConn();
        // DELETE associated colis and create new associations?
        $sql = "DELETE from colisLivraison where fkLivraison='$this->id_livraison'";

        $result = mysqli_query($conn, $sql);

        // ADD COLIS
        foreach ($this->colis as $postedColis){
            $colis = (array)$postedColis; // pour convertr de stdClass
            $sql = "INSERT INTO colisLivraison (fkLivraison, colis, facture) VALUES (?,?,?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $this->id_livraison, $colis["colis"], $colis["facture"]);

            // execute query
            if($stmt->execute()){
                $insert_id = $stmt->insert_id;                
            }
        }
        
        return true;
    }
}
?>
