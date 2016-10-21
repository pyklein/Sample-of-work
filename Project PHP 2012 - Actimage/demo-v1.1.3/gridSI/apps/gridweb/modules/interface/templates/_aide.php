
<?php if (sfContext::getInstance()->getUser()->isAuthenticated()) { ?>

  <?php
    $objAide = new Aide();
    $boolAideAffiche = sfContext::getInstance()->getUser()->hasAttribute("aide");
    $boolAideAffiche = $objAide->hasAide();
  ?>

  <div id="aide" class="<?php echo $boolAideAffiche ? "" : "off" ?>">

    <div class="header">
      Aide en ligne
    </div>

    <div class="body">
      <?php $contenu = $objAide->getAide(); ?>
      <?php if ($contenu) { ?>
        <?php echo $contenu ?>
      <?php } else { ?>
        <?php echo libelle("msg_libelle_information_non_disponible"); ?>.
      <?php } ?>
    </div>
  </div>

  <?php if (sfConfig::get("app_effects") == "true") { ?>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#help a').click(function() {

          // on n'utilise pas le lien par défaut
          var a = $('#help').find('a');
          a.attr("href", "javascript:void(0)");

          // aide affiché -> il faut enlever
          if (a.hasClass("active")) {

            // on change l'icône de bouton
            a.removeClass("active");

            // requete AJAX pour enregistrer le changement dans le session aussi
            $.ajax({
              'url' : '<?php echo url_for("interface/changerEtatAide?valeur=0", true); ?>'
            });

            // on cache l'aide en ligne
            $('#aide').fadeOut(500, 'swing', function() {
              // si terminé on mets à jour la page
              $('#col2').removeClass("on");
              $('#col2').attr("style", "");
            });

          // aide n'est pas affiché -> il faut afficher
          } else {

            // on change l'icône de bouton
            a.addClass("active");

            // requete AJAX pour enregistrer le changement dans le session aussi
            $.ajax({
              'url'  : '<?php echo url_for("interface/changerEtatAide?valeur=1", true); ?>',
              'type' : 'GET',
              'cache': false
            });

            // on mets à jour la page
            $('#col2').addClass("on");
            $('#col2').attr("style", "");
            // on affiche l'aide en ligne
            $('#aide').fadeIn(1000, 'swing');
          }
        });
      });
    </script>
  <?php } ?>
<?php } ?>
