<?php use_helper("Message"); ?>

<?php echo message(); ?>


<p>
  <?php echo libelle('msg_libelle_generer_documents_brevet', array($objBrevet->getTitre())) ?>
</p

<!--Liste des documents pour les inventeurs-->

  <p class="underline">
    <?php echo libelle('msg_libelle_document_destination_inventeur') ?>
  </p>
  <ul>
    <?php
  foreach($objDossier->getInventeurs() as $inventeur){
        echo '<li>'. $inventeur .":" ;
        echo link_to_grid(libelle("msg_libelle_lettre_notification"),"referentiel_bpi/genererLettreDepotBrevet?id=".$objBrevet->getId()."&inventeur=".$inventeur->getId()."&dossier=".$objDossier->getId(),array("class" => "picto bt_telecharger")) ;
        echo '</li>' ;
      }
  ?>
</ul>


<!--Liste des documents pour les entités responsables-->

  <p class="underline">
    <?php echo libelle('msg_libelle_document_destination_entites_responsables') ?>
  </p>
  <ul>
  <li>
    <?php echo libelle('msg_libelle_hierarchie_locale') ?>
    :
    <?php echo link_to_grid(libelle("msg_libelle_lettre_notification"),"referentiel_bpi/genererLettreDepotBrevet?id=".$objBrevet->getId()."&entite=".$objDossier->getHierarchieLocaleId()."&dossier=".$objDossier->getId() ,array("class" => "picto bt_telecharger")) ?>
  </li>

  <li>
    <?php echo libelle('msg_libelle_autorite_decision') ?>
    :
    <?php echo link_to_grid(libelle("msg_libelle_autorite_decision"),"referentiel_bpi/genererLettreDepotBrevet?id=".$objBrevet->getId()."&entite=".$objDossier->getAutoriteDecisionId()."&dossier=".$objDossier->getId() ,array("class" => "picto bt_telecharger")) ?>
  </li>
</ul>

<div class="left">
  <?php echo link_to_grid(libelle("msg_bouton_retourner"), "dossier_bpi/listerBrevets?dossier_bpi_id=" . $objDossier->getId(), array("class" => "picto bt_retour")); ?>
</div>