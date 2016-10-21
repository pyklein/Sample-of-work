<?php use_helper("Message"); ?>


<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objContenant)) ?>


<?php echo message(); ?>

<div class="reduit">

  <h4>
      <?php echo libelle("msg_libelle_documents_joints")?>
  </h4>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_document_joint"),"dossier_mris/creerDocument_joint?".strtolower($strModelContenant)."=".$objContenant->getId(), array("class" => "picto bt_ajouter")); ?>
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
            <?php echo link_to_grid("", "dossier_mris/telechargerDocument?id=".$objDocumentJoint->getId(), array("class" => "picto_court bt_telecharger","title" => libelle("msg_bouton_telecharger"))); ?>
            <?php echo link_to_grid("","dossier_mris/modifierDocument?id=".$objDocumentJoint->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_mris/supprimerDocument?id=".$objDocumentJoint->getId(), array("class" => "picto_court bt_supprimer","title" =>libelle("msg_bouton_supprimer"))); ?>
          </td>
          <td>
            <?php echo $objDocumentJoint->getTitre(); ?>
          </td>
          <td>
            <?php echo $objDocumentJoint->getFichierOrig(); ?>
          </td>
          <td>
            <?php if($objDocumentJoint->getDocument_type_id()!= NULL): ?>
              <?php echo $objDocumentJoint->getDocument_type()->getIntitule(); ?>
            <?php else: ?>
              <?php echo $objDocumentJoint->getAutre_type();?>
            <?php endif; ?>
          </td>
       <?php endforeach ?>
    </table>
  <?php else: ?>
      <table class="mep">
        <caption>
          <?php echo  libelle("msg_document_joint_aucun_resultat"); ?>
        </caption>
      </table>

  <?php endif; ?>
  <br/>
  <br/>

  <h4>
    <?php echo libelle("msg_libelle_documents_references")?>
  </h4>

  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_nouveau_document_reference"),"dossier_mris/creerDocument_reference?".strtolower($strModelContenant)."=".$objContenant->getId(), array("class" => "picto bt_ajouter")); ?>
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
            <?php echo link_to_grid("", "dossier_mris/telechargerDocument?id=".$objDocumentReference->getId(), array("class" => "picto_court bt_telecharger","title" => libelle("msg_bouton_telecharger"))); ?>
            <?php echo link_to_grid("", "dossier_mris/modifierDocument?id=".$objDocumentReference->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_mris/supprimerDocument?id=".$objDocumentReference->getId(), array("class" => "picto_court bt_supprimer","title" => libelle("msg_bouton_supprimer"))); ?>
          </td>
          <td>
            <?php echo $objDocumentReference->getTitre(); ?>
          </td>
          <td>
            <?php echo $objDocumentReference->getFichier(); ?>
          </td>
          <td>
            <?php if($objDocumentReference->getDocument_type_id()!= NULL): ?>
              <?php echo $objDocumentReference->getDocument_type()->getIntitule(); ?>
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

<?php include_partial('autreActionsMris',array('strNomModel'=>$strModelContenant, 'id' => $strId)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"),"dossier_mris/lister".$strModelContenant."s",array("class" => "picto bt_retour")) ?>
</div>