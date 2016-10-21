
/**
 * Permet de séléctionner ou déselectionner tous les checkbox
 * @param checkAllId ID de checkbox maitre
 * @param checkboxName nom des checkbox à gérer
 */
function checkAll(checkAllId, checkboxName) {
  $(document).ready(function(){
    $("#" + checkAllId).click(function() {
      var checked_status = this.checked;
      $("input:checkbox[name=" + checkboxName + "]").each(function() {
        this.checked = checked_status;
      });
    });
  });
}

/**
 * Permet d'activer ou de desactiver un élément
 * @param checkId ID de checkbox maitre
 * @param elementId id de l'élément
 */
function activateOnCheck(checkId, elementId) {
  $(document).ready(function() {

    //si la case 'est_executant' est cochée alors on active le champ code executant et inversement.
    $('#'+checkId).change(function() {
      if($('#'+checkId).attr('checked')){
        $('#'+elementId).attr("disabled", false);
      }else{
        $('#'+elementId).attr("disabled", true);
      }
    });

    $('#'+checkId).change();

  });
}