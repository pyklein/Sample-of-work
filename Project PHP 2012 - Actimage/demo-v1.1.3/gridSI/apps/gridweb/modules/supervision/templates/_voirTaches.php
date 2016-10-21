
<?php use_helper("Libelle"); ?>
<?php use_helper("Format"); ?>

<table class="mep">
  <thead>
    <tr>
      <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
      <th width="25%"><?php echo libelle("msg_libelle_nom") ?></th>
      <th width="60%"><?php echo libelle("msg_libelle_derniere_execution") ?></th>
      <th width="10%"><?php echo libelle("msg_libelle_statut") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php $intI = 0; ?>
    <?php foreach($arrTaches as $strCle => $objTache) { ?>

      <tr class="<?php echo $intI % 2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php echo $objTache != null && $objTache->isRunning() ?
                  link_to_grid("", "supervision/arreterTache?cle=".$strCle, array("title" => libelle("msg_bouton_arreter"), "class" => "picto_court bt_supprimer", "id" => "bt_arreter_".$strCle)) :
                  link_to_grid("", "supervision/lancerTache?cle=".$strCle, array("title" => libelle("msg_bouton_lancer"), "class" => "picto_court bt_relance", "id" => "bt_lancer_".$strCle)); ?>
        </td>
        <td>
          <?php
            switch($strCle) {
              case TacheTable::CREATION_ALERTES_BPI:     echo libelle("msg_tache_alertes_bpi"); break;
              case TacheTable::CREATION_MAIL_DE_RELANCE: echo libelle("msg_tache_relances_mip"); break;
              case TacheTable::ENVOI_MAILS:              echo libelle("msg_tache_mails"); break;
              case TacheTable::GRID_TEST_UNIT:           echo libelle("msg_tache_test_unit"); break;
              case TacheTable::IMPORTATION_MRIS:         echo libelle("msg_tache_importation_mris"); break;
              case TacheTable::PURGE_SESSION:            echo libelle("msg_tache_purgesession"); break;
              case TacheTable::RECUPERATION_DOSSIER_FTP: echo libelle("msg_tache_recuperation_dossier_ftp"); break;
              case TacheTable::TACHE_A_TUER:             echo "Tâche à tuer"; break;
            }
          ?>
        </td>
        <td>
          <?php if ($objTache != null) { ?>
            <div class="tache <?php echo $objTache->isRunning() ? "warning" : ($objTache->getErreur() ? "ko" : "ok"); ?>"></div>
          <?php } ?>
          <?php echo $objTache != null ? libelle("msg_libelle_date_heure", array(formatDate($objTache->getDebut()), formatHeure($objTache->getDebut()))) : libelle("msg_libelle_jamais"); ?>
          <?php if ($objTache != null && $objTache->getResultat()) { ?>
            <div class="<?php echo $objTache->getErreur() ? "rouge " : "vert " ?>smaller">
              <?php echo $objTache->getRaw('resultat'); ?>
            </div>
          <?php } ?>
        </td>
        <td>
          <?php echo $objTache != null && $objTache->isRunning() ? libelle("msg_libelle_en_cours_execution") : libelle("msg_libelle_pret"); ?>
        </td>
      </tr>

      <?php $intI++; ?>
    <?php } ?>
  </tbody>
</table>
