<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($objDossier)); ?>
</h3>

<?php echo message(); ?>

<div class="reduit">
<?php if ($objDossier->getEstActif()): ?>
  <form action="" method="post">
    <fieldset class="fieldset_formulaire">
      <legend>
        <?php echo libelle("msg_module_dossier_bpi_action_creer_remarquebpi") ?>
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

  <?php echo libelle("msg_remarque_bpi_header",array(formatDate($objRemarque->getUpdatedAt()),
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
  <?php if (($objUser->getUtilisateur()->getId() == $objRemarque->getCreated_by())) :?>
    <div class="right">
      <?php echo link_to_grid(libelle("msg_remarque_bpi_libelle_edit"),"dossier_bpi/modifierRemarque_bpi?id=".$objRemarque->getId(), array('class' => 'picto bt_modifier')) ?>
      <?php echo link_to_grid(libelle("msg_remarque_bpi_libelle_del"),"dossier_bpi/supprimerRemarque_bpi?id=".$objRemarque->getId(), array('class' => 'picto bt_supprimer')) ?>
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

<?php include_partial('autreActions',array('id' => $objDossier->getId())) ?>

<hr class="clear">

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>

