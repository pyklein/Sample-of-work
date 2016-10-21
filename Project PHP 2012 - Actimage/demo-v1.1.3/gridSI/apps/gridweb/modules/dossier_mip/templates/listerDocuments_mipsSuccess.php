<?php use_helper("Message"); ?>

<div class="reduit">

  <?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

  <?php echo message(); ?>

  <h4>
    <?php echo libelle("msg_libelle_documents_joints")?>
  </h4>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_document_joint"), "dossier_mip/creerDocument_mip_joint?".$strModelContenant."=".$objContenant->getId(), array("class" => "picto bt_ajouter")); ?>
  </div>

  <?php if ($objDocumentsJoints->count()!= 0): ?>
    <table class="mep">
      <th width="15%"><?php echo libelle("msg_libelle_action"); ?></th>
      <th width="30%"><?php echo libelle("msg_libelle_titre"); ?></th>
      <th width="35%"><?php echo libelle("msg_libelle_nom_fichier"); ?></th>
      <th width="20%"><?php echo libelle("msg_libelle_type_document"); ?></th>

      <?php foreach ($objDocumentsJoints as $intCle => $objDocumentJoint): ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("", "dossier_mip/telechargerDocument_mip_joint?id=".$objDocumentJoint->getId(), array("class" => "picto_court bt_telecharger","title" => libelle("msg_bouton_telecharger"))); ?>
            <?php echo link_to_grid("","dossier_mip/modifierDocument_mip_joint?id=".$objDocumentJoint->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_mip/supprimerDocument_mip_joint?id=".$objDocumentJoint->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_supprimer","title" =>libelle("msg_bouton_supprimer"))); ?>
          </td>
          <td>
            <?php echo $objDocumentJoint->getTitre(); ?>
          </td>
          <td>
            <?php echo $objDocumentJoint->getFichierOrig(); ?>
          </td>
          <td>
            <?php if($objDocumentJoint->getDocuments_mip_type_id()!= NULL): ?>
              <?php echo $objDocumentJoint->getDocuments_mip_type(); ?>
            <?php else: ?>
              <?php echo $objDocumentJoint->getAutre_type();?>
            <?php endif; ?>
          </td>
       <?php endforeach ?>
    </table>
  <?php else: ?>
      <table class="mep">
        <caption>
          <?php echo  libelle("msg_document_mip_joint_aucun_resultat"); ?>
        </caption>
      </table>

  <?php endif; ?>
  <br />

  <h4>
    <?php echo libelle("msg_libelle_documents_references")?>
  </h4>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_document_reference"),"dossier_mip/creerDocument_mip_reference?".$strModelContenant."=".$objContenant->getId(), array("class" => "picto bt_ajouter")); ?>
  </div>

  <?php if ($objDocumentsReferences->count()!= 0): ?>
    <table class="mep">
      <th width="15%"><?php echo libelle("msg_libelle_action"); ?></th>
      <th width="30%"><?php echo libelle("msg_libelle_titre"); ?></th>
      <th width="35%"><?php echo libelle("msg_libelle_nom_fichier"); ?></th>
      <th width="20%"><?php echo libelle("msg_libelle_type_document"); ?></th>

      <?php foreach ($objDocumentsReferences as $intCle => $objDocumentReference): ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("", "dossier_mip/telechargerDocument_mip_reference?id=".$objDocumentReference->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_telecharger","title" => libelle("msg_bouton_telecharger"))); ?>
            <?php echo link_to_grid("", "dossier_mip/modifierDocument_mip_reference?id=".$objDocumentReference->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_mip/supprimerDocument_mip_reference?id=".$objDocumentReference->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_supprimer","title" => libelle("msg_bouton_supprimer"))); ?>
          </td>
          <td>
            <?php echo $objDocumentReference->getTitre(); ?>
          </td>
          <td>
            <?php echo $objDocumentReference->getFichier(); ?>
          </td>
          <td>
            <?php if($objDocumentReference->getDocuments_mip_type_id()!= NULL): ?>
              <?php echo $objDocumentReference->getDocuments_mip_type(); ?>
            <?php else: ?>
              <?php echo $objDocumentReference->getAutre_type();?>
            <?php endif; ?>
          </td>
       <?php endforeach ?>
    </table>
  <?php else: ?>
    <table>
      <caption>
        <?php echo  libelle("msg_document_mip_reference_aucun_resultat"); ?>
      </caption>
    </table>

  <?php endif; ?>
</div>

<?php include_partial('autreActions',array('id' => $strId,'objDossier'=>$objContenant)) ?>

<hr class="clear">
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier_mip"), "dossier_mip/listerDossier_mips",array("class" => "picto bt_retour")) ?>
</div>