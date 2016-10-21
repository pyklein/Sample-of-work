<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php include_partial('interface/conteneurForme', array('action' => 'modifier', 'model' => 'Dossier_bpi', 'objForm' => $objForm,'strModule' => $sf_context->getModuleName())) ?>