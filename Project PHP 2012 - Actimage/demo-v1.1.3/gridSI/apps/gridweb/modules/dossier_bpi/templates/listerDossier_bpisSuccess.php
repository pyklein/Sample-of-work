<?php use_helper("Message"); ?>

<?php echo message(); ?>

<!-- Filtre -->
<div class="filtre">
  <form action="" method="post" name="filtre">
    <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_filtres') ?>
      </legend>

      <?php echo $objFormFiltre['autorite_decision_id']->renderRow(); ?>
      <?php echo $objFormFiltre['annee']->renderRow(); ?>
      <?php echo $objFormFiltre['nom_prenom_email']->renderRow(); ?>

      <p>
        <?php echo $objFormFiltre['titre']->renderLabel(); ?> :
        <?php echo $objFormFiltre['titre']->render(); ?>
        <?php echo $objFormFiltre['etou_titre']->render(); ?>
      </p>

      <?php echo $objFormFiltre['statut_dossier_bpi_id']->renderRow(); ?>
      <?php echo $objFormFiltre['est_clos']->renderRow(); ?>
      <?php echo $objFormFiltre['est_actif']->renderRow(); ?>


      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_filtrer"); ?>" />
        <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
      </div>
    </fieldset>
  </form>
</div>


<br />
<!-- Ajout -->
<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_dossier_bpi"), "dossier_bpi/creerDossier_bpi", array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_dossier_bpi"))); ?>
</div>

<!-- Liste -->
<?php if ($objPager->count() != 0): ?>

  <table class="mep">
      <caption>
        <?php echo libelle("msg_dossier_bpi_nombre_resultat", array($objPager->count())); ?>
      </caption>
  <thead>
    <tr>
      <th><?php echo libelle("msg_libelle_actions"); ?></th>
      <th><?php echo libelle("msg_libelle_numero"); ?></th>
      <th><?php echo libelle("msg_libelle_intitule"); ?></th>
      <th><?php echo libelle("msg_libelle_date_creation"); ?></th>
      <th><?php echo libelle("msg_libelle_inventeurs"); ?></th>
      <th><?php echo libelle("msg_libelle_statut"); ?></th>
      <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($objPager as $intCle => $objDossier) {
    ?>
      <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
        <td class="actions">
          <ul class="jsddm">
        <!-- Si le dossier est actif on affiche toutes les actions sinon juste l'activation -->
        <?php  if($objDossier->getEstActif() ){ ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/modifierDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
          <?php
          echo $objDossier->getEstActif() ?
                  link_to_grid_liste("", "dossier_bpi/changerActivationDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                  link_to_grid_liste("", "dossier_bpi/changerActivationDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
          ?>

          <?php echo link_to_grid_liste("", "dossier_bpi/actionsDossiers?dossier_bpi=" .$objDossier->getId() , array("class" => "picto_court bt_actions_a_mener" , "title" => libelle("msg_bouton_actions"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/listerBrevets?dossier_bpi_id=". $objDossier->getId(), array("class" => "picto_court bt_brevets" , "title" => libelle("msg_bouton_brevets"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/listerContrats?dossier_bpi_id=". $objDossier->getId(), array("class" => "picto_court bt_contrats" , "title" => libelle("msg_bouton_contrats"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/listerRedevances?dossier_bpi_id=". $objDossier->getId(), array("class" => "picto_court bt_redevances" , "title" => libelle("msg_bouton_redevances"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/alertesDossier_bpi?id=".$objDossier->getId(), array("class" => "picto_court bt_alertes" , "title" => libelle("msg_bouton_alertes"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/modifierContentieux?dossier_bpi_id=". $objDossier->getId(), array("class" => "picto_court bt_contentieux" , "title" => libelle("msg_bouton_contentieux"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/listerDocuments_bpis?dossier_bpi=". $objDossier->getId() , array("class" => "picto_court bt_documents" , "title" => libelle("msg_bouton_documents"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/listerRemarque_bpis?dossier_bpi_id=". $objDossier->getId(), array("class" => "picto_court bt_remarques" , "title" => libelle("msg_bouton_remarques"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/modifierRecompenses?dossier_bpi_id=". $objDossier->getId(), array("class" => "picto_court bt_recompenses" , "title" => libelle("msg_bouton_recompenses"))); ?>
          <?php echo link_to_grid_liste("", "dossier_bpi/lierDossiers_mip?dossier_bpi=". $objDossier->getId()."&start=true", array("class" => "picto_court bt_liaison","title" => libelle("msg_bouton_liaison"))); ?>
          <?php
          echo $objDossier->getEstClos() ?
                  link_to_grid_liste("", "dossier_bpi/rouvrirDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_rouvrir", "title" => libelle("msg_bouton_rouvrir"))):
                  link_to_grid_liste("", "dossier_bpi/cloreDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_clore", "title" => libelle("msg_bouton_clore")));
          ?>
		  <?php echo link_to_grid_liste("", "dossier_bpi/voirDescriptionDossier_bpi?id=". $objDossier->getId(), array("class" => "picto_court bt_voir" , "title" => libelle("msg_bouton_voir"))); ?>
        <?php }else { ?>
          <?php
          echo $objDossier->getEstActif() ?
                  link_to_grid_liste("", "dossier_bpi/changerActivationDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                  link_to_grid_liste("", "dossier_bpi/changerActivationDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
          ?>
        <?php } ?>
        <?php echo sfConfig::get('app_menus_deroulants') ? include_partial('interface/listeActions') : '' ?>
        </ul>
      </td>
      <td><?php echo $objDossier->getNumero(); ?></td>
      <td><?php echo $objDossier->getTitre(); ?></td>
      <td><?php echo $objDossier->getDateTimeObject('created_at')->format('d/m/Y'); ?></td>
      <td><?php
      foreach($objDossier->getInventeurs() as $inventeur){
        echo $inventeur;
        echo '<br />';
      }
      ?></td>
      <td><?php echo $objDossier->getStatut_dossier_bpi()->getIntitule(); ?></td>

      <td class="centre">
        <?php
        if($objDossier->getEstActif() ){
          echo $objDossier->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif");
          echo "/";
          echo $objDossier->getEstClos() ? libelle("msg_libelle_ferme") : libelle("msg_libelle_ouvert");
        }else{
          echo libelle("msg_libelle_inactif");
        }
        ?>
      </td>

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
      <?php echo libelle("msg_dossier_bpi_aucun_resultat"); ?>
    </caption>
  </table>

<?php endif; ?>
