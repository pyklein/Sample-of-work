<?php use_helper("Format")?>

<!-- Effectue l'affichage des notifications sur la page d'accueil-->
<?php if($arrNotifications->count() > 0):?>
  <div class="notifications">
      <?php foreach ($arrNotifications as $intCle => $objNotification): ?>
        <div class="notification <?php echo $intCle%2 == 0 ? "impair" : "pair" ?>">
          <div class="notification_info">
            <?php if($objNotification->getMetierId() == MetierTable::BPI_ID)
                  {
                    echo libelle("msg_libelle_notification_du_metier",array($objNotification->getMetier()));
                  }
                  else if($objNotification->getMetierId() == MetierTable::ADMINISTRATEUR_ID)
                  {
                    echo libelle("msg_libelle_notification_admin",array($objNotification->getMetier()));
                  }
                  else
                  {
                    echo libelle("msg_libelle_notification_de_metier",array($objNotification->getMetier()));
                  }
                  echo " - ".formatDate($objNotification->getDate_debut());
            ?>
          </div>
          <?php echo $objNotification->getRaw('contenu'); ?>
        </div>
     <?php endforeach ?>
  </div>
<?php endif;?>
