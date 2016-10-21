<?php use_helper("Message"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objForm->getObject())); ?>

<?php echo message();?>

<?php if (isset($strId)): ?>
  <?php include_partial('gestion_dossier_bpi',array('strId' => $strId, 'ongletActif' => 4, "estBrevetable" => true)) ?>
<?php endif; ?>


<div>
  <div id="zone_cadre" class="reduit">
    <form action="" method="post">
    <div class="boutons">
        <input type="submit" value="<?php echo libelle('msg_bouton_enregistrer'); ?>" />
    </div>
    <p><?php echo libelle("msg_classement_dossier_bpi") ?>
      <?php foreach ($arrClassement as $abr => $bool) {echo $abr . " ";} ?>
      <?php if ($boolContentieuxExist) :?>
        <br/>
        <?php echo libelle('msg_dossier_bpi_contentieux_exist');?>
      <?php endif; ?>
    </p>

    <?php if($arrClassement->offsetExists(Classement_invention_inventeurTable::HMNA )): ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_droit_fieldset_echeances") ?>
        </legend>
            <?php
              echo $objForm['Attribution_droit']['echeance_initiale']->renderRow();
              echo $objForm['Attribution_droit']['echeance_supplementaire']->renderRow();
            ?>
      </fieldset>
    

    <?php elseif($arrClassement->offsetExists(Classement_invention_inventeurTable::HMA)): ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_droit_fieldset_echeances") ?>
        </legend>
            <?php
              echo $objForm['Attribution_droit']['echeance_initiale']->renderRow(array('disabled' => true));
              echo $objForm['Attribution_droit']['echeance_supplementaire']->renderRow();

            ?>
      </fieldset>
    <?php endif; ?>


    <?php if($arrClassement->offsetExists(Classement_invention_inventeurTable::HMA) || $arrClassement->offsetExists(Classement_invention_inventeurTable::HMNA)):?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_droit_fieldset_attribution") ?>
        </legend>
          <?php
            echo $objForm['Attribution_droit']['droits_attribues']->renderRow();
            echo $objForm['Attribution_droit']['date_decision_attribution']->renderRow();
          ?>
      </fieldset>
    <?php endif;?>
    
    <?php if($arrClassement->offsetExists(Classement_invention_inventeurTable::HMA) || $arrClassement->offsetExists(Classement_invention_inventeurTable::HMNA) || ($arrClassement->offsetExists(Classement_invention_inventeurTable::M) && $intNbInventeurExt > 0)):?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_droit_fieldset_contractualisation") ?>
        </legend>
          <?php
            echo $objForm['Attribution_droit']['date_envoi_contrat']->renderRow();
            echo $objForm['Attribution_droit']['contrat_id']->renderRow();
          ?>
          
      </fieldset>
    <?php endif;?>

    <fieldset>
      <legend>
        <?php echo libelle("msg_droit_fieldset_brevet") ?>
      </legend>
        <?php
          echo $objForm['Attribution_droit']['redaction_brevet_lance']->renderRow();
          echo $objForm['Attribution_droit']['brevet_id']->renderRow();
        ?>
    </fieldset>
      
    <?php if($arrClassement->offsetExists(Classement_invention_inventeurTable::M) || $arrClassement->offsetExists(Classement_invention_inventeurTable::HMA) || $arrClassement->offsetExists(Classement_invention_inventeurTable::HMNA)):?>
    <fieldset>
        <legend>
          <?php echo libelle("msg_droit_fieldset_commentaires") ?>
        </legend>
          <?php
            echo $objForm['Attribution_droit']['commentaire']->renderRow();
          ?>
    </fieldset>
    <?php endif;?>

    <div class="boutons">
      <input type="submit" value="<?php echo libelle('msg_bouton_enregistrer'); ?>" />
    </div>
    </form>
    &nbsp;
  </div>

  <?php include_partial('autreActions',array('id' => $strId)) ?>

  <hr class="clear" />
  
  <div>
    <?php echo link_to(libelle("msg_bouton_retour_dossier"),'dossier_bpi/listerDossier_bpis', array('class'=>'picto bt_retour'))  ?>
  </div>
  
</div>


