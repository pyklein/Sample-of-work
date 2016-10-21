<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('onglet_contractualisation',array( 'type_dossier' => $type_dossier, 'dossierId' => $dossierId, 'ongletActif' => "1" )) ?>

<div id="zone_cadre">

  <?php if($conventionCollective){?>

  <?php include_partial('contractualisation_descriptionForm', array('objForm' => $objForm , 'objDossier' => $objDossier ,  'conventionCollective' => TRUE)) ?>
  
  <?php } else {  ?>
    <form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

      <?php include_partial('contractualisation_descriptionForm', array('objForm' => $objForm ,'conventionCollective' => FALSE)) ?>

      <div class="boutons">
        <input type="submit" value="<?php echo  libelle("msg_bouton_enregistrer"); ?>" name="bouton_recompenses" />
      </div>

    </form>
  <?php } ?>
</div>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/lister".$type_dossier."s", array("class" => "picto bt_retour")); ?>
</div>