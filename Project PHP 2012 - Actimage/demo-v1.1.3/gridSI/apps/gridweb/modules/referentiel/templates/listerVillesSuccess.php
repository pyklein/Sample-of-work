<?php use_helper("Message"); ?>

<?php echo message(); ?>




<?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre)) ?>
<div class="right">
  <?php if ($intModeleRelatifId): ?>
    <?php if ($objModeleRelatif->getEstActif()){echo link_to_grid(libelle("msg_bouton_ajouter_ville"), "referentiel/creerVille?departement=". $intModeleRelatifId, array("class" => "picto bt_ajouter", 'title' =>  libelle("msg_bouton_ajouter")));} ?>
  <?php else : ?>
    <?php echo link_to_grid(libelle("msg_bouton_ajouter_ville"), "referentiel/creerVille", array("class" => "picto bt_ajouter", 'title' =>  libelle("msg_bouton_ajouter_ville"))); ?>
  <?php endif; ?>
</div>

<?php if ($objPager->count() == 0): ?>
   <?php if(!$objModeleRelatif) : ?>
      <?php echo libelle("msg_ville_0_resultat"); ?>
   <?php else : ?>
      <?php echo libelle("msg_ville_0_resultat_departement", array($objModeleRelatif)); ?>
   <?php endif ?>
<?php else : ?>
  <table class="mep">
    <caption>
      <?php if(!$objModeleRelatif) : ?>
        <?php echo libelle("msg_ville_nombre_resultat", array($objPager->getNbResults())); ?>
      <?php else : ?>
        <?php echo libelle("msg_ville_nombre_resultat_departement", array($objPager->getNbResults(),$objModeleRelatif)); ?>
      <?php endif ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_nom"); ?></th>
        <th><?php echo libelle("msg_libelle_departement"); ?></th>
        <th><?php echo libelle("msg_libelle_code_postal"); ?></th>
        <th><?php echo libelle("msg_libelle_statut"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $intCle => $objVille) { ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php if (($objVille->getEstActif() && !$objModeleRelatif) || ($objVille->getEstActif() && $objModeleRelatif != false && $objModeleRelatif->getEstActif())) {echo link_to_grid("", "referentiel/modifierVille?id=".$objVille->getId(), array("class" => "picto_court bt_modifier", 'title' => libelle("msg_bouton_modifier")));} ?>
            <?php echo $objVille->getEstActif() ?
                    link_to_grid("", "referentiel/changerActivationVille?id=".$objVille->getId(), array("class" => "picto_court bt_desactiver", 'title' => libelle("msg_bouton_desactiver"))) :
                    link_to_grid("", "referentiel/changerActivationVille?id=".$objVille->getId(), array("class" => "picto_court bt_activer", 'title' => libelle("msg_bouton_activer"))); ?>
          </td>
          <td><?php echo $objVille->getNom(); ?></td>
          <td>
            <?php echo $objVille->getDepartement()->getCodeDepartemental(); ?>
            -
            <?php echo $objVille->getDepartement()->getNom(); ?>
          </td>
          <td class="centre"><?php echo $objVille->getCodePostal(); ?></td>
          <td class="centre"><?php echo $objVille->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur',array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif;  ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)); ?>
  <?php endif; ?>

  
<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_departement"), "referentiel/listerDepartements", array("class" => "picto bt_retour")); ?>
</div>