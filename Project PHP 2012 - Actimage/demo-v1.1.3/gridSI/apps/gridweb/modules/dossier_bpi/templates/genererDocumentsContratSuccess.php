<?php use_helper("Message"); ?>
<?php echo message(); ?>


  <?php if (count($objContrat->getSignataire()) > 0) { ?>
    <p class="underline">
      <?php echo libelle("msg_contrat_libelle_lettres_accomp"); ?> :
    </p>
    <ul>
      <?php foreach($objContrat->getSignataire() as $objSignataire) { ?>
        <?php if ($boolEstTypeLicence) { ?>
          <li>
            <?php echo $objSignataire->getOrganisme()->getIntitule(); ?> :
            <?php echo link_to_grid(libelle("msg_contrat_libelle_lettre_accomp_licence"), "dossier_bpi/genererDocumentsContrat?id=".$sf_params->get('id')."&organisme_id=".$objSignataire->getOrganisme()->getId()."&licence=true", array("class" => "picto bt_telecharger")); ?>
          </li>
        <?php } ?>
        <?php if ($boolEstTypeCoprop) { ?>
          <li>
            <?php echo $objSignataire->getOrganisme()->getIntitule(); ?> :
            <?php echo link_to_grid(libelle("msg_contrat_libelle_lettre_accomp_coprop"), "dossier_bpi/genererDocumentsContrat?id=".$sf_params->get('id')."&organisme_id=".$objSignataire->getOrganisme()->getId()."&copropriete=true", array("class" => "picto bt_telecharger")); ?>
          </li>
        <?php } ?>
      <?php } ?>
    </ul>
  <?php } ?>

<div class="left">
  <?php echo link_to_grid(libelle("msg_contrat_bouton_retournervers_contrat"), "dossier_bpi/listerContrats?dossier_bpi_id=".$objContrat->getDossierBpiId(), array("class" => "picto bt_retour")); ?>
</div>