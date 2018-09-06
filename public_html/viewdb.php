<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<body style="background: #000">
    <div name='menu' class='page_menu layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">menu</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?></div>
            <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
<div id="contenu">
    <form action="viewdb.php" method="post">
        <?php
            try{
                $servername = "localhost";
                $username = "interlivraison";
                $password = "TT67xgw!**";
                $dbname = "interlivraison";
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                function mysqli_field_name($result, $field_offset)
                {
                    $properties = mysqli_fetch_field_direct($result, $field_offset);
                    return is_object($properties) ? $properties->name : null;
                }

                if (isset($_GET['tableName'])) {
                    // get rows from table that was passed in the parameters in the url while the employee chats while waiting in line to punch their time card
                    $tableName = $_GET['tableName'];

                    $query = "SELECT COLUMN_NAME FROM information_schema.columns WHERE TABLE_SCHEMA='$dbname' AND TABLE_NAME='$tableName';";
                    $result = mysqli_query($conn, $query);

                    $fieldsQuery = "SELECT ";
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $fieldsQuery .= $row["COLUMN_NAME"] . ",";
                        }
                        // remove last comma --> how to do this one in one line?
                        $fieldsQuery = substr($fieldsQuery, 0, -1);
                        $fieldsQuery .= " FROM $tableName" . ";";

                        // fetch data from table parce que SELECT * from $tableName aurait été trop simple!!!
                        $result = mysqli_query($conn, $fieldsQuery);
                        if(mysqli_num_rows($result) > 0){
                            echo "<table width='100%'><tr>";
                            if (mysqli_num_rows($result)>0){
                                //loop thru the field names to print the correct headers
                                $i = 0;
                                while ($i < mysqli_num_fields($result)){
                                    echo "<th><font color='#fff'>". mysqli_field_name($result, $i) . "&nbsp;&nbsp;</font></th>";
                                    $i++;
                                }
                                echo "</tr>";

                                while ($rows = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    foreach ($rows as $data)
                                        echo "<td align='center'><font color='#fff'>". $data . "</font></td>";
                                }
                            }
                            else{
                                echo "<tr><td colspan='" . ($i+1) . "'>No Results found!</td></tr>";
                            }
                            echo "</table>";
                        }
                        else{
                            echo "Error in running query :". mysql_error();
                        }
                    }
                    else {
                        echo "[<b>0</b>] field names...omg wtf lol<br>";
                    }
                }// Display Table Names
                $query = "SELECT table_name FROM information_schema.tables where table_schema='$dbname';";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "Table <b><a href='" . $_SERVER['PHP_SELF'] . "?tableName=" . $row["table_name"]. "'>" . $row["table_name"]. "</a></b><br>";
                    }
                }
                else {
                    echo "[<b>0</b>] field names...omg wtf lol<br>";
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['btnDelOwnCommands'])) {
                        echo deleteCommandeFromMoi();
                    }
                    if( isset($_POST['btnDoShit']))
                    {
                        //$dateCommande = new DateTime(strtotime('1522505933'));
                        //echo $dateCommande;                        
                    }
                }
                else
                {}
            } 
        catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        ?>
    </form>
</body>
</html>