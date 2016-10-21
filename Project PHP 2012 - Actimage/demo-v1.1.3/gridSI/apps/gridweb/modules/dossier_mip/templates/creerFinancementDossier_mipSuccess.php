<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php echo message();?>

<form action="" method="post">

  <fieldset>
    <legend>
      <?php echo libelle("msg_dossier_mip_financement_fieldset_description") ?>
    </legend>

    <?php
      echo $objForm['budget_type_id']->renderRow();
      echo $objForm['date_financement']->renderRow();
      echo $objForm['montant']->renderRow();
      echo $objForm['reference']->renderRow();
      echo $objForm['entite_id']->renderRow();
    ?>

  </fieldset>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle('msg_bouton_ajouter'); ?>" />
  </div>
</form>

<div class="left">
    <?php echo link_to(libelle("msg_dossier_mip_financement_bouton_retour"),"dossier_mip/listerFinancementDossier_mips?dossier_mip=".$objDossier->getId(),array("class" => "picto bt_retour")); ?>
</div>
