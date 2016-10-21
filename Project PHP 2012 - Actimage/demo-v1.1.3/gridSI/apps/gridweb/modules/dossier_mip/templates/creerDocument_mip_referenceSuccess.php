<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php echo message(); ?>

<?php include_partial('interface/conteneurForme', array('action' => 'creer', 'model' => 'Documents_mip', 'objForm' => $objForm,'strModule' => $sf_context->getModuleName(),'strContenant' => $strContenant, 'idContenant' => $idContenant)) ?>

<script type="text/javascript">
  enableElementOnSelectValue("documents_mip_documents_mip_type_id", "", "documents_mip_autre_type");
</script>
