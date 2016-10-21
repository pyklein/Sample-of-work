<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Statut_dossier_mip',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName(),
            'strRedirectionComplete' => 'referentiel_mip/creerStatut_Dossier_mip/',
            ))
?>