<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="<?php echo url_for('referentiel_mris/'.($objForm->getObject()->isNew() ? 'creerIntervenant' : 'modifierIntervenant').(!$objForm->getObject()->isNew() ? '?id='.$objForm->getObject()->getId() : '')) ?>" method="post" >
  <?php include_partial('intervenantForm', array('action' => 'modifier', 'model' => 'Intervenant', 'objForm' => $objForm)) ?>

  <div class="boutons">
    <input type="submit" value="<?php echo ($objForm->getObject()->isNew()) ? libelle('msg_bouton_ajouter') :  libelle('msg_bouton_enregistrer'); ?>" />
  </div>

  &nbsp;

  <?php echo link_to_grid(libelle("msg_intervenant_bouton_retour"),'referentiel_mris/listerIntervenants', array('class'=>'picto bt_retour'))  ?>
</form>
