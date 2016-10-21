
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>

<div class="reduit">
    <?php  include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre, 'boolReinitialiser' => true)) ?>

  <?php foreach ($objPager->getResults() as $objEvenement): ?>
    <br>
    <br>

    <strong><?php echo formatDate($objEvenement->getDate()) ?></strong>
    <br>
    <fieldset>
      <?php echo $objEvenement->getRaw('evenement') ?>
    </fieldset>
    <?php echo libelle("msg_evenement_mip_footer",array(formatDate($objEvenement->getCreatedAt()),
                                                       formatHeure($objEvenement->getCreatedAt()),
                                                       $objEvenement->getUtilisateurCreatedBy()->getPrenom(),
                                                       strtoupper($objEvenement->getUtilisateurCreatedBy()->getNom()),
                                                       $objEvenement->getUtilisateurCreatedBy()->getProfil()->getIntitule()
                                                      )
                      );
    ?>
    <?php if (($objUser->getUtilisateur()->getId() == $objEvenement->getCreated_by())) :?>
      <div class="right">
        <?php echo link_to_grid(libelle("msg_evenement_mip_libelle_edit"),"dossier_mip/modifierEvenement_mip?id=".$objEvenement->getId(), array('class' => 'picto bt_modifier')) ?>
        <?php if (!$objEvenement->getEstCloture()) { echo link_to_grid(libelle("msg_evenement_mip_libelle_clore"),"dossier_mip/cloreEvenement_mip?id=".$objEvenement->getId(), array('class' => 'picto bt_supprimer'));} ?>
      </div>
    <?php endif; ?>
  <?php endforeach ?>

  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur',array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)); ?>
  <?php endif; ?>
    
  <?php if ($objDossier->getEstActif()): ?>
    <form action="" method="post">
      <fieldset class="fieldset_formulaire">
        <legend>
          <?php echo libelle("msg_module_dossier_mip_action_creer_evenementmip") ?>
        </legend>
        <?php echo $objForm; ?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_creer"); ?>" />
        </div>
      </fieldset>
      <br />
    </form>
  <?php endif; ?>
</div>
<?php include_partial('dossier_mip/autreActions',array('id' => $objDossier->getId(),'boolEstPreProjet' => $objDossier->estPreProjet(),'objDossier'=>$objDossier)) ?>


<hr class="clear">
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>
  

