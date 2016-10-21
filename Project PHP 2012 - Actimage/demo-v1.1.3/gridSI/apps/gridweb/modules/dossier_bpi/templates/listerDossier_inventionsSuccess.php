<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial("interface/conteneurFiltre",array("objFormFiltre"=>$objFormFiltre, "boolReinitialiser" => true)) ?>

<br />

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_dossier_bpi"), "dossier_bpi/creerDossier_bpi", array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_dossier_bpi"))); ?>
</div>

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
        <td>
        <?php echo link_to_grid("", "dossier_bpi/modifierDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
        <?php
        echo $objDossier->getEstActif() ?
                link_to_grid("", "dossier_bpi/changerActivationDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                link_to_grid("", "dossier_bpi/changerActivationDossier_bpi?id=" . $objDossier->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")));
        ?>
          
        <?php echo link_to_grid("", "dossier_bpi/actionsDossiers?dossier_bpi=" .$objDossier->getId() , array("class" => "picto_court bt_actions" , "title" => libelle("msg_bouton_actions"))); ?>
        <?php echo link_to_grid("", "dossier_bpi/listerDossier_bpi", array("class" => "picto_court bt_suivi_financier" , "title" => libelle("msg_bouton_suivi_financier"))); ?>

      </td>
      <td><?php echo $objDossier->getNumero(); ?></td>
      <td><?php echo $objDossier->getTitre(); ?></td>
      <td><?php echo $objDossier->getDateTimeObject('created_at')->format('d/m/Y'); ?></td>
      <td><?php //echo $objDossier->GetPartInventive()-> ?></td>
      <td><?php echo 'Enregistrement'; ?></td>
      <td class="centre"><?php echo $objDossier->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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
