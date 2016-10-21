<?php

include(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "pData.class.php");
include(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "pChart.class.php");

/**
 * Classe pour la gestion des graphiques avec Pchart
 *
 * @author Alexandre WETTA
 */
class ServiceChart {

  //Données générales des graphiques : largeur et hauteur de l'image générée, plage de couleurs de la palette et nombre de couleurs générées.
  protected $imgOutWidth;
  protected $imgOutHeight;
  protected $gradientColors       = array(200, 15, 15, 15, 15, 200);
  protected $nbCouleurs           = 5;

  protected $dataSet              = NULL;
  protected $chartObj             = NULL;
  protected $chartRender          = "";

  protected $fontSize;

/**
 * Constructeur de la classe avec possibilité de définir la taille de l'image générée
 * @param int $imgWidth Largeur de l'image
 * @param int $imgHeight Hauteur de l'image
 * @param int $fontSize Taille de police sur l'image
 * @author Julien GAUTIER
 */
  function __construct($imgWidth = NULL, $imgHeight = NULL, $fontSize = NULL) {
    $this->imgOutWidth  = $imgWidth  > 0 ? $imgWidth  : sfConfig::get('app_image_genere_largeur');
    $this->imgOutHeight = $imgHeight > 0 ? $imgHeight : sfConfig::get('app_image_genere_hauteur');
    $this->fontSize     = $fontSize  > 0 ? $fontSize  : sfConfig::get('app_image_genere_taille_police');
  }

  public function setFontSize($fontSize)
  {
    $this->fontSize = $fontSize;
  }

/**
 * Définition de la plage de la palette de couleurs
 * @param int $rougeDep Valeur du rouge pour la couleur de départ de la plage
 * @param int $vertDep Valeur du vert pour la couleur de départ de la plage
 * @param int $bleuDep Valeur du bleu pour la couleur de départ de la plage
 * @param int $rougeFin Valeur du rouge pour la couleur de fin de la plage
 * @param int $vertFin Valeur du vert pour la couleur de fin de la plage
 * @param int $bleuFin Valeur du bleu pour la couleur de fin de la plage
 * @author Julien GAUTIER
 */
  public function setGradientColors($rougeDep, $vertDep, $bleuDep, $rougeFin, $vertFin, $bleuFin) {
    if ($rougeDep >=0 && $vertDep >=0 && $bleuDep >=0 && $rougeFin >=0 && $vertFin >=0 && $bleuFin >=0) {
      $this->gradientColors = array($rougeDep, $vertDep, $bleuDep, $rougeFin, $vertFin, $bleuFin);
    }
  }

/**
 * Définition du nombre de couleurs utilisées pour le graphique
 * @param int $nbCouleurs Nombre de couleur
 * @author Julien GAUTIER
 */
  public function setNbCouleurs($nbCouleurs) {
    if ($nbCouleurs > 0) $this->nbCouleurs = $nbCouleurs;
  }

/**
 * Création des éléments d'entête et préparation du graphique.
 * A appeller avant tout renseignement du graphique.
 *
 * @param array $libelle Tableau pour les libelles des données
 * @param array $donnees Tableau de données (A envoyer dans le même ordre que les libellés)
 * @param boolean $cadre Ajout d'un cadre entourant de graphique
 * @param array $couleurFond Composantes RVB de la couleur du fond du cadre
 * @author Julien GAUTIER
 */
  public function creerEntete($libelle, $donnees, $cadre = false, $couleurFond = array(230, 230, 230)) {
    // Dataset definition
    $dataSetTmp = new pData();
    $dataSetTmp->AddPoint($donnees, "Serie1");
    $dataSetTmp->AddPoint($libelle, "SerieName");
    $dataSetTmp->AddSerie("Serie1");
    $dataSetTmp->SetAbsciseLabelSerie("SerieName");
    $this->dataSet = $dataSetTmp;

    // Initialise the graph
    $chartTmp = new pChart($this->imgOutWidth, $this->imgOutHeight);
    $chartTmp->createColorGradientPalette($this->gradientColors[0]
            , $this->gradientColors[1]
            , $this->gradientColors[2]
            , $this->gradientColors[3]
            , $this->gradientColors[4]
            , $this->gradientColors[5]
            , $this->nbCouleurs);
    $chartTmp->setFontProperties(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "Fonts" . DIRECTORY_SEPARATOR ."tahoma.ttf", $this->fontSize);

    //Vérification des paramètres pour le cadre
    if ($cadre && count($couleurFond) == 3 && $couleurFond[0] >= 0 && $couleurFond[0] <= 255 && $couleurFond[1] >= 0 && $couleurFond[1] <= 255 && $couleurFond[2] >= 0 && $couleurFond[2] <= 255) {
      $chartTmp->drawFilledRoundedRectangle(7, 7, $this->imgOutWidth - 7, $this->imgOutHeight - 7, 5, 240, 240, 240);
      $chartTmp->drawRoundedRectangle(5, 5, $this->imgOutWidth - 5, $this->imgOutHeight - 5, 5, $couleurFond[0], $couleurFond[1], $couleurFond[2]);
    }
    $chartTmp->AntialiasQuality = 0;
    $this->chartObj = $chartTmp;

  }

