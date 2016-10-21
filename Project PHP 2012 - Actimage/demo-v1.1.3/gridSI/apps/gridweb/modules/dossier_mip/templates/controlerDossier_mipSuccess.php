<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php echo message(); ?>

<div class="reduit">

<?php if ($objDossier->getEstActif() && $objDossier->getNecessiteControle() != 0): ?>

	<?php if(isset($arrErreurs['infos']) || isset($arrErreurs['regles']) || isset($arrErreurs['echeances']) || isset($arrErreurs['finances'])) : ?>

	  <!-- Groupement Informations manquantes-->
	  <?php if(isset($arrErreurs['infos'])):?>
		<fieldset>
		  <legend>
			<?php echo libelle("msg_dossier_mip_fieldset_info_manquantes") ?>
		  </legend>
		  <ul>
			<?php foreach($arrErreurs['infos'] as $erreur ) : ?>
			  <li class="<?php echo $erreur->current() ?>">
				<?php echo libelle("msg_libelle_".$erreur->key())." : " . libelle("msg_libelle_a_renseigner")  ?>
			  </li>
			<?php endforeach; ?>
		  </ul>
		</fieldset>
	  <?php endif; ?>

	  <!--Groupement Règles métier-->
	  <?php if(isset($arrErreurs['regles'])) : ?>
		<fieldset>
		  <legend>
			<?php echo libelle("msg_dossier_mip_fieldset_regles_metier") ?>
		  </legend>
		  <?php echo libelle("msg_dossier_mip_controle_statut",array($objDossier->getStatut_dossier_mip()))?>
		  <ul>
			<?php foreach($arrErreurs['regles'] as $erreur ) : ?>
			  <li class="<?php echo $erreur->current() ?>">
				<?php echo libelle("msg_dossier_mip_controle_".$erreur->key()) ?>
			  </li>
			<?php endforeach; ?>
		  </ul>
	   </fieldset>
	  <?php endif; ?>

	  <!-- Groupement Echéances-->
	   <?php if(isset($arrErreurs['echeances'])):?>
		<fieldset>
		<legend>
		  <?php echo libelle("msg_dossier_mip_fieldset_echeance") ?>
		</legend>
		<ul>
		<?php print_r($arrErreurs['echeances']); ?>
		  <?php foreach($arrErreurs['echeances'] as $echeance ) : ?>
			<li class="<?php echo $echeance['class'] ?>">
			  <?php echo libelle("msg_dossier_mip_controle_".$echeance['intitule']) ?>
			  <br>
			  <?php echo libelle("msg_dossier_mip_controle_date_".$echeance['intitule'],array(formatDate($echeance['date'])))?>
			  <br>
			  <?php if(isset($echeance['dateRelance']) && count($echeance['dateRelance']) > 0) : ?>
				<?php echo libelle("msg_dossier_mip_controle_relance",array($objDossier->getPilote())) ?>
				<?php foreach ($echeance['dateRelance'] as $key => $dateRelance) : ?>
				  <b><?php echo ($key > 0 ?  ', ' : '') . formatDate($dateRelance) ?></b>
				<?php endforeach; ?>
			  <?php endif; ?>
			</li>
		  <?php endforeach; ?>
		</ul>
		</fieldset>
	   <?php endif; ?>

	  <!--Groupement Financements-->
	  <?php if(isset($arrErreurs['finances'])):?>
		<fieldset>
		  <legend>
			<?php echo libelle("msg_libelle_financements"); ?>
		  </legend>
		  <ul>
			<?php foreach($arrErreurs['finances'] as $finance ) : ?>
			  <li class="<?php echo $finance->current() ?>">
				<?php echo libelle("msg_dossier_mip_controle_".$finance->key()) ?>
			  </li>
			<?php endforeach; ?>
		  </ul>
		  <?php echo link_to(libelle("msg_dossier_mip_controle_gerer_budget"),"dossier_mip/suiviFinancierDossier_mips?dossier_mip=".$intIdDossierMip); ?>
		</fieldset>
	  <?php endif; ?>
  
  <?php else : ?>
    <?php echo libelle('msg_dossier_mip_controle_ras',array($objDossier)); ?>
  <?php endif; ?>
  
<?php else : ?>
  <?php echo libelle('msg_dossier_mip_controle_ras',array($objDossier)); ?>
<?php endif; ?>
</div>

<?php include_partial('dossier_mip/autreActions',array('id' => $objDossier->getId(),'objDossier'=>$objDossier)) ?>

<hr class="clear"/>
<div class="left">
  <?php echo link_to_grid_retour(libelle("msg_bouton_retourner"), array("class" => "picto bt_retour")); ?>
</div>

