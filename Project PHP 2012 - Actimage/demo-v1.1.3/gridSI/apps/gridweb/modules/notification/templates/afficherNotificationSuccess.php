<!-- Template pour voir une notification -->
<?php
  use_helper('Format');
?>

<table class="mep">
  <tr>
    <td>
      <label><?php echo libelle("msg_libelle_metier"); ?></label>
    </td>
    <td>
      <?php echo $objNotification->getMetier()->getIntitule(); ?>
    </td>
  </tr>
  <tr>
    <td>
      <label><?php echo libelle("msg_libelle_date_debut"); ?></label>
    </td>
    <td>
      <?php echo formatDate($objNotification->getDateDebut()); ?>
    </td>
  </tr>
  <tr>
    <td>
      <label><?php echo libelle("msg_libelle_date_fin"); ?></label>
    </td>
    <td>
      <?php echo formatDate($objNotification->getDateFin()); ?>
    </td>
  </tr>
  <tr>
    <td>
      <label><?php echo libelle("msg_libelle_est_actif"); ?></label>
    </td>
    <td>
      <?php echo $objNotification->getEstActifLibelle(); ?>
    </td>
  </tr>
  <tr>
    <td>
      <label><?php echo libelle("msg_libelle_contenu"); ?></label>
    </td>
    <td>
      <?php echo $objNotification->getRaw('contenu'); ?>
    </td>
  </tr>
</table>
<br/>
<div>
  <?php echo link_to(libelle("msg_bouton_retourner"), "notification/listerNotifications", array("class" => "picto bt_retour")); ?>
</div>
