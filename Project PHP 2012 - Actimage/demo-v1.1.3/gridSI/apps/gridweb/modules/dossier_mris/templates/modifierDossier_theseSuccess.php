<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php include_partial('dossier_mris/onglet_dossier', array('strNomModel' => 'Dossier_these', 'strId' => $strId, 'ongletActif' => 1)) ?>

<div id="zone_cadre" class="reduit">

  <?php include_partial('dossier_mris/dossier_these_form', array('objForm'=> $objForm)) ?>

</div>

<?php include_partial('autreActionsMris',array('strNomModel'=>'Dossier_these', 'id' => $strId)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossier_theses", array("class" => "picto bt_retour")); ?>
</div>
