<?php
/**
 * Description of EnumEtOu
 * @author Gabor JAGER
 */
class EnumEtOu
{
  const ET = "AND";
  const OU = "OR";

  /**
   * Permet de récuperer tous les élements possibles
   * @return array tableau[id] = libellé
   * @author Gabor JAGER
   */
  public static function getEnums()
  {
    $arrRetour = array();

    $arrRetour[self::ET] = self::getLibelle(self::ET);
    $arrRetour[self::OU] = self::getLibelle(self::OU);

    return $arrRetour;
  }


  /**
   * Permet de récuperer tous les IDs des éléments
   * @return array tableau[] = id1, tableau[] = id2, ...
   * @author Gabor JAGER
   */
  public static function getEnumIds()
  {
    return array_keys(self::getEnums());
  }


  /**
   * Permet de récuperer la libelle d'un élémnet
   * @param integer $intEnumId
   * @author Gabor JAGER
   */
  public static function getLibelle($intEnumId)
  {
    switch($intEnumId)
    {
      case self::ET:
        return "ET";
        break;
      case self::OU:
        return "OU";
        break;
      default:
        return null;
        break;
    }
  }
}
