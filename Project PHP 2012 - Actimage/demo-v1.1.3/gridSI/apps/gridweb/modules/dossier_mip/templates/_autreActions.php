
<fieldset class="outils">
  <legend><?php echo libelle('msg_libelle_autres_actions') ?></legend>
  <?php if ((($objDossier->getPiloteId() == $sf_user->getUtilisateur()->getId()) || ($sf_user->hasCredential('SUP-MIP') )) && ($objDossier->getEstActif())) : ?>
    <?php echo link_to_grid(libelle("msg_bouton_editer_dossier"), "dossier_mip/modifierDossier_mip?id=" . $objDossier->getId(), array("class" => "picto bt_modifier")); ?>
  <?php endif; ?>
  <?php echo link_to_grid(libelle("msg_bouton_evenements"),"dossier_mip/listerEvenement_mips?dossier_mip=" . $id , array("class" => "picto bt_evenements")); ?>
  <?php echo link_to_grid(libelle("msg_bouton_remarques"),"dossier_mip/listerRemarque_mips?dossier_mip=" . $id , array("class" => "picto bt_remarques")); ?>
  <?php if (!isset($boolEstPreProjet) || !$boolEstPreProjet) : ?>
    <?php echo link_to_grid(libelle("msg_bouton_documents"), "dossier_mip/listerDocuments_mips?dossier_mip=" . $id, array("class" => "picto bt_documents")); ?>
    <?php echo link_to_grid(libelle("msg_bouton_controle"),"dossier_mip/controlerDossier_mip?id=" . $id, array("class" => "picto bt_controles")); ?>
    <?php echo link_to_grid(libelle("msg_bouton_suivi_financier"),"dossier_mip/suiviFinancierDossier_mips?dossier_mip=".$id, array("class" => "picto bt_suivi_financier")); ?>
    <?php echo link_to_grid(libelle("msg_bouton_voir_dossier"),"dossier_mip/voirDescriptionDossier_mip?id=".$id, array("class" => "picto bt_voir")); ?>
    <?php echo link_to_grid(libelle("msg_bouton_generer_lettres"), "dossier_mip/genererLettres?id=" . $id, array("class" => "picto bt_genererdocs")); ?>
   <?php endif; ?>
</fieldset>
