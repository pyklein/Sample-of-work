
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php include_partial('interface/conteneurForme', array('action' => 'modifier', 'model' => 'Documents_bpi', 'objForm' => $objForm,'strModule' => $sf_context->getModuleName(),'strContenant' => $strContenant, 'idContenant' => $idContenant)) ?>
