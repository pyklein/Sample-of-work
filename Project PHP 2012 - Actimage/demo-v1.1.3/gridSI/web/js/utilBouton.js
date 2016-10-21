
/**
 * Permet de supprimer l'attribut href d'un balise 'a'
 * @param boutonId ID de bouton
 */
function clearHref(boutonId) {
  $(document).ready(function() {
    $("#" + boutonId).attr("href", "javascript:void(0)");
  });
}

/**
 * Permet de modifier l'attribut href d'un balise 'a'
 * @param boutonId ID de bouton
 * @param valeurHref La nouvelle valeur de l'attribut href
 */
function changeHref(boutonId, valeurHref) {
  $(document).ready(function() {
    $("#" + boutonId).attr("href", valeurHref);
  });
}
