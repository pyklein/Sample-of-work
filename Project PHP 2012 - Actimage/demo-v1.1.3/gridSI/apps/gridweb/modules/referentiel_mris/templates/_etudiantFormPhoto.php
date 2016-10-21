<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>

<?php if (isset($strId)): ?>
  <?php include_partial('referentiel_mris/gestion_etudiant',array('strId' => $strId, 'ongletActif' => 2)) ?>
<?php endif; ?>

<div>
  <div id="zone_cadre">
    <form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
      
    <?php echo $objForm ?>
    
    <div class="boutons">
      <input type="submit" value=<?php echo libelle('msg_bouton_enregistrer'); ?> />
    </div>
    </form>
  </div>
  <div>
    <?php echo link_to(libelle("msg_etudiants_bouton_retour_liste"),'referentiel_mris/listerEtudiants',array("class" => "picto bt_retour"))  ?>
  </div>
</div>