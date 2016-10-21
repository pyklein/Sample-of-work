<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php include_partial('interface/conteneurForme', array('action' => 'modifier', 'model' => 'Remarque_bpi', 'objForm' => $objForm,'strModule' => $sf_context->getModuleName(), 'strContenant' => $strContenant, 'idContenant' => $idContenant)) ?>
