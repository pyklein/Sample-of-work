<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" '?>>
  <fieldset>
    <legend>
      <?php echo libelle("msg_module_dossier_bpi_action_creer_documents_bpi") ?>
    </legend>
    <?php echo $objForm; ?>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_ajouter"); ?>" />
    </div>
  </fieldset>
</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDocuments_bpis?dossier_bpi=" .$idContenant, array("class" => "picto bt_retour")); ?>
</div>
