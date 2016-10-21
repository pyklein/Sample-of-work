
<script type="text/javascript">

  function initEffets() {
    <?php if (sfConfig::get("app_effects") != "true") { ?>
        return false;
    <?php } ?>
    $(document).ready(function() {
      $('.error_list').each(function(index) {

        var inputP = $(this).parent();

        // pour les checkbox
        var inputElement = inputP.find(':input');

        if (inputElement != null) {

          switch (inputElement.attr('type')) {
            case "radio":
            case "select-one":
            case "checkbox":
              inputElement.change(function() {
                inputP.find('.erreur').hide('slow');
                inputP.find('.error_list').hide('slow');
              });
              break;
            default:
              inputElement.keydown(function() {
                inputP.find('.erreur').hide('slow');
                inputP.find('.error_list').hide('slow');
              });
              break;
          }
        }
      });

      hideOnClick('.erreurMessage');
      hideOnClick('.succesMessage');
      hideOnClick('.warningMessage');

    });
  }

  initEffets();
</script>