  /**
 * Création des éléments d'entête et préparation du graphique.
 * A appeller avant tout renseignement du graphique.
 * Permet de gérer deux séries de données
 * @param array $libelle Tableau pour les libelles des données
 * @param array $donnees Tableau de données (A envoyer dans le même ordre que les libellés)
 * @param array $donnees2 Deuxieme tableau de données (A envoyer dans le même ordre que les libellés)
 * @param boolean $cadre Ajout d'un cadre entourant de graphique
 * @param array $couleurFond Composantes RVB de la couleur du fond du cadre
 * @author Julien GAUTIER
 */
  public function creerEntetePourBarGraph($libelle, $donnees, $legende, $donnees2 = array(), $cadre = false, $couleurFond = array(230, 230, 230)) {
    // Dataset definition
    $dataSetTmp = new pData();
    $dataSetTmp->AddPoint($donnees, "Serie1");
    $dataSetTmp->AddPoint($libelle, "SerieName");

    if(isset($donnees2))
    {
      $dataSetTmp->AddPoint($donnees2, "Serie2");
      $dataSetTmp->AddSerie("Serie2");
      $dataSetTmp->SetSerieName($legende[1],"Serie2");
    }
    $dataSetTmp->AddSerie("Serie1");
//    $dataSetTmp->AddAllSeries();
    $dataSetTmp->SetAbsciseLabelSerie("SerieName");
    $dataSetTmp->SetSerieName($legende[0],"Serie1");
    $this->dataSet = $dataSetTmp;

    // Initialise the graph
    $chartTmp = new pChart($this->imgOutWidth, $this->imgOutHeight);
    $chartTmp->createColorGradientPalette($this->gradientColors[0]
            , $this->gradientColors[1]
            , $this->gradientColors[2]
            , $this->gradientColors[3]
            , $this->gradientColors[4]
            , $this->gradientColors[5]
            , $this->nbCouleurs);
    $chartTmp->setFontProperties(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "Fonts" . DIRECTORY_SEPARATOR ."MankSans.ttf", $this->fontSize);

    
    //Vérification des paramètres pour le cadre
    if ($cadre && count($couleurFond) == 3 && $couleurFond[0] >= 0 && $couleurFond[0] <= 255 && $couleurFond[1] >= 0 && $couleurFond[1] <= 255 && $couleurFond[2] >= 0 && $couleurFond[2] <= 255) {
      $chartTmp->drawFilledRoundedRectangle(7, 7, $this->imgOutWidth - 7, $this->imgOutHeight - 7, 5, 240, 240, 240);
      $chartTmp->drawRoundedRectangle(5, 5, $this->imgOutWidth - 5, $this->imgOutHeight - 5, 5, $couleurFond[0], $couleurFond[1], $couleurFond[2]);
    }
    $chartTmp->AntialiasQuality = 0;
    $this->chartObj = $chartTmp;

  }
  
/**
 * Affichage d'un titre pour le graphique
 *
 * @param string $titre Titre du camembert
 * @param array $couleurTitre Composantes RVB de la couleur du texte du titre
 * @param int $positionX Position gauche du titre
 * @param int $positionY Position à partir du haut du titre
 * @author Julien GAUTIER
 */
  public function creerTitre($titre, $couleurTitre = array(100, 100, 100), $positionX = 10, $positionY = 20) {
    if ($this->chartObj) {
      if (!(count($couleurTitre) == 3 && $couleurTitre[0] >= 0 && $couleurTitre[0] <= 255 && $couleurTitre[1] >= 0 && $couleurTitre[1] <= 255 && $couleurTitre[2] >= 0 && $couleurTitre[2] <= 255)) {
        $couleurTitre = array(100, 100, 100);
      }
      $this->chartObj->setFontProperties(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "Fonts" . DIRECTORY_SEPARATOR ."MankSans.ttf", $this->fontSize + 2);
      $this->chartObj->drawTitle($positionX, $positionY, $titre, $couleurTitre[0], $couleurTitre[1], $couleurTitre[2]);
      $this->chartObj->setFontProperties(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "Fonts" . DIRECTORY_SEPARATOR ."tahoma.ttf", $this->fontSize);

    }
  }

/**
 * Accès à l'objet principal pour la génération de graphique
 * @param string $prefixe Prefixe pour le nom du graphique
 * @author Julien GAUTIER
 */
  public function genererGraphique($prefixe = "chart") {
    $objUtilArbo = new ServiceArborescence();
    $this->chartObj->Render($objUtilArbo->getRepertoireTemporaire() . $prefixe . "_" . date("YmdHis") . ".png");
    $this->chartRender = $prefixe . "_" . date("YmdHis") . ".png";
  }

/**
 * Accès à l'objet principal pour la génération de graphique
 * @return pChart Objet permettant la construction d'un graphique
 * @author Julien GAUTIER
 */
  public function getObjetGraphique() {
    return $this->chartObj;
  }

/**
 * Accès à l'objet de configuration pour la génération de graphique
 * @return pData Objet permettant la configuration d'un graphique
 * @author Julien GAUTIER
 */
  public function getObjetConfiguration() {
    return $this->dataSet;
  }

/**
 * Récupération du nom du fichier graphique généré
 * @return string Nom du fichier généré pour le graphique
 * @author Julien GAUTIER
 */
  public function getFichierGraphique() {
    return $this->chartRender;
  }

/**
 *
 * @param array $libelle Tableau pour les libelles des données
 * @param array $donnees Tableau de données (A envoyer dans le même ordre que les libellés)
 * @param array $legende Tableau des libellés légendes (A envoyer dans le même ordre que les libellés)
 * @param string $prefixe Prefixe pour le nom de fichier
 * @param string $titre Titre du camembert
 * @param string $complement Information supplémentaire en bas de graphique
 * @param int $typeLibelle Type d'affichage des labels sur le graphique (PIE_LABELS, PIE_NOLABEL, PIE_PERCENTAGE, PIE_PERCENTAGE_LABEL)
 * @return string Lien pour le chart
 * @author Julien GAUTIER
 */
  public function creerCamembert($libelle, $donnees, $legende = array(), $prefixe = "chart", $titre = null, $complement = null, $typeLibelle = PIE_PERCENTAGE_LABEL) {
    $this->setNbCouleurs(count($donnees));

    $this->creerEntete($libelle, $donnees, true);

    // taille de police
    $this->chartObj->setFontProperties(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "Fonts" . DIRECTORY_SEPARATOR ."MankSans.ttf", $this->fontSize);

    // Draw the pie chart
    $pieX = round($this->imgOutWidth/2);
    $pieY = round($this->imgOutHeight/2);
    $this->chartObj->AntialiasQuality = 0;
    $this->chartObj->drawPieGraph($this->dataSet->GetData(), $this->dataSet->GetDataDescription(), $pieX, $pieY, 100, $typeLibelle, FALSE, 50, 20, 5);

    //Legend
    if (count($legende) > 0) {
      $this->dataSet->AddPoint($legende, "SerieLegend");
      $libelleLegende = array("Position"=>"SerieLegend", "Values"=>array("Serie1"), "Description"=>$legende);
      $legendeBox = $this->chartObj->getLegendBoxSize($libelleLegende);
      $this->chartObj->drawPieLegend($this->imgOutWidth - 10 - $legendeBox[0] , 15, $this->dataSet->GetData(), $libelleLegende, 250, 250, 250);
    }

    // Write the title
    if($titre) $this->creerTitre($titre);

    //Complement
    if ($complement)
      $this->chartObj->drawTitle(10 , $this->imgOutHeight - 8, $complement, 0, 0, 0);

    $this->genererGraphique($prefixe);
    return $this->getFichierGraphique() ;
  }

