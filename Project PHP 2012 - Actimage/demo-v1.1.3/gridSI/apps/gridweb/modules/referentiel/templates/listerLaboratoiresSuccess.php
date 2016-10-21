<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php if($objContenant->getEstActifRecursif()) {echo link_to_grid(libelle("msg_bouton_ajouter_laboratoire"), "referentiel/creerLaboratoire?".$strModelContenant."=".$objContenant->getId(), array("class" => "picto bt_ajouter", 'title' => libelle("msg_bouton_ajouter")));} ?>
</div>

<?php if ($objPager->count() > 0 ) : ?>
  <table class="mep">
    <caption>
      <?php echo libelle("msg_laboratoire_nombre_resultat_".$strModelContenant, array($objPager->getNbResults(),$objContenant)); ?>
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
      <?php foreach ($objPager->getResults() as $intCle => $Laboratoire) {
      ?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td>
          <?php if ($Laboratoire->getEstActifRecursif())
                  {echo link_to_grid("", "referentiel/modifierLaboratoire?id=" . $Laboratoire->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_modifier", 'title' => libelle("msg_bouton_modifier")));}
          ?>
          <?php
          echo $Laboratoire->getEstActif() ?
                  link_to_grid("", "referentiel/changerActivationLaboratoire?id=" . $Laboratoire->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_desactiver", 'title' => libelle("msg_bouton_desactiver"))) :
                  link_to_grid("", "referentiel/changerActivationLaboratoire?id=" . $Laboratoire->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto_court bt_activer",'title' => libelle("msg_bouton_dactiver")));
          ?>
          <?php echo link_to_grid("", "referentiel/listerPoint_contacts?laboratoire=" . $Laboratoire->getId(), array("class" => "picto_court bt_point_contact", 'title' => libelle("msg_bouton_points_contact"))); ?>
          </td>
          <td><?php echo $Laboratoire->getIntitule(); ?></td>
          <td class="centre"><?php echo $Laboratoire->getAbreviation(); ?></td>
          <td class="centre"><?php echo $Laboratoire->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?></td>
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
  <?php echo libelle("msg_laboratoire_aucun_resultat_".$strModelContenant, array($objContenant)) ?>
<?php endif; ?>

<div class="left">
  <?php if ($strModelContenant == 'organisme'): ?>
    <?php echo link_to(libelle("msg_bouton_retour_organisme"),"referentiel/listerOrganismes",array('class' => 'picto bt_retour')) ?>
  <?php else : ?>
    <?php echo link_to(libelle("msg_bouton_retour_service"),"referentiel/listerServices?organisme=".$objContenant['Organisme']->getId(),array('class' => 'picto bt_retour')) ?>
  <?php endif; ?>
</div>