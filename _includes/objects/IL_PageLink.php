<?PHP
interface folder
{
    const Root = 1;
    const CamionsNeufs = 2;
    const Nextpart = 3;
    const NousJoindre = 4;
    const PiecesService = 5;
    const PromotionsNouvelles = 6;
    const RemorquesNeuves = 7;
    const Service = 8;
    const VehiculesUtilitaires = 9;
    const EXTERNAL = 10;
}

interface page
{
    const Accueil = 1;
    const LocationsDeCamions = 2;
    const Apropos = 3;
    const UrgenceRoutiere24H = 4;
    const MentionsLegales = 5;
    const DemandePieces = 6;
    const BonDeTravail = 7;
    const Fournisseurs = 8;
    const PlanSite = 9;
    const DemandeInformation = 10;
    const PlanifierEssaiRoutier = 11;
    const ObtenirPrix = 12;
    const DemandeFinancement = 13;
    const EvaluerEchange = 14;
    const NousJoindre = 15;
    const Details_New = 16;
    const Details_Used = 17;
    const Carrieres = 18;
    const Postuler = 19;
    
    const CamionsInventaireComplet = 100;
    const CamionsInternational = 101;
    const CamionsOttawaKalmar = 102;
    const CamionsIsuzu = 103;
    const CamionsOccasion = 104;
    const RemorqesNeuvesInventaireComplet = 105;
    const RemorquesDiMond = 106;
    const RemorquesDoepker = 107;
    
    const VehiculesUtilitairesMiniExcavatrices = 200;
    const VehiculesUtilitairesTransporteursToutTerrain = 201;
    const VehiculesUtilitairesSkidSteerEtChargeurAChenilles = 202;
    const VehiculesUtilitairesChargeuseV3EtV4 = 203;
    
    const PiecesEtServicesPiecesEtAsccessoires = 300;
    const PiecesEtServicesServiceRoutier = 301;
    const PiecesEtServicesServiceApresVente = 302;
    const PiecesEtServicesFinancement = 303;
    const PiecesEtServicesPromoPieces = 304;
        
    const NousJoindreCamionsInterLanaudiere = 401;
    const NousJoindreCamionsInterAnjou = 402;
    const NousJoindreInterBoucherville = 403;
    const NousJoindreLesCamionsBeaudoin = 404;
    const NousJoindreCentreduCamionBeaudoin = 405;
    const NousJoindreCharestInternational = 406;
    const NousJoindreGarageCharestetFreres = 407;
    const NousJoindreLeCentreduCamionAmiante = 408;
    const NousJoindreLeCentreduCamionBeauce = 409;
    const NousJoindreLeCentreRoutier1994 = 410;
    const NousJoindreCamionsInternationalElite = 411;
    const NousJoindreGarageRobert = 412;
    const NousJoindreCamionsIsuzu = 413;    
    
    const PromotionsEtNouvellesPromotions = 500;
    const PromotionsEtNouvellesNouvelles = 501;
    const PromotionsEtNouvellesConcours = 502;
    const PromotionsEtNouvellesPromoPieces = 503;
        
    const InscriptionNextPart = 600;
    const InscriptionNextPartAbonnement = 601;
    
    const EXTERNAL_nextPartLogin = 700;
    const EXTERNAL_nextPart = 701;
    const EXTERNAL_fleetrite = 702;
    const EXTERNAL_detailsNEW = 703;
    const EXTERNAL_detailsUSED = 704;
    const EXTERNAL_boutiqueEnLigne = 705;
    const EXTERNAL_DiMond = 706;
    const EXTERNAL_Doepker = 707;
    const EXTERNAL_OffreEmploi = 708;
    const EXTERNAL_INTERNATIONAL = 709;
}

class IL_PageLink
{
    private $_page = "";
    private $_folder = "";
    private $_wholeURL = false;
        
