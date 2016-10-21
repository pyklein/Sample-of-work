<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Entite',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName(),
            'strRedirectionComplete' => 'referentiel_bpi/creerInventeur/',
            ))
?>


<script type='text/javascript'>
  hideOtherOptionsOnSelectValue('<?php echo $objForm["organisme_mindef_id"]->renderId(); ?>', '<?php echo $objForm["entite_id"]->renderId(); ?>');
</script>
