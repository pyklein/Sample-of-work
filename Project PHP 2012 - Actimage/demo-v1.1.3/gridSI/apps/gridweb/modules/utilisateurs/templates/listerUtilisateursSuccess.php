<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial("utilisateurs/formFiltre",array("objFiltre"=>$objFiltre, 'boolReinitialiser' => true)) ?>
  

<br>

<div class="right">
  <?php echo link_to_grid(libelle("msg_utilisateur_boutton_nouveau"),'utilisateurs/preCreerUtilisateurs',array("class" => "picto bt_ajouter", "title"=>libelle("msg_utilisateur_boutton_nouveau"))); ?>
  
  <?php if ($intNombreResUtilisateur>0): ?>
  <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'utilisateurs/exporterUtilisateursCSV',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
    
  <?php endif; ?>
</div>

<table class="mep">
  <caption>
    <?php echo ($intNombreResUtilisateur==0) ? libelle("msg_utilisateurs_aucun_resultats") : libelle("msg_utilisateurs_nombre_resultats",array($intNombreResUtilisateur)); ?>
  </caption>
  <?php if ($intNombreResUtilisateur>0):  ?>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_action")?></th>
        <th><?php echo libelle("msg_libelle_nom")?></th>
        <th><?php echo libelle("msg_utilisateur_libelle_prenom")?></th>
        <th><?php echo libelle("msg_libelle_email")?></th>
        <th><?php echo libelle("msg_libelle_statut")?></th>
        <th><?php echo libelle("msg_utilisateur_bouton_profils")?></th>
        <th><?php echo libelle("msg_libelle_org_mindef")?></th>
        <th><?php echo libelle("msg_utilisateur_libelle_entite_affect")?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $clef => $utilisateur): ?>
        <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php if ($objMyUser->getUtilisateur()->isPeutGererUtilisateur($utilisateur)): ?>
              <?php echo link_to_grid(' ','utilisateurs/modifierUtilisateurs?id='.$utilisateur->getId(),array("class" => "picto_court bt_modifier", "title"=>libelle("msg_bouton_modifier"))); ?>
              <?php echo $utilisateur->getEstActif() ?
                        ($utilisateur->estDesactivable() ? link_to_grid(' ','utilisateurs/changerActivationUtilisateur?id='.$utilisateur->getId(),array("class" => "picto_court bt_desactiver", "title"=>libelle("msg_bouton_desactiver"))) : "") :
                        link_to_grid(' ','utilisateurs/changerActivationUtilisateur?id='.$utilisateur->getId(),array("class" => "picto_court bt_activer", "title"=>libelle("msg_bouton_activer"))); ?>
              <?php echo link_to_grid(' ','utilisateurs/reinitMotDePassUtilisateurs?id='.$utilisateur->getId(),array("class" => "picto_court bt_motdepasse", "title"=>libelle("msg_utilisateur_bouton_reinit_motdepass")));  ?>
              <?php echo link_to_grid(' ','utilisateurs/modifierProfilsUtilisateur?id='.$utilisateur->getId(),array("class" => "picto_court bt_profils", "title"=>libelle("msg_utilisateur_bouton_profils"))); ?>
            <?php endif; ?>
          </td>
          <td><?php echo $utilisateur->getNom() ?></td>
          <td><?php echo $utilisateur->getPrenom() ?></td>
          <td><?php echo $utilisateur->getEmail() ?></td>
          <td><?php echo ($utilisateur->getEstActif()) ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif") ?></td>
          <td>
            <?php
            $arrProfil =  $utilisateur->getProfils();
              foreach ($arrProfil as $objProfil){?>
                <?php echo $objProfil; ?><br/>
            <?php } ?>    
          </td>
          <td><?php echo $utilisateur->getAbreviationOrganismeMindef() ?></td>
          <td><?php echo $utilisateur->getAbreviationEntite() ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  <?php endif; ?>
</table>

<?php if ($intNombreResUtilisateur>0):  ?>
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