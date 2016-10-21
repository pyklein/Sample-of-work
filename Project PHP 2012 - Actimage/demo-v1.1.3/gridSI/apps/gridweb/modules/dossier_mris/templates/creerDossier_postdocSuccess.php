
<?php use_helper("Message"); ?>
<?php echo message(); ?>


<div>
    <form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" '?>>
      <fieldset>
        <legend>
            <?php echo libelle("msg_fieldset_identification") ?>
        </legend>
            <?php echo $objForm['numero_provisoire']->renderRow(); ?>
            <?php echo $objForm['numero_definitif']->renderRow(); ?>
            <?php echo $objForm['titre']->renderRow(); ?>
            <?php echo $objForm['objet']->renderRow(); ?>
            <?php echo $objForm['domaine_scientifique_id']->renderRow(); ?>
            <?php echo $objForm['organisme_mindef_id']->renderRow(); ?>
            <?php echo $objForm['organisme_id']->renderRow(); ?>
            <?php echo $objForm['etat_partage_id']->renderRow(); ?>
            <?php echo $objForm['cotutelle']->renderRow(); ?>
            <?php echo $objForm['cooperation']->renderRow(); ?>

      </fieldset>

      <fieldset>
        <legend>
          <?php echo libelle("msg_fieldset_description") ?>
        </legend>
          <?php echo $objForm['fichier_pdf']->renderRow(); ?>
          <?php echo $objForm['fichier_editable']->renderRow(); ?>
      </fieldset>


      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
      </div>

    </form>
  </div>
  
  <div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerDossier_postdocs", array('class'=>'picto bt_retour')); ?>
  </div>


