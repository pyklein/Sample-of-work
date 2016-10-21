<?php

/**
 * A mettre avent le contenu de PDF
 * @author Gabor JAGER
 */
function pdf_debut()
{
  ob_clean();
  ob_start();
  ?>
  <link type="text/css" href="<?php echo sfConfig::get("sf_web_dir") ?>/css/pdf.css" rel="stylesheet">
  <?php
}

/**
 * A mettre à la fin de contenu PDF
 * @param string $strNomFichier nom de téléchargement du fichier
 * @param string $strTitre titre de document
 * @author Gabor JAGER
 */
function pdf_fin($strNomFichier="", $strTitre = "")
{
  $strContent = ob_get_clean();
  
  require_once(sfConfig::get("sf_lib_dir").'/vendor/html2pdf_v4/html2pdf.class.php');
  $objPdf = new HTML2PDF('P','A4','fr', false);

  $objPdf->pdf->SetAuthor(sfConfig::get("sf_projet_nom")." ".sfConfig::get("sf_projet_version"));
  $objPdf->pdf->SetTitle($strTitre != "" ? $strTitre : sfConfig::get("sf_projet_nom")." ".sfConfig::get("sf_projet_version"));

  $objPdf->setTestIsImage(false);

  $utilString = new UtilString();

  $strContent = utf8_decode($utilString->filtrer_balises($strContent, array("script")));

  // signe euro
  $strContent = str_replace(array("€", "&euro;"), chr(128), $strContent);
  
  $objPdf->writeHTML($strContent);
  $objPdf->Output($strNomFichier, 'D');
  exit();
}
