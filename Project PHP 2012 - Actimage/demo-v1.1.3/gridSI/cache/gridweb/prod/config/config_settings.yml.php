<?php
// auto-generated by sfDefineEnvironmentConfigHandler
// date: 2016/10/06 07:28:59
sfConfig::add(array(
  'sf_error_404_module' => 'authentification',
  'sf_error_404_action' => 'nonAutorise',
  'sf_login_module' => 'authentification',
  'sf_login_action' => 'seconnecter',
  'sf_secure_module' => 'authentification',
  'sf_secure_action' => 'nonAutorise',
  'sf_module_disabled_module' => 'default',
  'sf_module_disabled_action' => 'disabled',
  'sf_error_db_module' => 'sys',
  'sf_error_db_action' => 'erreurSgbdr',
  'sf_setup_module' => 'sys',
  'sf_setup_action' => 'setup',
  'sf_use_database' => true,
  'sf_i18n' => false,
  'sf_compressed' => false,
  'sf_check_lock' => false,
  'sf_csrf_secret' => '4f6bd923a33b6bf71f6a562ebd590939f73b647e',
  'sf_escaping_strategy' => true,
  'sf_escaping_method' => 'ESC_SPECIALCHARS',
  'sf_no_script_name' => false,
  'sf_cache' => false,
  'sf_etag' => true,
  'sf_web_debug' => false,
  'sf_error_reporting' => 341,
  'sf_file_link_format' => NULL,
  'sf_admin_web_dir' => '/sf/sf_admin',
  'sf_web_debug_web_dir' => '/sf/sf_web_debug',
  'sf_standard_helpers' => array (
  0 => 'Partial',
  1 => 'Cache',
  2 => 'Libelle',
  3 => 'LinkToGrid',
),
  'sf_enabled_modules' => array (
  0 => 'default',
),
  'sf_charset' => 'utf-8',
  'sf_logging_enabled' => false,
  'sf_default_culture' => 'en',
  'sf_projet_nom' => 'GRID',
  'sf_projet_version' => 'v1.0.4',
  'sf_arborescence' => array (
  'utilisateur_repertoire' => '/uploads',
  'etudiant_repertoire' => '/uploads',
  'modeles_documents_repertoire' => '/uploads',
  'convention_organisme_repertoire' => '/uploads',
  'fichiers_temporaires_repertoire' => '/temp',
  'dossier_mip_repertoire' => '/dossiers/MIP',
  'dossier_bpi_repertoire' => '/dossiers/BPI',
  'dossier_these_repertoire' => '/dossiers/MRIS/these',
  'dossier_postdoc_repertoire' => '/dossiers/MRIS/postdoc',
  'dossier_ere_repertoire' => '/dossiers/MRIS/ere',
  'documents_dossier_repertoire' => '/documents',
  'convention_dossier_repertoire' => '/documents',
  'import_ixarm_repertoire' => '/importation_iXarm',
  'import_ixarm_repertoire_courant' => '/importation_iXarm/courant',
  'fichiers_statiques' => 
  array (
    'fiche_inscription' => 'fichier_absent1.pdf',
    'grilles_evaluation' => 'fichier_absent2.pdf',
    'fiches_suivi' => 'fichier_absent3.pdf',
    'lettre_invitation_personne' => 'Invitation_Commission_personne_modele.rtf',
    'lettre_invitation_laboratoire' => 'Invitation_Commission_laboratoire_modele.rtf',
    'lettre_invitation_service' => 'Invitation_Commission_service_modele.rtf',
    'lettre_validation_refus' => 'Validation_Refus.rtf',
    'lettre_validation_refus_apres_attente' => 'Validation_Refus_ApresAttente.rtf',
    'lettre_validation_liste_attente' => 'Validation_ListeAttente.rtf',
    'lettre_validation_attestation' => 'Validation_attestation.rtf',
    'lettre_validation_acceptation_directe' => 'Validation_Directe.rtf',
    'lettre_validation_acceptation_apres_attente' => 'Validation_ApresAttente.rtf',
    'lettre_accompagnement_licence' => 'Lettre_Accompagnement_Licence.rtf',
    'lettre_accompagnement_copropriete' => 'Lettre_Accompagnement_Copropriete.rtf',
    'lettre_depot_dga' => 'Lettre_Depot_DGA.rtf',
    'lettre_depot_hors_dga' => 'Lettre_Depot_HorsDGA.rtf',
  ),
),
));
