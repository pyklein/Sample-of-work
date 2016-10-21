
var formulaireOrig;
var boolIsSubmitFormulaire;

/**
 * Mettre à jour un formulaire dans un popup
 * @param objForm Formulaire déjà sélectionné
 * @param strLienId Id de lien vers le popup
 * @param boolReload Si après le popup (réussi) on veut recharger la page ou juste mettre à jour un select
 * @author Gabor JAGER
 */
function miseAJourForm(objForm, strLienId, boolReload) {

  $(document).ready(function() {
    objForm.submit(function() {
      $.fancybox.showActivity();
      $.ajax({
          'type'      : 'POST',
          'data'      : objForm.serialize(),
          'url'       : $('#' + strLienId).attr('href'),
          'success'   : function(data) {
                          $.fancybox.hideActivity();
                          $.fancybox.center();

                          // formulaire erreur ou la réponse n'est pas un objet
                          if (typeof data != 'object') {

                            // formulaire erreur
                            if (data != '') {
                              $('#fancybox-content').html(data);
                              miseAJourBoutonRetour($('#fancybox-content').find('.bt_retour'));
                              miseAJourForm($('#fancybox-content').find('form'), strLienId, boolReload);
                              initEffets();

                            // pas d'erreur
                            } else {

                              // on recharge la page
                              if (boolReload) {
                                location.reload();

                              // on ferme le popup
                              } else {
                                $.fancybox.close();
                                activerSubmit(formulaireOrig);
                              }
                            }


                          // formulaire terminé
                          } else {

                            // s'il faut recharger la page (GET)
                            if (boolReload) {
                              location.reload();

                            // s'il faut mettre à jour un element 'select'
                            } else {
                              $.fancybox.close();
                              var select = $('#' + strLienId).parent().find('select');

                              if (data.select) {

                                // select avec optgroup
                                if (data.select.groupe) {

                                  // on vérifie si l'optgroup déjà existe
                                  var groups = select.find('optgroup');
                                  var found = false;
                                  groups.each(function() {
                                    if ($(this).attr("label") == data.select.groupe) {
                                      found = true;
                                    }
                                  });

                                  // il faut créer l'optgroup
                                  if (!found) {
                                    select.append('<optgroup label="' + data.select.groupe + '"></optgroup>');
                                  }

                                  // on rajoute l'option à l'optgroup
                                  select.find('optgroup[label=' + data.select.groupe + ']').append('<option value="' + data.select.valeur + '">' + data.select.libelle + '</option>');
                                  select.val(data.select.valeur);

                                // select sans groups
                                } else {
                                  select.append('<option value="' + data.select.valeur + '">' + data.select.libelle + '</option>');
                                  select.val(data.select.valeur);
                                }
                              }

                              activerSubmit(formulaireOrig);
                            }
                          }

                          return false;
                        },
          'error'     : function() {

                          $.fancybox.hideActivity();
                          $.fancybox.center();

                          alert('error');

                          activerSubmit(formulaireOrig);

                          return false;
                        }
      });

      return false;
    });
  });
}

function activerSubmit() {
  boolIsSubmitFormulaire = true;
}

function desactiverSubmit() {
  boolIsSubmitFormulaire = false;
}

/**
 * Corrige le lien de bouton retour
 * @param objBouton Bouton déjà sélectionné
 * @author Gabor JAGER
 */
function miseAJourBoutonRetour(objBouton) {

  $(document).ready(function() {
    objBouton.attr('href', 'javascript:void(0)');
    objBouton.click(function() {
      $.fancybox.close();
    });
  });

}

/**
 * Initialise un popup
 * @param strLienId Id de lien vers le popup
 * @param boolReload Si après le popup (réussi) on veut recharger la page ou juste mettre à jour un select
 * @author Gabor JAGER
 */
function initFancybox(strLienId, boolReload) {

  $(document).ready(function() {

    formulaireOrig = $('form');

    formulaireOrig.submit(function() {
      return boolIsSubmitFormulaire;
    });

    $('#' + strLienId).fancybox({
      'transitionIn'   : 'elastic',
      'transitionOut'  : 'elastic',
      'speedIn'        : 600,
      'speedOut'       : 200,
      'overlayColor'   : '#fff',
      'overlayOpacity' : 0.8,
      'centerOnScroll' : true,
      'onComplete'     : function() {
                           desactiverSubmit(formulaireOrig);
                           miseAJourBoutonRetour($('#fancybox-content').find('.bt_retour'));
                           miseAJourForm($('#fancybox-content').find('form'), strLienId, boolReload);
                         },
      'onClosed'       : function() {
                           activerSubmit(formulaireOrig);
                         }
    });
  });

}
