<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>

<?php if (isset($strId)): ?>
  <?php include_partial('referentiel_mris/gestion_etudiant',array('strId' => $strId, 'ongletActif' => 1)) ?>
<?php endif; ?>

<div>
  <div <?php if (!isset($creer)) {echo('id="zone_cadre"');} ?>>
    <form action="" method="post">
    <?php if (!$objForm->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="post" />
    <?php endif; ?>


    <fieldset>
      <legend>
        <?php echo libelle("msg_etudiant_fieldset_info_identite") ?>
      </legend>
      <?php echo $objForm['civilite_id']->renderLabel(); ?> <b>:</b>
      <?php
        echo $objForm['civilite_id']->render();
        echo $objForm['nom']->renderRow();
        echo $objForm['nom_jeunefille']->renderRow();
        echo $objForm['prenom']->renderRow();
        echo $objForm['date_naissance']->renderRow();
        echo $objForm['lieu_naissance']->renderRow();
        echo $objForm['nationalite_id']->renderRow();
      ?>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_etudiant_fieldset_coord") ?>
      </legend>
      <?php
        echo $objForm['email']->renderRow();
        echo $objForm['email2']->renderRow();
        echo $objForm['adresse']->renderRow();
        echo $objForm['adresse2']->renderRow();
        echo $objForm['adresse3']->renderRow();
        echo $objForm['code_postal']->renderRow();
        echo $objForm['ville_id']->renderLabel()." : "; 
        echo $objForm['ville_id']->renderError(); 
        echo $objForm['ville_id']->render(array('class' => 'ville'));
        echo $objForm['complement_adresse']->renderLabel()." : "; 
        echo $objForm['complement_adresse']->renderError(); 
        echo $objForm['complement_adresse']->render(array('class' => 'complement'));

      ?>

      <hr class="separateur"/>

      <?php
        echo $objForm['adresse_etrangere']->renderRow();
        echo $objForm['pays_id']->renderRow();
      ?>

      <hr class="separateur"/>

      <?php
        echo $objForm['telephone_fixe']->renderRow();
        echo $objForm['telephone_mobile']->renderRow();
      ?>
    </fieldset>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle('msg_bouton_enregistrer'); ?>" />
    </div>
    </form>
    &nbsp;
  </div>
  <div>
    <?php echo link_to(libelle("msg_etudiants_bouton_retour_liste"),'referentiel_mris/listerEtudiants', array('class'=>'picto bt_retour'))  ?>
  </div>
</div>