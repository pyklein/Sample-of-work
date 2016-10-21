<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>

  <!--Formulaire pour ajouter un date d'envoi-->
  <form action="" method="post">
        <?php echo $objForm ?>
      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer"); ?>" />
      </div>

  </form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), 'dossier_mris/suiviCommissionDossier?'.$strContenant.'_id='.$idContenant.'&commission_id='.$strIdCommission, array("class" => "picto bt_retour")); ?>
</div>