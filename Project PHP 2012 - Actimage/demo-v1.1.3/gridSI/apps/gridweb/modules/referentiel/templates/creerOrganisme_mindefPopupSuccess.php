<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Organisme_mindef',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName(),
            'strRedirectionComplete' => 'referentiel_bpi/creerInventeur/',
            ))
?>