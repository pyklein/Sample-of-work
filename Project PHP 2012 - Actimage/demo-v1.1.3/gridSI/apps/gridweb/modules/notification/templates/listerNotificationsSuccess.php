<?php
  use_helper('Format');
  use_helper("Message")
?>

<?php echo message(); ?>

<?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre, 'boolReinitialiser'=>$boolReinitialiser)) ?>
<br/>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_nouveau"),"notification/creerNotification",array("class" => "picto bt_ajouter")); ?>
</div>

<?php if ($objPager->getNbResults() != 0): ?>
  <table class="mep">

    <caption>
      <?php echo libelle("msg_notifications_nombre_resultat",array($objPager->getNbResults())); ?>
    </caption>

      <th><?php echo libelle("msg_libelle_action"); ?></th>
      <th><?php echo libelle("msg_libelle_metier"); ?></th>
      <th><?php echo libelle("msg_libelle_extrait"); ?></th>
      <th><?php echo libelle("msg_libelle_validite"); ?></th>
      <th><?php echo libelle("msg_libelle_date_debut"); ?></th>
      <th><?php echo libelle("msg_libelle_date_fin"); ?></th>
      <th><?php echo libelle("msg_libelle_statut"); ?></th>

    <?php foreach ($objPager->getResults() as $intCle => $objNotification): ?>
      <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php echo link_to_grid("","notification/afficherNotification?id=".$objNotification->getId(), array("class" => "picto_court bt_voir","title" => libelle("msg_bouton_voir"))); ?>
          
          <?php if ($objMyUser->hasMetier($objNotification->getMetier()->getIntitule())
                  || ($objNotification->getMetier()->getEstAdministrateur() && $objMyUser->isAdministrateur()) ) : ?>
             <?php echo link_to_grid("","notification/modifierNotification?id=".$objNotification->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
          

             <?php echo $objNotification->getEstActif() ?
                    link_to_grid("", "notification/changerActivationNotification?id=".$objNotification->getId(), array("class" => "picto_court bt_desactiver","title" => libelle("msg_bouton_desactiver"))) :
                    link_to_grid("", "notification/changerActivationNotification?id=".$objNotification->getId(), array("class" => "picto_court bt_activer","title" => libelle("msg_bouton_activer"))); ?>
          <?php endif; ?>

        </td>
        <td>
          <?php echo $objNotification->getMetier(); ?>
        </td>
        <td>
          <span title="<?php echo str_replace("\"", "\\\"", $objNotification->getContenu()); ?>">
            <?php echo $objNotification->getExtrait(); ?>
          </span>
        </td>
        <td>
          <?php echo $objNotification->getValiditeLibelle(); ?>
        </td>
        <td>
          <?php echo formatDate($objNotification->getDate_debut()); ?>
        </td>
        <td>
          <?php echo formatDate($objNotification->getDate_fin()); ?>
        </td>
        <td>
          <?php echo $objNotification->getEstActifLibelle(); ?>
        </td>

     <?php endforeach ?>
  </table>

  <!--Affichage de la pagination -->
  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>

<?php else: ?>
  
  <table class="mep">
    <caption>
      <?php echo libelle("msg_notifications_aucun_resultat"); ?>
    </caption>
  </table>

<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>