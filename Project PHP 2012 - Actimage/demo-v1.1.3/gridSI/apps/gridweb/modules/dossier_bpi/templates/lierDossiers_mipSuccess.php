<?php use_helper("Message"); ?>

<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($objDossier)); ?>
</h3>

<?php echo message(); ?>

<hr class="clear" />
<div class="reduit">
  <form action="" method="post">
  <fieldset>
    <legend><?php echo libelle('msg_liaison_bpi_mip_fieldset',array($objDossier)) ?></legend>
    <div class="select_multiple">
      <p><?php echo libelle('msg_dossier_mip_libelle_concernes') ?></p>
      <?php if ($arrDossiersConcernes->count() == 0): ?>
        <?php echo libelle('msg_liaison_dossier_mip_0_concerne') ?>
      <?php else : ?>
        <select multiple="true" size="10" name="concerne[]">
          <?php foreach ($arrDossiersConcernes as $dossierMIP): ?>
              <option<?php echo ' value="'.$dossierMIP->getId().'">'.$dossierMIP ?></option>
          <?php endforeach; ?>
        </select>
      <?php endif; ?>
    </div>
    <div class="boutons_deplacer">
      <br/>
      <input type="submit" class="submit_court bt_left" value="<" name="ajout"/>
      <br/>
      <br/>
      <input type="submit" class="submit_court bt_right" value=">" name="retrait"/>
    </div>
    <div class="select_multiple">
      <p><?php echo libelle('msg_dossier_bpi_libelle_disponibles') ?></p>
      <?php if ($arrDossiersDisponibles->count() == 0) : ?>
        <?php echo libelle('msg_liaison_dossier_bpi_0_disponible') ?>
      <?php else : ?>
        <select multiple="true" size="10" name="disponible[]">
            <?php foreach ($arrDossiersDisponibles as $dossierMIP): ?>
              <option<?php echo ' value="'.$dossierMIP->getId().'">'.$dossierMIP ?></option>
            <?php endforeach; ?>
        </select>
      <?php endif; ?>
    </div>
    <hr class="clear">
    <div class="boutons">
      <input type="submit" value="Enregistrer les modifications"/>
    </div>
    </fieldset>
  </form>
</div>

<?php include_partial('autreActions', array('id' => $strId)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to_grid_retour(libelle("msg_bouton_retourner"), array("class" => "picto bt_retour")); ?>
</div>
