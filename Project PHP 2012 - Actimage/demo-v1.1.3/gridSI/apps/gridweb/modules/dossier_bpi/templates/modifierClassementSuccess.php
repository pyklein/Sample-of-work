<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objForm->getObject())); ?>

<?php echo message(); ?>

<?php include_partial('dossier_bpi/gestion_dossier_bpi',array('strId' => $strId, 'ongletActif' => 3, "estBrevetable" => $objForm->getObject()->getEstBrevetable())) ?>

<div id="zone_cadre" class="reduit">

  <form action="" method="post">
    <div class ="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
      <?php if ($objDocumentsJoints->count() != 0 || $objDocumentsReferences->count() != 0) { ?>

    <fieldset>
      <legend>
        <?php echo libelle("msg_bouton_documents") ?>
      </legend>

      <?php if ($objDocumentsJoints->count() != 0) { ?>

        <h4>
          <?php echo libelle("msg_libelle_documents_joints")?>
        </h4>

        <ul>
          <?php foreach ($objDocumentsJoints as $intCle => $objDocumentJoint) { ?>
            <li>
              <?php echo link_to_grid($objDocumentJoint->getTitre() ? $objDocumentJoint->getTitre() : $objDocumentJoint->getFichierOrig(), "dossier_bpi/telechargerDocument_bpi_joint?id=".$objDocumentJoint->getId(), array("title" => $objDocumentJoint->getFichierOrig(), "target" => "_blank")); ?>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>

      <?php if ($objDocumentsReferences->count() != 0) { ?>

        <h4>
          <?php echo libelle("msg_libelle_documents_references")?>
        </h4>

        <ul>
          <?php foreach ($objDocumentsReferences as $intCle => $objDocumentReference) { ?>
            <li>
              <?php echo link_to_grid($objDocumentReference->getTitre() ? $objDocumentReference->getTitre() : $objDocumentReference->getFichier(), "dossier_bpi/telechargerDocument_bpi_reference?id=".$objDocumentReference->getId(), array("title" => $objDocumentReference->getFichier(), "target" => "_blank")); ?>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>
    </fieldset>
  <?php } ?>
    
    <fieldset>
      <legend>
        <?php echo libelle("msg_classement_analyse") ?>
      </legend>
      <?php echo $objForm['est_brevetable']->renderLabel() ?><b> : </b>
      <?php echo $objForm['est_brevetable']->render() ?>
    </fieldset>
    <?php if($objForm->getObject()->getEstBrevetable()) : ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_classement_classement") ?>
      </legend>
      <?php if ($objForm['Classement_invention_inventeur']->count() > 0) : ?>
      <table class="mep">
        <thead>
          <tr>
            <th><?php echo libelle("msg_libelle_inventeur") ?></th>
            <th><?php echo libelle("msg_libelle_propose") ?></th>
            <?php if ($objForm->getObject()->getAutoriteDecisionId() != $objForm->getObject()->getHierarchieLocaleId()) : ?>
              <th><?php echo libelle("msg_libelle_hierarchie") ?></th>
              <th><?php echo libelle("msg_libelle_autorite") ?></th>
            <?php else : ?>
              <th><?php echo libelle("msg_libelle_autorite_hierarchie") ?></th>
            <?php endif; ?>
            <th><?php echo libelle("msg_libelle_final") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($objForm['Classement_invention_inventeur'] as $clef => $classement) : ?>
           <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
            <td><?php echo $classement['concerne_id'] ?></td>
            <td><?php echo $classement['classement_propose_id'] ?></td>
            <?php if ($objForm->getObject()->getAutoriteDecisionId() != $objForm->getObject()->getHierarchieLocaleId()) : ?>
             <td><?php echo $classement['classement_hierarchie_id'] ?></td>
             <td><?php echo $classement['classement_autorite_id'] ?></td>
            <?php else : ?>
             <td><?php echo $classement['classement_autorite_id'] ?></td>
            <?php endif; ?>
            <td><?php echo $classement['classement_final_id'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else : ?>
        <?php echo libelle('msg_classement_0_inventeur') ?>
      <?php endif; ?>
      <?php echo $objForm['date_classement']->renderRow() ?>
      <?php echo $objForm['date_classement_cnis']->renderRow() ?>
    </fieldset>
    <fieldset>
      <legend>
        <?php echo libelle("msg_classement_commentaire_contentieux") ?>
      </legend>
      <?php if ($boolContentieuxExist) :?>
        <br/>
        <?php echo libelle('msg_dossier_bpi_contentieux_exist');?>
        <br/>
      <?php endif; ?>
      <?php echo $objForm['commentaire_classement']->renderRow() ?>
    </fieldset>
    <?php endif; ?>
    <div class ="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
  </form>
</div>

<?php include_partial('autreActions',array('id' => $strId)) ?>

<hr class="clear" />
<div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>

