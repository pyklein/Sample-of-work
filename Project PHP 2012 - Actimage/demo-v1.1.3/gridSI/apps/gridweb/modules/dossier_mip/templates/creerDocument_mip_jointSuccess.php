<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php echo message(); ?>

<?php include_partial('creerDocument_mip',array('objForm' => $objForm,'strContenant'=>$strContenant,'idContenant'=>$idContenant)) ?>