    //public static function getLink(folder $folder, page $page)
    public static function getHref($folder, $page)
    {
        $_wholeURL = false;
        
        switch($folder){
            case folder::CamionsNeufs:$_folder = "/camions-neufs/";break;
            case folder::Nextpart:$_folder = "/nextpart/";break;
            case folder::NousJoindre:$_folder = "/nous-joindre/";break;
            case folder::PiecesService:$_folder = "/pieces-services/";break;
            case folder::PromotionsNouvelles:$_folder = "/promotions-nouvelles/";break;
            case folder::RemorquesNeuves:$_folder = "/remorques-neuves/";break;            
            case folder::Service:$_folder = "/service/";break;
            case folder::VehiculesUtilitaires:$_folder = "/vehicules-utilitaires/";break;
            case folder::Root:$_folder = "/";break;
            case folder::EXTERNAL:$_folder = "";break;
            default:$_folder = "";break;
        }
        
        switch($page){
            case page::Accueil:$_page="accueil";break;
            case page::CamionsInventaireComplet:$_page = "inventaire-camion-neufs";break;
            case page::CamionsInternational:$_page = "camions-lourds-neufs-international";break;
            case page::CamionsOttawaKalmar:$_page = "ottawa-kalmar";break;
            case page::CamionsIsuzu:$_page = "isuzu";break;
            case page::CamionsOccasion:$_page = "camions-occasion";break;
            case page::RemorqesNeuvesInventaireComplet:$_page = "inventaire-remorques";break;
            case page::RemorquesDiMond:$_page = "remorques-di-mond";break;
            case page::RemorquesDoepker:$_page = "remorques-doepker";break;
            case page::VehiculesUtilitairesMiniExcavatrices:$_page = "mini-excavatrices";break;
            case page::VehiculesUtilitairesTransporteursToutTerrain:$_page = "transporteurs-tout-terrain";break;
            case page::VehiculesUtilitairesSkidSteerEtChargeurAChenilles:$_page = "skid-steer-chargeur-chenilles";break;
            case page::VehiculesUtilitairesChargeuseV3EtV4:$_page = "chargeuses-yanmar-v3-v4";break;
            case page::LocationsDeCamions:$_page = "location-camions";break;
            case page::PiecesEtServicesPiecesEtAsccessoires:$_page = "pieces-accessoires";break;
            case page::PiecesEtServicesServiceRoutier:$_page = "service-routier";break;
            case page::PiecesEtServicesServiceApresVente:$_page = "apres-vente";break;
            case page::PiecesEtServicesFinancement:$_page = "financement";break;
            case page::PiecesEtServicesPromoPieces:$_page = "promo-pieces";break;
            case page::NousJoindre:$_page = "nous-joindre";break;
            case page::NousJoindreCamionsInterLanaudiere:$_page = "inter-lanaudiere";break;
            case page::NousJoindreCamionsInterAnjou:$_page = "camions-inter-anjou";break;
            case page::NousJoindreInterBoucherville:$_page = "inter-boucherville";break;
            case page::NousJoindreLesCamionsBeaudoin:$_page = "les-camions-beaudoin";break;
            case page::NousJoindreCentreduCamionBeaudoin:$_page = "centre-camion-beaudoin";break;
            case page::NousJoindreCharestInternational:$_page = "charest-international";break;
            case page::NousJoindreGarageCharestetFreres:$_page = "garage-charest-freres";break;
            case page::NousJoindreLeCentreduCamionAmiante:$_page = "le-centre-camion-amiante";break;
            case page::NousJoindreLeCentreduCamionBeauce:$_page = "le-centre-camion-beauce";break;
            case page::NousJoindreLeCentreRoutier1994:$_page = "centre-routier-1994";break;
            case page::NousJoindreCamionsInternationalElite:$_page = "camions-international-elite";break;
            case page::NousJoindreGarageRobert:$_page = "garage-robert";break;
            case page::NousJoindreCamionsIsuzu:$_page = "camions-isuzu";break;
            case page::Apropos:$_page = "a-propos";break;
            case page::PromotionsEtNouvellesPromotions:$_page = "promotions";break;
            case page::PromotionsEtNouvellesNouvelles:$_page = "nouvelles";break;
            case page::PromotionsEtNouvellesConcours:$_page = "concours";break;
            case page::PromotionsEtNouvellesPromoPieces:$_page = "promo-pieces";break;
            case page::UrgenceRoutiere24H:$_page = "urgence-routiere-24h";break;
            case page::InscriptionNextPart:$_page = "abonnement-nextpart";break;
            case page::InscriptionNextPartAbonnement:$_page = "confirmation-abonnement";break;
            case page::MentionsLegales:$_page = "mentions-legales";break;
            case page::DemandePieces:$_page = "demande-pieces";break;
            case page::BonDeTravail:$_page = "demande-bon-travail";break;
            case page::Fournisseurs:$_page = "fournisseurs";break;
            case page::PlanSite:$_page = "plan-site";break;            
            case page::DemandeInformation: $_page = "demande-information";break;
            case page::PlanifierEssaiRoutier: $_page = "planifier-essai-routier";break;
            case page::ObtenirPrix: $_page = "obtenir-prix";break;
            case page::DemandeFinancement: $_page = "demande-financement";break;
            case page::EvaluerEchange: $_page = "evaluer-echange";break;
            case page::Details_New: $_page = "details_new";break;
            case page::Details_Used: $_page = "details_used";break;
            case page::Carrieres: $_page = "carrieres";break;
            case page::Postuler: $_page = "postuler";break;            
                
            case page::EXTERNAL_nextPartLogin: $_page = "http://www.nexpart.com/login.php";$_wholeURL = true;break;
            case page::EXTERNAL_fleetrite: $_page = "http://www.fleetrite.com";$_wholeURL = true;break;
            case page::EXTERNAL_detailsNEW: $_page = "http://reseaudynamique.com/details_new.php";$_wholeURL = true;break;
            case page::EXTERNAL_detailsUSED: $_page = "http://reseaudynamique.com/details_used.php";$_wholeURL = true;break;
            case page::EXTERNAL_boutiqueEnLigne: $_page = "https://reseaudynamique.gxd.ca/";$_wholeURL = true;break;
            case page::EXTERNAL_DiMond: $_page = "http://www.di-mond.com/index2.html";$_wholeURL = true;break;
            case page::EXTERNAL_Doepker: $_page = "http://www.doepker.com/";$_wholeURL = true;break;
            case page::EXTERNAL_OffreEmploi: $_page = "http://reseaudynamique.com/carrieres.php";$_wholeURL = true;break;
            case page::EXTERNAL_INTERNATIONAL: $_page = "http://ca.internationaltrucks.com/";$_wholeURL = true;break;
            default: $_page = "accueil";break;
            //case page:: $_page = "";break;
        }

        return $_wholeURL ? $_page : $_folder . $_page . ".php";
    }
}

