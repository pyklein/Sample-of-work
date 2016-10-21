
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mip/gestion_dossier_mip', array('strId' => $strId, 'ongletActif' => 2,'boolEstPreProjet' => $objDossier->estPreProjet())) ?>

<div id="zone_cadre" class="reduit">
  <form action="" method="post">
    <div class="boutons">
         <input type="submit" value="Enregistrer" name="save"/>
    </div>
    <fieldset>
      <legend><?php echo libelle('msg_innovateurs_libelle_concernes') ?></legend>
      <?php if ($arrInnovateursConcernes->count() == 0): ?>
        <?php echo libelle('msg_innovateurs_0_concernes') ?>
      <?php else : ?>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_nom") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_prenom") ?></th>
              <th><?php echo libelle("msg_libelle_org_mindef") ?></th>
              <th><?php echo libelle("msg_libelle_innovateur_type") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($arrInnovateursConcernes as $clef => $utilisateur): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <?php echo link_to("", "dossier_mip/retirerInnovateur?dossier_mip=" . $strId . "&innovateur=" . $utilisateur->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
              </td>
              <td><?php echo $utilisateur->getNom() ?></td>
              <td><?php echo $utilisateur->getPrenom() ?></td>
              <td><?php echo $utilisateur->getAbreviationOrganismeMindef() ?></td>
              <td><?php echo $utilisateur->getTypeInnovateurBySession($strId,$transactionToken) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </fieldset>
  </form>
  <fieldset>
    <legend><?php echo libelle('msg_innovateurs_ajouter_innovateur') ?></legend>
      <div class="right">
        <?php echo link_to_grid_popup(libelle("msg_bouton_ajouter_innovateur"),
                                      "utilisateurs/creerInnovateur?id=".$strId,
                                      array("class" => "picto bt_ajouter", "id" => "ajouter_innovateur"),
                                      true); ?>

      </div>
    <form action="" method="post">
      <?php echo $objForm; ?>
      <div class="boutons">
        <input type="submit" value="<?php echo libelle("msg_bouton_ajouter"); ?>" name="add"/>
      </div>
    </form>
  </fieldset>
  <form action="" method="post">
    <div class="boutons">
      <input type="submit" value="Enregistrer" name="save"/>
    </div>
  </form>
</div>

<?php include_partial('autreActions', array('id' => $strId,'boolEstPreProjet' => $objDossier->estPreProjet(),'objDossier'=>$objDossier)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>
