<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>
<?php use_stylesheets_for_form($objFormFiltre) ?>
<?php use_javascripts_for_form($objFormFiltre) ?>

<?php echo message(); ?>

<!-- Filtre -->
<div class="filtre">
  <form action="" method="post" name="filtre">
    <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_filtres') ?>
      </legend>

      <?php echo $objFormFiltre['organisme_mindef_id']->renderRow(); ?>
      <?php echo $objFormFiltre['annee']->renderRow(); ?>
      <?php echo $objFormFiltre['statut_dossier_mip_id']->renderRow(); ?>
      <?php echo $objFormFiltre['nom_prenom_email']->renderRow(); ?>
      <?php echo $objFormFiltre['numero']->renderRow(); ?>
      <?php echo $objFormFiltre['statut_projet']->renderRow(); ?>
      
        <p>
          <?php echo $objFormFiltre['titre']->renderLabel(); ?> :
          <?php echo $objFormFiltre['titre']->render(); ?>
          <?php echo $objFormFiltre['etou_titre']->render(); ?>
        </p>
        <p>
          <?php echo $objFormFiltre['acronyme']->renderRow(); ?>
        </p>
        <p>
          <?php echo $objFormFiltre['descriptif']->renderLabel(); ?> :
          <?php echo $objFormFiltre['descriptif']->render(); ?>
          <?php echo $objFormFiltre['etou_descriptif']->render(); ?>
        </p>
        <p>
          <?php echo $objFormFiltre['dossier_vivant']->renderRow(); ?>
        </p>
      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_filtrer"); ?>" />
        <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
      </div>
    </fieldset>
  </form>
</div>

<!-- Bouton ajouter -->
<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_dossier_mip"), "dossier_mip/creerDossier_mip", array("class" => "picto bt_ajouter")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_export_csv"), "dossier_mip/exporterDossier_mipsCSV", array("class" => "picto bt_export_csv")); ?>
</div>

<!-- Liste -->
<?php if ($objPager->count() != 0) : ?>
  <table class="mep_mip">
    <caption>
      <?php echo libelle("msg_dossier_mip_nombre_resultat", array($objPager->getNbResults())); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_numero"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule"); ?></th>
        <th><?php echo libelle("msg_libelle_acronyme"); ?></th>
        <th><?php echo libelle("msg_libelle_date_creation"); ?></th>
        <th><?php echo libelle("msg_libelle_innovateurs"); ?></th>
        <th><?php echo libelle("msg_libelle_statut_dossier"); ?></th>
        <th><?php echo libelle("msg_libelle_organisme_armee"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $intCle => $objDossier) { ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td class="actions">
            <ul class="jsddm">
              <?php if ((($objDossier->getPiloteId() == $sf_user->getUtilisateur()->getId()) || ($sf_user->hasCredential('SUP-MIP') )) && ($objDossier->getEstActif())) : ?>
                <?php echo link_to_grid_liste("", "dossier_mip/modifierDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
              <?php endif; ?>
			  <!--
              <?php
              echo $objDossier->getEstActif() ?
                      link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                      link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
              ?>
			  -->
              <?php echo link_to_grid_liste("", "dossier_mip/supprimerDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_supprimer"))); ?>
			  <?php if (!$objDossier->estPreProjet()) echo link_to_grid_liste("", "dossier_mip/listerDocuments_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_documents", 'title' => libelle("msg_bouton_documents"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mip/listerRemarque_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_remarques", 'title' => libelle("msg_bouton_remarques"))); ?>
              <?php echo link_to_grid_liste("", "dossier_mip/listerEvenement_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_evenements", 'title' => libelle("msg_bouton_evenements"))); ?>
              <?php if (!$objDossier->estPreProjet()) echo link_to_grid_liste("", "dossier_mip/controlerDossier_mip?id=" . $objDossier->getId() , array("class" => "picto_court bt_controles",'title' => libelle("msg_bouton_controle"))); ?>
              <?php if (!$objDossier->estPreProjet()) echo link_to_grid_liste("", "dossier_mip/suiviFinancierDossier_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_suivi_financier",'title' => libelle("msg_bouton_suivi_financier"))); ?>         
              <?php echo link_to_grid_liste("", "dossier_mip/genererLettres?id=" . $objDossier->getId(), array("class" => "picto_court bt_genererdocs", 'title' => libelle("msg_bouton_generer_lettres"))); ?>
			  <?php if (!$objDossier->estPreProjet()) echo link_to_grid_liste("", "dossier_mip/voirDescriptionDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_voir", 'title' => libelle("msg_bouton_voir"))); ?>
              <?php echo sfConfig::get('app_menus_deroulants') ? include_partial('interface/listeActions') : '' ?>
            </ul>
          </td>
          <td><?php echo $objDossier->estPreProjet()? $objDossier['Statut_projet_mip'] : $objDossier->getNumero(); ?></td>
          <td><?php echo $objDossier->getTitre(); ?></td>
          <td><?php echo $objDossier->getAcronyme(); ?></td>
          <td><?php echo formatDate($objDossier->getCreatedAt()); ?></td>
          <td>
            <?php foreach ($objDossier->getInnovateurs() as $innovateur): ?>
              <?php echo $innovateur ?><br/>
            <?php endforeach; ?>
          </td>
          <td><?php echo $objDossier['Statut_dossier_mip']; ?></td>
          <td><?php echo $objDossier['Organisme_mindef']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

<?php else: ?>

  <table class="mep">
    <caption>
      <?php echo libelle("msg_dossier_mip_0_resultat"); ?>
    </caption>
  </table>

<?php endif; ?>

<?php if ($objPager->haveToPaginate()) : ?>
  <?php include_partial('interface/paginateur', array('objPager' => $objPager, 'strUrlRedirection' => $strUrlRedirection)) ?>
<?php endif; ?>

<?php if ($objPager->count() > 0) : ?>
  <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
<?php endif; ?>
