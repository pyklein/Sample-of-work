
<?php if (sfContext::getInstance()->getUser()->getUtilisateur()) { ?>
  <?php $objUtilisateur = sfContext::getInstance()->getUser()->getUtilisateur(); ?>
  <div id="user">
    <div id="tools">
      <?php echo link_to_grid("", "utilisateurs/editerProfil", array("class" => "edit", "title" => libelle('msg_module_utilisateurs_editermonprofil'))); ?>
      <a href="<?php echo url_for('@deconnecter'); ?>" title="<?php echo libelle('msg_bouton_deconnecter'); ?>" class="deco"></a>
    </div>
    <h3><?php echo $objUtilisateur; ?></h3>
    <p>
      <?php
        $strTousProfils = "";
        foreach($objUtilisateur->getProfils() as $objProfil) {
          $strTousProfils .= ($strTousProfils == "" ? "" : ", ").$objProfil;
        }
      ?>

      <span title="<?php echo $strTousProfils; ?>">
        <?php echo $objUtilisateur->getProfil(true); ?>
      </span>
    </p>
  </div>
<?php } else { ?>
  <div id="user">
    <h3><?php echo libelle('msg_libelle_anonymous'); ?></h3>
  </div>
<?php } ?>
