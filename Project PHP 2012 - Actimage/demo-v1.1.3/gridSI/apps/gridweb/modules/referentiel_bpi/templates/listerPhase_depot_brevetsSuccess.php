<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_phase"), "referentiel_bpi/creerPhase_depot_brevet",array("class" =>"picto bt_ajouter")); ?>
</div>

<?php if ($objPhases->count()!= 0): ?>
  <table class="mep">
    <caption>
      <?php echo libelle("msg_referentiel_bpi_phases_nombre_resultat",array($objPhases->count())); ?>
    </caption>

    <th><?php echo libelle("msg_libelle_action"); ?></th>
    <th><?php echo libelle("msg_libelle_intitule"); ?></th>
    <th><?php echo libelle("msg_libelle_abreviation"); ?></th>
    <th><?php echo libelle("msg_libelle_statut"); ?></th>

    <?php foreach ($objPhases as $intCle => $objPhase): ?>
      <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
        <td>

            <?php echo link_to("","referentiel_bpi/modifierPhase_depot_brevet?id=".$objPhase->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
            <?php
            echo $objPhase->getEstActif() ?
                    link_to_grid("","referentiel_bpi/changerActivationPhaseDepotBrevet?id=".$objPhase->getId(), array("class" => "picto_court bt_desactiver","title"=> libelle("msg_bouton_desactiver"))) :
                    link_to_grid("","referentiel_bpi/changerActivationPhaseDepotBrevet?id=".$objPhase->getId(), array("class" => "picto_court bt_activer","title" => libelle("msg_bouton_activer")))
            ?>

        </td>
        <td>
          <?php echo $objPhase->getIntituleDansArbre(); ?>
        </td>
        <td>
          <?php echo $objPhase->getAbreviation(); ?>
        </td>
        <td>
          <?php echo $objPhase->getEstActif()? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?>
        </td>
     <?php endforeach ?>
  </table>

  <?php else: ?>
    <table class="mep">
      <caption>
        <?php echo  libelle("msg_referentiel_bpi_phases_aucun_resultat"); ?>
      </caption>
    </table>

<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>