<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mris/gestion_commissions', array('strId' => $strId, 'ongletActif' => 2)) ?>

<div>
  <div id="zone_cadre">
    <form action="" method="post">
      <div class="boutons">
        <input type="submit" value="Enregistrer"/>
      </div>
    </form>
    <fieldset>
      <legend><?php echo libelle('msg_participants_mindef_libelle_disponibles') ?></legend>
      <?php if ($objPager1->count() == 0) : ?>
        <?php echo libelle('msg_participants_mindef_0_disponible') ?>
      <?php else : ?>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_nom") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_prenom") ?></th>
              <th><?php echo libelle("msg_libelle_email") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($objPager1->getResults() as $clef => $utilisateur): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <?php echo link_to("", "dossier_mris/ajouterParticipant_mindef?commission=" . $strId . "&participant=" . $utilisateur->getId(), array("class" => "picto_court bt_ajouter", "title" => libelle("msg_bouton_ajouter"))); ?>
              </td>
              <td><?php echo $utilisateur->getNom() ?></td>
              <td><?php echo $utilisateur->getPrenom() ?></td>
              <td><?php echo $utilisateur->getEmail() ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <?php if ($objPager1->haveToPaginate()): ?>
          <?php include_partial('interface/paginateur', array('objPager' => $objPager1, 'strUrlRedirection' => $strUrlRedirection,'intIdPager' => '1')) ?>
        <?php endif; ?>

        <?php if ($objPager1->count() > 0) : ?>
          <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres, 'intIdPager' => '1')) ?>
        <?php endif; ?>

      <?php endif; ?>
    </fieldset>
    <fieldset>
      <legend><?php echo libelle('msg_participants_mindef_libelle_concernes') ?></legend>
      <?php if ($objPager2->count() == 0): ?>
        <?php echo libelle('msg_participants_mindef_0_concernes') ?>
      <?php else : ?>
        <table class="mep">
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
              <th width="25%"><?php echo libelle("msg_libelle_nom") ?></th>
              <th width="25%"><?php echo libelle("msg_utilisateur_libelle_prenom") ?></th>
              <th><?php echo libelle("msg_libelle_email") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($objPager2 as $clef => $utilisateur): ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <?php echo link_to("", "dossier_mris/retirerParticipant_mindef?commission=" . $strId . "&participant=" . $utilisateur->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
              </td>
              <td><?php echo $utilisateur->getNom() ?></td>
              <td><?php echo $utilisateur->getPrenom() ?></td>
              <td><?php echo $utilisateur->getEmail() ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      
        <?php if ($objPager2->haveToPaginate()): ?>
          <?php include_partial('interface/paginateur', array('objPager' => $objPager2, 'strUrlRedirection' => $strUrlRedirection, 'intIdPager' => 2)) ?>
        <?php endif; ?>

        <?php if ($objPager2->count() > 0) : ?>
          <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres, 'intIdPager' => 2)) ?>
        <?php endif; ?>

      <?php endif; ?>
    </fieldset>
    <form action="" method="post">
      <div class="boutons">
        <input type="submit" value="Enregistrer"/>
      </div>
    </form>
  </div>
  <div>
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerCommissions", array("class" => "picto bt_retour")); ?>
  </div>
  <div>
    <?php //include_partial('autreActionsMris', array('id' => $strId)) ?>
  </div>
</div>
