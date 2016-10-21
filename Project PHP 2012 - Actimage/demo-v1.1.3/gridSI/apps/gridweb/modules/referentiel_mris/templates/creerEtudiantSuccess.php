<?php use_helper("Message"); ?>
<?php echo message(); ?>


<?php //include_partial('interface/conteneurForme', array('action' => 'creer', 'model' => 'Etudiant', 'objForm' => $objForm ,'strModule' => $sf_context->getModuleName() )) ?>
<?php include_partial('etudiantFormInformation', array('action' => 'creer', 'model' => 'Etudiant', 'objForm' => $objForm, 'creer' => true )) ?>