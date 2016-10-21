<?php

require_once sfConfig::get('sf_lib_dir').'/vendor/phprtflite/lib/PHPRtfLite.php';
require_once sfConfig::get('sf_lib_dir').'/vendor/simplehtmldom/simple_html_dom.php';

/**
 * Description of Html2Rtf
 *
 * @author Gabor JAGER
 */
class Html2Rtf
{
  /**
   * Si les information debug affiche dans le document generé ou pas
   * @var boolean
   */
  private $DEBUG = false;

  /**
   * Les balises non prise en compte dans le render (ces balises sont traités automatiquement)
   * @var string[]
   */
  private $ignoredTags = array("br", "strong", "b", "u", "em");

  /**
   * Largeur de papier (en cm)
   * @var float
   */
  private $PAPER_WIDTH = 21;

  /**
   * Hauteur de papier (en cm)
   * @var float
   */
  private $PAPER_HEIGHT = 29.7;

  /**
   * Largeur du champ de text (sans les margins)
   * @var float
   */
  private $textWidth;

  
  /**
   * Document RTF
   * @var PHPRtfLite
   */
  private $rtf;

  /**
   * Section principale
   * @var PHPRtfLite_Container_Section
   */
  private $section;

  /**
   * Header (en tête)
   * @var PHPRtfLite_Container_Header
   */
  private $header;

  /**
   * Table
   * @var PHPRtfLite_Table
   */
  private $table;

  /**
   * Nom de containeur
   * @var string
   */
  private $containeur;

  /**
   *
   * @var PHPRtfLite_Font
   */
  private $phpRtfLite_font;

  /**
   *
   * @var PHPRtfLite_ParFormat
   */
  private $align;

  private $CENTER;
  private $LEFT;
  private $RIGHT;
  private $JUSTIFY;

  /**
   *
   * @var simple_html_dom
   */
  private $html;