  /**
 *
 * @param array $libelle Tableau pour les libelles des données
 * @param array $donnees Tableau de données (A envoyer dans le même ordre que les libellés)
 * @param array $legende Tableau des libellés légendes (A envoyer dans le même ordre que les libellés)
 * @param string $prefixe Prefixe pour le nom de fichier
 * @param string $titre Titre du camembert
 * @param string $complement Information supplémentaire en bas de graphique
 * @param int $typeLibelle Type d'affichage des labels sur le graphique (PIE_LABELS, PIE_NOLABEL, PIE_PERCENTAGE, PIE_PERCENTAGE_LABEL)
 * @return string Lien pour le chart
 * @author Julien GAUTIER
 */
  public function creerCamembertLegendeACote($libelle, $donnees, $legende, $prefixe = "chart", $titre = null, $complement = null, $typeLibelle = PIE_PERCENTAGE_LABEL) {
    $this->setNbCouleurs(count($donnees));
    $this->creerEntete($libelle, $donnees, true);

    // taille de police
    $this->chartObj->setFontProperties(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "pChart" . DIRECTORY_SEPARATOR . "Fonts" . DIRECTORY_SEPARATOR ."MankSans.ttf", $this->fontSize);

    //Legend
    $this->dataSet->AddPoint($legende, "SerieLegend");
    $libelleLegende = array("Position"=>"SerieLegend", "Values"=>array("Serie1"), "Description"=>$legende);
    $legendeBox = $this->chartObj->getLegendBoxSize($libelleLegende);
    $this->chartObj->drawPieLegend($this->imgOutWidth - 10 - $legendeBox[0], 15, $this->dataSet->GetData(), $libelleLegende, 250, 250, 250);

    // Draw the pie chart
    $pieX = round(($this->imgOutWidth - $legendeBox[0] - 10)/2);
    $pieY = round($this->imgOutHeight/2);
    $this->chartObj->AntialiasQuality = 0;
    $this->chartObj->drawPieGraph($this->dataSet->GetData(), $this->dataSet->GetDataDescription(), $pieX, $pieY, 250, $typeLibelle, FALSE, 50, 20, 5);

    // Write the title
    if($titre) $this->creerTitre($titre);

    //Complement
    if ($complement)
      $this->chartObj->drawTitle(10 , $this->imgOutHeight - 8, $complement, 0, 0, 0);

    $this->genererGraphique($prefixe);
    return $this->getFichierGraphique() ;
  }

}
?>
