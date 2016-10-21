<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php include_partial('dossier_mris/onglet_dossier', array('strNomModel' => 'Dossier_ere', 'strId' => $objDossier->getId(), 'ongletActif' => 6)) ?>

<div id="zone_cadre" class="reduit">

  <form action="<?php echo url_for('dossier_mris/modifierAboutissement_Dossier_ere')?>" method="post">
    <div class="boutons">
        <input type="submit" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
    </div>
    <input type="hidden" name="dossier_ere_id" value="<?php echo $objDossier->getId()?>"/>


    <fieldset>
      <legend>
        <?php echo libelle('msg_dossier_ere_fieldset_element_aboutiss'); ?>
      </legend>

      <?php echo $objForm['reception_rapport_final']->renderRow(); ?>
      <?php echo $objForm['reception_fiche_evaluation']->renderRow(); ?>
      <?php echo $objForm['reception_synthese']->renderRow(); ?>

      <div class="boutons">
        <input type="submit" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
      </div>
    </fieldset>

  </form>
</div>

<?php include_partial('autreActionsMris',array('strNomModel'=>'Dossier_ere', 'id' => $objDossier->getId())) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossier_eres", array("class" => "picto bt_retour")); ?>
</div>
