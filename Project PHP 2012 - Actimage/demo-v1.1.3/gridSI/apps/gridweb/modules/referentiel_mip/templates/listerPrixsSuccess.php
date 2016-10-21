<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_prix"), "referentiel_mip/creerPrix", array("class" => "picto bt_ajouter", "title" => libelle("msg_bouton_ajouter_prix"))); ?>
</div>
<?php if ($objPager->count() > 0 ) : ?>
  <table class="mep">
    <caption>
      <?php echo libelle("msg_prix_nombre_resultat", array($objPager->count())); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule"); ?></th>
        <th><?php echo libelle("msg_libelle_statut"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager as $intCle => $objPrix) { ?>
        <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php echo link_to_grid("", "referentiel_mip/modifierPrix?id=".$objPrix->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
            <?php echo $objPrix->getEstActif() ?
                    link_to_grid("", "referentiel_mip/changerActivationPrix?id=".$objPrix->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver"))) :
                    link_to_grid("", "referentiel_mip/changerActivationPrix?id=".$objPrix->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer"))); ?>

          </td>
          <td><?php echo $objPrix->getIntitule(); ?></td>
          <td class="centre"><?php echo $objPrix->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php else : ?>
  <?php echo libelle("msg_prix_aucun_resultat") ?>
<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>