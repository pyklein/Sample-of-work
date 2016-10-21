<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php if (isset($strIdCommission)): ?>
  <?php include_partial('dossier_mris/gestion_commissions',array('strId' => $strIdCommission, 'ongletActif' => 1)) ?>
<?php endif; ?>

<div>
  <div <?php if (!isset($creer)) {echo('id="zone_cadre"');} ?>>
    <form action="" method="post">
       <div class ="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
      </div>
      <fieldset>
        <legend>
          <?php echo libelle("msg_commission_type_date") ?>
        </legend>
        <?php echo $objForm['type_dossier_mris_id']->renderRow() ?>
        <?php echo $objForm['est_selection']->renderLabel() ?><b> : </b>
        <?php echo $objForm['est_selection']->render() ?>
        <?php echo $objForm['date_debut']->renderRow() ?>
        <?php echo $objForm['date_fin']->renderRow() ?>
      </fieldset>
      <fieldset>
        <legend><?php echo libelle("msg_commission_ordre_du_jour") ?></legend>
        <?php echo $objForm['est_suivi']->renderRow() ?>
        <?php echo $objForm['est_analyse']->renderRow() ?>
        <?php echo $objForm['ordre_jour']->renderRow() ?>
      </fieldset>
      <div class ="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
      </div>
    </form>
  </div>
  <div class="left">
      <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerCommissions", array("class" => "picto bt_retour")); ?>
  </div>
</div>