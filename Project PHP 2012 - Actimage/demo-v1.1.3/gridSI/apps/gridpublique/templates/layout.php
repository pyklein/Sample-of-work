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
  <body>

    <div id="page" class="off">
    
      <div id="global">
        <div id="head">
          <div id="logo_ministere"><a name="top"></a></div>
          <div id="logo_grid"></div>
          <div id="logo_service_mip" class="publique"></div>
        </div>
        <div id="main">
<!--          <div id="col1">
            <?php // include_partial("interface/menu2"); ?>
            <hr class="clear" />
          </div>-->
          <div id="col2" class="publique">
            <?php // include_partial("interface/menu"); ?>
              <div id="content">
                <?php // include_component_slot('fil-ariane'); ?>
                
                <?php echo $sf_content ?>
              </div>
          </div>
          <hr class="clear" />
        </div>
        <div id="bottom">
          <span class="lien_haut publique">
            <a href="#top" title="Retour en haut">Retour en haut</a>
          </span>
          <?php echo sfConfig::get("sf_projet_nom") ?> <?php echo sfConfig::get("sf_projet_version"); ?> &copy; Ministère de la Défense DGA - Powered by Actimage
        </div>
      </div>

      <?php // include_partial("interface/aide"); ?>
      
    </div>
    <?php // include_partial("interface/effectJquery"); ?>
  </body>
</html>
