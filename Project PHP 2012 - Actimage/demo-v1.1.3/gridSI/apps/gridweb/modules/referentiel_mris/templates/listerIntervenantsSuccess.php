<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre, 'boolReinitialiser' => $boolReinitialiser)) ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_intervenant_bouton_ajout"), "referentiel_mris/creerIntervenant",array("class" =>"picto bt_ajouter")); ?>
</div>

<?php if ($intNbrIntervenants != 0): ?>
  <table class="mep">

    <caption>
      <?php echo libelle("msg_intervenant_nombre_resultats",array($intNbrIntervenants) ); ?>
    </caption>

    <th><?php echo libelle("msg_libelle_action"); ?></th>
    <th><?php echo libelle("msg_libelle_nom"); ?></th>
    <th><?php echo libelle("msg_libelle_prenom"); ?></th>
    <th><?php echo libelle("msg_libelle_email"); ?></th>
    <th><?php echo libelle("msg_intervenant_libelle_fontion_titre"); ?></th>
    <th><?php echo libelle("msg_libelle_organisme"); ?></th>
    <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>

    <?php foreach ($objPager->getResults() as $intCle => $objIntervenant): ?>
      <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php echo link_to_grid("","referentiel_mris/modifierIntervenant?id=".$objIntervenant->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
          <?php
          echo $objIntervenant->getEstActif() ?
                  link_to_grid("","referentiel_mris/changerActivationIntervenant?id=".$objIntervenant->getId(), array("class" => "picto_court bt_desactiver","title"=> libelle("msg_bouton_desactiver"))) :
                  link_to_grid("","referentiel_mris/changerActivationIntervenant?id=".$objIntervenant->getId(), array("class" => "picto_court bt_activer","title" => libelle("msg_bouton_activer")))
          ?>
        </td>
        <td>
          <?php echo $objIntervenant->getNom(); ?>
        </td>
        <td>
          <?php echo $objIntervenant->getPrenom(); ?>
        </td>
        <td>
          <?php echo $objIntervenant->getEmail(); ?>
        </td>
        <td>
          <?php echo $objIntervenant->getTitre(); ?>
        </td>
        <td>
          <?php echo $objIntervenant->getNomOrganisme(); ?>
        </td>
        <td>
          <?php echo $objIntervenant->getEstActif()? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?>
        </td>
     <?php endforeach ?>
  </table>

<?php else: ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_intervenant_msg_zero_resultats"); ?>
      </caption>
    </table>

<?php endif; ?>

<?php if ($intNbrIntervenants>0):  ?>
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