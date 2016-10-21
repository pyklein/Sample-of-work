<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>


<div>
  <form action="" method="post">
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_description_versement") ?>
      </legend>
        <?php echo $objForm; ?>
    </fieldset>

    <div class="boutons">
          <input type="submit" value="<?php echo  libelle("msg_bouton_modifier"); ?>" />
      </div>

    <div class="left">
      <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/modifierFinancement_Dossier_these?dossier_id=" . $idContenant, array("class" => "picto bt_retour")); ?>
    </div>
    
  </form>
</div>