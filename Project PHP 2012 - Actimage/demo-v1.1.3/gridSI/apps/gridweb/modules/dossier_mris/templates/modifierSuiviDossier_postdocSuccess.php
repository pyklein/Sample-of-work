<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<div>
  <form action="" method="post">
    <fieldset>
      <legend>
          <?php echo libelle("msg_fieldset_suivi_description") ?>
      </legend>
          <?php echo $objForm['type_suivi_postdoc_id']->renderRow(); ?>
          <?php echo $objForm['descriptif']->renderRow(); ?>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_fieldset_suivi_dates") ?>
      </legend>
        <?php echo $objForm['date_demande']->renderRow(); ?>
        <?php echo $objForm['date_echeance']->renderRow(); ?>
        <?php echo $objForm['date_reception']->renderRow(); ?>
    </fieldset>


    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_suivi_modifier_element"); ?>" />
    </div>

  </form>
</div>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerSuivi_".$strModelContenant."s?".  strtolower($strModelContenant)."_id=".$idContenant, array('class'=>'picto bt_retour')); ?>
</div>