<?php
include_partial('utilisateurs/popupCreerInnovateur',
        array('action' => 'creer',
            'model' => 'Utilisateur',
            'objForm' => $objForm ,
            'strModule' => $sf_context->getModuleName(),
            'strRedirectionComplete' => 'dossier_mip/modifierInnovateurs/',
            'strContenant' => 'dossier_mip',
            'idContenant' => $strDossierMipId))
?>

