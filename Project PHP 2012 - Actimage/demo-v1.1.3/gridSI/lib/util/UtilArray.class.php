<?php

/**
 * Description of UtilArray
 *
 * @author Simeon Petev
 */
class UtilArray
{
  /**
   * Recherche la dernier valeur de l'array pointé par la plus grande clé qui est
   * inverieur au deuxieme paramettre de la fonction
   *
   * @param array $arrDatesValeurs Un array de type array("date en format YYYY-MM-DD" => "valeur mixte")
   *                                Attention: l'array doit etre imperativement trié
   *                                            par ordre ASC des clés
   * @param string $strDateLimite Une date en format YYYY-MM-DD
   * @return mixte Retuns NULL s'il n'y a pas de clés inferieurs à la date limite
   *
   * @author Simeon PETEV
   */
  public function rechercheDichotomiqueDateKeys($arrDatesValeurs,$strDateLimite)
  {
    $mixteResultat = null;

    $intBorneSup = count($arrDatesValeurs)-1;
    $intBorneInf = 0;

    $arrArrKeys = array_keys($arrDatesValeurs);
    $intKeyIndex = -1;

    $intKeyIndex = (int)(($intBorneSup-$intBorneInf)/2);

    if (count($arrDatesValeurs) != 1)
    {
      while (($intBorneSup-$intBorneInf > 0) && ($intKeyIndex != $intBorneSup) && ($intKeyIndex != $intBorneInf))
      {
        if (strcmp($arrArrKeys[$intKeyIndex], $strDateLimite) == 0)
        {
          $intKeyIndex--;

          //On force la terminaison de while
          $intBorneSup = $intBorneInf;
        } else if (strcmp($arrArrKeys[$intKeyIndex], $strDateLimite) < 0)
        {
          $intBorneInf = $intKeyIndex;
          $intKeyIndex += (int)(($intBorneSup-$intBorneInf)/2);
        } else
        {
          $intBorneSup = $intKeyIndex;
          $intKeyIndex -= (int)($intBorneSup-$intBorneInf)/2;
        }
      }
    } else
    {
      if (strcmp($arrArrKeys[$intKeyIndex], $strDateLimite) < 0)
      {
        $intKeyIndex = 0;
      }
    }

    if ($intKeyIndex >= 0)
    {
      $mixteResultat = $arrDatesValeurs[$arrArrKeys[$intKeyIndex]];
    }

    return $mixteResultat;
  }

  /**
   * Recherche la dernier valeur de l'array pointé par la plus grande clé qui est
   * inverieur au deuxieme paramettre de la fonction
   *
   * @param array $arrDatesValeurs Un array de type array("date en format YYYY-MM-DD" => "valeur mixte")
   *                                Attention: l'array doit etre imperativement trié
   *                                            par ordre ASC des clés
   * @param string $strDateLimite Une date en format YYYY-MM-DD
   * @return mixte Retuns NULL s'il n'y a pas de clés inferieurs à la date limite
   *
   * @author Simeon PETEV
   */
  public function rechercheDateKeys($arrDatesValeurs,$strDateLimite)
  {
    $mixteResultat = null;

    $strKey = "-1";

    foreach ($arrDatesValeurs as $key => $value)
    {
      if (strcmp($key, $strDateLimite) < 0)
      {
        $strKey = $key;
      } else
      {
        break;
      }
    }

    if ($strKey >= 0)
    {
      $mixteResultat = $arrDatesValeurs[$strKey];
    }

    return $mixteResultat;
  }

  /**
   * Fait la sum des valeurs de l'array
   *
   * @param mixte $arrayKeyValue Un array-like collection de type array("key" => "valeur_numerique")
   * @return mixte Valeur numerique (int,float,...)
   *
   * @author Simeon PETEV
   */
  public function sumValeursArray($arrayKeyValue)
  {
    $mixteSumTotal = 0;

    foreach ($arrayKeyValue as $key => $mixteNumerique)
    {
      $mixteSumTotal += $mixteNumerique;
    }

    return $mixteSumTotal;
  }
}
?>
