<?php
require_once('class.phpmailer.php');
require_once('class.smtp.php');

interface TypeEmail
{
    const DemandeInformation = 1;
    const PlanifierEssaiRoutier = 2;
    const ObtenirPrix = 3;
    const DemandFinancement = 4;
    const EvaluerEchange = 5;
    const InscriptionNextPart = 6;
    const BonTravail = 7;
    const DemandePieces = 8;
    const InscriptionAUTOMANN = 9;
    const PostulerEmploi = 10;
}

interface TypeVehicule
{
    const CamionNeuf = 1;
    const CamionUsage = 2;
    const Remorque = 3;
}

interface TypeInstructionsBonTravail
{
    const EstimeAvantDebutTravaux = 1;
    const ProcederMaisAppelerSiPrixExcede = 2;
    const PasDevaluation = 3;
}

Class IL_Email
{
    public $camion;
    public $prenom = '';
    public $nom = '';
    public $ville = '';
    public $email = '';
    public $telephone = '';
    public $commentaire = '';
    public $adresse = '';
    public $province = '';
    public $codePostal = '';
    public $marque = '';
    public $modele = '';
    public $annee = '';
    public $km = '';
    public $etatInterieur = '';
    public $etatExterieur = '';
    public $idVehicule = '';
    public $mail = null;
    public $vin = '';
    public $unite = '';
    public $bonCommande = '';
    public $travaux = '';
    public $responsable = '';
    public $succursale = '';
    public $prixReparationsMax = '';
    public $instructions = '';
    public $compagnie = '';
    public $pieces = '';
    public $description = '';
    public $travaux1 = '';
    public $travaux2 = '';
    public $travaux3 = '';
    public $travaux4 = '';
    public $travaux5 = '';
    public $travaux6 = '';
    public $travaux7 = '';
    public $travaux8 = '';
    
    public function load($TypeEmail,$Prenom,$Nom,$Ville,$Email,$Telephone,$Commentaire,$Adresse,$Province,$CodePostal,$Marque,$Modele,$Annee,$Km,$EtatInterieur,$EtatExterieur, $IdVehicule, $TypeVehicule, $NEW)
    {
        global $applicationConfig;
        $emailto = $toName = $subject = $body = "";
        
        switch($TypeEmail)
        {
            case TypeEmail::DemandeInformation:   //$emailto = "ptourigny@servicesinfo.info,philtourigny@gmail.com";
                                                  $emailto= "dpaquet@inter-quebec.com,lgerbermuir@inter-quebec.com";
                                                  $toName  = "";
                                                  $subject = "Demande d'information";
                                                  $this->camion = new RD_Camion(null);
                                                  if( $NEW == 1 )
                                                    $this->camion->load_new(urldecode(base64_decode($IdVehicule)));
                                                  else
                                                      $this->camion->load_used(urldecode(base64_decode($IdVehicule)));
                                                  break;
            case TypeEmail::PlanifierEssaiRoutier://$emailto = "ptourigny@servicesinfo.info";
                                                  $emailto= "dpaquet@inter-quebec.com,lgerbermuir@inter-quebec.com";
                                                  $toName  = "";
                                                  $subject = "Demande de planification d'un essai routier";
                                                  $this->camion = new RD_Camion(null);
                                                  if( $NEW == 1 )
                                                    $this->camion->load_new(urldecode(base64_decode($IdVehicule)));
                                                  else
                                                      $this->camion->load_used(urldecode(base64_decode($IdVehicule)));
                                                  break;
            case TypeEmail::ObtenirPrix:          //$emailto = "ptourigny@servicesinfo.info";
                                                  $emailto= "dpaquet@inter-quebec.com,lgerbermuir@inter-quebec.com";
                                                  $subject = "Obtenir un prix";
                                                  $this->camion = new RD_Camion(null);
                                                  if( $NEW == 1 )
                                                    $this->camion->load_new(urldecode(base64_decode($IdVehicule)));
                                                  else
                                                      $this->camion->load_used(urldecode(base64_decode($IdVehicule)));
                                                  break;
            case TypeEmail::DemandFinancement:    //$emailto = "ptourigny@servicesinfo.info";
                                                  $emailto= "dpaquet@inter-quebec.com,lgerbermuir@inter-quebec.com";
                                                  $toName  = "";
                                                  $subject = "Demande de financement";
                                                  $this->camion = new RD_Camion(null);
                                                  if( $NEW == 1 )
                                                    $this->camion->load_new(urldecode(base64_decode($IdVehicule)));
                                                  else
                                                      $this->camion->load_used(urldecode(base64_decode($IdVehicule)));
                                                  break;
            case TypeEmail::EvaluerEchange:       //$emailto = "ptourigny@servicesinfo.info";
                                                  $emailto= "dpaquet@inter-quebec.com,lgerbermuir@inter-quebec.com";
                                                  $toName  = "";
                                                  $subject = "Demande d'évaluation d'échange";
                                                  $this->camion = new RD_Camion(null);
                                                  if( $NEW == 1 )
                                                    $this->camion->load_new(urldecode(base64_decode($IdVehicule)));
                                                  else
                                                      $this->camion->load_used(urldecode(base64_decode($IdVehicule)));
                                                  break;
            case TypeEmail::InscriptionNextPart:  //$emailto = "ptourigny@servicesinfo.info";
                                                  $emailto= "pdesrosiers@inter-quebec.com";
                                                  $toName  = "";
                                                  $subject = "Inscription NextPart";
                                                  break;
            case TypeEmail::InscriptionAUTOMANN:  //$emailto = "philtourigny@gmail.com";
                                                  $emailto= "crouleau@inter-quebec.com";
                                                  $toName  = "";
                                                  $subject = "Inscription AUTOMANN";
                                                  break;
        }
        
        $this->prenom = $Prenom;
        $this->nom = $Nom;
        $this->ville = $Ville;
        $this->email = urldecode($Email);
        $this->telephone = $Telephone;
        $this->commentaire = $Commentaire;
        $this->adresse = $Adresse;
        $this->province = $Province;
        $this->codePostal = $CodePostal;
        $this->marque = $Marque;
        $this->modele = $Modele;
        $this->annee = $Annee;
        $this->km = $Km;
        $this->etatInterieur = urldecode(base64_decode($EtatInterieur));
        $this->etatExterieur = urldecode(base64_decode($EtatExterieur));
        $this->idVehicule = $IdVehicule;
        
        $this->mail = new PHPMailer;

        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = $applicationConfig['smtp.server.host'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $applicationConfig['smtp.server.username'];
        $this->mail->Password = $applicationConfig['smtp.server.password'];
        $this->mail->SMTPSecure = false;
        $this->mail->Port = $applicationConfig['smtp.server.port'];
        $this->mail->setFrom('mailer@reseaudynamique.com', 'reseaudynamique.com');        
        $this->mail->addReplyTo($this->email, $this->prenom . " " . $this->nom);
        $this->mail->Subject = $subject;

        if( strpos($emailto, ",") === false )
            $this->mail->addAddress($emailto);
        else{
            // Plusieurs adresses emial pour un client ex.
            foreach(explode(",",$emailto) as $emailaddress)
                $this->mail->addAddress($emailaddress);
        }
        
        // Le body spécifique
        switch($TypeEmail)
        {
            case TypeEmail::DemandeInformation:
                $body .= "<table>";
                $body .= "<tr><td><img src='http://www.reseaudynamique.com/_assets/images/logoReseauDynamique.png' width='249' height='69' border='0' alt='Logo' title='Logo' style='display:block'></p></td></tr>";
                $body .= "<tr><td><b>Provient de </b></td><td><a href='";
                if( $NEW == 1 )
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsNEW) . "?id=" . $this->idVehicule;
                else
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsUSED) . "?id=" . $this->idVehicule;
                $body .= "'>" . $this->camion->noInventaire . "</a></td></tr>";
                $body .= "<tr><td><b>Véhicule</b></td><td>". $this->camion->beauTitre . "</td></tr>";
                $body .= "<tr><td><b>SKU</b></td><td>". $this->camion->noInventaire . "</td></tr>";
                $body .= "<tr><td><b>Prénom</b></td><td>". $this->prenom . "</td></tr>";
                $body .= "<tr><td><b>Nom</b></td><td>". $this->nom . "</td></tr>";
                $body .= "<tr><td><b>Ville</b></td><td>" . $this->ville . "</td></tr>";
                $body .= "<tr><td><b>Téléphone</b></td><td>" . $this->telephone . "</td></tr>";
                $body .= "<tr><td><b>Courriel</b></td><td>" . $this->email . "</td></tr>";
                if( $this->commentaire != "" )
                    $body .= "<tr><td><b>Commentaire</b></td><td>" . $this->commentaire . "</td></tr>";
                $body .= "</table>";
                break;
            case TypeEmail::PlanifierEssaiRoutier:
                $body .= "<table>";
                $body .= "<tr><td><img src='http://www.reseaudynamique.com/_assets/images/logoReseauDynamique.png' width='249' height='69' border='0' alt='Logo' title='Logo' style='display:block'></p></td></tr>";
                $body .= "<tr><td><b>Provient de </b></td><td><a href='";
                if( $NEW == 1 )
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsNEW) . "?id=" . $this->idVehicule;
                else
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsUSED) . "?id=" . $this->idVehicule;
                $body .= "'>" . $this->camion->noInventaire . "</a></td></tr>";
                $body .= "<tr><td><b>Véhicule</b></td><td>". $this->camion->beauTitre . "</td></tr>";
                $body .= "<tr><td><b>SKU</b></td><td>". $this->camion->noInventaire . "</td></tr>";
                $body .= "<tr><td><b>Prénom</b></td><td>". $this->prenom . "</td></tr>";
                $body .= "<tr><td><b>Nom</b></td><td>". $this->nom . "</td></tr>";
                $body .= "<tr><td><b>Ville</b></td><td>" . $this->ville . "</td></tr>";
                $body .= "<tr><td><b>Téléphone</b></td><td>" . $this->telephone . "</td></tr>";
                $body .= "<tr><td><b>Courriel</b></td><td>" . $this->email . "</td></tr>";
                if( $this->commentaire != "" )
                    $body .= "<tr><td><b>Commentaire</b></td><td>" . $this->commentaire . "</td></tr>";
                $body .= "</table>";
                break;
            case TypeEmail::ObtenirPrix:
                $body .= "<table>";
                $body .= "<tr><td><img src='http://www.reseaudynamique.com/_assets/images/logoReseauDynamique.png' width='249' height='69' border='0' alt='Logo' title='Logo' style='display:block'></p></td></tr>";
                $body .= "<tr><td><b>Provient de </b></td><td><a href='";
                if( $NEW == 1 )
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsNEW) . "?id=" . $this->idVehicule;
                else
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsUSED) . "?id=" . $this->idVehicule;
                $body .= "'>" . $this->camion->noInventaire . "</a></td></tr>";
                $body .= "<tr><td><b>Véhicule</b></td><td>". $this->camion->beauTitre . "</td></tr>";
                $body .= "<tr><td><b>SKU</b></td><td>". $this->camion->noInventaire . "</td></tr>";
                $body .= "<tr><td><b>Prénom</b></td><td>". $this->prenom . "</td></tr>";
                $body .= "<tr><td><b>Nom</b></td><td>". $this->nom . "</td></tr>";
                $body .= "<tr><td><b>Ville</b></td><td>" . $this->ville . "</td></tr>";                
                if( $this->commentaire != "" )
                    $body .= "<tr><td><b>Commentaire</b></td><td>" . $this->commentaire . "</td></tr>";
                $body .= "<tr><td><b>Courriel</b></td><td>" . $this->email . "</td></tr>";
                $body .= "<tr><td><b>Téléphone</b></td><td>" . $this->telephone . "</td></tr></table>";
                break;
            case TypeEmail::DemandFinancement:
                $body .= "<table>";
                $body .= "<tr><td><img src='http://www.reseaudynamique.com/_assets/images/logoReseauDynamique.png' width='249' height='69' border='0' alt='Logo' title='Logo' style='display:block'></p></td></tr>";
                $body .= "<tr><td><b>Provient de </b></td><td><a href='";
                if( $NEW == 1 )
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsNEW) . "?id=" . $this->idVehicule;
                else
                    $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsUSED) . "?id=" . $this->idVehicule;
                $body .= "'>" . $this->camion->noInventaire . "</a></td></tr>";
                $body .= "<tr><td><b>Véhicule</b></td><td>". $this->camion->beauTitre . "</td></tr>";
                $body .= "<tr><td><b>SKU</b></td><td>". $this->camion->noInventaire . "</td></tr>";
                $body .= "<tr><td><b>Prénom</b></td><td>". $this->prenom . "</td></tr>";
                $body .= "<tr><td><b>Nom</b></td><td>". $this->nom . "</td></tr>";
                $body .= "<tr><td><b>Adresse</b></td><td>" . $this->adresse . "</td></tr>";
                $body .= "<tr><td><b>Ville</b></td><td>" . $this->ville . "</td></tr>";
                $body .= "<tr><td><b>Code Postal</b></td><td>" . $this->codePostal . "</td></tr>";
                $body .= "<tr><td><b>Province</b></td><td>" . base64_decode(urldecode($this->province)) . "</td></tr>";
                $body .= "<tr><td><b>Téléphone</b></td><td>" . $this->telephone . "</td></tr>";
                $body .= "<tr><td><b>Courriel</b></td><td>" . $this->email . "</td></tr>";
                if( $this->commentaire != "" )
                    $body .= "Commentaire: " . $this->commentaire . "</td></tr>";
                $body .= "</table>";
                break;
            case TypeEmail::InscriptionNextPart:
                $body = "Demande d'inscription à NextPart de la part de: " . $this->prenom . " " . $this->nom . "<br />";
                $body .= "Entreprise: " . $this->ville . "<br />";
                $body .= "Telephone: " . $this->telephone . "<br />";
                $body .= "Courriel: " . $this->email . "<br />";
                if( $this->commentaire != "" )
                    $body .= "Commentaire: " . $this->commentaire . "<br /><br />";
                break;
            case TypeEmail::InscriptionAUTOMANN:
                $body = "Demande d'inscription de la part de: " . $this->prenom . "<br />";
                $body .= "# de facture: " . $this->nom . "<br />";
                $body .= "Nom de votre succursale: " . $this->ville . "<br />";
                $body .= "Courriel: " . $this->email;
                break;
            default:break;
        }
