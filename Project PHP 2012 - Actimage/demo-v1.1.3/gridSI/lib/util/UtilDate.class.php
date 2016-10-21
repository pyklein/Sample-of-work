<?php

/**
 * Classe permettant d'effectuer des opérations sur les dates
 * @author Jihad 
 */
class UtilDate
{


  /**
   * Permet d'afficher une date en lettre ex : 1er Juillet 2011
   * @param date $dateFr Date à formater, doit être de la forme jj/mm/aaaa OU j/m/aaaa
   * @return string $dateFinale
   * @author Alexandre WETTA
   */
  public function afficheDateFrComplete($dateFr){
    
    $dateFinale = "";

    $arrDate = explode("/", $dateFr);

    if(count($arrDate) != 3){
      return "date invalide";
    }

    //jour
    if($arrDate[0] == "1" || $arrDate[0] == "01"){
      $dateFinale = "1er ";
    }else{
      $dateFinale = $arrDate[0]." ";
    }
    
    //mois
    $dateFinale .= $this->getMoisFrByNumero($arrDate[1]). " ";
    //année
    $dateFinale .= $arrDate[2];

    return $dateFinale;
  }

  /**
   * Permet de récupérer le nom des mois selon le numéro
   * @param string $strNumero
   * @author Jihad Sahebdin
   */

  public function getMoisFrByNumero($strNumero)
  {
    $arrListeMois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

    //On enlève les zeros devant le chiffre s'il y en a.(ex:01,02,...)
    $strIndice = str_replace('0', '', $strNumero);

    if($strIndice > 0 && $strIndice <= 12)
    {
      return $arrListeMois[$strIndice-1];
    }
    else
    {
      return "numéro invalide";
    }

  }

  /**
   * Permet de calculer l'année scolaire à partir d'une date donnée
   * @param string $strDate date en format sql
   * @return string année scolaire en format AAAA/AAAA (ex. 2009/2010)
   * @author Gabor JAGER
   */
  public function getAnneeScolaire($strDate)
  {
    $intMois = date("n", strtotime($strDate));
    if (intval($intMois) > 9)
    {
      return date("Y", strtotime($strDate))."/".date("Y", strtotime($strDate." +1 year"));
    }
    else
    {
      return date("Y", strtotime($strDate." -1 year"))."/".date("Y", strtotime($strDate));
    }
    return "";
  }

}
