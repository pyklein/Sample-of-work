
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php use_helper("Message"); ?>

<?php echo message(); ?>

<hr class="clear" />
<div class="reduit">
  <form action="" method="post">
	<fieldset>
		<legend><?php echo libelle('msg_liaison_mip_bpi_fieldset',array($objDossier)) ?></legend>
		<div class="select_multiple">
		  <h4>
                    <?php echo libelle('msg_dossier_bpi_libelle_concernes') ?>
                  </h4>
		  <?php if ($arrDossiersConcernes->count() == 0): ?>
			<?php echo libelle('msg_liaison_dossier_bpi_0_concerne') ?>
		  <?php else : ?>
			<select multiple="true" size="10" name="concerne[]">
			  <?php foreach ($arrDossiersConcernes as $dossierBPI): ?>
				  <option<?php echo ' value="'.$dossierBPI->getId().'">'.$dossierBPI ?></option>
			  <?php endforeach; ?>
			</select>
		  <?php endif; ?>
		</div>
		<div class="boutons_deplacer">
		  <br/>
		  <input type="submit" class="submit_court bt_left" value="<" name="ajout" />
		  <br/>
		  <br/>
		  <input type="submit" class="submit_court bt_right" value=">" name="retrait" />
		</div>
		<div class="select_multiple">
		  <h4>
                    <?php echo libelle('msg_dossier_bpi_libelle_disponibles') ?>
                  </h4>
		  <?php if ($arrDossiersDisponibles->count() == 0) : ?>
			<?php echo libelle('msg_liaison_dossier_bpi_0_disponible') ?>
		  <?php else : ?>
			<select multiple="true" size="10" name="disponible[]">
				<?php foreach ($arrDossiersDisponibles as $dossierBPI): ?>
				  <option<?php echo ' value="'.$dossierBPI->getId().'">'.$dossierBPI ?></option>
				<?php endforeach; ?>
			</select>
		  <?php endif; ?>
		</div>
		<hr class="clear" />
		<div class="boutons">
		  <input type="submit" value="Enregistrer les modifications" />
		</div>
    </fieldset>
  </form>
</div>

<?php include_partial('autreActions', array('id' => $strId,'boolEstPreProjet' => $objDossier->estPreProjet(),'objDossier'=>$objDossier)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/modifierValorisation?dossier_mip=".$objDossier->getId(), array("class" => "picto bt_retour")); ?>
</div>
