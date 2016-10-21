
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objForm->getObject()->getDossier_mip())); ?>

<?php include_partial('interface/conteneurForme', array('action' => 'modifier', 'model' => 'Remarque_mip', 'objForm' => $objForm,'strModule' => $sf_context->getModuleName(), 'strContenant' => $strContenant, 'idContenant' => $idContenant)) ?>
