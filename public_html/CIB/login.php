<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    require_once(dirname(__DIR__).'/../_includes/commonIncludes.php');
?>

<html  xmlns="http://www.w3.org/1999/xhtml" lang="fr-CA" xml:lang="fr-CA">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <title>
        Login
    </title>

    <script type="text/json" class="communicator">[{"nop":""}]</script>
    <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    <link rel="stylesheet" type="text/css" href="../assets/css/style_bonCommande.css" />
    
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="application/javascript" src="../assets/js/dsTools/dsSwissKnife.js"></script>
    <script type="application/javascript" src="../assets/js/dsTools/dsAjaxCommunicator.js"></script>
    <script type="application/javascript" src="../assets/js/dsTools/dsAjaxV2.js"></script>
    <script type="application/javascript" src="../assets/js/dsTools/dsValueFormatter.js"></script>
    <script type="application/javascript" src="../assets/js/container.js"></script>
    <script type="application/javascript" src="../assets/js/animator.js"></script>
    <script type="application/javascript" src="../assets/js/popup.js"></script>

    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/animator.css" />
    
    <link rel="stylesheet" type="text/css" href="../assets/css/utilisateurs.css" />    
    <link rel="stylesheet" type="text/css" href="../assets/css/popup.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/layout_normal.css" />
    
    <meta  http-equiv="Content-type"  content="text/html;charset=UTF-8" />
</head>
<body>
<div name='login' class='page_login base_page serializable'>
    <?php
        // Define variables and initialize with empty values
        $username = $password = "";
        $username_err = $password_err = $client_id_err = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if(isset($_POST['btnLogin']))
            {
                // Check if username is empty
                if(empty(trim($_POST["username"]))){
                    $username_err = 'Veuillez entrer votre nom d\'utilisateur.';
                } else{
                    $username = trim($_POST["username"]);
                }
    
                // Check if password is empty
                if(empty(trim($_POST['password']))){
                    $password_err = 'Veuillez entrer votre mot de passe.';
                } else{
                    $password = trim($_POST['password']);
                }
    
                // Validate credentials
                if(empty($username_err) && empty($password_err)){
                    // Prepare a select statement
                    $conn = IL_Database::getConn();
                    
//                    echo password_hash(mysqli_real_escape_string($conn, '966'),PASSWORD_DEFAULT);
//                    echo password_hash(mysqli_real_escape_string($conn, 'phil'),PASSWORD_DEFAULT);
//                    echo password_hash(mysqli_real_escape_string($conn, '999'),PASSWORD_DEFAULT);
                    
                    $sql = "SELECT username, password FROM UsersBonCommande WHERE username = ?";

                    if($stmt = mysqli_prepare($conn, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_username);

                        // Set parameters
                        $param_username = $username;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Store result
                            mysqli_stmt_store_result($stmt);

                            // Check if username exists, if yes then verify password
                            if(mysqli_stmt_num_rows($stmt) == 1){                    
                                // Bind result variables

                                mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                                if(mysqli_stmt_fetch($stmt)){
                                    if(password_verify($password, $hashed_password)){

                                        /* Password is correct, so start a new session and
                                        save the username to the session */
                                        session_start();

                                        $user = new IL_Users();
                                        $user->load(0,'',$username,1);
                                        IL_Session::w(IL_SessionVariables::USERNAME,$user->username);
                                        IL_Session::w(IL_SessionVariables::ID_USER,$user->id);
                                        IL_Session::w(IL_SessionVariables::LEVEL,$user->level);
                                        IL_Session::w(IL_SessionVariables::SUCCURSALE,$user->succursale);
                                        
                                        $pageDemandee = IL_Session::r(IL_SessionVariables::ASKED_PAGE);

                                        setcookie('username', $user->username, time() + (86400 * 30), "/");
                                        setcookie('succursale', $user->succursale, time() + (86400 * 30), "/");
                                        
                                        if( $user->succursale == "CIB" )
                                            if( $pageDemandee == "" )
                                                header('Location: ' . "boncommande.php?succ=" . $user->succursale );
                                            else
                                                header('Location: ' . $pageDemandee . "?succ=" . $user->succursale . "&askedPage=" . $pageDemandee );
                                        else
                                            header('Location: ' . "login.php");
                                        
                                    } else{
                                        // Display an error message if password is not valid
                                        $password_err = 'Le mot de passe n\'est pas valide.';
                                    }
                                }
                            } else{
                                // Display an error message if username doesn't exist
                                $username_err = 'Ce compte n\'existe pas.';
                            }
                        } else{
                            echo "Houla! Une grave erreur s'est produite";
                        }
                    }
                    // Close statement
                    mysqli_stmt_close($stmt);
                }
                // Close connection
                mysqli_close($conn);

            }
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <img src="../assets/images/reseaudynamique_logo.png" alt=""/>                
            </div>
            <div class="col-xs-12">
                <label class="h1bonCommande">Bons de commande</label>
            </div>
        </div>
        <div class="row login">
            <div class="col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 loginBox">                
                <form name="form" role="form" method="POST" action="login.php">                    
                    <div class="row">
                        <div class="col-xs-6 label_boncommande">Nom d'utilisateur</div>
                        <div class="col-xs-6 field">
                            <input type="text" id="username" name="username" class="input" value="<?php echo $username;?>"/>
                            <span class="error"><?php echo $username_err;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 label_boncommande">Mot de passe</div>
                        <div class="col-xs-6 field">
                            <input type="password" id="password" name="password" class="input" value=""/>
                            <span class="error"><?php echo $password_err ;?></span>
                        </div>
                    </div>
                    <div class="row buttons">
                        <div class=" col-xs-12">
                            <input type="submit" class="buttonStyle btn-default" id="btnLogin" name="btnLogin" value="Entrer" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                registration.unregister()
            } });
    </script>
</div>
<div id="showLoading">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    <span class="sr-only">Loading...</span>
    <!--img src="wait.png"-->
</div>
</body>
</html>
