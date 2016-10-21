<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php
if ($arrEntite){
 $objPager = $arrEntite ;
}
if(empty($strIntituleModeleRelatif)){
  $strIntituleModeleRelatif = null;
}
?>

<?php if (!$boolRenderFiltre) : ?>
  <?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre)) ?>
<?php endif;?>

<?php if ($boolRenderFiltre){ ?>
  <div class="right">
    <?php if ($boolEntiteActive) echo link_to_grid(libelle("msg_bouton_ajouter_entite"), "referentiel/creerEntite?entite_id=".$entiteId, array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_entite"))); ?>
  </div>
<?php } else { ?>
  <div class="right">
    <?php if ($intModeleRelatifId): ?>
      <?php if ($objModeleRelatif->getEstActif()) echo link_to_grid(libelle("msg_bouton_ajouter_entite"), "referentiel/creerEntite?orgmindef=".$intModeleRelatifId, array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_entite"))); ?>
    <?php else : ?>
      <?php echo link_to_grid(libelle("msg_bouton_ajouter_entite"), "referentiel/creerEntite", array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_entite"))); ?>
    <?php endif ?>
  </div>
<?php } ?>
<?php if ($objPager->count() == 0): ?>
   <?php if(!$strIntituleModeleRelatif) : ?>
    <?php
      if(isset($entiteParent)){
        echo libelle("msg_entite_0_resultat", array($entiteParent->getIntitule()));
      }else{
        echo libelle("msg_entite_0_resultat_organisme_mindef", array($objModeleRelatif));
      }
    ?>
   <?php else : ?>
      <?php //echo libelle("msg_entite_0_resultat_organisme_mindef", array($strIntituleModeleRelatif)); ?>
   <?php endif ?>
<?php else : ?>
  <table class="mep">
    <caption>
      <?php if (!$boolRenderFiltre): ?>
        <?php if(!$strIntituleModeleRelatif): ?>
          <?php echo libelle("msg_entite_nombre_resultat", array($objPager->getNbResults())); ?>
        <?php else : ?>
          <?php echo libelle("msg_entite_nombre_resultat_org_mindef", array($objPager->getNbResults(),$strIntituleModeleRelatif)); ?>
        <?php endif ?>
      <?php else : ?>
        <?php echo libelle("msg_entite_parent_nombre_resultat", array(count($objPager), $entiteParent->getIntitule()));?>
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
      <?php foreach ($objPager as $intCle => $objEntite) { ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("", "referentiel/modifierEntite?id=".$objEntite->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo $objEntite->getEstActif() ?
                    link_to_grid("", "referentiel/changerActivationEntite?id=".$objEntite->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                    link_to_grid("", "referentiel/changerActivationEntite?id=".$objEntite->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer"))); ?>
            <?php echo link_to_grid('', "referentiel/listerEntites?id=".$objEntite->getId(), array("class" => "picto_court bt_liste")); ?>

          </td>
          <td><?php echo $objEntite->getIntitule(); ?></td>
          <td class="centre"><?php echo $objEntite->getAbreviation(); ?></td>
          <td class="centre"><?php echo $objEntite['Organisme_mindef']['abreviation']; ?></td>
          <td class="centre"><?php echo $objEntite->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php if (!$boolRenderFiltre) : ?>

    <?php if ($objPager->haveToPaginate()) : ?>
      <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
    <?php endif; ?>

    <?php if ($objPager->count() > 0) : ?>
      <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
    <?php endif; ?>

  <?php endif ?>
<?php endif ?>

<?php if ($boolRenderFiltre) : ?>
  <div class="left">
    <?php if ($boolEntiteRacine) : ?>
      <?php echo link_to_grid(libelle("msg_bouton_retour_entite"), "referentiel/listerEntites", array("class" => "picto bt_retour")); ?>
    <?php endif ?>
    <?php if (!$boolEntiteRacine) : ?>
      <?php echo link_to_grid(libelle("msg_bouton_retour_entite_parent", array($entiteParentEntiteId->getIntitule())), "referentiel/listerEntites?id=".$entiteParentEntiteId->getId(), array("class" => "picto bt_retour")); ?>
    <?php endif ?>
  </div>
<?php endif ?>

<?php if (!$boolRenderFiltre) : ?>
  <div class="left">
    <?php echo link_to_grid(libelle("msg_bouton_retour_org_mindef"), "referentiel/listerOrganisme_mindefs", array("class" => "picto bt_retour")); ?>
  </div>
<?php endif ?>