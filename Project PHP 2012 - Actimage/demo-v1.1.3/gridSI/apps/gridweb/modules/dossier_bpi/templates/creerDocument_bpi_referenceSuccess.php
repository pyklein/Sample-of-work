<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php echo message(); ?>

<?php include_partial('interface/conteneurForme', array('action' => 'creer', 'model' => 'Documents_bpi', 'objForm' => $objForm,'strModule' => $sf_context->getModuleName(),'strContenant' => $strContenant, 'idContenant' => $idContenant)) ?>
