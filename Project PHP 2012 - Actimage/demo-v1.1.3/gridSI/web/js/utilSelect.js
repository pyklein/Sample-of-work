
/**
 * Permet de changer la valeur "disabled" d'un element si une certain valeur a été sélectionné.
 * Si la valeur a été sélectionnée l'element devient active.
 * @param selectId ID de select
 * @param selectValeur valeur attendu
 * @param elementId element à gérer
 */
function enableElementOnSelectValue(selectId, selectValeur, elementId) {
  $(document).ready(function() {

    $("#" + selectId).change(function() {
      if ($(this).val() == selectValeur) {
        $("#" + elementId).attr("disabled", false);
      } else {
        $("#" + elementId).attr("disabled", true);
      }
    });

    // initialisation
    $("#" + selectId).change();

  });
}

/**
 * Permet de cahcer les options de select "slave" selon la valeur sélectionné dans le select "master".
 * Dans le select "slave" seulement l"option avec la valeur string vide et les options où le text
 * commencent avec la même text que l'option "master" sélectionné.
 * @param selectMasterId ID de select "master"
 * @param selectSlaveId ID de select "slave"
 */
function hideOtherOptionsOnSelectValue(selectMasterId, selectSlaveId) {
  $(document).ready(function() {

    $("#" + selectMasterId).change(function() {

      // on rends tous les options visible
      $("#" + selectSlaveId + " option").show();

      // s'il y a une valeur choisi (different que string vide)
      if ($(this).val() != "") {

        // vérification pour tous les options
        $("#" + selectSlaveId + " option").each(function() {

          if ($(this).val() != ""
              && $("#" + selectMasterId + " :selected").text() != $(this).text().substr(0, $("#" + selectMasterId + " :selected").text().length)) {

            // si l'option qu'on veut cacher est la même que l'option sélectionné,
            // alors on change la valeur sélectionné à string vide
            if ($(this).val() == $("#" + selectSlaveId).val()) {
              $("#" + selectSlaveId).val("");
            }

            // on cache l'option
            $(this).hide();
          }
        });
      }
    });

    // initialisation
    $("#" + selectMasterId).change();

  });
}

/**
 * Permet de cahcer les optiongroups de select "slave" selon la valeur sélectionné dans le select "master".
 * Dans le select "slave" seulement l'option avec la valeur string vide et l'optiongroup où le text
 * commencent avec la même text que l'option "master" sélectionné.
 * @param selectMasterId ID de select "master"
 * @param selectSlaveId ID de select "slave"
 */
function hideOtherOptionGroupsOnSelectValue(selectMasterId, selectSlaveId) {
  $(document).ready(function() {

    $("#" + selectMasterId).change(function() {

      // on rends tous les options visible
      $("#" + selectSlaveId + " optgroup").show();
      // on rends tous les sous options visibles / BUG CHROME
	  $("#" + selectSlaveId + " optgroup > option").show();
	  
      // s'il y a une valeur choisi (different que string vide)
      if ($(this).val() != "") {

        // on cache tous les autre optgroup
        $("#" + selectSlaveId + " optgroup[label!='" + $("#" + selectMasterId + " :selected").text() + "']").hide();
		// on masque les sous options / BUG CHROME
		$("#" + selectSlaveId + " optgroup[label!='" + $("#" + selectMasterId + " :selected").text() + "'] > option").hide();
		
        if ($("#" + selectSlaveId + " option:selected").parents("optgroup").attr("label") != $("#" + selectMasterId + " :selected").text()) {
          $("#" + selectSlaveId).val("");
        }
      }
    });

    // initialisation
    $("#" + selectMasterId).change();

  });
}

