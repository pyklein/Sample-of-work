<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>


  <?php if (!$objForm->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="post" />
  <?php endif; ?>
  
  <fieldset>
    <legend>
      <?php echo libelle('msg_intervenant_fieldset_personal_info'); ?>
    </legend>

    <?php echo $objForm['civilite_id']->renderRow(); ?>
    <?php echo $objForm['nom']->renderRow(); ?>
    <?php echo $objForm['prenom']->renderRow(); ?>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle('msg_intervenant_fieldset_position_titre'); ?>
    </legend>

    <?php echo $objForm['organisme_id']->renderRow(); ?>
    <?php echo $objForm['service_id']->renderRow(); ?>
    <?php echo $objForm['laboratoire_id']->renderRow(); ?>
    <?php echo $objForm['titre']->renderRow(); ?>
    <div>
      &nbsp; &nbsp;
      <label for="">
        <?php echo libelle('msg_intervenant_libelle_type'); ?> &nbsp;&nbsp;:
      </label>
      
      <ul class="checkbox_list">
        <li>
          <?php echo $objForm['est_participant_commission']->render(); ?>
          <?php echo $objForm['est_participant_commission']->renderLabel(); ?>
        </li>
        <li>
          <?php echo $objForm['est_responsable']->render(); ?>
          <?php echo $objForm['est_responsable']->renderLabel(); ?>
        </li>
      </ul>
    </div>
    
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle('msg_intervenant_fieldset_coord'); ?>
    </legend>

    <?php echo $objForm['email']->renderRow(); ?>
    <?php echo $objForm['email2']->renderRow(); ?>
    <?php echo $objForm['adresse']->renderRow(); ?>
    <?php echo $objForm['adresse2']->renderRow(); ?>
    <?php echo $objForm['adresse3']->renderRow(); ?>
    <?php echo $objForm['code_postal']->renderRow(); ?>
    <?php echo $objForm['ville_id']->renderLabel()." : "; ?>
    <?php echo $objForm['ville_id']->renderError(); ?>
    <?php echo $objForm['ville_id']->render(array('class' => 'ville')); ?>
    <?php echo $objForm['complement_adresse']->renderLabel()." : "; ?>
    <?php echo $objForm['complement_adresse']->renderError(); ?>
    <?php echo $objForm['complement_adresse']->render(array('class' => 'complement')); ?>

    <hr class="separateur"/>

    <?php echo $objForm['adresse_etrangere']->renderRow();  ?>
    <?php echo $objForm['pays_id']->renderRow();  ?>

    <hr class="separateur"/>

    <?php echo $objForm['telephone_fixe']->renderRow(); ?>
    <?php echo $objForm['telephone_mobile']->renderRow(); ?>
    <?php echo $objForm['fax']->renderRow(); ?>
  </fieldset>

  <script type='text/javascript'>
    hideOtherOptionGroupsOnSelectValue('<?php echo $objForm['organisme_id']->renderId(); ?>', '<?php echo $objForm['service_id']->renderId(); ?>');
  </script>
