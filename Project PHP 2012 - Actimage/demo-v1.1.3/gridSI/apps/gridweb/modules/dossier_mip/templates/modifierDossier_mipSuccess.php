
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objForm->getObject())); ?>

<?php include_partial('dossier_mip_general',array('objForm' => $objForm, 'strId' => $strId)) ?>

<?php include_partial('autreActions',array('id' => $strId,'boolEstPreProjet' => $objForm->getObject()->estPreProjet(),'objDossier'=>$objForm->getObject())) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>