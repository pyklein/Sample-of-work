<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_inventeur"), "referentiel_bpi/preCreerInventeur", array("class" =>"picto bt_ajouter")); ?>
</div>

<?php if ($objPager->getNbResults() != 0) : ?>
  <table class="mep">

    <caption>
      <?php echo libelle("msg_inventeurs_nombre_resultat", array($objPager->getNbResults())); ?>
    </caption>
   
    <th><?php echo libelle("msg_libelle_action"); ?></th>
    <th><?php echo libelle("msg_libelle_nom"); ?></th>
    <th><?php echo libelle("msg_libelle_prenom"); ?></th>
    <th><?php echo libelle("msg_libelle_email"); ?></th>
    <th><?php echo libelle("msg_libelle_appartenance"); ?></th>
    <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>

    <?php foreach ($objPager->getResults() as $intCle => $objInventeur) : ?>
      <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php echo link_to_grid("", "referentiel_bpi/modifierInventeur?id=" . $objInventeur->getId(), array("class" => "picto_court bt_modifier", "title" => libelle("msg_bouton_modifier"))); ?>
          <?php
          if ($objInventeur->getEstActif()) {
            if ($objInventeur->estDesactivable()) {
              echo link_to_grid("", "referentiel_bpi/changerActivationInventeur?id=" . $objInventeur->getId(), array("class" => "picto_court bt_desactiver", "title" => libelle("msg_bouton_desactiver")));
            }
          } else
            echo link_to_grid("", "referentiel_bpi/changerActivationInventeur?id=" . $objInventeur->getId(), array("class" => "picto_court bt_activer", "title" => libelle("msg_bouton_activer")))
          ?>
        </td>
        <td>
          <?php echo $objInventeur->getNom(); ?>
        </td>
        <td>
          <?php echo $objInventeur->getPrenom(); ?>
        </td>
        <td>
          <?php echo $objInventeur->getEmail(); ?>
        </td>
        <td>
          <?php
            if ($objInventeur->getEstExterieur()) {
              if ($objInventeur->getServiceId()) {
                echo $objInventeur->getService();
              } else if ($objInventeur->getOrganismeId()) {
                echo $objInventeur->getOrganisme();
              }
            } else {
              if ($objInventeur->getEntiteId()) {
                echo $objInventeur->getEntite()->getNomHierarchique();
              } else if ($objInventeur->getOrganismeMindefId()) {
                echo $objInventeur->getOrganisme_mindef();
              }
            }
          ?>
        </td>
        <td>
          <?php echo $objInventeur->getEstActif()? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?>
        </td>
     <?php endforeach ?>
  </table>
  <br>
  
  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager, 'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>
  
<?php else : ?>

  <table class="mep">
    <caption>
      <?php echo libelle("msg_inventeur_aucun_resultat"); ?>
    </caption>
  </table>

<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>