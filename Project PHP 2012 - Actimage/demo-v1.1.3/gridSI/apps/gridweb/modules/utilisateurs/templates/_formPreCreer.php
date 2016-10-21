<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>

<form action="<?php echo url_for('utilisateurs/preCreerUtilisateurs') ?>" method="post">
  
  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_email") ?>
    </legend>

    <?php echo $objForm['email']->renderRow();?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_utilisateur_fieldset_profils") ?>
    </legend>

    <?php echo $objForm['profils_list']->renderRow();?>

  </fieldset>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle('msg_utilisateur_bouton_nouveau_usr_profil') ?>" />
  </div>

</form>

&nbsp;
<div class="left">
    <?php echo link_to(libelle("msg_utilisateur_bouton_retour_liste"),"utilisateurs/listerUtilisateurs",array("class" => "picto bt_retour")); ?>
</div>