class IL_Header{
     /*
     * public static function getMetaContent($pageName)
     */  
    public static function getMetaContent($pageName)
    {   
        $metaContent = "";
        switch($pageName){
            case "login.php":$metaContent = "Inter-Livraison - LOGIN";break;
            case "accueil.php":$metaContent = "Réseau Dynamique est concessionnaire panquébécois de camions International et détaillant de camions et véhicules routiers Ottawa Kalmar, Isuzu et Yanmar.";break;
            case "promotions.php":$metaContent = "Profitez de promotions avantageuses à l&#39;achat d&#39;un ou plusieurs camions lourds International chez votre concessionnaire Réseau Dynamique.";break;
            case "nous-joindre.php":$metaContent = "Trouvez les coordonnées des succursales Réseau Dynamique au Québec.";break;
            case "urgence-routiere-24h.php":$metaContent = "Pour toute urgence sur la route, contactez la succursale la plus près de votre emplacement et profitez d&#39;une assistance routière ou un remorquage 24 h.";break;
            case "camions-lourds-neufs-international.php":$metaContent = "Trouvez un grand inventaire de camions lourds International neufs dans les divisions de Réseau Dynamique. Plus de 11 concessionnaires partout au Québec.";break;
            case "inventaire-camion-neufs.php":$metaContent = "Réseau Dynamique possède une grande flotte de camions neufs International, Ottawa Kalmar et Isuzu. Consultez notre inventaire en ligne pour voir nos modèles.";break;
            case "isuzu.php":$metaContent = "Présents à travers le Québec, les concessionnaires de Réseau Dynamique sont dépositaires de la gamme complète de camions Isuzu.";break;
            case "ottawa-kalmar.php.php":$metaContent = "Trouvez un grand inventaire de camions Ottawa Kalmar neufs dans les divisions de Réseau Dynamique. Plus de 11 concessionnaires présents partout au Québec.";break;
            case "les-camions-beaudoin.php":$metaContent = "Rendez-vous à la succursale Les Camions Beaudoin pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "inter-lanaudiere.php":$metaContent = "Rendez-vous à la succursale Inter-Lanaudière pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "camions-inter-anjou.php":$metaContent = "Inter-Anjou à Anjou offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "inter-boucherville.php":$metaContent = "Rendez-vous à la succursale Inter-Boucherville pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "centre-camion-beaudoin.php":$metaContent = "Rendez-vous à la succursale Centre du Camion Beaudoin ou pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "charest-international.php":$metaContent = "Rendez-vous à la succursale Charest International pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "garage-charest-freres.php":$metaContent = "Garage Charest et Frères à Trois-Rivières offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "le-centre-camion-amiante.php":$metaContent = "Le Centre du Camion à Thetford Mines offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "le-centre-camion-beauce.php":$metaContent = "Le Centre du Camion de St-Georges offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "centre-routier-1994.php":$metaContent = "Le Centre Routier 1994 à Rivière-du-Loup offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "camions-international-elite.php":$metaContent = "Camions International Élite à Québec offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "garage-robert.php":$metaContent = "Rendez-vous à la succursale Les Camions Beaudoin pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "camions-isuzu.php":$metaContent = "";break;
            case "confirmation-abonnement.php":$metaContent = "Merci de vous être abonné à NextPart. Nous espérons que votre expérience avec Réseau Dynamique en soit bonifiée!";break;
            case "abonnement-nextpart.php":$metaContent="Inscrivez-vous au service NextPart.";break;
            case "service-routier.php":$metaContent = "Économisez temps et coûts de remorquage grâce au service routier pour camions lourds de Réseau Dynamique. Service disponible partout au Québec.";break;
            case "pieces-accessoires.php":$metaContent = "Réseau Dynamique offre un large inventaire de pièces et accessoires pour les camions de toutes tailles et de toutes marques.";break;
            case "financement.php":$metaContent = "Pour un camion neuf ou d&#39;occasion ou encore un lot de camions, vous trouverez satisfaction parmi notre gamme de produits de financement concurrentiels.";break;
            case "apres-vente.php":$metaContent = "Profitez d&#39;un service après-vente incomparable sur votre camion lourd avec Réseau Dynamique grâce à un réseau composé de 19 points de service au Québec.";break;
            case "promotions.php":$metaContent = "Profitez de promotions avantageuses à l&#39;achat d&#39;un ou plusieurs camions lourds International chez votre concessionnaire Réseau Dynamique.";break;
            //case "promo-pieces.php":$metaContent = "";break;
            case "nouvelles.php":$metaContent = "Consultez les nouvelles et découvrez les événements à venir du Réseau Dynamique.";break;
            //case "concours.php":$metaContent = "";break;
            case "remorques-doepker.php":$metaContent = "Découvrez nos modèles haute performance de remorques agricoles, ponts plats, remorques-citernes, remorques pour bois d&#39;oeuvre et remorques à gravier Doepker.";break;
            case "remorques-di-mond.php":$metaContent = "";break;
            case "inventaire-remorques.php":$metaContent = "Réseau Dynamique possède une grande flotte de remorques et ponts plats. Consultez notre inventaire en ligne pour voir nos modèles.";break;
            case "transporteurs-tout-terrain.php":$metaContent = "Offrez-vous des performances supérieures et respectez l&#39;environnement avec les transporteurs tout-terrain de Yanmar. Découvrez les modèles maintenant!";break;
            case "skid-steer-chargeur-chenilles.php":$metaContent = "Découvrez la polyvalence et la puissance des Skeed Steer et chargeur à Chenilles Yanmar disponibles chez Réseau Dynamique dès maintenant!";break;
            case "mini-excavatrices.php":$metaContent = "Les mini-excavatrices de Yanmar sont synonymes de puissance, durabilité et efficacité. Retrouvez-les chez votre dépositaire Réseau Dynamique dès maintenant.";break;
            case "chargeuses-yanmar-v3-v4.php":$metaContent = "Découvrez dès maintenant les avantages des chargeuses V3 et V4 de Yanmar, les véhicules utilitaires idéaux pour vos travaux extérieurs et intérieurs.";break;
            case "fournisseurs.php":$metaContent = "Le Réseau Dynamique est le plus important réseau de concessionnaires International au Québec. Plus de 19 points de service répartis sur le territoire québécois.";break;
            case "plan-site.php":$metaContent = "Consultez le plan du site pour en savoir plus sur les produits et services de Réseau Dynamique.";break;
            case "mentions-legales.php":$metaContent = "Pour toute information d’ordre légal concernant le site Web de Réseau Dynamique, consultez les mentions légales.";break;
            case "location-camions.php":$metaContent = "Réseau Dynamique offre un service de location de camions lourds International et Ottawa Kalmar, neufs et usagés louables à court ou à long terme.";break;
            case "demande-pieces.php":$metaContent = "";break;
            case "demande-bon-travail.php":$metaContent = "";break;
            case "camions-occasion.php":$metaContent = "Trouvez un grand inventaire de camions lourds d&#39;occasion dans les divisions de Réseau Dynamique. Plus de 11 concessionnaires présents partout au Québec.";break;
            //case "demande-information.php":$title = "";break;
            //case "planifier-essai-routier.php":$title = "";break;
            //case "obtenir-prix.php":$title = "";break;
            //case "demande-financement.php":$title = "";break;
            //case "evaluer-echange.php":$title = "";break;
            //case "":$metaContent = "";
            default:"Le Réseau Dynamique est le plus important réseau de concessionnaires International au Québec. Plus de 19 points de service répartis sur le territoire québécois.";break;
        }
        
        echo $metaContent == "" ? "Réseau Dynamique est concessionnaire panquébécois de camions International et détaillant de camions et véhicules routiers Ottawa Kalmar, Isuzu et Yanmar." : $metaContent;
    }
    
