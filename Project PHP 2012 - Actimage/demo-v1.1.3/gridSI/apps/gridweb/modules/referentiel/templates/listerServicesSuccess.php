<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php if ($objOrganisme->getEstActif()){echo link_to_grid(libelle("msg_bouton_ajouter_service"), "referentiel/creerService?organisme=".$objOrganisme->getId(), array("class" => "picto bt_ajouter", 'title' => libelle("msg_bouton_ajouter")));} ?>
</div>

<?php if ($objPager->count() > 0 ) : ?>
  <table class="mep">
    <caption>
      <?php echo libelle("msg_service_nombre_resultat_organisme", array($objPager->getNbResults(),$objOrganisme)); ?>
    </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_actions"); ?></th>
        <th><?php echo libelle("msg_libelle_intitule"); ?></th>
        <th><?php echo libelle("msg_libelle_abreviation"); ?></th>
        <th><?php echo libelle("msg_libelle_organisme"); ?></th>
        <th><?php echo libelle("msg_libelle_statut"); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $intCle => $Service) {
      ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php if ($Service->getEstActif() && $objOrganisme->getEstActif()) {echo link_to_grid("", "referentiel/modifierService?id=" . $Service->getId()."&organisme=". $objOrganisme->getId(), array("class" => "picto_court bt_modifier", 'title' => libelle("msg_bouton_modifier")));} ?>
            <?php
            echo $Service->getEstActif() ?
                    link_to_grid("", "referentiel/changerActivationService?id=" . $Service->getId()."&organisme=". $objOrganisme->getId(), array("class" => "picto_court bt_desactiver", 'title' => libelle("msg_bouton_desactiver"))) :
                    link_to_grid("", "referentiel/changerActivationService?id=" . $Service->getId()."&organisme=". $objOrganisme->getId(), array("class" => "picto_court bt_activer", 'title' => libelle("msg_bouton_activer")));
            ?>
            <?php echo link_to_grid("", "referentiel/listerPoint_contacts?service=" . $Service->getId(), array("class" => "picto_court bt_point_contact", 'title' => libelle("msg_bouton_points_contact"))); ?>
            <?php echo link_to_grid("", "referentiel/listerLaboratoires?service=" . $Service->getId(), array("class" => "picto_court bt_liste2", 'title' => libelle("msg_bouton_laboratoires"))); ?>
          </td>
          <td><?php echo $Service->getIntitule(); ?></td>
          <td class="centre"><?php echo $Service->getAbreviation(); ?></td>
          <td class="centre"><?php echo $objOrganisme; ?></td>
          <td class="centre"><?php echo $Service->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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

<?php else : ?>
  <?php echo libelle("msg_service_aucun_resultat_organisme", array($objOrganisme)) ?>
<?php endif; ?>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_organisme"),"referentiel/listerOrganismes",array("class" => "picto bt_retour")) ?>
</div>