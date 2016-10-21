<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Classe de fils d'ariane
 * @author Gabor JAGER
 */
class Ariane
{
    private $strNomModule;
    private $strNomAction;

    private $strLabelAccueil;
    private $strLabelModule;
    private $strLabelAction;

    public function __construct()
    {
      
        $this->strLabelAccueil = libelle('msg_menu_accueil');

        $this->strNomModule = sfContext::getInstance()->getModuleName();
        $this->strNomAction = sfContext::getInstance()->getActionName();
        
        // fichier introuvable
        // ou pas droit d'accès
        // ou plus connecté
        if ($this->strNomModule == "interface" && $this->strNomAction == "fichierIntrouvable"
                || $this->strNomModule == "authentification" && $this->strNomAction == "nonAutorise"
                || $this->strNomModule == "authentification" && $this->strNomAction == "plusConnecter")
        {
          $this->strLabelModule = libelle(strtolower('msg_module_erreur'));
          $this->strNomAction = "";
        }

        // pages normal
        else if ($this->strNomModule != "interface")
        {
          $this->strLabelModule = libelle(strtolower('msg_module_'.$this->strNomModule.''));
            
          if ($this->strNomAction != "index")
          {
            $this->strLabelAction = libelle(strtolower('msg_module_'.$this->strNomModule.'_action_'.$this->strNomAction));
          }

          // action index du module
          else
          {
            $this->strNomAction = "";
          }
        }

        // page d'accueil
        else
        {
          $this->strNomModule = "";
        }
    }

    public function getNomModule()
    {
        return $this->strNomModule;
    }
    
    public function getNomAction()
    {
        return $this->strNomAction;
    }

    public function getLabelAccueil()
    {
        return $this->strLabelAccueil;
    }

    public function getLabelModule()
    {
        return $this->strLabelModule;
    }

    public function getLabelAction()
    {
        return $this->strLabelAction;
    }
    
}
