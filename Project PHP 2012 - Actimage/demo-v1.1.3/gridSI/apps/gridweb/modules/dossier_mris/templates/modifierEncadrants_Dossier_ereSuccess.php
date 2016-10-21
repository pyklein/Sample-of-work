<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php include_partial('dossier_mris/onglet_dossier', array('strNomModel' => 'Dossier_ere', 'strId' => $objDossier->getId(), 'ongletActif' => 3)) ?>

<div id="zone_cadre" class="reduit">
  <div class="boutons">
    <form action="<?php echo url_for('dossier_mris/modifierEncadrants_Dossier_ere')?>" method="post">
      <input type="hidden" name="dossier_ere_id" value="<?php echo $objDossier->getId()?>"/>
      <input type="submit" name="enregistrer" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
    </form>
  </div>
  <fieldset>
    <legend>
      <?php echo libelle('msg_dossier_ere_fieldset_resp_dispo'); ?>
    </legend>

    <form action="<?php echo url_for('dossier_mris/modifierEncadrants_Dossier_ere')?>" method="post">
      <?php echo $objFormEncadrantDossierEre; ?>
      <input type="hidden" name="dossier_ere_id" value="<?php echo $objDossier->getId()?>"/>

      <table class="mep">
        <?php if ($intNombreResEncadrants==0): ?>
          <caption>
            <?php echo libelle("msg_dossier_mris_aucun_responsable_dispo"); ?>
          </caption>
        <?php endif; ?>
        <?php if ($intNombreResEncadrants>0):  ?>
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action"); ?></th>
              <th width="20%"><?php echo libelle("msg_libelle_nom"); ?></th>
              <th width="20%"><?php echo libelle("msg_libelle_prenom"); ?></th>
              <th width="20%"><?php echo libelle("msg_libelle_organisme"); ?></th>
              <th width="35%"><?php echo libelle("msg_intervenant_libelle_fontion_titre"); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($objPager1->getResults() as $clef => $encadrantDispo): ?>
              <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
                <td>
                  <button type="submit" id="<?php echo $encadrantDispo->getId()?>" name="<?php echo "encadrant_disponible[".$encadrantDispo->getId()."]";?>" value="<?php echo libelle('msg_bouton_ajouter')?>" title="<?php echo libelle('msg_bouton_ajouter')?>" class="picto_court bt_ajouter" />
                </td>
                <td><?php echo $encadrantDispo->getNom() ?></td>
                <td><?php echo $encadrantDispo->getPrenom() ?></td>
                <td><?php echo $encadrantDispo->getNomOrganisme() ?></td>
                <td><?php echo $encadrantDispo->getTitre() ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        <?php endif; ?>
      </table>
    </form>
    <?php if ($objPager1->haveToPaginate()): ?>
      <?php include_partial('interface/paginateur', array('objPager' => $objPager1, 'strUrlRedirection' => $strUrlRedirection,'intIdPager' => '1')) ?>
    <?php endif; ?>

    <?php if ($objPager1->count() > 0) : ?>
      <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres, 'intIdPager' => '1')) ?>
    <?php endif; ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle('msg_dossier_ere_fieldset_encadrants'); ?>
    </legend>

    <table class="mep">
        <?php if ($intNombreResEncadrantsAssocies==0): ?>
          <caption>
            <?php echo libelle("msg_dossier_mris_aucun_encadrant_assoc"); ?>
          </caption>
        <?php endif; ?>
        <?php if ($intNombreResEncadrantsAssocies>0):  ?>
          <thead>
            <tr>
              <th width="5%"><?php echo libelle("msg_libelle_action"); ?></th>
              <th width="20%"><?php echo libelle("msg_libelle_nom"); ?></th>
              <th width="20%"><?php echo libelle("msg_libelle_prenom"); ?></th>
              <th width="20%"><?php echo libelle("msg_libelle_organisme"); ?></th>
              <th width="20%"><?php echo libelle("msg_intervenant_libelle_fontion_titre"); ?></th>
              <th width="15%"><?php echo libelle("msg_dossier_mris_libelle_role"); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $i=0; ?>
            <?php foreach ($arrEncadrantsAssocies as $clef => $encadrantAssoc): ?>
              <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
                <td>
                  <?php echo link_to("", 'dossier_mris/modifierEncadrants_Dossier_ere?dossier_ere_id='.$objDossier->getId().'&responsable_associe='.$encadrantAssoc->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
                </td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getNom() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getPrenom() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getNomOrganisme() ?></td>
                <td><?php echo $encadrantAssoc->getIntervenant()->getTitre() ?></td>
                <td><?php echo $encadrantAssoc->getRoleEre()->getIntitule() ?></td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </tbody>
        <?php endif; ?>
      </table>
  </fieldset>

  <div class="boutons">
    <form action="<?php echo url_for('dossier_mris/modifierEncadrants_Dossier_ere')?>" method="post">
      <input type="hidden" name="dossier_ere_id" value="<?php echo $objDossier->getId()?>"/>
      <input type="submit" name="enregistrer" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
    </form>
  </div>

  <h4>
    <?php echo libelle('msg_dossier_mris_libelle_ajout_encadrant')?>
  </h4>
  <form action="<?php echo url_for('dossier_mris/modifierEncadrants_Dossier_ere?dossier_ere_id='.$objDossier->getId()) ?>" method="post" >
    <?php include_partial('referentiel_mris/intervenantForm', array('action' => 'ajout_intervenant', 'model' => 'Dossier_ere', 'objForm' => $objFormAjoutIntervenant)) ?>
    <?php echo $objFormEncadrantDossierEre; ?>

    <div class="boutons">
      <input type="submit" name="ajout_nouveau_intervenant" value="<?php echo libelle('msg_dossier_mris_bouton_ajout_responsable'); ?>" />
    </div>
  </form>

</div>

<?php include_partial('autreActionsMris',array('strNomModel'=>'Dossier_ere', 'id' => $objDossier->getId())) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossier_eres", array("class" => "picto bt_retour")); ?>
</div>
