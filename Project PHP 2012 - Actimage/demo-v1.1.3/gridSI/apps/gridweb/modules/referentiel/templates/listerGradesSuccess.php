<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre)) ?>
<div class="right">
  <?php if ($intModeleRelatifId)  : ?>
     <?php if($objModeleRelatif->getEstActif()) {echo link_to_grid(libelle("msg_bouton_ajouter_grade"), "referentiel/creerGrade?organisme_mindef=".$intModeleRelatifId, array("class" => "picto bt_ajouter", 'title' => libelle("msg_bouton_ajouter_grade")));} ?>
  <?php else : ?>
    <?php echo link_to_grid(libelle("msg_bouton_ajouter_grade"), "referentiel/creerGrade", array("class" => "picto bt_ajouter", 'title' => libelle("msg_bouton_ajouter_grade"))); ?>
  <?php endif; ?>
</div>
<table class="mep">
  <caption>
    <?php if(!$objModeleRelatif): ?>
      <?php echo libelle("msg_grade_nombre_resultat", array($objPager->getNbResults())); ?>
    <?php else : ?>
      <?php echo libelle("msg_grade_nombre_resultat_org_mindef", array($objPager->getNbResults(),$objModeleRelatif)); ?>
    <?php endif ?>
  </caption>
  <thead>
    <tr>
      <th><?php echo libelle("msg_libelle_actions"); ?></th>
      <th><?php echo libelle("msg_libelle_intitule"); ?></th>
      <th><?php echo libelle("msg_libelle_abreviation"); ?></th>
      <th><?php echo libelle("msg_libelle_org_mindef"); ?></th>
      <th><?php echo libelle("msg_libelle_statut"); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($objPager->getResults() as $intCle => $objGrade) {
    ?>
      <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
        <td>
        <?php if (($objGrade->getEstActif() && !$objModeleRelatif) || ($objGrade->getEstActif() && $objModeleRelatif != false && $objModeleRelatif->getEstActif())){echo link_to_grid("", "referentiel/modifierGrade?id=" . $objGrade->getId(), array("class" => "picto_court bt_modifier", 'title' => libelle("msg_bouton_modifier")));} ?>
        <?php
        echo $objGrade->getEstActif() ?
                link_to_grid("", "referentiel/changerActivationGrade?id=" . $objGrade->getId(), array("class" => "picto_court bt_desactiver", 'title' => libelle("msg_bouton_desactiver"))) :
                link_to_grid("", "referentiel/changerActivationGrade?id=" . $objGrade->getId(), array("class" => "picto_court bt_activer" , 'title' => libelle("msg_bouton_activer") ));
        ?>
      </td>
      <td><?php echo $objGrade->getIntitule(); ?></td>
      <td class="centre"><?php echo $objGrade->getAbreviation(); ?></td>
      <td class="centre"><?php echo $objGrade['Organisme_mindef']->getIntitule(); ?></td>
      <td class="centre"><?php echo $objGrade->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>