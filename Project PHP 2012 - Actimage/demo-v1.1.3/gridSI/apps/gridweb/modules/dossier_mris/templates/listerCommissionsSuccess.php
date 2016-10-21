<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial("interface/conteneurFiltre",array("objFormFiltre"=>$objFormFiltre,"boolReinitialiser" => true)) ?>

<br />

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_commission"), "dossier_mris/creerCommission", array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter"))); ?>
</div>

<?php if ($objPager->count() != 0): ?>

  <table class="mep">
    <caption>
      <?php echo libelle("msg_commission_nombre_resultat", array($objPager->count())); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_date_debut"); ?></th>
        <th><?php echo libelle("msg_libelle_date_fin"); ?></th>
        <th><?php echo libelle("msg_libelle_type_dossiers"); ?></th>
        <th><?php echo libelle("msg_libelle_commission_type"); ?></th>
        <th><?php echo libelle("msg_libelle_commission_etat"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager as $intCle => $objCommission) { ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("", "dossier_mris/modifierCommission?id=" . $objCommission->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo link_to_grid("", "dossier_mris/listerDossiersCommission?id=". $objCommission->getId().'&'.$objCommission->getRedirectionListeDossier($objCommission->getId()), array("class" => $objCommission->getClasseBoutonPourListeCommission($objCommission->getId()), "title" => $objCommission->getLibellePourListeCommission($objCommission->getId()) )); ?>

            <?php if($objCommission->getTypeCommission($objCommission->getId()))
                  {
                    echo link_to_grid("", "dossier_mris/listerDossiersCommission?id=". $objCommission->getId().'&EnCours=true', array("class" => "picto_court bt_liste2", "title" => libelle("msg_bouton_dossiers")));
                  }
            ?>

            <?php echo link_to_grid("", "dossier_mris/genererDocumentsCommission?id=" . $objCommission->getId(), array("class" => "picto_court bt_genererdocs", "title" => libelle("msg_bouton_generer_lettres"))); ?>
          </td>
          
          <td><?php echo $objCommission->getDateTimeObject('date_debut')->format('d/m/Y'); ?></td>
          <td><?php echo $objCommission->getDateTimeObject('date_fin')->format('d/m/Y'); ?></td>
          <td><?php echo $objCommission['Type_dossier_mris']; ?></td>
          <td><?php echo $objCommission->getLibelleEstSelection(); ?></td>
          <td><?php echo $objCommission->getLibelleEtat(); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager, 'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>

<?php else: ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_commission_aucun_resultat"); ?>
      </caption>
    </table>
<?php endif; ?>
