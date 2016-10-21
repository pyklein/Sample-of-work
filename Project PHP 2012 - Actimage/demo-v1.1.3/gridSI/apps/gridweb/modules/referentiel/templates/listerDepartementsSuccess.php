<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_departement"), "referentiel/creerDepartement", array("class" => "picto bt_ajouter", 'title' => libelle('msg_bouton_ajouter_departement'))); ?>
</div>

<table class="mep">
  <caption>
    <?php echo libelle("msg_departement_nombre_resultat", array($objPager->getNbResults())); ?>
  </caption>
  <thead>
    <tr>
      <th><?php echo libelle("msg_libelle_actions"); ?></th>
      <th><?php echo libelle("msg_libelle_nom"); ?></th>
      <th><?php echo libelle("msg_libelle_code"); ?></th>
      <th><?php echo libelle("msg_libelle_statut"); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($objPager->getResults() as $intCle => $objDepartement) {
    ?>
      <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php if($objDepartement->getEstActif()) {echo link_to_grid("", "referentiel/modifierDepartement?id=" . $objDepartement->getId(), array("class" => "picto_court bt_modifier", 'title' => libelle("msg_bouton_modifier")));} ?>
          <?php
          echo $objDepartement->getEstActif() ?
                  link_to_grid("", "referentiel/changerActivationDepartement?id=" . $objDepartement->getId(), array("class" => "picto_court bt_desactiver",'title' => libelle("msg_bouton_desactiver"))) :
                  link_to_grid("", "referentiel/changerActivationDepartement?id=" . $objDepartement->getId(), array("class" => "picto_court bt_activer", 'title' => libelle("msg_bouton_activer")));
          ?>
          <?php echo link_to_grid("", "referentiel/listerVilles?departement=" . $objDepartement->getId(), array("class" => "picto_court bt_liste", 'title' => libelle("msg_bouton_villes"))); ?>
        </td>
      <td><?php echo $objDepartement->getNom(); ?></td>
      <td class="centre"><?php echo $objDepartement->getCodeDepartemental(); ?></td>
      <td class="centre"><?php echo $objDepartement->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>
