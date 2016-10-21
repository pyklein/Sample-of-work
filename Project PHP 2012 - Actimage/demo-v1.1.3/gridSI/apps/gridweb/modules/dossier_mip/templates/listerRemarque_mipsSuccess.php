
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<div class="reduit">
  <?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre, 'boolReinitialiser' => true)) ?>

  <?php foreach ($arrRemarques as $objRemarque): ?>
    <br>
    <br>

    <?php echo libelle("msg_remarque_mip_header",array(formatDate($objRemarque->getUpdatedAt()),
                                                       formatHeure($objRemarque->getUpdatedAt()),
                                                       $objRemarque->getUtilisateurCreatedBy()->getPrenom(),
                                                       strtoupper($objRemarque->getUtilisateurCreatedBy()->getNom()),
                                                       $objRemarque->getUtilisateurCreatedBy()->getProfil()->getIntitule()
                                                      )
                      );
    ?>
    <br>
    <fieldset>
      <?php echo $objRemarque->getRaw('contenu') ?>
    </fieldset>
    <?php if (($objUser->getUtilisateur()->getId() == $objRemarque->getCreated_by())) :?>
      <div class="right">
        <?php echo link_to_grid(libelle("msg_remarque_mip_libelle_edit"),"dossier_mip/modifierRemarque_mip?id=".$objRemarque->getId(), array('class' => 'picto bt_modifier')) ?>
        <?php echo link_to_grid(libelle("msg_remarque_mip_libelle_del"),"dossier_mip/supprimerRemarque_mip?id=".$objRemarque->getId(), array('class' => 'picto bt_supprimer')) ?>
      </div>
    <?php endif; ?>
  <?php endforeach ?>
    
  <?php if ($objDossier->getEstActif()): ?>
    <form action="" method="post">
      <fieldset class="fieldset_formulaire">
        <legend>
          <?php echo libelle("msg_module_dossier_mip_action_creer_remarquemip") ?>
        </legend>
        <?php echo $objForm; ?>
        <div class="boutons">
          <input type="submit" value="<?php echo libelle("msg_bouton_creer"); ?>" />
        </div>
      </fieldset>
      <br />
    </form>
  <?php endif; ?>
</div>

<?php include_partial('autreActions',array('id' => $objDossier->getId(),'boolEstPreProjet' => $objDossier->estPreProjet(),'objDossier'=>$objDossier)) ?>

<hr class="clear">
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>