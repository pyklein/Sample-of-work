<?php
include_partial('referentiel/popupCreerObjet',
        array('action' => 'creer',
            'model' => 'Statut_dossier_bpi',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName()
            ))
?>