    public static function getPageMetaForSearch($pageName)
    {   
        $metaContent = "";
        switch($pageName){
            case "a-propos.php":$metaContent = "Le Réseau Dynamique est le plus important réseau de concessionnaires International au Québec. Plus de 19 points de service répartis sur le territoire québécois.";break;
            case "accueil.php":$metaContent = "Réseau Dynamique est concessionnaire panquébécois de camions International et détaillant de camions et véhicules routiers Ottawa Kalmar, Isuzu et Yanmar.";break;
            case "promotions.php":$metaContent = "Profitez de promotions avantageuses à l&#39;achat d&#39;un ou plusieurs camions lourds International chez votre concessionnaire Réseau Dynamique.";break;
            case "nous-joindre.php":$metaContent = "Trouvez les coordonnées des succursales Réseau Dynamique au Québec.";break;
            case "urgence-routiere-24h.php":$metaContent = "Pour toute urgence sur la route, contactez la succursale la plus près de votre emplacement et profitez d&#39;une assistance routière ou un remorquage 24 h.";break;
            case "camions-lourds-neufs-international.php":$metaContent = "Trouvez un grand inventaire de camions lourds International neufs dans les divisions de Réseau Dynamique. Plus de 11 concessionnaires partout au Québec.";break;
            case "inventaire-camion-neufs.php":$metaContent = "Réseau Dynamique possède une grande flotte de camions neufs International, Ottawa Kalmar et Isuzu. Consultez notre inventaire en ligne pour voir nos modèles.";break;
            case "isuzu.php":$metaContent = "Présents à travers le Québec, les concessionnaires de Réseau Dynamique sont dépositaires de la gamme complète de camions Isuzu.";break;
            case "ottawa-kalmar.php.php":$metaContent = "Trouvez un grand inventaire de camions Ottawa Kalmar neufs dans les divisions de Réseau Dynamique. Plus de 11 concessionnaires présents partout au Québec.";break;
            case "les-camions-beaudoin.php":$metaContent = "Rendez-vous à la succursale Les Camions Beaudoin pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "inter-lanaudiere.php":$metaContent = "Rendez-vous à la succursale Inter-Lanaudière pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "camions-inter-anjou.php":$metaContent = "Inter-Anjou à Anjou offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "inter-boucherville.php":$metaContent = "Rendez-vous à la succursale Inter-Boucherville pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "centre-camion-beaudoin.php":$metaContent = "Rendez-vous à la succursale Centre du Camion Beaudoin ou pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "charest-international.php":$metaContent = "Rendez-vous à la succursale Charest International pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "garage-charest-freres.php":$metaContent = "Garage Charest et Frères à Trois-Rivières offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "le-centre-camion-amiante.php":$metaContent = "Le Centre du Camion à Thetford Mines offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "le-centre-camion-beauce.php":$metaContent = "Le Centre du Camion de St-Georges offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "centre-routier-1994.php":$metaContent = "Le Centre Routier 1994 à Rivière-du-Loup offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "camions-international-elite.php":$metaContent = "Camions International Élite à Québec offre un vaste choix de camions International en plus d&#39;offrir l&#39;entretien et la réparation de votre camion lourd.";break;
            case "garage-robert.php":$metaContent = "Rendez-vous à la succursale Les Camions Beaudoin pour un vaste choix de camions International et l&#39;entretien ou la réparation de votre camion lourd.";break;
            case "camions-isuzu.php":$metaContent = "";break;
            case "confirmation-abonnement.php":$metaContent = "Merci de vous être abonné à NextPart. Nous espérons que votre expérience avec Réseau Dynamique en soit bonifiée!";break;
            case "abonnement-nextpart.php":$metaContent="Inscrivez-vous au service NextPart.";break;
            case "service-routier.php":$metaContent = "Économisez temps et coûts de remorquage grâce au service routier pour camions lourds de Réseau Dynamique. Service disponible partout au Québec.";break;
            case "pieces-accessoires.php":$metaContent = "Réseau Dynamique offre un large inventaire de pièces et accessoires pour les camions de toutes tailles et de toutes marques.";break;
            case "financement.php":$metaContent = "Pour un camion neuf ou d&#39;occasion ou encore un lot de camions, vous trouverez satisfaction parmi notre gamme de produits de financement concurrentiels.";break;
            case "apres-vente.php":$metaContent = "Profitez d&#39;un service après-vente incomparable sur votre camion lourd avec Réseau Dynamique grâce à un réseau composé de 19 points de service au Québec.";break;
            case "promotions.php":$metaContent = "Profitez de promotions avantageuses à l&#39;achat d&#39;un ou plusieurs camions lourds International chez votre concessionnaire Réseau Dynamique.";break;
            //case "promo-pieces.php":$metaContent = "";break;
            case "nouvelles.php":$metaContent = "Consultez les nouvelles et découvrez les événements à venir du Réseau Dynamique.";break;
            //case "concours.php":$metaContent = "";break;
            case "remorques-doepker.php":$metaContent = "Découvrez nos modèles haute performance de remorques agricoles, ponts plats, remorques-citernes, remorques pour bois d&#39;oeuvre et remorques à gravier Doepker.";break;
            case "remorques-di-mond.php":$metaContent = "";break;
            case "inventaire-remorques.php":$metaContent = "Réseau Dynamique possède une grande flotte de remorques et ponts plats. Consultez notre inventaire en ligne pour voir nos modèles.";break;
            case "transporteurs-tout-terrain.php":$metaContent = "Offrez-vous des performances supérieures et respectez l&#39;environnement avec les transporteurs tout-terrain de Yanmar. Découvrez les modèles maintenant!";break;
            case "skid-steer-chargeur-chenilles.php":$metaContent = "Découvrez la polyvalence et la puissance des Skeed Steer et chargeur à Chenilles Yanmar disponibles chez Réseau Dynamique dès maintenant!";break;
            case "mini-excavatrices.php":$metaContent = "Les mini-excavatrices de Yanmar sont synonymes de puissance, durabilité et efficacité. Retrouvez-les chez votre dépositaire Réseau Dynamique dès maintenant.";break;
            case "chargeuses-yanmar-v3-v4.php":$metaContent = "Découvrez dès maintenant les avantages des chargeuses V3 et V4 de Yanmar, les véhicules utilitaires idéaux pour vos travaux extérieurs et intérieurs.";break;
            case "fournisseurs.php":$metaContent = "Le Réseau Dynamique est le plus important réseau de concessionnaires International au Québec. Plus de 19 points de service répartis sur le territoire québécois.";break;
            case "plan-site.php":$metaContent = "Consultez le plan du site pour en savoir plus sur les produits et services de Réseau Dynamique.";break;
            case "mentions-legales.php":$metaContent = "Pour toute information d’ordre légal concernant le site Web de Réseau Dynamique, consultez les mentions légales.";break;
            case "location-camions.php":$metaContent = "Réseau Dynamique offre un service de location de camions lourds International et Ottawa Kalmar, neufs et usagés louables à court ou à long terme.";break;
            case "demande-pieces.php":$metaContent = "";break;
            case "demande-bon-travail.php":$metaContent = "";break;
            case "camions-occasion.php":$metaContent = "Trouvez un grand inventaire de camions lourds d&#39;occasion dans les divisions de Réseau Dynamique. Plus de 11 concessionnaires présents partout au Québec.";break;
            //case "demande-information.php":$title = "";break;
            //case "planifier-essai-routier.php":$title = "";break;
            //case "obtenir-prix.php":$title = "";break;
            //case "demande-financement.php":$title = "";break;
            //case "evaluer-echange.php":$title = "";break;
            //case "":$metaContent = "";
            default:"Le Réseau Dynamique est le plus important réseau de concessionnaires International au Québec. Plus de 19 points de service répartis sur le territoire québécois.";break;
        }
        
        return $metaContent == "" ? "Réseau Dynamique est concessionnaire panquébécois de camions International et détaillant de camions et véhicules routiers Ottawa Kalmar, Isuzu et Yanmar." : $metaContent;
    }
    
