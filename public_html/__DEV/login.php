<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    require_once(dirname(__DIR__).'/__DEVincludes/commonIncludes.php');
    
    ini_set('session.gc_maxlifetime', 2592000);
    ini_set('session.cookie_lifetime', 2592000);
    session_set_cookie_params(2592000);

    session_start();
    IL_Session::start();
?>

<html  xmlns="http://www.w3.org/1999/xhtml" lang="fr-CA" xml:lang="fr-CA">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <title>
        Login
    </title>

    <script type="text/json" class="communicator">[{"nop":""}]</script>
    <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsSwissKnife.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsAjaxCommunicator.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsAjaxV2.js"></script>
    <script type="application/javascript" src="assets/js/dsTools/dsValueFormatter.js"></script>
    <script type="application/javascript" src="assets/js/container.js"></script>
    <script type="application/javascript" src="assets/js/animator.js"></script>
    <script type="application/javascript" src="assets/js/popup.js"></script>
    
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/animator.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/utilisateurs.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/login.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/popup.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/menu.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/layout_normal.css" />
    
    <meta  http-equiv="Content-type"  content="text/html;charset=UTF-8" />
</head>
<body>
<div name='divAgent' id="divAgent"></div>
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
                    
                    $sql = "SELECT username, password FROM users WHERE username = ?";

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
                                        
//                                        session_destroy();
//                                        IL_Session::w(IL_SessionVariables::USERNAME,false);
//                                        IL_Session::w(IL_SessionVariables::ID_USER,false);
//                                        IL_Session::w(IL_SessionVariables::LEVEL,false);
//                                        IL_Session::w(IL_SessionVariables::SUCCURSALE,false);

//                                        ini_set('session.gc_maxlifetime', 604800);
//                                        session_set_cookie_params(604800);
//                                        
//                                        session_start();
//                                        IL_Session::start();
                                        
                                        //$_SESSION = array();
                                        
                                        $user = new IL_Users();
                                        $user->load(0,'',$username,0);
                                        
                                        IL_Session::w(IL_SessionVariables::USERNAME,  $user->username);
                                        IL_Session::w(IL_SessionVariables::SUCCURSALE,$user->succursale);
                                        IL_Session::w(IL_SessionVariables::ID_USER,   $user->id);
                                        IL_Session::w(IL_SessionVariables::LEVEL,     $user->level);
                                        
                                        setcookie('USERNAME', $user->username, time() + (2592000), "/");
                                        setcookie('SUCCURSALE', $user->succursale, time() + (2592000), "/");
                                        setcookie('ID_USER', $user->id, time() + (2592000), "/");
                                        setcookie('LEVEL', $user->level, time() + (2592000), "/");
                                        
                                        header('Location: ' . "default.php");
                                        
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
                            echo "Houla! Une grave erreur s'est produite [mysqli_stmt_execute($ stmt)]";
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
                <br/>
                <img src="assets/images/reseaudynamique_logo.png" alt=""/>
            </div>
        </div>
        <div class="row login">
            <div class="col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 loginBox">
                <form name="form" role="form" method="POST" action="/__DEV/login.php">
                    <div class="row">
                        <div class="col-xs-6 label">Nom d'utilisateur</div>
                        <div class="col-xs-6 field">
                            <input type="text" id="username" name="username" class="input" value="<?php echo $username;?>"/>
                            <span class="error"><?php echo $username_err;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 label">Mot de passe</div>
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
