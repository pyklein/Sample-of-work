<form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" '?>>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_identification_dossier") ?>
      </legend>
      <?php echo $objForm['numero']->renderRow(); ?>
      <?php echo $objForm['titre']->renderRow(); ?>
      <?php echo $objForm['objet']->renderRow(); ?>
      <?php echo $objForm['domaine_scientifique_id']->renderRow(); ?>
      <?php echo $objForm['organisme_mindef_id']->renderRow(); ?>
      <?php echo $objForm['organisme_id']->renderRow(); ?>
      <?php echo $objForm['etat_partage_id']->renderRow(); ?>
      <?php echo $objForm['type_convention_organisme_id']->renderRow(); ?>
      <?php echo $objForm['cotutelle']->renderRow(); ?>
      <?php echo $objForm['cooperation']->renderRow(); ?>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_description_dossier") ?>
      </legend>

      <?php echo $objForm['fichier_pdf']->renderRow(); ?>
      <?php echo $objForm['fichier_editable']->renderRow(); ?>

    </fieldset>


    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>

</form>