    /*
     * public static function getPageTitle($pageName)
     */    
    public static function getPageTitle($pageName)
    {   
        $title = "";
        
        switch($pageName){
            case "a-propos.php":$title = "À Propos Réseau Camion International | Réseau Dynamique";break;
            case "accueil.php":$title = "";break;
            case "nous-joindre.php":$title = "Nous joindre | Réseau Dynamique";break;
            case "urgence-routiere-24h.php":$title = "Urgence Routière 24 h Camions Lourds Canada et États-Unis";break;
            case "camions-lourds-neufs-international.php":$title = "Camions Neufs International | Réseau Dynamqiue";break;
            case "inventaire-camion-neufs.php":$title = "Camion neufs | Réseau Dynamique";break;
            case "isuzu.php":$title = "Camions Neufs Isuzu | Réseau Dynamique";break;
            case "ottawa-kalmar.php.php":$title = "Camions Lourds Neufs Ottawa Kalmar | Réseau Dynamique";break;
            case "les-camions-beaudoin.php":$title = "Camions International Saint-Hyacinthe | Les Camions Beaudoin";break;
            case "inter-lanaudiere.php":$title = "Camions International Joliette | Inter-Launaudiere";break;
            case "camions-inter-anjou.php":$title = "Camions International Anjou | Inter-Anjou";break;
            case "inter-boucherville.php":$title = "Camions International Boucherville | Inter-Boucherville";break;
            case "centre-camion-beaudoin.php":$title = "Camions International Drummondville | Centre du Camion Beaudoin";break;
            case "charest-international.php":$title = "Camions International Victoriaville | Charest International";break;
            case "garage-charest-freres.php":$title = "Camions International Trois-Rivières | Garage Charest et Frères";break;
            case "le-centre-camion-amiante.php":$title = "Camions International Thetford Mines | Le Centre du camion";break;
            case "le-centre-camion-beauce.php":$title = "Camions International St-Georges | Le Centre du Camion";break;
            case "centre-routier-1994.php":$title = "Camions International Rivière-du-Loup | Centre Routier 1994";break;
            case "camions-international-elite.php":$title ="Camions International Québec | Camions International Élite";break; 
            case "garage-robert.php":$title = "Garage Robert Shawinigan | Réseau Dynamique";break;
            case "camions-isuzu.php":$title = "Camions Isuzu";break;
            case "confirmation-abonnement.php":$title = "";break;
            case "abonnement-nextpart.php":$title = "Inscription à NextPart | Réseau Dynamique";break;
            case "service-routier.php":$title = "Service Routier Mécanique Camion Lourd | Réseau Dynamique";break;
            case "pieces-accessoires.php":$title = "Pièces et Accessoires pour Camions | Réseau Dynamique";break;
            case "financement.php":$title = "Financement Camions Lourds Neufs & Usagés | Réseau Dynamique";break;
            case "apres-vente.php":$title = "Service Après-Vente Camions Lourds | Réseau Dynamique";break;
            case "promotions.php":$title = "Promotions sur Camions Lourds | Réseau Dynamique";break;
            case "promo-pieces.php":$title = "Promo pièces | Réseau Dynamique";break;
            case "nouvelles.php":$title = "Nouvelles et Événements | Réseau Dynamique";break;
            case "concours.php":$title = "Concours | Réseau Dynamique";break;
            case "remorques-doepker.php":$title = "Remorques Doepker | Réseau Dynamique";break;
            case "remorques-di-mond.php":$title = "Remorques Di-Mond | Réseau Dynamique";break;
            case "inventaire-remorques.php":$title = "Inventaire complet de remorques | Réseau Dynamique";break;
            case "transporteurs-tout-terrain.php":$title = "Transporteurs Tout Terrain Yanmar | Réseau Dynamique";break;
            case "skid-steer-chargeur-chenilles.php":$title = "Skeed Steer & Chargeur à Chenilles Yanmar | Réseau Dynamique";break;
            case "mini-excavatrices.php":$title = "Mini-Excavatrices Yanmar | Réseau Dynamique";break;
            case "chargeuses-yanmar-v3-v4.php":$title = "Chargeuses Yanmar V3 et V4 | Réseau Dynamique";break;
            case "fournisseurs.php":$title = "Fournisseurs | Réseau Dynamique";break;
            case "plan-site.php":$title = "Plan du site | Réseau Dynamique";break;
            case "mentions-legales.php":$title = "Mentions légales | Réseau Dynamique";break;
            case "location-camions.php":$title = "Location de Camions Lourds | Réseau Dynamique";break;
            case "demande-pieces.php":$title = "Demande de pièces | Réseau dynamique";break;
            case "demande-bon-travail.php":$title = "Demande de bon de travail | Réseau dynamique";break;
            case "camions-occasion.php":$title = "Camions Lourds d'Occasion | Réseau Dynamique";break;
            case "demande-information.php":$title = "Demande d'information | Réseau Dynamique";break;
            case "planifier-essai-routier.php":$title = "Planifier un essai routier | Réseau Dynamique";break;
            case "obtenir-prix.php":$title = "Obtenir un prix | Réseau Dynamique";break;
            case "demande-financement.php":$title = "Demande de financement | Réseau Dynamique";break;
            case "evaluer-echange.php":$title = "Évaluer mon échange | Réseau Dynamique";break;
            case "promotions.php":$title = "Promotions sur Camions Lourds | Réseau Dynamique";
            //case "":$title = "";break;
            default:;
        }
        
        echo $title == "" ? "Réseau Dynamique | Concessionnaire Camions International" : $title;
    }
    
