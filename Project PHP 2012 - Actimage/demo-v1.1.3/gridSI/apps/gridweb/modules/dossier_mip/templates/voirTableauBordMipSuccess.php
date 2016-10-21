<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>


<?php echo message(); ?>
<div>

<!--  Initialisation de variables-->
  <?php
    $nbDossiersNouveaux = sfConfig::get('app_nb_dossiers_nouveaux');
  ?>

 <!-- Liste des dossiers necessitant un contrôle-->
  <?php if ($objPager1->getNbResults() != 0) : ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_dossier_mip_dossiers_need_controle"); ?>
      </caption>
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_actions"); ?></th>
          <th><?php echo libelle("msg_libelle_numero"); ?></th>
          <th><?php echo libelle("msg_libelle_intitule"); ?></th>
          <th><?php echo libelle("msg_libelle_acronyme"); ?></th>
          <th><?php echo libelle("msg_libelle_date_creation"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($objPager1->getResults() as $intCle => $objDossier): ?>
          <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
            <td class="actions">
              <ul class="jsddm">
                <?php if ($objDossier->getEstActif()) : ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/modifierDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
                <?php endif; ?>
                <?php
                echo $objDossier->getEstActif() ?
                        link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                        link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
                ?>
                <?php echo link_to_grid_liste("", "dossier_mip/supprimerDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_supprimer"))); ?>
				<?php echo link_to_grid_liste("", "dossier_mip/listerDocuments_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_documents", 'title' => libelle("msg_bouton_documents"))); ?>
                <?php echo link_to_grid_liste("", "dossier_mip/listerRemarque_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_remarques", 'title' => libelle("msg_bouton_remarques"))); ?>
                <?php echo link_to_grid_liste("", "dossier_mip/listerEvenement_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_evenements", 'title' => libelle("msg_bouton_evenements"))); ?>
                <?php echo link_to_grid_liste("", "dossier_mip/controlerDossier_mip?id=" . $objDossier->getId() , array("class" => "picto_court bt_controles",'title' => libelle("msg_bouton_controle"))); ?>
				<?php echo link_to_grid_liste("", "dossier_mip/suiviFinancierDossier_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_suivi_financier",'title' => libelle("msg_bouton_suivi_financier"))); ?>
                <?php echo link_to_grid_liste("", "dossier_mip/genererLettres?id=" . $objDossier->getId(), array("class" => "picto_court bt_genererdocs", 'title' => libelle("msg_bouton_generer_lettres"))); ?>
				<?php echo link_to_grid_liste("", "dossier_mip/voirDescriptionDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_voir", 'title' => libelle("msg_bouton_voir"))); ?>
                <?php echo sfConfig::get('app_menus_deroulants') ? include_partial('interface/listeActions') : '' ?>
              </ul>
            </td>
            <td class="center"><?php echo $objDossier->getNumero(); ?></td>
            <td><?php echo $objDossier->getTitre(); ?></td>
            <td class="center"><?php echo $objDossier->getAcronyme(); ?></td>
            <td class="center"><?php echo formatDate($objDossier->getCreatedAt()); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <br>
    <?php if ($objPager1->haveToPaginate()) : ?>
        <?php include_partial('interface/paginateur', array('objPager' => $objPager1,'strUrlRedirection' => $strUrlRedirection, 'intIdPager' => 1)) ?>
    <?php endif; ?>

  <?php else: ?>
    <caption>
      <?php echo libelle("msg_dossier_mip_0_resultat"); ?>
    </caption>
  <?php endif; ?>

  <!-- Liste des dossiers nouveaux-->
  <?php if ($arrDossiersNouveaux->count() != 0) : ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_dossier_mip_derniers_ajoutes", array($nbDossiersNouveaux)); ?>
      </caption>
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_actions"); ?></th>
          <th><?php echo libelle("msg_libelle_numero"); ?></th>
          <th><?php echo libelle("msg_libelle_intitule"); ?></th>
          <th><?php echo libelle("msg_libelle_acronyme"); ?></th>
          <th><?php echo libelle("msg_libelle_date_creation"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($arrDossiersNouveaux as $intCle => $objDossier): ?>
          <?php if($intCle < $nbDossiersNouveaux):?>
            <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
              <td class="actions">
                <ul class="jsddm">
                  <?php if ($objDossier->getEstActif()) : ?>
                    <?php echo link_to_grid_liste("", "dossier_mip/modifierDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
                  <?php endif; ?>
                  <?php
                  echo $objDossier->getEstActif() ?
                          link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                          link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
                  ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/supprimerDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_supprimer"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/listerDocuments_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_documents", 'title' => libelle("msg_bouton_documents"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/listerRemarque_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_remarques", 'title' => libelle("msg_bouton_remarques"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/listerEvenement_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_evenements", 'title' => libelle("msg_bouton_evenements"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/controlerDossier_mip?id=" . $objDossier->getId() , array("class" => "picto_court bt_controles",'title' => libelle("msg_bouton_controle"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/suiviFinancierDossier_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_suivi_financier",'title' => libelle("msg_bouton_suivi_financier"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/genererLettres?id=" . $objDossier->getId(), array("class" => "picto_court bt_genererdocs", 'title' => libelle("msg_bouton_generer_lettres"))); ?>
				  <?php echo link_to_grid_liste("", "dossier_mip/voirDescriptionDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_voir", 'title' => libelle("msg_bouton_voir"))); ?>
                  <?php echo sfConfig::get('app_menus_deroulants') ? include_partial('interface/listeActions') : '' ?>
                </ul>
              </td>
              <td class="center"><?php echo $objDossier->getNumero(); ?></td>
              <td><?php echo $objDossier->getTitre(); ?></td>
              <td class="center"><?php echo $objDossier->getAcronyme(); ?></td>
              <td class="center"><?php echo formatDate($objDossier->getCreatedAt()); ?></td>
            </tr>
          <?php endif;?>
        <?php endforeach; ?>
      </tbody>
    </table>
  <br>
  <div class="left">
    <?php echo link_to(libelle("msg_bouton_voir_tous_dossiers"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_voir")); ?>
  </div>

  <?php else: ?>
    <caption>
      <?php echo libelle("msg_dossier_mip_0_resultat"); ?>
    </caption>
  <?php endif; ?>


  <!-- Liste des dossiers selon le pilote-->
  <?php if ($objPager2->getNbResults() != 0) : ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_dossier_mip_dossiers_selon_pilote"); ?>
      </caption>
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_actions"); ?></th>
          <th><?php echo libelle("msg_libelle_numero"); ?></th>
          <th><?php echo libelle("msg_libelle_intitule"); ?></th>
          <th><?php echo libelle("msg_libelle_acronyme"); ?></th>
          <th><?php echo libelle("msg_libelle_date_creation"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($objPager2->getResults() as $intCle => $objDossier): ?>
            <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
              <td class="actions">
                <ul class="jsddm">
                  <?php if ($objDossier->getEstActif()) : ?>
                    <?php echo link_to_grid_liste("", "dossier_mip/modifierDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
                  <?php endif; ?>
                  <?php
                  echo $objDossier->getEstActif() ?
                          link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                          link_to_grid_liste("", "dossier_mip/changerActivationDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
                  ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/supprimerDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_supprimer"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/listerDocuments_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_documents", 'title' => libelle("msg_bouton_documents"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/listerRemarque_mips?dossier_mip=" . $objDossier->getId(), array("class" => "picto_court bt_remarques", 'title' => libelle("msg_bouton_remarques"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/listerEvenement_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_evenements", 'title' => libelle("msg_bouton_evenements"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/controlerDossier_mip?id=" . $objDossier->getId() , array("class" => "picto_court bt_controles",'title' => libelle("msg_bouton_controle"))); ?>
				  <?php echo link_to_grid_liste("", "dossier_mip/suiviFinancierDossier_mips?dossier_mip=" . $objDossier->getId() , array("class" => "picto_court bt_suivi_financier",'title' => libelle("msg_bouton_suivi_financier"))); ?>
                  <?php echo link_to_grid_liste("", "dossier_mip/genererLettres?id=" . $objDossier->getId(), array("class" => "picto_court bt_genererdocs", 'title' => libelle("msg_bouton_generer_lettres"))); ?>
				  <?php echo link_to_grid_liste("", "dossier_mip/voirDescriptionDossier_mip?id=" . $objDossier->getId(), array("class" => "picto_court bt_voir", 'title' => libelle("msg_bouton_voir"))); ?>
                  <?php echo sfConfig::get('app_menus_deroulants') ? include_partial('interface/listeActions') : '' ?>
                </ul>
              </td>
              <td class="center"><?php echo $objDossier->getNumero(); ?></td>
              <td><?php echo $objDossier->getTitre(); ?></td>
              <td class="center"><?php echo $objDossier->getAcronyme(); ?></td>
              <td class="center"><?php echo formatDate($objDossier->getCreatedAt()); ?></td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <br>
    <?php if ($objPager2->havetoPaginate()) : ?>
        <?php include_partial('interface/paginateur', array('objPager' => $objPager2,'strUrlRedirection' => $strUrlRedirection, 'intIdPager' => 2)) ?>
    <?php endif; ?>

  <?php else: ?>
    <caption>
      <?php echo libelle("msg_dossier_mip_0_resultat"); ?>
    </caption>
  <?php endif; ?>

</div>
