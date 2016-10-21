<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_organisme_mindef"), "referentiel/creerOrganisme_mindef", array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_organisme_mindef"))); ?>
</div>

<table class="mep">
  <caption>
    <?php echo libelle("msg_organisme_mindef_nombre_resultat", array($objPager->count())); ?>
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
    <?php foreach ($objPager as $intCle => $objOrganisme) { ?>
      <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php echo link_to_grid("", "referentiel/modifierOrganisme_mindef?id=".$objOrganisme->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"), 'alt' =>'Modifier')); ?>
          <?php echo $objOrganisme->getEstActif() ?
                  link_to_grid("", "referentiel/changerActivationOrganisme_mindef?id=".$objOrganisme->getId(),  array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"), 'alt' =>'Désactiver')) :
                  link_to_grid("", "referentiel/changerActivationOrganisme_mindef?id=".$objOrganisme->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer"),'alt' =>'Activer')); ?>
          <?php echo link_to_grid('', "referentiel/listerEntites?Organisme_mindef=".$objOrganisme->getId(), array("class" => "picto_court bt_liste", "title" => libelle("msg_bouton_liste_entite"))); ?>
          <?php echo link_to_grid('', "referentiel/modifierLibelleOrganisme?Organisme_mindef=".$objOrganisme->getId(), array("class" => "picto_court bt_liste2", "title" => libelle("msg_bouton_libelle_organisme"))); ?>
        </td>
        <td><?php echo $objOrganisme->getIntitule(); ?></td>
        <td class="centre"><?php echo $objOrganisme->getAbreviation(); ?></td>
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

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>