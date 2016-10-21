
<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objContenant)) ?>


<?php use_helper("Message"); ?>
<?php echo message(); ?>



<?php include_partial('conteneurFormDocument',array('objForm' => $objForm,'strContenant'=>$strModelContenant,'idContenant'=>$strIdContenant,'action' => 'creer')) ?>