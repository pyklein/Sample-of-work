<?php use_stylesheets_for_form($objForm) ?>

<?php use_helper("Message"); ?>
<?php echo message();?>

<form action="" method="post">


  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_info_identite") ?>
    </legend>

    <?php
      echo $objForm['civilite_id']->renderRow(array('disabled'=> true));
      echo $objForm['nom']->renderRow(array('disabled'=> true));
      echo $objForm['nom_jeunefille']->renderRow(array('disabled'=> true));
      echo $objForm['prenom']->renderRow(array('disabled'=> true));
    ?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_dates") ?>
    </legend>

    <?php
      echo $objForm['date_naissance']->renderRow(array('disabled'=> true));
      echo $objForm['date_deces']->renderRow(array('disabled'=> true));
    ?>

     <?php echo $objForm['statut_id']->renderRow(array('disabled'=> true));?>

  </fieldset>


  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_situation_coord") ?>
    </legend>

    <?php
      echo $objForm['email']->renderRow(array('disabled'=> true));
      echo $objForm['email2']->renderRow(array('disabled'=> true));
      echo $objForm['organisme_mindef_id']->renderRow(array('disabled'=> true));
      echo $objForm['entite_id']->renderRow(array('disabled'=> true));
      echo $objForm['grade_id']->renderRow(array('disabled'=> true));
      echo $objForm['telephone_fixe']->renderRow(array('disabled'=> true));
      echo $objForm['telephone_mobile']->renderRow(array('disabled'=> true));
      echo $objForm['telephone_autre']->renderRow(array('disabled'=> true));
    ?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_coord_perso") ?>
    </legend>

    <?php
      echo $objForm['email_perso']->renderRow(array('disabled'=> true));
      echo $objForm['adresse_perso']->renderRow(array('disabled'=> true));
      echo $objForm['adresse_perso2']->renderRow(array('disabled'=> true));
      echo $objForm['adresse_perso3']->renderRow(array('disabled'=> true));
      echo $objForm['code_postal_perso']->renderRow(array('disabled'=> true));
      echo $objForm['ville_perso_id']->renderLabel()." : ";
      echo $objForm['ville_perso_id']->renderError();
      echo $objForm['ville_perso_id']->render(array('disabled'=> true, 'class' => 'ville'));
      echo $objForm['complement_adresse_perso']->renderLabel()." : ";
      echo $objForm['complement_adresse_perso']->renderError();
      echo $objForm['complement_adresse_perso']->render(array('disabled'=> true, 'class' => 'complement'));
      echo $objForm['telephone_fixe_perso']->renderRow(array('disabled'=> true));
      echo $objForm['telephone_mobile_perso']->renderRow(array('disabled'=> true));
    ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_photo") ?>
    </legend>

    <?php echo $objForm['photographie']->renderRow(array('disabled'=> true));?>

  </fieldset>

</form>
&nbsp;
<div class="left">
    <?php echo link_to(libelle("msg_utilisateur_bouton_retour_liste"),"utilisateurs/rechercherInnovateurs",array("class" => "picto bt_retour")); ?>
</div>