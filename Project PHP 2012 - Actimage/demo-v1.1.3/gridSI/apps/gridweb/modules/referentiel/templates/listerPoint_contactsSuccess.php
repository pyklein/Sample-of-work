<?php use_helper("Message"); ?>

<?php echo message(); ?>


<?php if ($objPager->count() == 0 && $objContenant->getEstActifRecursif()) : ?>
  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_ajouter_point_contact"), "referentiel/creerPoint_contact?".$strModelContenant."=".$objContenant->getId(), array("class" => "picto bt_ajouter", 'title' => libelle("msg_bouton_ajouter"))); ?>
  </div>
<?php endif; ?>

<?php if ($objPager->count() != 0): ?>
  <caption>
    <?php echo libelle("msg_point_contact_metier_".$strModelContenant, array($objContenant,$objMetier)); ?>
  </caption>
  <hr/>
  <?php foreach ($objPager->getResults() as $PointDeContact) { ?>
    <p>
      <label><?php echo libelle('msg_libelle_telephone') ?></label>
      <?php echo $PointDeContact->getTelephone();?>
    </p>
    <p>
      <label><?php echo libelle('msg_libelle_email') ?></label>
      <?php echo $PointDeContact->getEmail();?>
    </p>

    <?php if ($PointDeContact->getPaysId() == null) { ?>
      <fieldset>
        <legend><?php echo libelle("msg_point_contact_coordonnes_postales"); ?></legend>
        <p>
          <label><?php echo libelle('msg_libelle_adresse') ?></label>
          <?php echo $PointDeContact->getAdresse();?>
        </p>
        <p>
          <label><?php echo libelle('msg_libelle_code_postal') ?></label>
          <?php echo $PointDeContact->getCodePostal();?>
        </p>
        <p>
          <label><?php echo libelle('msg_libelle_ville') ?></label>
          <?php echo $PointDeContact->getVille()->getNom();?>
        </p>
      </fieldset>
    <?php } else { ?>
      <fieldset>
        <legend><?php echo libelle("msg_point_contact_coordonnes_postales_etrangers"); ?></legend>
        <p>
          <label><?php echo libelle('msg_libelle_adresse') ?></label>
          <?php echo $PointDeContact->getAdresseEtrangere();?>
        </p>
        <p>
          <label><?php echo libelle('msg_libelle_pays') ?></label>
          <?php echo $PointDeContact->getPays();?>
        </p>
      </fieldset>
    <?php } ?>

    <?php if ($objContenant->getEstActif()) { ?>
      <div class="boutons">
        <?php echo link_to_grid(libelle("msg_bouton_modifier"), "referentiel/modifierPoint_contact?id=" . $PointDeContact->getId()."&".$strModelContenant."=". $objContenant->getId(), array("class" => "picto bt_modifier")); ?>
      </div>
    <?php } ?>
  <?php } ?>
<?php else: ?>
  <?php echo libelle("msg_point_contact_0_resultat_".$strModelContenant, array($objContenant)); ?>
<?php endif; ?>
<div class="left">
  <?php if ($strModelContenant == 'organisme'): ?>
    <?php echo link_to(libelle("msg_bouton_retour_organisme"),"referentiel/listerOrganismes",array('class' => 'picto bt_retour')) ?>
  <?php elseif ($strModelContenant == 'service') : ?>
    <?php echo link_to(libelle("msg_bouton_retour_service"),"referentiel/listerServices?organisme=".$objContenant['Organisme']->getId(),array('class' => 'picto bt_retour')) ?>
  <?php else : ?>
    <?php if ($objOrganismeContenant->getId() != null): ?>
      <?php echo link_to(libelle("msg_bouton_retour_laboratoire"),"referentiel/listerLaboratoires?organisme=".$objContenant->getOrganisme()->getId(),array('class' => 'picto bt_retour')) ?>
    <?php else: ?>
      <?php echo link_to(libelle("msg_bouton_retour_laboratoire"),"referentiel/listerLaboratoires?service=".$objContenant->getService()->getId(),array('class' => 'picto bt_retour')) ?>
    <?php endif; ?>
  <?php endif; ?>
</div>