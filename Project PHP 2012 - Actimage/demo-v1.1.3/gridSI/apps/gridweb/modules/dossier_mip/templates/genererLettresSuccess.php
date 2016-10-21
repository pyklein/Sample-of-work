
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossierMip)); ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<div class="reduit">
  <?php if ($intNbInnovateurs != 0) { ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_lettre_projet"); ?>
    </legend>
    <div>
       <?php echo libelle("msg_libelle_demande_avis_etat_major"); ?>
        <br />
        <?php if (Modele_lettreTable::getInstance()->estModeleLettreDisponible($intNbInnovateurs > 1 ? Modele_lettreTable::MIP_LETTRE_PROJET_PLUSIEURS_INNOVATEURS : Modele_lettreTable::MIP_LETTRE_PROJET_UN_INNOVATEUR)) { ?>
          <?php echo link_to_grid(libelle("msg_libelle_telecharger_lettre"), "dossier_mip/genererLettres?id=".$sf_params->get('id')."&cle=".($intNbInnovateurs > 1 ? Modele_lettreTable::MIP_LETTRE_PROJET_PLUSIEURS_INNOVATEURS : Modele_lettreTable::MIP_LETTRE_PROJET_UN_INNOVATEUR), array("class" => "picto_small bt_export_rtf_small")); ?>
        <?php } else { ?>
          <ul>
            <li class="controle_haut">
              <?php echo libelle("msg_libelle_modele_nexiste_pas"); ?>
            </li>
          </ul>
        <?php } ?>
        </div>
  </fieldset>

  <?php if($boolFinancements) { ?>
	  <fieldset>
		<legend>
		  <?php echo libelle("msg_libelle_lettre_soutien"); ?>
		</legend>
		<div>
		 	<?php echo libelle("msg_libelle_decision_de_soutien_a"); ?>
			<br />
			<?php if (Modele_lettreTable::getInstance()->estModeleLettreDisponible($intNbInnovateurs > 1 ? Modele_lettreTable::MIP_LETTRE_SOUTIEN_PLUSIEURS_INNOVATEURS : Modele_lettreTable::MIP_LETTRE_SOUTIEN_UN_INNOVATEUR)) { ?>
			  <?php echo link_to_grid(libelle("msg_libelle_telecharger_lettre"), "dossier_mip/genererLettres?id=".$sf_params->get('id')."&cle=".($intNbInnovateurs > 1 ? Modele_lettreTable::MIP_LETTRE_SOUTIEN_PLUSIEURS_INNOVATEURS : Modele_lettreTable::MIP_LETTRE_SOUTIEN_UN_INNOVATEUR), array("class" => "picto_small bt_export_rtf_small")); ?>
			<?php } else { ?>
			  <ul>
				<li class="controle_haut">
				  <?php echo libelle("msg_libelle_modele_nexiste_pas"); ?>
				</li>
			  </ul>
			<?php } ?>
		</div>
		
	  </fieldset>
  <?php } ?>

  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_lettres_cloture_ar"); ?>
    </legend>
    <div>
        <?php echo libelle("msg_libelle_lettre_cloture_etat_major"); ?>
        <br />
        <?php if (Modele_lettreTable::getInstance()->estModeleLettreDisponible(Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_EM)) : ?>
          <ul>
            <?php foreach ($arrInnovateurs as $objInnovateur):?>
              <li>
                <?php echo $objInnovateur; ?>
                <?php echo link_to_grid(libelle("msg_libelle_telecharger_lettre"), "dossier_mip/genererLettres?id=".$sf_params->get('id')."&cle=".Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_EM."&innov=".$objInnovateur->getId(), array("class" => "picto_small bt_export_rtf_small")); ?>
              </li>
            <?php endforeach;?>
          </ul>

        <?php else:?>
          <ul>
            <li class="controle_haut">
              <?php echo libelle("msg_libelle_modele_nexiste_pas"); ?>
            </li>
          </ul>
      <?php endif; ?>
    </div>
    <br>
    <div>
        <?php echo libelle("msg_libelle_lettre_cloture_mindef"); ?>
        <br />
        <?php if (Modele_lettreTable::getInstance()->estModeleLettreDisponible($intNbInnovateurs > 1 ? Modele_lettreTable::MIP_LETTRE_CLOTURE_PLUSIEURS_INNOVATEURS_MINDEF : Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_MINDEF)) { ?>
          <?php echo link_to_grid(libelle("msg_libelle_telecharger_lettre"), "dossier_mip/genererLettres?id=".$sf_params->get('id')."&cle=".($intNbInnovateurs > 1 ? Modele_lettreTable::MIP_LETTRE_CLOTURE_PLUSIEURS_INNOVATEURS_MINDEF : Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_MINDEF), array("class" => "picto_small bt_export_rtf_small")); ?>
        <?php } else { ?>
          <ul>
            <li class="controle_haut">
              <?php echo libelle("msg_libelle_modele_nexiste_pas"); ?>
            </li>
          </ul>
        <?php } ?>
    </div>
    <br>
    <div>

        <?php echo libelle("msg_libelle_lettre_accuse_reception"); ?>
        <?php if (Modele_lettreTable::getInstance()->estModeleLettreDisponible(Modele_lettreTable::MIP_LETTRE_ACCUSE_RECEPTION_VISITE)) : ?>
          <ul>
            <?php foreach ($arrInnovateurs as $objInnovateur):?>
              <li>
                <?php echo $objInnovateur; ?>
                <?php echo link_to_grid(libelle("msg_libelle_telecharger_lettre"), "dossier_mip/genererLettres?id=".$sf_params->get('id')."&cle=".Modele_lettreTable::MIP_LETTRE_ACCUSE_RECEPTION_VISITE."&innov=".$objInnovateur->getId(), array("class" => "picto_small bt_export_rtf_small")); ?>
              </li>
            <?php endforeach;?>
          </ul>

        <?php else:?>
          <ul>
            <li class="controle_haut">
              <?php echo libelle("msg_libelle_modele_nexiste_pas"); ?>
            </li>
          </ul>
        <?php endif; ?>
    </div>
    
  </fieldset>
  <?php }
else{
  echo libelle(msg_libelle_contenu_info_dossier_mip);
}?>
</div>

<?php include_partial('autreActions',array('id' => $strId,'objDossier'=>$objDossierMip)) ?>
<hr class="clear">
<hr class="clear" />
<div class="left">
  <?php echo link_to_grid(libelle("msg_bouton_retourner"), "dossier_mip/index", array("class" => "picto bt_retour")); ?>
</div>
