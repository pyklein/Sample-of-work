<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_convention_bouton_nouvelle"),'referentiel_mris/creerConvention_organisme',array("class" => "picto bt_ajouter", "title"=>libelle("msg_convention_bouton_nouvelle"))); ?>
</div>

<table class="mep">
  <caption>
    <?php echo ($objPager->count() == 0) ? libelle("msg_convention_aucun_resultat") : libelle("msg_convention_nombre_resultats",array($objPager->count())); ?>
  </caption>
  <?php if ($objPager->count() > 0):  ?>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_action")?></th>
        <th><?php echo libelle("msg_libelle_organisme")?></th>
        <th><?php echo libelle("msg_convention_libelle_date_signature")?></th>
        <th><?php echo libelle("msg_convention_libelle_date_prise_effet")?></th>
        <th><?php echo libelle("msg_convention_libelle_date_fin_effet")?></th>
        <th><?php echo libelle("msg_libelle_montant")?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $clef => $objConventionOrg): ?>
        <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid(' ','referentiel_mris/modifierConvention_organisme?id='.$objConventionOrg->getId(),array("class" => "picto_court bt_modifier", "title"=>libelle("msg_bouton_modifier"))); ?>
            <?php if ($objConventionOrg->getFichier()) echo link_to_grid(' ','referentiel_mris/telechargerConvention_organisme?id='.$objConventionOrg->getId(),array("class" => "picto_court bt_telecharger", "title"=>libelle("msg_convention_bouton_telecharger"))); ?>
          </td>
          <td><?php echo $objConventionOrg->getOrganisme()->getIntitule() ?></td>
          <td><?php echo ($objConventionOrg->getDateSignature()) ? formatDate($objConventionOrg->getDateSignature()) : "" ?></td>
          <td><?php echo ($objConventionOrg->getDatePriseEffet()) ? formatDate($objConventionOrg->getDatePriseEffet()) : "" ?></td>
          <td><?php echo ($objConventionOrg->getDateFinEffet()) ? formatDate($objConventionOrg->getDateFinEffet()) : "" ?></td>
          <td><?php echo formatMontantFr($objConventionOrg->getMontant()) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  <?php endif; ?>
</table>

<?php if ($objPager->count() > 0):  ?>
  <?php if ($objPager->haveToPaginate()): ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>
<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>