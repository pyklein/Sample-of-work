<?php use_helper("Message"); ?>

<?php echo message(); ?>


<?php if ($objPager->count() > 0 ) : ?>
  <table class="mep">
    <caption>
      <?php echo libelle("msg_laboratoire_orphelin_nombre_resultat", array($objPager->getNbResults())); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule"); ?></th>
        <th><?php echo libelle("msg_libelle_abreviation"); ?></th>
        <th><?php echo libelle("msg_libelle_statut"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $intCle => $Laboratoire) {
      ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>
          <?php  echo link_to_grid("", "referentiel/modifierLaboratoireOrphelin?id=" . $Laboratoire->getId(), array("class" => "picto_court bt_modifier", 'title' => libelle("msg_bouton_modifier"))); ?>
          </td>
          <td><?php echo $Laboratoire->getIntitule(); ?></td>
          <td class="centre"><?php echo $Laboratoire->getAbreviation(); ?></td>
          <td class="centre"><?php echo $Laboratoire->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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

<?php else : ?>
  <?php echo libelle("msg_laboratoire_orphelin_aucun_resultat") ?>
<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>