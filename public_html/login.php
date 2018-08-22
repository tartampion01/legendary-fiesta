<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(dirname(__DIR__).'/_includes/commonIncludes.php');
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
<div name='login' class='page_login base_page serializable'>
    <?php
        $usernameErr = $passwordErr = "";
        $username = $password = "";

        $errorCount = 0;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if(isset($_POST['btnLogin']))
            {
                if (empty($_POST["username"])){
                    $usernameErr = "Champ obligatoire";
                    $errorCount += 1;
                }
                else
                    $username = IL_Utils::test_input($_POST["username"]);

                if (empty($_POST["password"])){
                    $passwordErr = "Champ obligatoire";
                    $errorCount += 1;
                }
                else
                    $password = IL_Utils::test_input($_POST["password"]);
                
                // LOGIN
                if( $errorCount == 0 )
                {
                    $level = IL_Utils::login($username,$password);
                    
                    $_SESSION["username"] = $username;
                    $_SESSION["level"] = $level;
                    
                    // Most useless switch ever?!?
                    switch($level)
                    {
                        // USER
                        case 0: header('Location: ' . "default.php");
                                break;
                        // ADMIN
                        case 1: header('Location: ' . "default.php");
                                break;
                        // BOTH
                        case 2: header('Location: ' . "default.php");
                                break;
                        case -1: $usernameErr = "Utilisateur inexistant/Mauvais mot de passe";
                            break;
                    }
                    
                    echo $result;
                }
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
                <form name="form" role="form" method="POST" action="/login.php">
                    <div class="row">
                        <div class="col-xs-6 label">Nom d'utilisateur</div>
                        <div class="col-xs-6 field">
                            <input type="text" id="username" name="username" class="input" value="<?php echo $username;?>"/>
                            <span class="error"><?php echo $usernameErr;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 label">Mot de passe</div>
                        <div class="col-xs-6 field">
                            <input type="password" id="password" name="password" class="input" value=""/>
                            <span class="error"><?php echo $passwordErr ;?></span>
                        </div>
                    </div>
                    <div class="row buttons">
                        <div class=" col-xs-12">
                            <input type="submit" class="buttonStyle btn-default" id="btnLogin" name="btnLogin" />
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
