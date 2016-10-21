<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" '?>>
  <fieldset>
    <legend>
      <?php echo libelle("msg_module_dossier_".$action."_document") ?>
    </legend>
    <?php echo $objForm; ?>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_".$action); ?>" />
    </div>
  </fieldset>
</form>

<script type='text/javascript'>
  enableElementOnSelectValue('<?php echo $objForm[$objForm->nomWidgetType]->renderId(); ?>', '', '<?php echo $objForm["autre_type"]->renderId(); ?>');
</script>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerDocuments?".strtolower($strContenant)."=" .$idContenant, array("class" => "picto bt_retour")); ?>
</div>
