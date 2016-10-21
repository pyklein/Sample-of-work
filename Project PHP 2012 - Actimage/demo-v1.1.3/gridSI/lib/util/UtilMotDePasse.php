<?php

/**
 * Utilitaire de mot de passe
 * @author Siméon PETEV, Gabor JAGER
 */
class UtilMotDePasse {

  private $intLongeur;
  private $strAlphabet;

  public function __construct($intLongeur, $strAlphabet) {
    $this->intLongeur = $intLongeur;
    $this->strAlphabet = $strAlphabet;
  }

  public function getMotDePasseAleatoire()
  {
    $intMax=strlen($this->strAlphabet)-1;
  
    $strMotDePasseAleat='';

    mt_srand((double)microtime()*1000000);
    while (strlen($strMotDePasseAleat) < $this->intLongeur)
    {
      $strMotDePasseAleat.=$this->strAlphabet{mt_rand(0,$intMax)};
    }

    return $strMotDePasseAleat;
  }

  public function getChaineAleatoire()
  {
    $this->intLongeur = 10;

    $intMax=strlen($this->strAlphabet)-1;
    $strMotDePasseAleat='';

    mt_srand((double)microtime()*1000000);
    while (strlen($strMotDePasseAleat)<$this->intLongeur+1)
    {
      $strMotDePasseAleat.=$this->strAlphabet{mt_rand(0,$intMax)};
    }

    return $strMotDePasseAleat;
  }
}

