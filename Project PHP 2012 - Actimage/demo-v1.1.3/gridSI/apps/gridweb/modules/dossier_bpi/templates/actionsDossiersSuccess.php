<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>


<?php echo message(); ?>

<div class="reduit">
<?php if ($objDossier->getEstActif()): ?>
  <form action="" method="post">
    <fieldset class="fieldset_formulaire">
      <legend>
        <?php echo libelle("msg_module_dossier_bpi_action_creer_actionbpi") ?>
      </legend>
      <?php echo $objForm; ?>
      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_ajouter_action"); ?>" />
      </div>
    </fieldset>
    <br />
  </form>
<?php endif; ?>

<?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre)) ?>

<br>

  <?php foreach ($objPager->getResults() as $objAction): ?>
    <?php if($objAction->getStatut_action_id() == Statut_actionTable::A_MENER)
          {
            echo libelle("msg_liste_actions_a_mener_header",array($objAction->getPilote(),  formatDate($objAction->getDate_echeance())));
          }
          else if($objAction->getStatut_action_id() == Statut_actionTable::MENER)
          {
            echo libelle("msg_liste_actions_menee_header",array($objAction->getPilote(),  formatDate($objAction->getDate_echeance())));
          }
     ?>

    <strong>
    <?php if($objAction->getDate_action() > $objAction->getDate_echeance())
          {
            echo (libelle("msg_action_header_retard"));
          }
    ?>
    </strong>

    <fieldset>
      <?php echo $objAction->getRaw('description') ?>
    </fieldset>
    <?php if ($objAction->getPilote()->getNom() == $objUser->getUtilisateur()->getNom() || $objUser->hasCredential("SUP-BPI") ) :?>
      <div class="right">
        <?php echo link_to_grid(libelle("msg_action_libelle_edit"),"dossier_bpi/modifierAction_bpi?id=".$objAction->getId(), array('class' => 'picto bt_modifier')) ?>
        <?php echo link_to_grid(libelle("msg_action_libelle_del"),"dossier_bpi/supprimerAction_bpi?id=".$objAction->getId(), array('class' => 'picto bt_supprimer')) ?>
      </div>
    <?php endif; ?>
  <br>
  <?php endforeach ?>

  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>

  <div class="left">
    <?php echo link_to_grid_retour(libelle("msg_bouton_retourner"), array("class" => "picto bt_retour")); ?>
  </div>
  <br>
</div>
<?php include_partial('autreActions',array('id' => $objDossier->getId())) ?>