//echo $body;
        $this->mail->Body = $body;
        $this->mail->AltBody = "-alt-";
    }
    
    public function loadEvaluerEchange($TypeEmail,$Prenom,$Nom,$Ville,$Email,$Telephone,$Commentaire,$Adresse,$Province,$CodePostal,$Marque,$Modele,$Annee,$Km,$EtatInterieur,$EtatExterieur, $IdVehicule, $TypeVehicule, $file1, $file2, $file3, $file1temp, $file2temp, $file3temp, $NEW)
    {
        global $applicationConfig;
        $emailto = $toName = $subject = $body = "";
        
        //$emailto = "ptourigny@servicesinfo.info";
        $emailto = "dpaquet@inter-quebec.com,lgerbermuir@inter-quebec.com";
        $toName  = "";
        $subject = "Demande d'évaluation d'échange";

        $this->camion = new RD_Camion(null);
        if( $NEW == 1 )
          $this->camion->load_new(urldecode(base64_decode($IdVehicule)));
        else
            $this->camion->load_used(urldecode(base64_decode($IdVehicule)));
        
        $this->prenom = $Prenom;
        $this->nom = $Nom;
        $this->ville = $Ville;
        $this->email = urldecode($Email);
        $this->telephone = $Telephone;
        $this->commentaire = $Commentaire;
        $this->adresse = $Adresse;
        $this->province = $Province;
        $this->codePostal = $CodePostal;
        $this->marque = $Marque;
        $this->modele = $Modele;
        $this->annee = $Annee;
        $this->km = $Km;
        $this->etatInterieur = urldecode(base64_decode($EtatInterieur));
        $this->etatExterieur = urldecode(base64_decode($EtatExterieur));
        $this->idVehicule = $IdVehicule;
        
        $this->mail = new PHPMailer;

        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = $applicationConfig['smtp.server.host'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $applicationConfig['smtp.server.username'];
        $this->mail->Password = $applicationConfig['smtp.server.password'];
        $this->mail->SMTPSecure = false;
        $this->mail->Port = $applicationConfig['smtp.server.port'];
        $this->mail->setFrom('mailer@reseaudynamique.com', 'reseaudynamique.com');
        $this->mail->addReplyTo($this->email, $this->prenom . " " . $this->nom);
        $this->mail->Subject = $subject;
        
        if( strpos($emailto, ",") === false )
            $this->mail->addAddress($emailto);
        else{
            // Plusieurs adresses emial pour un client
            foreach(explode(",",$emailto) as $emailaddress)
                $this->mail->addAddress($emailaddress);
        }        
                
        $body .= "<table>";
        $body .= "<tr><td><img src='http://www.reseaudynamique.com/_assets/images/logoReseauDynamique.png' width='249' height='69' border='0' alt='Logo' title='Logo' style='display:block'></p></td></tr>";
        $body .= "<tr><td><b>Provient de </b></td><td><a href='";
        
        if( $NEW == 1 )
            $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsNEW) . "?id=" . $this->idVehicule;
        else
            $body .= RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_detailsUSED) . "?id=" . $this->idVehicule;
        
        $body .= "'>" . $this->camion->noInventaire . "</a></td></tr>";
        
        $body .= "<tr><td><b>Véhicule</b></td><td>". $this->camion->beauTitre . "</td></tr>";
        $body .= "<tr><td><b>SKU</b></td><td>". $this->camion->noInventaire . "</td></tr>";
        $body .= "<tr><td><b>Prénom</b></td><td>". $this->prenom . "</td></tr>";
        $body .= "<tr><td><b>Nom</b></td><td>". $this->nom . "</td></tr>";
        $body .= "<tr><td><b>Ville</b></td><td>" . $this->ville . "</td></tr>";
        $body .= "<tr><td><b>Téléphone</b></td><td>" . $this->telephone . "</td></tr>";
        $body .= "<tr><td><b>Courriel</b></td><td>" . $this->email . "</td></tr>";
        $body .= "<tr><td><b>Marque</b></td><td>" . $this->marque . "</td></tr>";
        $body .= "<tr><td><b>Modèle</b></td><td>" . $this->modele . "</td></tr>";
        $body .= "<tr><td><b>Année</b></td><td>" . $this->annee . "</td></tr>";
        $body .= "<tr><td><b>KM</b></td><td>" . $this->km . "</td></tr>";
        $body .= "<tr><td><b>État intérieur</b></td><td>" . $this->etatExterieur . "</td></tr>";
        $body .= "<tr><td><b>État extérieur</b></td><td>" . $this->etatInterieur . "</td></tr>";
        if( $this->commentaire != "" )
            $body .= "Commentaire: " . $this->commentaire . "</td></tr>";
        $body .= "</table>";
        
        if( $file1 != '' ){
            $this->mail->addAttachment($file1temp, $file1);
        }
        if( $file2 != '' ){
            $this->mail->addAttachment($file2temp, $file2);
        }
        if( $file3 != '' ){
            $this->mail->addAttachment($file3temp, $file3);
        }
