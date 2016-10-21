<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($objDossier)); ?>
</h3>

<?php echo message(); ?>

<div class="reduit">

  <div class="right">
    <?php echo link_to_grid(libelle("msg_contrat_bouton_nouveau"), "dossier_bpi/creerContrat?dossier_bpi_id=".$objDossier->getId(), array("class" => "picto bt_ajouter", "title" => libelle("msg_contrat_bouton_ajouter"))); ?>
  </div>

  <?php if ($objPager->count() != 0): ?>

    <table class="mep">
        <caption>
          <?php echo libelle("msg_contrat_nombre_resultat", array($objPager->count())); ?>
        </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_contrat_libelle_date_redaction"); ?></th>
        <th><?php echo libelle("msg_libelle_types"); ?></th>
        <th><?php echo libelle("msg_contrat_libelle_signataire"); ?></th>
        <th><?php echo libelle("msg_libelle_statut"); ?></th>
        <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager as $intCle => $objContrat) {
      ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>

          <?php  if($objContrat->getEstActif() ){ ?>
            <?php echo link_to_grid("", "dossier_bpi/modifierContrat?contrat_id=" . $objContrat->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
            <?php
            echo $objContrat->getEstActif() ?
                    link_to_grid("", "dossier_bpi/changerActivationContrat?id=" . $objContrat->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                    link_to_grid("", "dossier_bpi/changerActivationContrat?id=" . $objContrat->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
            ?>

            <?php
              if ($objContrat->peutAvoirDocumentsAGenerer())
              {
                echo link_to_grid("", "dossier_bpi/genererDocumentsContrat?id=".$objContrat->getId(), array("class" => "picto_court bt_genererdocs" , "title" => libelle("msg_bouton_documents")));
              }
            ?>

          <?php }else { ?>
            <?php
            echo $objContrat->getEstActif() ?
                    link_to_grid("", "dossier_bpi/changerActivationContrat?id=" . $objContrat->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                    link_to_grid("", "dossier_bpi/changerActivationContrat?id=" . $objContrat->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
            ?>
          <?php } ?>

        </td>
        <td><?php echo ($objContrat->getDateRedaction()) ? formatDate($objContrat->getDateRedaction()) : ""; ?></td>

        <td>
          <ul>
            <?php foreach ($objContrat->getType_contrats() as $objTypeContrat) :?>
              <li><?php echo $objTypeContrat->getIntitule(); ?></li>
            <?php endforeach;?>
          </ul>
        </td>

        <td>
          <ul>
            <?php foreach ($objContrat->getSignataire() as $objSignataire) :?>
              <li>
                <?php
                  echo $objSignataire->getOrganisme()->getIntitule();
                  echo (($objSignataire->getService() && $objSignataire->getService()->getIntitule()) ? " (".$objSignataire->getService()->getIntitule().")" : "");
                ?>
              </li>
            <?php endforeach;?>
          </ul>
        </td>

        <td><?php echo $objContrat->getStatut_contrat()->getIntitule(); ?></td>

        <td><?php echo $objContrat->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>

      </tr>


      <?php } ?>
      </tbody>
    </table>

    <?php if ($objPager->haveToPaginate()) : ?>
      <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
    <?php endif; ?>

    <?php if ($objPager->count() > 0) : ?>
      <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
    <?php endif; ?>
  
  <?php else: ?>
      <table class="mep">
        <caption>
          <?php echo libelle("msg_contrat_aucun_resultat"); ?>
        </caption>
      </table>

  <?php endif; ?>

  </div>
<?php include_partial('autreActions',array('id' => $objDossier->getId())) ?>

<hr class="clear">

  <div class="left">
      <?php echo link_to_grid(libelle("msg_bouton_retour_dossier"),"dossier_bpi/listerDossier_bpis" , array("class" => "picto bt_retour")); ?>
  </div>



