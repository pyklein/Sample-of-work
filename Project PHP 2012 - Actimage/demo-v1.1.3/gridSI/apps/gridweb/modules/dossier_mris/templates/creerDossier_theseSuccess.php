
<?php use_helper("Message"); ?>
<?php echo message(); ?>
<?php
if (isset($strContenant)) {
  $strRedirection = "?" . $strContenant . "=" . $idContenant;
} else {
  $strRedirection = "";
}
?>

<?php include_partial('dossier_mris/dossier_these_form', array('objForm'=> $objForm)) ?>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossier_theses" . $strRedirection, array("class" => "picto bt_retour")); ?>
</div>