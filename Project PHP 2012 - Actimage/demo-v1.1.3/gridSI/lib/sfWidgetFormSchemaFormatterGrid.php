<?php
/**
 * Formulaire decorateur
 *
 * @author Gabor JAGER
 */
class sfWidgetFormSchemaFormatterGrid extends sfWidgetFormSchemaFormatter
{  
  protected $rowFormat = '<div class="formulaire_ligne">
                            %label% : %field%%help%%error%%hidden_fields%
                          </div>';
  protected $errorRowFormat         = '<ul>%errors%</ul>';
  protected $errorListFormatInARow  = "<p class=\"erreur\"></p>
                                       <ul class=\"error_list\">
                                         %errors%
                                       </ul>";
  protected $errorRowFormatInARow      = "    <li>%error%</li>\n";
  protected $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>\n";

  protected $helpFormat      = '%help%';
  protected $decoratorFormat = "<div>\n %content%</div>";
}
