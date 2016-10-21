<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>

<form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_info_identite") ?>
    </legend>

    <?php
      echo $objForm['civilite_id']->renderRow();
      echo $objForm['nom']->renderRow();
      echo $objForm['nom_jeunefille']->renderRow();
      echo $objForm['prenom']->renderRow();
    ?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_dates") ?>
    </legend>

    <?php
      echo $objForm['date_naissance']->renderRow();
    ?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_situation_coord") ?>
    </legend>

    <?php
      echo $objForm['email']->renderRow();
      echo $objForm['email2']->renderRow();
      echo $objForm['telephone_fixe']->renderRow();
      echo $objForm['telephone_mobile']->renderRow();
      echo $objForm['telephone_autre']->renderRow();
      echo $objForm['fax']->renderRow();
    ?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_coord_perso") ?>
    </legend>

    <?php
      echo $objForm['email_perso']->renderRow();
      echo $objForm['adresse_perso']->renderRow();
      echo $objForm['adresse_perso2']->renderRow();
      echo $objForm['adresse_perso3']->renderRow();
      echo $objForm['code_postal_perso']->renderRow();
      echo $objForm['ville_perso_id']->renderLabel();
      echo $objForm['ville_perso_id']->renderError();
      echo $objForm['ville_perso_id']->render(array('class' => 'ville'));
      echo $objForm['complement_adresse_perso']->renderLabel()." : ";
      echo $objForm['complement_adresse_perso']->renderError();
      echo $objForm['complement_adresse_perso']->render(array('class' => 'complement'));
      echo $objForm['telephone_fixe_perso']->renderRow();
      echo $objForm['telephone_mobile_perso']->renderRow();
    ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_photo") ?>
    </legend>

    <?php echo $objForm['photographie']->renderRow();?>

  </fieldset>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle('msg_bouton_save'); ?>" />
  </div>

</form>
&nbsp;