  /**
   * Constructeur
   */
  public function __construct()
  {
    // Autoloader de la classe PHPRtfLite (spl)
    PHPRtfLite::registerAutoloader();

    // créer les instances
    $this->rtf               = new PHPRtfLite();
    $this->phpRtfLite_font   = new PHPRtfLite_Font();

    // constantes d'alignements
    $this->CENTER            = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
    $this->LEFT              = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT);
    $this->RIGHT             = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
    $this->JUSTIFY           = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY);

    // initialisation d'alignement
    $this->setAlign();
  }

  /**
   * Enregistre le contenu dans un fichier
   * @param string $strNomFichier chemin complète du fichier
   */
  public function save($strNomFichier)
  {
    // enregistrer le fichier RTF
    $this->rtf->save($strNomFichier);
  }

  /**
   * Convert le string passé en parametre en RTF
   * @param string $strTextHtml
   */
  public function doRtf($strTextHtml)
  {
    $strTextHtml = $this->cleanUpHtml($strTextHtml);
    
    // Créer un objet DOM
    $this->html = str_get_html($strTextHtml);

    // add section
    $this->newSection();

    $html = $this->html->find("html", 0);
    
    // margins
    $this->rtf->setMargins($html->left ? $html->left : 2,
                           $html->top ? $html->top : 2,
                           $html->right ? $html->right : 1,
                           $html->bottom ? $html->bottom : 2);

    // taille de page
    $this->rtf->setPaperWidth($this->PAPER_WIDTH);
    $this->rtf->setPaperHeight($this->PAPER_HEIGHT);

    // taille de text "champ"
    $this->textWidth = $this->rtf->getPaperWidth() - ($this->rtf->getMarginLeft() + $this->rtf->getMarginRight());

    $this->render($html);
  }

  /**
   * Render un element
   * @param element $element
   */
  private function render($element)
  {
    $this->log("render(".$element->tag.") - containeur: ".$this->containeur);

    foreach ($element->children() as $elementChild)
    {
      if (!in_array(strtolower($elementChild->tag), $this->ignoredTags))
      {
        switch(strtolower($elementChild->tag))
        {
          case "head":
            $this->containeur = "header";
            $this->header = $this->section->addHeader();
            $this->render($elementChild);
            break;
          case "body":
            $this->containeur = "section";
            $this->render($elementChild);
            break;
          case "table":
            $this->tag_table($elementChild);
            break;
          case "div":
            $this->tag_div($elementChild);
            break;
          default:
            throw new Exception("L'element '".$elementChild->tag."' n'est pas supporté.");
            break;
        }
      }
    }

    $this->log("end render(".$element->tag.")");
  }

  /**
   * Change l'alignement du text
   * @param string $strAlign center, justify, right ou left
   */
  private function setAlign($strAlign = "left")
  {
    switch (strtolower($strAlign))
    {
      case "center":
        $this->align = $this->CENTER;
        break;
      case "justify":
        $this->align = $this->JUSTIFY;
        break;
      case "right":
        $this->align = $this->RIGHT;
        break;
      case "left":
      default:
        $this->align = $this->LEFT;
        break;
    }
    
    $this->log("setAlign - align: ".$strAlign);

  }

  /**
   * Render un IMG
   * @param element $element
   */
  private function tag_img($element)
  {
    if (!file_exists($element->src) || !is_readable($element->src))
    {
      throw new Exception("Le fichier '".$element->src."' n'existe pas.");
    }

    $image = $this->{$this->containeur}->addImage($element->src);

    if ($element->width)
    {
      $image->setWidth($element->width);
    }
    if ($element->height)
    {
      $image->setHeight($element->height);
    }

    // border
    if ($element->border)
    {
      $intBorder = $element->border;
    }
    else
    {
      $intBorder = 1;
    }

    $border = new PHPRtfLite_Border(
        $this->rtf,
        new PHPRtfLite_Border_Format($intBorder, '#000000'),
        new PHPRtfLite_Border_Format($intBorder, '#000000'),
        new PHPRtfLite_Border_Format($intBorder, '#000000'),
        new PHPRtfLite_Border_Format($intBorder, '#000000')
    );
    $image->setBorder($border);
  }

  /**
   * Render un DIV
   * @param element $element
   */
  private function tag_div($element)
  {
    if ($element->align)
    {
      $this->setAlign($element->align);
    }
    else
    {
      $this->setAlign();
    }

    // on récupere les childs
    $arrChildren = $this->getElementsChildren($element);

    // pas de balise html
    if (count($arrChildren) == 0)
    {
      $this->{$this->containeur}->writeText($element->innertext, $this->phpRtfLite_font, $this->align);
    }

    // s'il y a encore des elements dedans
    else
    {
      
      // si on a un firstChild -> on vérifie s'il y a des textes avac ce noeud
      if (count($arrChildren) > 0)
      {
        $this->writePreText($element, $arrChildren[0]);
      }
      
      // on render tous les childs
      foreach ($arrChildren as $elementChild)
      {
        // image
        if (strtolower($elementChild->tag) == "img")
        {
          $this->tag_img($elementChild);
        }

        // autre
        else
        {
          $this->render($elementChild);
        }
      }
      
      // il y a plusieurs childs -> il faut voir les textes après le derniere
      if (count($arrChildren) > 0)
      {
        $this->writePostText($element, $arrChildren[count($arrChildren) - 1]);
      }
    }

    // fermeture de div
    $this->{$this->containeur}->writeText("", $this->phpRtfLite_font, $this->align);
  }

  /**
   * Recupere tous les childs (non-ignoré) d'un element
   * @return element[]
   */
  private function getElementsChildren($element)
  {
    $arrChildren = array();
    foreach ($element->children() as $elementChild)
    {
      if (!in_array($elementChild->tag, $this->ignoredTags))
      {
        $arrChildren[] = $elementChild;
      }
    }

    return $arrChildren;
  }

  /**
   * Ecrire le texte avant l'element child
   * @param element $element
   * @param element $child
   */
  private function writePreText($element, $child)
  {
    $this->{$this->containeur}->writeText($this->getPreText($element, $child), $this->phpRtfLite_font, $this->align);
  }

  /**
   * Recupère le texte avant l'element child
   * @param element $element
   * @param element $child
   * @return string
   */
  private function getPreText($element, $child)
  {
    $strPreText = substr($element->innertext, 0, strpos($element->innertext, $child->outertext));
    $this->log("  pretext: ".$strPreText);
    return $strPreText;
  }

  /**
   * Ecrire le texte après l'element child
   * @param element $element
   * @param element $child
   */
  private function writePostText($element, $child)
  {
    $this->{$this->containeur}->writeText($this->getPostText($element, $child), $this->phpRtfLite_font, $this->align);
  }

  /**
   * Recupère le texte après l'element child
   * @param element $element
   * @param element $child
   * @return string
   */
  private function getPostText($element, $child)
  {
    $strPostText = substr($element->innertext, strrpos($element->innertext, $child->outertext) + strlen($child->outertext));
    $this->log("  posttext: ".$strPostText);
    return $strPostText;
  }

  /**
   * Render un TABLE
   * @param element $element
   */
  private function tag_table($element)
  {
    // on créer la table
    $this->table = $this->{$this->containeur}->addTable();

    // boucle sur les TRs
    foreach ($element->children() as $tr)
    {
      if (strtolower($tr->tag) != "tr")
      {
        throw new Exception("Balise '".$tr->tag."' inattendu dans 'table'.");
      }

      $this->tag_tr($tr);
    }
  }

  /**
   * Render un TR
   * @param element $element
   */
  private function tag_tr($element)
  {
    // on ajout une ligne
    $this->table->addRow();

    // boucle sur les TDs - pour vérifier
    foreach ($element->children() as $td)
    {
      if (strtolower($td->tag) != "td")
      {
        throw new Exception("Balise '".$td->tag."' inattendu dans 'tr'.");
      }
    }

    // ajouter les TDs
    $width = $this->textWidth / count($element->children());
    $arrColumns = array();
    foreach ($element->children() as $td)
    {
      $arrColumns[] = $width;
    }
    $this->table->addColumnsList($arrColumns);

    foreach ($element->children() as $intNoCell => $td)
    {
      $this->tag_td($td, $intNoCell + 1);
    }
  }

  /**
   * Render un TD
   * @param element $element
   * @param integer $intNoCell
   */
  private function tag_td($element, $intNoCell)
  {
    $cell = $this->table->getCell(count($this->table->getRows()), $intNoCell);
    if ($element->align)
    {
      $cell->setTextAlignment($element->align);
    }

    $cell->writeText($element->innertext);
  }

  /**
   * Crée un nouveau section
   */
  private function newSection()
  {
    $this->section = $this->rtf->addSection();
  }

  /**
   *
   * @param string $strTextHtml
   * @return string
   */
  private function cleanUpHtml($strTextHtml)
  {
    $strTextHtml = str_replace(array("\n", "\r"), "", $strTextHtml);
    $strTextHtml = trim($strTextHtml);
    while(strpos($strTextHtml, "  "))
    {
      $strTextHtml = str_replace("  ", " ", $strTextHtml);
    }
    $strTextHtml = str_replace("> <", "><", $strTextHtml);
    $strTextHtml = str_replace("> ", ">", $strTextHtml);
    $strTextHtml = str_replace(" <", "<", $strTextHtml);

    return $strTextHtml;
  }

  /**
   * Message de log
   * @param string $strMessage
   */
  private function log($strMessage)
  {
    if ($this->DEBUG && isset($this->containeur))
    {
      $this->{$this->containeur}->writeText("<i>".$strMessage."</i>", $this->phpRtfLite_font, $this->align);
    }
  }
}
