<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>



<div class="reduit">
  <div>
    <?php
      if ($strModelContenant == "Dossier_these"):
        echo libelle("msg_titre_dossier_these",array($objDossier->getTitre()));

      elseif($strModelContenant == "Dossier_postdoc"):
        echo libelle("msg_titre_dossier_postdoc",array($objDossier->getTitre()));

      elseif($strModelContenant == "Dossier_ere"):
        echo libelle("msg_titre_dossier_ere",array($objDossier->getTitre()));

      endif;
    ?>
  </div>

  <?php echo message(); ?>

  <?php if ($objDossier->getEstActif()): ?>
    <form action="" method="post">
      <fieldset class="fieldset_formulaire">
        <legend>
          <?php echo libelle("msg_module_".strtolower($strModelContenant)."_action_creer_remarquemris") ?>
        </legend>
        <?php echo $objForm; ?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_creer"); ?>" />
        </div>
      </fieldset>
      <br />
    </form>
  <?php endif; ?>


  <?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre, 'boolReinitialiser' => true)) ?>

  <?php foreach ($objPager->getResults() as $objRemarque): ?>
    <br>
    <br>

    <?php echo libelle("msg_remarque_mris_header",array(
        formatDate($objRemarque->getUpdatedAt()),
        formatHeure($objRemarque->getUpdatedAt()),
        $objRemarque->getUtilisateurCreatedBy()->getPrenom(),
        strtoupper($objRemarque->getUtilisateurCreatedBy()->getNom()),
        $objRemarque->getUtilisateurCreatedBy()->getProfil()->getIntitule()
        )
                      );
    ?>
    <br>
    <fieldset>
      <?php echo $objRemarque->getRaw('contenu') ?>
    </fieldset>
    <?php if (($objUser->getUtilisateur()->getId() == $objRemarque->getCreated_by()) || ($objUser->hasCredential("SUP-MRIS"))) :?>
      <div class="right">
        <?php echo link_to_grid(libelle("msg_remarque_mris_libelle_edit"),"dossier_mris/modifierRemarque_mris?id=".$objRemarque->getId()."&dossier_id=".$objDossier->getId(),array("class" => "picto bt_modifier")) ?>
        <?php echo link_to_grid(libelle("msg_remarque_mris_libelle_del"),"dossier_mris/supprimerRemarque_mris?id=".$objRemarque->getId()."&dossier_id=".$objDossier->getId(),array("class" => "picto bt_supprimer")) ?>
      </div>
    <?php endif; ?>
  <?php endforeach ?>

  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>

</div>

<?php include_partial('autreActionsMris',array('strNomModel' => $strModelContenant,'id' => $objDossier->getId())) ?>

<hr class="clear">

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/lister".$strModelContenant."s", array("class" => "picto bt_retour")); ?>
</div>

