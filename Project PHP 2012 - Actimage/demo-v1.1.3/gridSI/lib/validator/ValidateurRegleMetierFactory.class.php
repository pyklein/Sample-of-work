<?php

/**
 * Description of ValidateurRegleMetierFactory
 * @author William
 */
class ValidateurRegleMetierFactory
{
  /**
   * Retourne un objet validateur règle métier instancié selon le dossier passé. Lève une
   * LogicException si l'objet passé n'est pas un Dossier traitable.
   * @param <type> $objDossier
   * @return UtilValidateurRegleMetier
   */
  public function getValidateurMetier($objDossier)
  {
    if (is_a($objDossier, 'Dossier_mip'))
    {
      return new ValidateurRegleMetierMIP($objDossier);
    }
    else if (is_a($objDossier, 'Dossier_bpi'))
    {
      return new ValidateurRegleMetierBPI($objDossier);
    }
    
    throw new LogicException('Type de dossier non reconnu');
  }
}