    public static function getPageTitleForSearch($pageName)
    {   
        $title = "";
        
        switch($pageName){
            case "a-propos.php":$title = "À Propos Réseau Camion International | Réseau Dynamique";break;
            case "accueil.php":$title = "Accueil | Réseau Dynamique";break;
            case "nous-joindre.php":$title = "Nous joindre | Réseau Dynamique";break;
            case "urgence-routiere-24h.php":$title = "Urgence Routière 24 h Camions Lourds Canada et États-Unis";break;
            case "camions-lourds-neufs-international.php":$title = "Camions Neufs International | Réseau Dynamqiue";break;
            case "inventaire-camion-neufs.php":$title = "Camion neufs | Réseau Dynamique";break;
            case "isuzu.php":$title = "Camions Neufs Isuzu | Réseau Dynamique";break;
            case "ottawa-kalmar.php.php":$title = "Camions Lourds Neufs Ottawa Kalmar | Réseau Dynamique";break;
            case "les-camions-beaudoin.php":$title = "Camions International Saint-Hyacinthe | Les Camions Beaudoin";break;
            case "inter-lanaudiere.php":$title = "Camions International Joliette | Inter-Launaudiere";break;
            case "camions-inter-anjou.php":$title = "Camions International Anjou | Inter-Anjou";break;
            case "inter-boucherville.php":$title = "Camions International Boucherville | Inter-Boucherville";break;
            case "centre-camion-beaudoin.php":$title = "Camions International Drummondville | Centre du Camion Beaudoin";break;
            case "charest-international.php":$title = "Camions International Victoriaville | Charest International";break;
            case "garage-charest-freres.php":$title = "Camions International Trois-Rivières | Garage Charest et Frères";break;
            case "le-centre-camion-amiante.php":$title = "Camions International Thetford Mines | Le Centre du camion";break;
            case "le-centre-camion-beauce.php":$title = "Camions International St-Georges | Le Centre du Camion";break;
            case "centre-routier-1994.php":$title = "Camions International Rivière-du-Loup | Centre Routier 1994";break;
            case "camions-international-elite.php":$title ="Camions International Québec | Camions International Élite";break; 
            case "garage-robert.php":$title = "Garage Robert Shawinigan | Réseau Dynamique";break;
            case "camions-isuzu.php":$title = "Camions Isuzu";break;
            case "confirmation-abonnement.php":$title = "";break;
            case "abonnement-nextpart.php":$title = "Inscription à NextPart | Réseau Dynamique";break;
            //case "service-routier.php":$title = "Service Routier Mécanique Camion Lourd | Réseau Dynamique";break;
            case "pieces-accessoires.php":$title = "Pièces et Accessoires pour Camions | Réseau Dynamique";break;
            case "financement.php":$title = "Financement Camions Lourds Neufs & Usagés | Réseau Dynamique";break;
            case "apres-vente.php":$title = "Service Après-Vente Camions Lourds | Réseau Dynamique";break;
            case "promotions.php":$title = "Promotions sur Camions Lourds | Réseau Dynamique";break;
            case "promo-pieces.php":$title = "Promo pièces | Réseau Dynamique";break;
            case "nouvelles.php":$title = "Nouvelles et Événements | Réseau Dynamique";break;
            case "concours.php":$title = "Concours | Réseau Dynamique";break;
            case "remorques-doepker.php":$title = "Remorques Doepker | Réseau Dynamique";break;
            case "remorques-di-mond.php":$title = "Remorques Di-Mond | Réseau Dynamique";break;
            case "inventaire-remorques.php":$title = "Inventaire complet de remorques | Réseau Dynamique";break;
            case "transporteurs-tout-terrain.php":$title = "Transporteurs Tout Terrain Yanmar | Réseau Dynamique";break;
            case "skid-steer-chargeur-chenilles.php":$title = "Skeed Steer & Chargeur à Chenilles Yanmar | Réseau Dynamique";break;
            case "mini-excavatrices.php":$title = "Mini-Excavatrices Yanmar | Réseau Dynamique";break;
            case "chargeuses-yanmar-v3-v4.php":$title = "Chargeuses Yanmar V3 et V4 | Réseau Dynamique";break;
            case "fournisseurs.php":$title = "Fournisseurs | Réseau Dynamique";break;
            case "plan-site.php":$title = "Plan du site | Réseau Dynamique";break;
            case "mentions-legales.php":$title = "Mentions légales | Réseau Dynamique";break;
            case "location-camions.php":$title = "Location de Camions Lourds | Réseau Dynamique";break;
            case "demande-pieces.php":$title = "Demande de pièces | Réseau dynamique";break;
            case "demande-bon-travail.php":$title = "Demande de bon de travail | Réseau dynamique";break;
            case "camions-occasion.php":$title = "Camions Lourds d'Occasion | Réseau Dynamique";break;
            case "demande-information.php":$title = "Demande d'information | Réseau Dynamique";break;
            case "planifier-essai-routier.php":$title = "Planifier un essai routier | Réseau Dynamique";break;
            case "obtenir-prix.php":$title = "Obtenir un prix | Réseau Dynamique";break;
            case "demande-financement.php":$title = "Demande de financement | Réseau Dynamique";break;
            case "evaluer-echange.php":$title = "Évaluer mon échange | Réseau Dynamique";break;
            case "promotions.php":$title = "Promotions sur Camions Lourds | Réseau Dynamique";
            //case "":$title = "";break;
            default:;
        }
        
        return $title == "" ? "Réseau Dynamique | Concessionnaire Camions International" : $title;
    }
}
?>