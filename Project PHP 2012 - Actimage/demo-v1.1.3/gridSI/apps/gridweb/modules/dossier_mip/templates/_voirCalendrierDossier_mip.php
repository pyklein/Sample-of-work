<?php use_helper("Format"); ?>

<?php if($objAvisEtatMajor && $objRemiseDoc && $objTransfertCloture){?>

  <!--Cadre Avis d'etat major -->
  <?php if($objAvisEtatMajor): ?>
    <fieldset>
      <legend>
          <?php echo libelle("msg_gestion_calendrier_creeravisetatmajor") ?>
      </legend>

      <p>
        <?php
          if($objAvisEtatMajor->getEstFavorable() && $objAvisEtatMajor->getDateReception()){
            echo libelle('msg_libelle_vue_calendrier_avis_favorable')  . formatDate($objAvisEtatMajor->getDateReception());
          }else if(!$objAvisEtatMajor->getEstFavorable() && $objAvisEtatMajor->getDateReception()){
            echo libelle('msg_libelle_vue_calendrier_avis_defavorable')  . formatDate($objAvisEtatMajor->getDateReception());
          }else{
            echo libelle('msg_libelle_aucun_avis');
          }
        ?>
      </p>

      <p><?php if($objAvisEtatMajor->getRecommandation()!= null) echo libelle('msg_libelle_recommandation').": ".$objAvisEtatMajor->getRaw('recommandation'); ?></p>
      <p><?php if($objSoutien->getDateEmission() != null) echo libelle("msg_libelle_vue_calendrier_lettre_decision_envoye") . formatDate($objSoutien->getDateEmission()); ?></p>

    </fieldset>

  <?php endif; ?>


  <!--Cadre Remise des documents -->
  <?php if($objRemiseDoc && ($objRemiseDoc->getDateReceptionEa() || $objRemiseDoc->getDateReceptionCr() || $objRemiseDoc->getDateReceptionVideo())): ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_gestion_calendrier_creerremisedocuments") ?>
      </legend>

    <p>
      <?php
      if($objRemiseDoc->getDateReceptionEa() != null){
        echo libelle("msg_libelle_vue_calendrier_etat_avancement_recu_le");
        echo formatDate($objRemiseDoc->getDateReceptionEa());
      }
      ?>
    </p>
    <p>
      <?php
      if($objRemiseDoc->getDateReceptionCr() != null){
        echo libelle("msg_libelle_vue_calendrier_compte_rendu_recu_le") ;
        echo formatDate($objRemiseDoc->getDateReceptionCr());
      }
      ?>
    </p>
    <p>
      <?php
      if($objRemiseDoc->getDateReceptionVideo() != null){
        echo libelle("msg_libelle_vue_calendrier_video_recu_le") ;
        echo formatDate($objRemiseDoc->getDateReceptionVideo());
      }
      ?>
    </p>

    </fieldset>

  <?php endif; ?>


  <!--Cadre Remise des documents -->
  <?php if($objTransfertCloture && ($objTransfertCloture->getDateTransfert() || $objTransfertCloture->getDestinationAutre() || $objTransfertCloture->getDateCloture())): ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_gestion_calendrier_creertransfertcloture") ?>
      </legend>

      <p>
        <?php
        if($objTransfertCloture->getDateTransfert() != null){
          echo libelle("msg_libelle_vue_calendrier_transfert_effectue_le") ;
          echo formatDate($objTransfertCloture->getDateTransfert());
        }
        ?>
      </p>

      <p>
        <?php
        if($objTransfertCloture->getDestinationAutre() != null){
          echo libelle("msg_libelle_destination") ." : ". $objTransfertCloture->getDestinationAutre();
        }
        ?>
      </p>
      <p>
        <?php
        if($objTransfertCloture->getDateCloture() != null){
          echo libelle("msg_libelle_vue_calendrier_cloture_effectuee_le") ;
          echo formatDate($objTransfertCloture->getDateCloture());
        }
        ?>
      </p>

    </fieldset>

  <?php endif; ?>

<?php
} else if (!isset($pdf)) {
  echo libelle("msg_libelle_aucune_information_disponible") ;
}
?>