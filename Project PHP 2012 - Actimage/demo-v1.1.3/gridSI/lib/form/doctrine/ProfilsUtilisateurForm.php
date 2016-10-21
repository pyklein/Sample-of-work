<?php
/**
 * Description of ProfilsUtilisateurForm
 *
 * @author William
 */
class ProfilsUtilisateurForm extends BaseUtilisateurForm{

  
  private $intIdUtilisateur;

  /**
   * Construit la forme en prenant compte les dtroit de l'utilisateur
   *
   * @param <type> $object 
   * @param <type> $options
   * @param <type> $CSRFSecret
   * @param integer $intIdUsr L'id de l'utilisateur actuellement logué. Si aucun
   *                          id n'est specifié, droit d'admin son appliqués
   * @return ProfilsUtilisateurForm
   */
  public function  __construct($object = null, $options = array(), $CSRFSecret = null, $intIdUsr=0)
  {
    parent::__construct($object, $options, $CSRFSecret);

    $this->intIdUtilisateur = $intIdUsr;

    $this->configure();

    return $this;
  }


  public function  configure() {
 
    $this->useFields(array('profils_list'));

    $this->widgetSchema['profils_list'] = new sfWidgetFormDoctrineChoice(
            array('model' => $this->getRelatedModelName('Profils'),
                  'multiple' => true,
                  'expanded' => true,
                  'query' => ProfilTable::getInstance()->getQueryProfilsGerablesParCetUtilisateur($this->intIdUtilisateur))
            );
    
    $this->validatorSchema['profils_list'] = new sfValidatorDoctrineChoice(
            array('model' => $this->getRelatedModelName('Profils'),
                  'multiple' => true,
                  'required' => true),
            array('required' => libelle("msg_utilisateur_profil_requis")));

     $this->widgetSchema['profils_list']->setLabel(libelle("msg_libelle_profil"));

    parent::configure();
  }

  public function  save($con = null)
  {
    //La liste qu'on va reelement pase pour la sauveguarde
    $arrListToSave = array();

    //Recupere les profils de la base dans l'ordre dans lequels l'adminConfig
    //les ordonne
    $arrProfilsBaseTriePourForm = ProfilTable::getInstance()->getQueryProfilsGerablesParCetUtilisateur(0)->execute();

    //Utilisateur initiateur de l'action
    $objUsrCurr = UtilisateurTable::getInstance()->getUnAvecId($this->intIdUtilisateur);

    //Les profiles de l'utilisateur avant changements
    $arrIdsProfilsInit = $this->getObject()->getProfilsIds();

    //Les profil submités
    $arrSumitList = $this->values['profils_list'];

    $arrIdProfGerablesParCurrUsr = $objUsrCurr->getIdsProfilsGerables();
    $arrIdProfIngerablesParCurrUsr = $objUsrCurr->getIdsProfilsIngerables();

    foreach ($arrProfilsBaseTriePourForm as $objProfil)
    {
      if (in_array($objProfil->getId(),$arrIdProfGerablesParCurrUsr))
      {
        if (in_array($objProfil->getId(),$arrSumitList))
        {
          $arrListToSave[] = $objProfil;
        }
      } else if (in_array($objProfil->getId(),$arrIdsProfilsInit))
      {
        $arrListToSave[] = $objProfil;
      }
    }

    $objUtilisateurToModif = UtilisateurTable::getInstance()->getUnAvecId($this->getObject()->getId());

    $i=0;
    foreach ($arrIdsProfilsInit as $intIdProfil)
    {
      $objUtilisateurToModif->getProfils()->remove($i);
      $i++;
    }

    foreach ($arrListToSave as $objProfil)
    {
      $objUtilisateurToModif->getProfils()->add($objProfil);
    }

    $objUtilisateurToModif->save();

    return $objUtilisateurToModif;
  }

  
}
?>
