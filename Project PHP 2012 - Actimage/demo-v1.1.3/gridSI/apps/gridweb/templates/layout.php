<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body class="<?php if (!sfContext::getInstance()->getUser()->isAuthenticated()) : ?>home<?php endif; ?>">

    <?php $objAide = new Aide(); ?>
    
      <div id="global">
        <div id="head">
          <div id="logo_ministere"><a name="top"></a></div>
          <div id="logo_grid">
            <a href="<?php echo url_for('@accueil'); ?>">
              <?php if (sfContext::getInstance()->getUser()->isAuthenticated()) : ?>

                <?php $utilUrl = new UtilUrl(); ?>
                <img src="<?php echo $utilUrl->getUrlBase(); ?>/images/interface/logo_grid.png" alt="" border="0" />
              <?php endif;?>
            </a>
          </div>

          <?php include_partial("interface/logo"); ?>

          <?php include_partial("interface/utilisateur"); ?>
        </div>
        <div id="main">
          <?php $user = sfContext::getInstance()->getUser();
		  $boolHasOtherMetierThanAdmin = $user->isAuthenticated() && $user->hasMetier(MetierTable::BPI) || $user->hasMetier(MetierTable::MRIS) || $user->hasMetier(MetierTable::MIP);
          if($boolHasOtherMetierThanAdmin) : ?>
          <div id="col1">
            <?php include_partial("interface/menu2"); ?>
            <hr class="clear" />
          </div>
          <?php endif; ?>

          <?php include_partial("interface/aide"); ?>

          <div id="col2" class="<?php if ($objAide->hasAide()) : ?> on<?php endif; ?><?php if(!$boolHasOtherMetierThanAdmin) : ?> nomenu<?php endif; ?>">
            <?php include_partial("interface/menu"); ?>
            <div id="content">
              <?php include_component_slot('fil-ariane'); ?>
              <span id="help"><a href="<?php echo $objAide->getAideUrl(); ?>" title="<?php echo $objAide->hasAide() ? libelle("msg_bouton_desactiver_aide") : libelle("msg_bouton_activer_aide"); ?>"<?php if ($objAide->hasAide()) : ?> class="active"<?php endif; ?>></a></span>

              <h2>
                <?php $objAriane = sfContext::getInstance()->getUser()->getFlash("ariane"); ?>
                <?php if($objAriane->getNomModule() == "") { ?>
                  <?php echo $objAriane->getLabelAccueil(); ?>
                <?php } else if($objAriane->getNomAction() == "") { ?>
                  <?php echo $objAriane->getLabelModule(); ?>
                <?php } else { ?>
                  <?php echo $objAriane->getLabelAction(); ?>
                <?php } ?>
              </h2>

              <?php echo $sf_content ?>
            </div>
          </div>
          <hr class="clear" />
        </div>
        <div id="bottom">
          <span class="lien_haut">
            <a href="#top" title="Retour en haut">Retour en haut</a>
          </span>
          <a href="<?php echo url_for('utilisateurs/afficherMentionCnil')?>" title="Mention CNIL">Mention CNIL</a> - <a href="#" title="Documentation en ligne">Documentation en ligne</a> - <?php echo sfConfig::get("sf_projet_nom") ?> <?php echo sfConfig::get("sf_projet_version"); ?> &copy; Ministère de la Défense DGA - Powered by Actimage
        </div>
      </div>

    <?php include_partial("interface/effectJquery"); ?>
  </body>
</html>
