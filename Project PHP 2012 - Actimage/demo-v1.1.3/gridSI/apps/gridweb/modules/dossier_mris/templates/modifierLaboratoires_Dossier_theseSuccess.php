<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>


<?php include_partial('dossier_mris/onglet_dossier', array('strNomModel' => 'Dossier_these', 'strId' => $objDossier->getId(), 'ongletActif' => 4)) ?>

<div id="zone_cadre" class="reduit">
  <div class="boutons">
    <form action="<?php echo url_for('dossier_mris/modifierLaboratoires_Dossier_these')?>" method="post">
      <input type="hidden" name="dossier_these_id" value="<?php echo $objDossier->getId()?>"/>
      <input type="submit" name="enregistrer" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
    </form>
  </div>
  <fieldset>
    <legend>
      <?php echo libelle('msg_dossier_these_fieldset_labo_dispo'); ?>
    </legend>

    <form action="<?php echo url_for('dossier_mris/modifierLaboratoires_Dossier_these')?>" method="post" >
      <input type="hidden" name="dossier_these_id" value="<?php echo $objDossier->getId()?>"/>
      <fieldset>
        <legend>
          <?php echo libelle('msg_libelle_filtres')?>
        </legend>

        <?php echo $objFiltreLaboratoires ?>

        <div class="boutons">
          <input type="submit" name="labo_filtre_submit" value="<?php echo libelle('msg_bouton_filtrer') ?>" />
          <?php if (isset($boolReinitialiser)): ?>
                <input type="submit" name="labo_reset_submit" value="<?php echo libelle('msg_bouton_reset_filtres') ?>" />
          <?php endif; ?>
        </div>

      </fieldset>
    </form>

    <form action="<?php echo url_for('dossier_mris/modifierLaboratoires_Dossier_these')?>" method="post">
      <input type="hidden" name="dossier_these_id" value="<?php echo $objDossier->getId()?>"/>

      <table class="mep">
        <?php if ($objPager1->count()==0): ?>
          <caption>
            <?php echo libelle("msg_dossier_mris_aucun_laboratoire_dispo"); ?>
          </caption>
        <?php endif; ?>
        <?php if ($objPager1->count()>0):  ?>
          <thead>
            <tr>
              <th width="7%"><?php echo libelle("msg_libelle_action"); ?></th>
              <th width="31%"><?php echo libelle("msg_libelle_intitule"); ?></th>
              <th width="31%"><?php echo libelle("msg_libelle_organisme"); ?></th>
              <th width="31%"><?php echo libelle("msg_libelle_service"); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($objPager1->getResults() as $clef => $laboratoireDispo): ?>
              <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
                <td>
                  <button type="submit" id="<?php echo $laboratoireDispo->getId()?>" name="<?php echo "laboratoire_disponible[".$laboratoireDispo->getId()."]";?>" value="<?php echo libelle('msg_bouton_ajouter')?>" title="<?php echo libelle('msg_bouton_ajouter')?>" class="picto_court bt_ajouter" />
                </td>
                <td><?php echo $laboratoireDispo->getIntitule() ?></td>
                <td><?php echo $laboratoireDispo->getOrganisme()->getIntitule() ?></td>
                <td><?php echo $laboratoireDispo->getService()->getIntitule() ?></td>
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
      <?php echo libelle('msg_dossier_these_fieldset_labo_assoc'); ?>
    </legend>

    <table class="mep">
        <?php if ($intNombreResLaboratoiresAssocies==0): ?>
          <caption>
            <?php echo libelle("msg_dossier_mris_aucun_laboratoire_assoc"); ?>
          </caption>
        <?php endif; ?>
        <?php if ($intNombreResLaboratoiresAssocies>0):  ?>
          <thead>
            <tr>
              <th width="7%"><?php echo libelle("msg_libelle_action"); ?></th>
              <th width="31%"><?php echo libelle("msg_libelle_intitule"); ?></th>
              <th width="31%"><?php echo libelle("msg_libelle_organisme"); ?></th>
              <th width="31%"><?php echo libelle("msg_libelle_service"); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $i=0; ?>
            <?php foreach ($arrLaboratoiresAssocies as $clef => $laboratoireAssoc): ?>
              <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
                <td>
                  <?php echo link_to("", 'dossier_mris/modifierLaboratoires_Dossier_these?dossier_these_id='.$objDossier->getId().'&laboratoire_associe='.$laboratoireAssoc->getId(), array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer"))); ?>
                </td>
                <td><?php echo $laboratoireAssoc->getLaboratoire()->getIntitule() ?></td>
                <td><?php echo $laboratoireAssoc->getLaboratoire()->getOrganisme()->getIntitule() ?></td>
                <td><?php echo $laboratoireAssoc->getLaboratoire()->getService()->getIntitule() ?></td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
          </tbody>
        <?php endif; ?>
      </table>
  </fieldset>

  <div class="boutons">
    <form action="<?php echo url_for('dossier_mris/modifierLaboratoires_Dossier_these')?>" method="post">
      <input type="hidden" name="dossier_these_id" value="<?php echo $objDossier->getId()?>"/>
      <input type="submit" name="enregistrer" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
    </form>
  </div>

  <h4>
    <?php echo libelle('msg_dossier_mris_libelle_ajout_laboratoire')?>
  </h4>
  <form action="<?php echo url_for('dossier_mris/modifierLaboratoires_Dossier_these?dossier_these_id='.$objDossier->getId()) ?>" method="post" >

    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_description") ?>
      </legend>

      <?php echo $objPointContactLaboratoireForm['Laboratoire']['intitule']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['Laboratoire']['abreviation']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['Laboratoire']['evaluation_aers']->renderRow() ?>

    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_appartenance") ?>
      </legend>

      <?php echo $objPointContactLaboratoireForm['Laboratoire']['organisme_id']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['Laboratoire']['service_id']->renderRow() ?>
    </fieldset>
    
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_point_contact") ?>
      </legend>

      <?php echo $objPointContactLaboratoireForm['telephone']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['fax']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['email']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['email2']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['adresse']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['adresse2']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['adresse3']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['code_postal']->renderRow() ?>
      <?php echo $objPointContactLaboratoireForm['ville_id']->renderLabel()." : "; ?>
      <?php echo $objPointContactLaboratoireForm['ville_id']->renderError(); ?>
      <?php echo $objPointContactLaboratoireForm['ville_id']->render(array('class' => 'ville')); ?>
      <?php echo $objPointContactLaboratoireForm['complement_adresse']->renderLabel()." : "; ?>
      <?php echo $objPointContactLaboratoireForm['complement_adresse']->renderError(); ?>
      <?php echo $objPointContactLaboratoireForm['complement_adresse']->render(array('class' => 'complement')); ?>

      <hr class="separateur"/>

      <?php echo $objPointContactLaboratoireForm['adresse_etrangere']->renderRow(); ?>
      <?php echo $objPointContactLaboratoireForm['pays_id']->renderRow(); ?>

    </fieldset>

    <script type='text/javascript'>
      hideOtherOptionGroupsOnSelectValue('<?php echo $objPointContactLaboratoireForm['Laboratoire']['organisme_id']->renderId(); ?>', '<?php echo $objPointContactLaboratoireForm['Laboratoire']['service_id']->renderId(); ?>');
    </script>

    <script type='text/javascript'>
      hideOtherOptionGroupsOnSelectValue('<?php echo $objFiltreLaboratoires['organisme_id']->renderId(); ?>', '<?php echo $objFiltreLaboratoires['service_id']->renderId(); ?>');
    </script>

    <div class="boutons">
      <input type="submit" name="ajout_nouveau_laboratoire" value="<?php echo libelle('msg_dossier_mris_bouton_ajout_laboratoire'); ?>" />
    </div>
  </form>
</div>

<?php include_partial('autreActionsMris',array('strNomModel'=>'Dossier_these', 'id' => $objDossier->getId())) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossier_theses", array("class" => "picto bt_retour")); ?>
</div>
