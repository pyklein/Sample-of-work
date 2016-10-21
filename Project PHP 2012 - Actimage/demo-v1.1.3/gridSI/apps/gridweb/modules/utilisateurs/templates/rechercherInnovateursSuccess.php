<?php use_helper("Message"); ?>

<?php echo message(); ?>

<!-- Filtre -->
<div class="filtre">
  <form action="" method="post" name="filtre">
    <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_filtres') ?>
      </legend>

      <?php echo $objFormFiltre?>


      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_filtrer"); ?>" />
        <input type="submit" name="reset" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
      </div>
    </fieldset>
  </form>
</div>

<br>
<div class="right">
   <?php echo link_to_grid_popup(libelle("msg_bouton_ajouter_innovateur"),
                                      "utilisateurs/creerInnovateur",
                                      array("class" => "picto bt_ajouter", "id" => "ajouter_innovateur"),
                                      true); ?>
  <?php if ($objPager->count() != 0): ?>
    <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'utilisateurs/exporterInnovateursCSV',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
  <?php endif; ?>
</div>

<!-- Liste -->
<?php if ($objPager->count() != 0): ?>

  <table class="mep">
      <caption>
        <?php echo libelle("msg_libelle_innovateur_nombre_resultat", array($objPager->count())); ?>
      </caption>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_action")?></th>
        <th><?php echo libelle("msg_libelle_nom")?></th>
        <th><?php echo libelle("msg_libelle_prenom")?></th>
        <th><?php echo libelle("msg_libelle_email")?></th>
        <th>
        <?php echo libelle("msg_libelle_org_mindef")?>
        <br />
        <?php echo libelle("msg_libelle_entite_affectation")?>
        </th>
        <th><?php echo libelle("msg_libelle_telephone")?></th>
        <th><?php echo libelle("msg_libelle_etat")?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $clef => $utilisateur): ?>
        <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
          <td>
              <?php
              if($sf_user->hasCredential('SUP-MIP') ){
                  echo link_to_grid(' ','utilisateurs/modifierUtilisateurs?id='.$utilisateur->getId().'&innovateur=true',array("class" => "picto_court bt_modifier", "title"=>libelle("msg_bouton_modifier")));
                }else {
                  echo link_to_grid(' ','utilisateurs/modifierInnovateurLectureSeule?id='.$utilisateur->getId(),array("class" => "picto_court bt_modifier", "title"=>libelle("msg_bouton_modifier")));
                }
              ?>
              <?php echo $utilisateur->getEstActif() ?
                        ($utilisateur->estDesactivable() ? link_to_grid(' ','utilisateurs/changerActivationUtilisateur?id='.$utilisateur->getId().'&innovateur=true',array("class" => "picto_court bt_desactiver", "title"=>libelle("msg_bouton_desactiver"))) : "") :
                        link_to_grid(' ','utilisateurs/changerActivationUtilisateur?id='.$utilisateur->getId().'&innovateur=true',array("class" => "picto_court bt_activer", "title"=>libelle("msg_bouton_activer"))); ?>
          </td>
          <td><?php echo $utilisateur->getNom() ?></td>
          <td><?php echo $utilisateur->getPrenom() ?></td>
          <td><?php echo $utilisateur->getEmail() ?></td>
          <td><?php if($utilisateur->getEntiteId() != null) echo $utilisateur->getEntite()->getNomHierarchique(); ?> </td>
          <td><?php echo $utilisateur->getTelephoneFixe() ?></td>
          <td><?php echo ($utilisateur->getEstActif()) ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif") ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    
  </table>

  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>

<?php else: ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_libelle_innovateur_aucun_resultat"); ?>
      </caption>
    </table>

<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>