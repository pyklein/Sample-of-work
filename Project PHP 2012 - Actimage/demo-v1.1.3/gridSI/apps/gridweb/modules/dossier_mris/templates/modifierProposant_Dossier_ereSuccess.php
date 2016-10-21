<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php include_partial('dossier_mris/modifierProposantMRIS',array(
    'strTypeDossier' => 'Dossier_ere',
    'strId' => $strId,
    'objEtudiantForm' => $objEtudiantForm,
    'objDossierForm' => $objDossierForm,
    'boolIsAdminMris' => $boolIsAdminMris )) ?>



