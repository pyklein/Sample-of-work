<?php use_helper("Message"); ?>
<?php use_helper("LinkToGrid") ?>
<?php echo message(); ?>



<?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre, 'boolReinitialiser' => true )) ?>

<div class="right">
  <?php if ($intModeleRelatifId) : ?>
    <?php echo link_to_grid(libelle("msg_bouton_ajouter_organisme"), "referentiel/creerOrganisme?type_organisme=".$intModeleRelatifId, array("class" => "picto bt_ajouter", 'title' => libelle("msg_bouton_ajouter"))); ?>
  <?php else : ?>
    <?php echo link_to_grid(libelle("msg_bouton_ajouter_organisme"), "referentiel/creerOrganisme", array("class" => "picto bt_ajouter", 'title' => libelle("msg_bouton_ajouter"))); ?>
  <?php endif; ?>
</div>

<?php if ($objPager->count() == 0): ?>
   <?php if(!$objModeleRelatif) : ?>
      <?php echo libelle("msg_organisme_0_resultat"); ?>
   <?php else : ?>
      <?php echo libelle("msg_organisme_0_resultat_type", array($objModeleRelatif)); ?>
   <?php endif ?>
<?php else : ?>
  <table class="mep">
    <caption>
      <?php if(!$objModeleRelatif): ?>
        <?php echo libelle("msg_organisme_nombre_resultat", array($objPager->getNbResults())); ?>
      <?php else : ?>
        <?php echo libelle("msg_organisme_nombre_resultat_type_organisme", array($objPager->getNbResults(),$objModeleRelatif)); ?>
      <?php endif ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule"); ?></th>
        <th><?php echo libelle("msg_libelle_abreviation"); ?></th>
        <th><?php echo libelle("msg_libelle_type_organisme"); ?></th>
        <th><?php echo libelle("msg_libelle_statut"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $intCle => $objOrganisme) {
      ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>
          <?php if ($objOrganisme->getEstActif()){echo link_to_grid("", "referentiel/modifierOrganisme?id=" . $objOrganisme->getId(), array("class" => "picto_court bt_modifier", 'title' => libelle("msg_bouton_modifier")));} ?>
          <?php
          echo $objOrganisme->getEstActif() ?
                  link_to_grid("", "referentiel/changerActivationOrganisme?id=" . $objOrganisme->getId(), array("class" => "picto_court bt_desactiver", 'title' => libelle("msg_bouton_desactiver"))) :
                  link_to_grid("", "referentiel/changerActivationOrganisme?id=" . $objOrganisme->getId(), array("class" => "picto_court bt_activer", 'title' => libelle("msg_bouton_activer")));
          ?>
          <?php echo link_to_grid("", "referentiel/listerPoint_contacts?organisme=" . $objOrganisme->getId(), array("class" => "picto_court bt_point_contact", 'title' => libelle("msg_bouton_points_contact"))); ?>
          <?php echo link_to_grid("", "referentiel/listerServices?organisme=" . $objOrganisme->getId(), array("class" => "picto_court bt_liste", 'title' => libelle("msg_bouton_services"))); ?>
          <?php echo link_to_grid("", "referentiel/listerLaboratoires?organisme=" . $objOrganisme->getId(), array("class" => "picto_court bt_liste2", 'title' => libelle("msg_bouton_laboratoires"))); ?>
        </td>
        <td><?php echo $objOrganisme->getIntitule(); ?></td>
        <td class="centre"><?php echo $objOrganisme->getAbreviation(); ?></td>
        <td class="centre"><?php echo $objOrganisme['Type_organisme']->getIntitule(); ?></td>
        <td class="centre"><?php echo $objOrganisme->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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

<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>