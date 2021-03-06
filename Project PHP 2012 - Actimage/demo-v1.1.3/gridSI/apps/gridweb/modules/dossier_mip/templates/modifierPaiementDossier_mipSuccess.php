<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objPaiement->getDossier_mip())); ?>

<?php echo message();?>

<form action="" method="post">

  <fieldset>
    <legend>
      <?php echo libelle("msg_dossier_mip_paiement_fieldset_description") ?>
    </legend>

    <?php
      echo $objForm['date_paiement']->renderRow();
      echo $objForm['montant']->renderRow();
      echo $objForm['reference']->renderRow();
      echo $objForm['entite_id']->renderRow();
    ?>

  </fieldset>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle('msg_bouton_save'); ?>" />
  </div>
</form>

<div class="left">
    <?php echo link_to(libelle("msg_dossier_mip_paiement_bouton_retour"),"dossier_mip/listerPaiementDossier_mips?dossier_mip=".$objPaiement->getDossier_mip()->getId(),array("class" => "picto bt_retour")); ?>
</div>