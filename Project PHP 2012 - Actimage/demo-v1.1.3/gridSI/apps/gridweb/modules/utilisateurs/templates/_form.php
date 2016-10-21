<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>

<form action="<?php echo url_for('utilisateurs/'.($objForm->getObject()->isNew() ? 'creerUtilisateurs' : 'modifierUtilisateurs').(!$objForm->getObject()->isNew() ? '?id='.$objForm->getObject()->getId() : '')) ?>" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

  <?php if (!$objForm->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="post" />
  <?php endif; ?>

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
      echo $objForm['date_deces']->renderRow();
    ?>
    <?php if ($isProfilMIP):?>
      <?php echo $objForm['statut_id']->renderRow();?>
    <?php endif;?>
  </fieldset>

  <?php if ($isProfilCorMRIS) :?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_utilisateur_fieldset_domaine_sci") ?>
      </legend>

      <?php echo $objForm['domaines_scientifiques_list']->renderRow(); ?>

    </fieldset>
  <?php endif; ?>


  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_situation_coord") ?>
    </legend>

    <?php
      echo $objForm['email']->renderRow();
      echo $objForm['email2']->renderRow();
      echo $objForm['organisme_mindef_id']->renderRow();
      echo $objForm['entite_id']->renderRow();
      echo $objForm['grade_id']->renderRow();
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
      echo $objForm['ville_perso_id']->renderLabel()." : ";
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
    <input type="submit" value="<?php echo ($objForm->getObject()->isNew()) ? libelle('msg_bouton_ajouter') :  libelle('msg_bouton_save'); ?>" />
  </div>

  <script type='text/javascript'>
    hideOtherOptionsOnSelectValue('<?php echo $objForm["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objForm["entite_id"]->renderId(); ?>');
    hideOtherOptionGroupsOnSelectValue('<?php echo $objForm["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objForm["grade_id"]->renderId(); ?>');
  </script>

</form>
&nbsp;
<div class="left">
    <?php echo link_to(libelle("msg_utilisateur_bouton_retour_liste"),"utilisateurs/listerUtilisateurs",array("class" => "picto bt_retour")); ?>
</div>