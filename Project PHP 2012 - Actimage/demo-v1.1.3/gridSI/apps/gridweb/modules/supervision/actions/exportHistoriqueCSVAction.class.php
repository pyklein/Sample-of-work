<?php

/**
 * Export CSV de l'historique des connexions
 *
 * @author Julien GAUTIER
 */
class exportHistoriqueCSVAction extends gridAction {

  public function execute($request) {

    $objConnexionsListe = ConnexionTable::getInstance()->getListeConnexions();

    $strNomFichier = "export_supervision_historique_connexions_" . date("YmdHis") . ".csv";
    $objUtilCsv = new UtilCsv($strNomFichier);

    // en tete
    $objUtilCsv->ajouterValeur(libelle("msg_supervision_libelle_date"));
    $objUtilCsv->ajouterValeur(libelle("msg_supervision_libelle_compteur"));

    $objUtilCsv->ajouterLigne();

    foreach ($objConnexionsListe as $entreeHisto) {
      $objUtilCsv->ajouterValeur($entreeHisto['date_debut']);
      $objUtilCsv->ajouterValeur($entreeHisto['compteur']);
      $objUtilCsv->ajouterLigne();
    }

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();
  }

}
?>
