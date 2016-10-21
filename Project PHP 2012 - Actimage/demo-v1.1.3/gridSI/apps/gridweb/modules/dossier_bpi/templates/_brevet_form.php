<?php use_helper("Message"); ?>

<h3>
  <?php
    if($creer) {
      echo libelle('msg_libelle_ajout_brevet_dossier_bpi', array($objDossier->getTitre()));
    } else {
      echo libelle('msg_libelle_modifier_brevet_dossier_bpi', array($objDossier->getTitre()));
    }
  ?>
</h3>

<?php echo message(); ?>

<form action="" method="post">

  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_description_brevet')?>
    </legend>

    <?php echo $objForm['parent_id']->renderRow(); ?>
    <?php echo $objForm['numero_demande']->renderRow(); ?>
    <?php echo $objForm['numero_publication']->renderRow(); ?>
    <?php echo $objForm['titre']->renderRow(); ?>
    <?php echo $objForm['type_depot_id']->renderRow(); ?>
    <?php echo $objForm['phase_depot_brevet_id']->renderRow(); ?>
    <?php echo $objForm['pays_id']->renderRow(); ?>

  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_responsable')?>
    </legend>

    <?php echo $objForm['responsable_id']->renderRow(); ?>

  </fieldset>

   <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_frais_engages')?>
    </legend>

    <?php echo $objForm['date_reference']->renderRow(); ?>
    <?php echo $objForm['somme_frais']->renderRow(); ?>

  </fieldset>

   <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_reperes_temporels')?>
    </legend>

     <?php echo $objForm['date_decision_depot']->renderRow(); ?>
     <?php echo $objForm['date_objectif_depot']->renderRow(); ?>
     <?php echo $objForm['date_depot']->renderRow(); ?>
     <?php echo $objForm['date_rapport_recherche']->renderRow(); ?>
     <?php echo $objForm['date_obtention']->renderRow(); ?>
     <?php echo $objForm['date_rejet']->renderRow(); ?>
     <?php echo $objForm['date_cession']->renderRow(); ?>
     <?php echo $objForm['contrat_id']->renderRow(); ?>

  </fieldset>

    <div class="boutons">
      <input type="submit" value="<?php echo $creer ?  libelle("msg_bouton_ajouter_brevet") :  libelle("msg_bouton_modifier_brevet"); ?>" />
    </div>

</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerBrevets?dossier_bpi_id=" .$objDossier->getId(), array("class" => "picto bt_retour")); ?>
</div>