//echo $body;        
        $this->mail->Body = $body;
        $this->mail->AltBody = "-alt-";
        
    }
    
    public function loadBonTravail($TypeEmail,$Succursale,$Compagnie,$Responsable,$Telephone,$Email,$Vin, $Unite, $Km, $BonCommande,$NoteSpeciale, $Instructions, $PrixReparationsMax, $travaux1, $travaux2, $travaux3, $travaux4, $travaux5, $travaux6, $travaux7, $travaux8, $file1, $file2, $file3, $file1temp, $file2temp, $file3temp)
    {
        global $applicationConfig;
        $emailto = $toName = $subject = $body = "";

        // TODO get # for succursale et incrémenter
        switch($TypeEmail)
        {
            case TypeEmail::BonTravail: //$emailto = "philtourigny@gmail.com";
                                        $emailto = RD_Succursales::getEmailBonTravail($Succursale);
                                        //$subject = "Demande de Bon de travail";
                                        $toName  = "";
                                        break;
        }

        $noBonTravail = RD_Utils::getBonTravail($Succursale);
        //echo "bt=" . $noBonTravail;
        $subject = "Demande de Bon de travail # " . $noBonTravail . " pour " . urldecode(base64_decode($Succursale));
        
        $this->succursale = $Succursale;
        $this->compagnie = $Compagnie;
        $this->responsable = $Responsable;
        $this->email = urldecode($Email);
        $this->telephone = $Telephone;
        $this->vin = $Vin;
        $this->unite = $Unite;
        $this->km = $Km;
        $this->bonCommande = $BonCommande;
        $this->travaux1 = $travaux1;
        $this->travaux2 = $travaux2;
        $this->travaux3 = $travaux3;
        $this->travaux4 = $travaux4;
        $this->travaux5 = $travaux5;
        $this->travaux6 = $travaux6;
        $this->travaux7 = $travaux7;
        $this->travaux8 = $travaux8;
        $this->commentaire = $NoteSpeciale;
        $this->prixReparationsMax = $PrixReparationsMax;
        
        switch($Instructions)
        {
            case TypeInstructionsBonTravail::EstimeAvantDebutTravaux:         $this->instructions = "Demande d'estimé avant d'effectuer les travaux.";
                                                                              break;
            case TypeInstructionsBonTravail::ProcederMaisAppelerSiPrixExcede: $this->instructions = "Procédez, mais appelez si le prix excède : <b>$PrixReparationsMax</b> $";
                                                                              break;
            case TypeInstructionsBonTravail::PasDevaluation:                  $this->instructions = "Pas d'évaluation demandée.";
                                                                              break;
            default:break;
        }
        
        $this->mail = new PHPMailer;

        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = $applicationConfig['smtp.server.host'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $applicationConfig['smtp.server.username'];
        $this->mail->Password = $applicationConfig['smtp.server.password'];
        $this->mail->SMTPSecure = false;
        $this->mail->Port = $applicationConfig['smtp.server.port'];
        $this->mail->setFrom('mailer@reseaudynamique.com', 'reseaudynamique.com');
        $this->mail->addAddress($this->email);
        $this->mail->addReplyTo($this->email);
        $this->mail->Subject = $subject;
                
        if( strpos($emailto, ",") === false )
            $this->mail->addAddress($emailto);
        else{
            // Plusieurs adresses emial pour un client
            foreach(explode(",",$emailto) as $emailaddress){
                $this->mail->addAddress($emailaddress);
                //echo $emailaddress;
            }
        }
//        echo "emailto:" . $emailto;
        
//        echo $this->mail->Host;
//        echo $this->mail->Username;
//        echo $this->mail->Password;
//        echo $this->mail->Port;
        
        if( $file1 != '' ){
            $this->mail->addAttachment($file1temp, $file1);
        }
        if( $file2 != '' ){
            $this->mail->addAttachment($file2temp, $file2);
        }
        if( $file3 != '' ){
            $this->mail->addAttachment($file3temp, $file3);
        }
                
        // Le body spécifique
        switch($TypeEmail)
        {
            case TypeEmail::BonTravail:
//                $body = "Demande de bon de travail pour : " . $this->succursale . "<br />";
//                $body .= "Compagnie: " . $this->compagnie . "<br />";
//                $body .= "Responsable: " . $this->responsable . "<br />";
//                $body .= "Telephone: " . $this->telephone . "<br />";
//                $body .= "Courriel: " . $this->email . "<br />";
//                $body .= "VIN: " . $this->vin . "<br />";
//                $body .= "Unité: " . $this->unite . "<br />";
//                $body .= "KM: " . $this->km . "<br />";
//                $body .= "Bon de commande: " . $this->bonCommande . "<br />";
//                $body .= "Travaux à faire : " . $this->travaux . "<br />";
//                $body .= "Note spéciale: " . $this->commentaire . "<br />";
//                $body .= "Instructions: " . $this->instructions . "<br />";
                $body = '<p class="MsoNormal"><img src="http://www.reseaudynamique.com/_assets/images/logoReseauDynamique.png" width="249" height="69" border="0" alt="Logo" title="Logo" style="display:block"></p>
                        <div><h1>Demande de bon de travail</span></h1></div>
                        <p><strong><span lang="FR-CA">Demande # :</span></strong><span lang="FR-CA">&nbsp;' . $noBonTravail . '</span></p>
                        <p><strong><span lang="FR-CA">Date :</span></strong><span lang="FR-CA">&nbsp;' . date("Y-m-d H:i:s") . '</span></p>
                        <table class="m_272356984177441604MsoNormalTable" cellspacing="3" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>Client :</strong></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">' . $this->compagnie . '</p>
                                    </td>
                                    <td style="width:18.75pt;padding:.75pt .75pt .75pt .75pt" width="25">
                                        <p class="MsoNormal">&nbsp;</p></td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>VIN :</strong></p></td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">' . $this->vin . '</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>Nom du responsable :</strong></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">' . $this->responsable . '</p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">&nbsp;</p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>Unité # :</strong></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">' . $this->unite . '</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>Téléphone :</strong></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">' . $this->telephone . '</p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">&nbsp;</p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>Kilométrage :</strong></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">' . $this->km . '</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>Courriel :</strong></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><a href="mailto:' . $this->email . '" target="_blank">' . $this->email . '</a></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">&nbsp;</p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal"><strong>Bon de commande :</strong></p>
                                    </td>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                        <p class="MsoNormal">' . $this->bonCommande . '</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p>
                            <strong><span lang="FR-CA">Description des travaux :</span></strong>
                        </p>
                        <table class="m_272356984177441604MsoNormalTable" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#1&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux1 .'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#2&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux2 .'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#3&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux3 .'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#4&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux4 .'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#5&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux5 .'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#6&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux6 .'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#7&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux7 .'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">Travaux&nbsp;#8&nbsp;:</p>
                                </td>
                                <td style="padding:0cm 0cm 0cm 0cm" valign="top">
                                    <p class="MsoNormal">'. $this->travaux8 .'</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p><strong><span lang="FR-CA">Note spéciale : ' . $this->commentaire . '</span></strong><span lang="FR-CA"></span></p>
                        <p><strong><span lang="FR-CA">Autorisation :</span></strong><span lang="FR-CA">&nbsp;Oui</span></p>
                        <p><span lang="FR-CA">J\'autorise par ceci le travail de réparation ci-dessus à être effectué avec les matériaux nécessaires. Vous ne serez pas jugé responsable de la perte ou des dommages au véhicule, ou aux articles laissés dans le véhicule, en cas de feu,
                         de vol, d\'accident ou de toute autre cause indépendante de votre volonté. J\'autorise par ceci vous et vos employés à opérer le véhicule ci-dessus décrit à des fin d\'essais routier et ou d\'inspections. Je reconnais que vous avez un lien légal sur le véhicule
                         pour recouvrir la valeur des travaux encourue sur le véhicule. </p>
                        <strong>Par :&nbsp;'. $this->responsable .'</strong>&nbsp;</span></p>
                        <p><strong><span lang="FR-CA">Instruction :</span></strong><span lang="FR-CA">&nbsp;' . $this->instructions . '&nbsp;</span></p>
                        </div>
                        </div>';
                break;
            default:break;
        }
        
        //print_r($this->mail);
        $this->mail->Body = $body;
        $this->mail->AltBody = "-alt-";
    }
    
    public function loadDemandePieces($TypeEmail,$Succursale,$Compagnie,$Responsable,$PiecesRequises,$Email,$Telephone,$Description)
    {
        global $applicationConfig;
        $emailto = $toName = $subject = $body = "";
        
        switch($TypeEmail)
        {
            case TypeEmail::DemandePieces: 
                                           // Cuidado vrai emails de gens dans la fonction: 
                                           $emailto = RD_Succursales::getEmailDemandePieces($Succursale);
                                           $subject = "Demande de pièces";
                                           $toName  = "";
                                           break;
        }
        
        $this->succursale = urldecode(base64_decode($Succursale));
        $this->compagnie = $Compagnie;
        $this->responsable = $Responsable;
        $this->email = urldecode($Email);
        $this->telephone = $Telephone;
        $this->pieces = $PiecesRequises;
        $this->description = $Description;
        
        $this->mail = new PHPMailer;

        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = $applicationConfig['smtp.server.host'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $applicationConfig['smtp.server.username'];
        $this->mail->Password = $applicationConfig['smtp.server.password'];
        $this->mail->SMTPSecure = false;
        $this->mail->Port = $applicationConfig['smtp.server.port'];
        $this->mail->setFrom('mailer@reseaudynamique.com', 'reseaudynamique.com');
        $this->mail->addReplyTo($this->email);
        $this->mail->Subject = $subject;
        
        if( strpos($emailto, ",") === false )
            $this->mail->addAddress($emailto);
        else{
            // Plusieurs adresses emial pour un client
            foreach(explode(",",$emailto) as $emailaddress)
                $this->mail->addAddress($emailaddress);
        }
                
        // Le body spécifique
        switch($TypeEmail)
        {
            case TypeEmail::DemandePieces:
                $body = "Demande de pièces pour : " . $this->succursale . "<br />";
                $body .= "Compagnie: " . $this->compagnie . "<br />";                     // On passe la compagnie dans le prenom
                $body .= "Responsable: " . $this->responsable . "<br />";
                $body .= "Telephone: " . $this->telephone . "<br />";
                $body .= "Courriel: " . $this->email . "<br />";
                $body .= "Pièces: " . $this->pieces . "<br />";                           // On passe les pièces dans le nom
                if( $this->description != "" )
                    $body .= "Description: " . $this->description . "<br /><br />";
                break;
            default:break;
        }
        
        $this->mail->Body = $body;
        $this->mail->AltBody = "-alt-";
    }   
    
    public function loadPostulerEmploi($TypeEmail,$emploi,$Nom,$Prenom,$Ville,$Telephone,$Email,$Commentaire,$FileCVPrettyName,$FilePresPrettyName,$CVFile,$PresFile)
    {
        global $applicationConfig;
        $emailto = $toName = $subject = $body = "";
        $bodyHeader = "";
        
        // id = -1 quand c'est une candidature spontanée
        if($emploi->id != -1 ){
            $emailto = $emploi->succursaleObj->emailOffreEmploi;
            $toName  = "";
            $subject = "Réponse pour l'offre d'emploi: " .$emploi->titre . " - [ " . $emploi->referenceInterne . " ] - " . $emploi->succursaleObj->ville;
            $bodyHeader = '<h1>Candidature pour le poste de <a name="hyperlien" href="'.                    
                            RD_PageLink::getHref(folder::EXTERNAL,page::EXTERNAL_OffreEmploi) . '?emp=' . $emploi->lienEncode .'">'. $emploi->titre .'</a></h1>';
        }
        else{
            $emailto = "rh@camionbeaudoin.com";
            $toName  = "";
            $subject = "Candidature spontanée provenant de www.reseaudynamique.com";
            $bodyHeader = '<h1>Candidature spontanée</h1>';
        }
        
        $this->email = urldecode($Email);
        
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = $applicationConfig['smtp.server.host'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $applicationConfig['smtp.server.username'];
        $this->mail->Password = $applicationConfig['smtp.server.password'];
        $this->mail->SMTPSecure = false;
        $this->mail->Port = $applicationConfig['smtp.server.port'];
        $this->mail->setFrom('mailer@reseaudynamique.com', 'reseaudynamique.com');
        $this->mail->addAddress($emailto, $toName);        
        $this->mail->addReplyTo($this->email);
        $this->mail->Subject = $subject;
        
        if( $CVFile != '' ){
            $this->mail->addAttachment($CVFile, $FileCVPrettyName);
        }
        if( $PresFile != '' ){
            $this->mail->addAttachment($PresFile, $FilePresPrettyName);
        }

        $body = $bodyHeader . '<p><strong><span>Nom :</span></strong>&nbsp;' . $Nom . '</p>
                               <p><strong><span>Prénom :</span></strong>&nbsp;' . $Prenom . '</p>
                               <p><strong><span>Ville :</span></strong>&nbsp;' . $Ville . '</p>
                               <p><strong><span>Courriel :</span></strong>&nbsp;' . $Email . '</p>
                               <p><strong><span>Téléphone :</span></strong>&nbsp;' . $Telephone . '</p>
                               <p><strong><span>Info candidat(e) :</span></strong>&nbsp;' . $Commentaire . '</p>';

        $this->mail->Body = $body;
        $this->mail->AltBody = "-alt-";
    }
    
    public function send()
    {
        return $this->mail->send();
    }
}
