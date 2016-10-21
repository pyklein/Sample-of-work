<?php include_partial('dossier_mris/dossierHeader', array('objDossier' => $objDossier)) ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>


<?php include_partial('dossier_mris/onglet_dossier', array('strNomModel' => 'Dossier_these', 'strId' => $objDossier->getId(), 'ongletActif' => 6)) ?>

<div id="zone_cadre" class="reduit">

  <form action="<?php echo url_for('dossier_mris/modifierAboutissement_Dossier_these')?>" method="post">
    <div class="boutons">
        <input type="submit" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
    </div>
    <input type="hidden" name="dossier_these_id" value="<?php echo $objDossier->getId()?>"/>

    <fieldset>
      <legend>
        <?php echo libelle('msg_dossier_these_fieldset_prix_these'); ?>
      </legend>

      <p>
        &nbsp; &nbsp;
        <label for="">
          <?php echo libelle('msg_dossier_these_libelle_select_prix_these'); ?> &nbsp;&nbsp;:
        </label>
      </p>
      <ul class="checkbox_list">
        <li>
          <?php echo $objForm['est_preselectionne_prix']->render(); ?>
          <?php echo $objForm['est_preselectionne_prix']->renderLabel(); ?>
        </li>
        <li>
          <?php echo $objForm['est_selectionne_prix']->render(); ?>
          <?php echo $objForm['est_selectionne_prix']->renderLabel(); ?>
        </li>
      </ul>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle('msg_dossier_these_fieldset_element_aboutiss'); ?>
      </legend>

      <?php echo $objForm['date_soutenance']->renderRow(); ?>
      <?php echo $objForm['reception_exemplaire_these']->renderRow(); ?>
      <?php echo $objForm['reception_rapport_soutenance']->renderRow(); ?>
      <?php echo $objForm['reception_liste_publication']->renderRow(); ?>
      <?php echo $objForm['reception_fiche_evaluation']->renderRow(); ?>
      <?php echo $objForm['reception_synthese']->renderRow(); ?>

      <div class="boutons">
        <input type="submit" value="<?php echo libelle('msg_dossier_mris_bouton_enregistrer')?>"/>
      </div>
    </fieldset>

  </form>
</div>

<?php include_partial('autreActionsMris',array('strNomModel'=>'Dossier_these', 'id' => $objDossier->getId())) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/listerDossier_theses", array("class" => "picto bt_retour")); ?>
</div>
