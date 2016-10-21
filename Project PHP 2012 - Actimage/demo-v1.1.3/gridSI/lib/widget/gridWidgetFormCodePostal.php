<?php

if (sfContext::hasInstance())
{
  sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery-ui-1.8.10.custom.min.js", 'last');
}

/**
 * Input code postal
 * @author Gabor JAGER
 */
class gridWidgetFormCodePostal extends sfWidgetFormInputCodePostal
{
  /**
   * ID de widget ville
   * @var string
   */
  private $strWidgetFormVilleId = "";

  /**
   * Permet d'enregistrer l'ID de widget ville
   * @param string $strWidgetFormVilleId
   */
  public function setWidgetFormVille($strWidgetFormVilleId)
  {
    $this->strWidgetFormVilleId = $strWidgetFormVilleId;
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $strHtml = parent::render($name, $value, $attributes, $errors);

    // bouton de la version sans Javascript
    $strHtml .= '<span>
                   <input type="submit" name="chargerVilles" title="'.libelle("msg_bouton_charger_villes").'" alt="'.libelle("msg_bouton_charger_villes").'" value="'.libelle("msg_bouton_charger_villes").'" class="submit_court bt_valider_small">
                 </span>';

    // gestion javascript
    $strHtml .= '<script type="text/javascript">
                   var reqAjax = null;

                   function miseAJourWidgetVille() {

                      // on annule ancien requete ajax
                      if (reqAjax != null) {
                        reqAjax.abort();
                        reqAjax = null;
                      }

                      // s il y a au moins 2 caracteres de code postal
                      if ($("#'.$this->generateId($name).'").val().length >= 2) {

                        reqAjax = $.ajax({
                          url        : "'.url_for("interface/chargerWidgetVille", true).'",
                          data       : "cp=" + $("#'.$this->generateId($name).'").val(),
                          beforeSend : function() {
                            $("#'.$this->generateId($name).'").parent().find(".ajax_loader").show();
                          },
                          success    : function(data) {
                            if ($("#'.$this->generateId($name).'").val().length >= 2) {
                              var valeurSelect = $("#'.$this->strWidgetFormVilleId.'").val();
                              $("#'.$this->strWidgetFormVilleId.'").html(data);
                              $("#'.$this->strWidgetFormVilleId.'").val(valeurSelect);
                            }
                            $("#'.$this->generateId($name).'").parent().find(".ajax_loader").hide();
                          }

                        });

                      } else {

                        $("#'.$this->strWidgetFormVilleId.'").find("option[value!=\'\']").remove();
                        $("#'.$this->generateId($name).'").parent().find(".ajax_loader").hide();

                      }
                   }

                   $(document).ready(function() {
                      $("#'.$this->generateId($name).'").parent().find("input[type=submit]").hide();
                      $("#'.$this->generateId($name).'").parent().append(" <span class=\'picto_court_popup ajax_loader hidden\'>&nbsp;</span>");
                      
                      $("#'.$this->generateId($name).'").keyup(function(event) {
                        // uniquement les chiffres
                        if (event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 8 || event.keyCode == 86 || (event.keyCode >= 96 && event.keyCode <= 105)) {
                          miseAJourWidgetVille();
                        }
                      });
                   });
                 </script>';
    
    return $strHtml;
  }
}
