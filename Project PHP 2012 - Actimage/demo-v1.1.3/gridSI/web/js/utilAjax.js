
var updaterArray = new Array();

/**
 * Permet de mettre à jour un element par AJAX
 * @param url URL de l'action appelé
 * @param element selecteur JQuery de l'element
 */
function updateElement(url, element) {
  $(document).ready(function() {
    
    // on execute uniquement si le derniere appel est déjà terminé
    if (updaterArray[element] != true) {
      $.ajax({
          'method'   : 'get',
          'url'      : url,
          'dataType' : 'text',
          'success'  : function (text) {
                          $(element).html(text);
                          updaterArray[element] = false;
                       }
      });
      updaterArray[element] = true;
    }
  });
}

/**
 * Permet de mettre à jour un element par AJAX periodiquement
 * @param url URL de l'action appelé
 * @param period period en millisecond
 * @param element selecteur JQuery de l'element
 */
function periodicalUpdater(url, period, element) {
  $(document).ready(function() {
    setInterval(updateElement, period, url, element);
  });
}

/**
 * Permet de remplacer l'appel "normal" avec un appel AJAX d'un bouton (lien)
 * @param element selecteur JQuery de l'element
 */
function ajaxBouton(element) {
  $(document).ready(function() {
    
    var href = $(element).attr('href');

    $(element).click(function() {
      $.ajax({
          'method'   : 'get',
          'url'      : href
      });
    });

    $(element).attr('href', 'javascript:void(0)');
  });
}
