<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php echo message(); ?>

<div class="reduit">
  <h4>
    <?php echo libelle("msg_libelle_documents_joints")?>
  </h4>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_document_joint"), "dossier_bpi/creerDocument_bpi_joint?".$strModelContenant."=".$objContenant->getId(), array("class" => "picto bt_ajouter")); ?>
  </div>

  <?php if ($objDocumentsJoints->count()!= 0): ?>
    <table class="mep">
      <th><?php echo libelle("msg_libelle_action"); ?></th>
      <th><?php echo libelle("msg_libelle_titre"); ?></th>
      <th><?php echo libelle("msg_libelle_nom_fichier"); ?></th>
      <th><?php echo libelle("msg_libelle_statut_associe"); ?></th>

      <?php foreach ($objDocumentsJoints as $intCle => $objDocumentJoint): ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("", "dossier_bpi/telechargerDocument_bpi_joint?id=".$objDocumentJoint->getId(), array("class" => "picto_court bt_telecharger","title" => libelle("msg_bouton_telecharger"))); ?>
            <?php echo link_to_grid("", "dossier_bpi/modifierDocument_bpi_joint?id=".$objDocumentJoint->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_bpi/supprimerDocument_bpi_joint?id=".$objDocumentJoint->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_supprimer","title" =>libelle("msg_bouton_supprimer"))); ?>
          </td>
          <td>
            <?php echo $objDocumentJoint->getTitre(); ?>
          </td>
          <td>
            <?php echo $objDocumentJoint->getFichierOrig(); ?>
          </td>
          <td>
            <?php echo $objDocumentJoint->getStatut_dossier_bpi(); ?>
          </td>
       <?php endforeach ?>
    </table>
  <?php else: ?>
      <table class="mep">
        <caption>
          <?php echo  libelle("msg_document_bpi_joint_aucun_resultat"); ?>
        </caption>
      </table>

  <?php endif; ?>
  <br/>
  <br/>

  <h4>
    <?php echo libelle("msg_libelle_documents_references")?>
  </h4>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_document_reference"),"dossier_bpi/creerDocument_bpi_reference?".$strModelContenant."=".$objContenant->getId(), array("class" => "picto bt_ajouter")); ?>
  </div>

  <?php if ($objDocumentsReferences->count()!= 0): ?>
    <table class="mep">
      <th><?php echo libelle("msg_libelle_action"); ?></th>
      <th><?php echo libelle("msg_libelle_titre"); ?></th>
      <th><?php echo libelle("msg_libelle_nom_fichier"); ?></th>
      <th><?php echo libelle("msg_libelle_statut_associe"); ?></th>

      <?php foreach ($objDocumentsReferences as $intCle => $objDocumentReference): ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("", "dossier_bpi/telechargerDocument_bpi_reference?id=".$objDocumentReference->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_telecharger","title" => libelle("msg_bouton_telecharger"))); ?>
            <?php echo link_to_grid("", "dossier_bpi/modifierDocument_bpi_reference?id=".$objDocumentReference->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_bpi/supprimerDocument_bpi_reference?id=".$objDocumentReference->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_supprimer","title" => libelle("msg_bouton_supprimer"))); ?>
          </td>
          <td>
            <?php echo $objDocumentReference->getTitre(); ?>
          </td>
          <td>
            <?php echo $objDocumentReference->getFichier(); ?>
          </td>
          <td>
            <?php echo $objDocumentReference->getStatut_dossier_bpi(); ?>
          </td>
       <?php endforeach ?>
    </table>
  <?php else: ?>
    <table>
      <caption>
        <?php echo  libelle("msg_document_bpi_reference_aucun_resultat"); ?>
      </caption>
    </table>

  <?php endif; ?>
</div>

<?php include_partial('autreActions',array('id' => $strId)) ?>

<hr class="clear">
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis",array("class" => "picto bt_retour")) ?>
</div>