<?php
/**
 * Utilitaire de string
 * @author Gabor JAGER
 */
class UtilString
{

  /**
   * Permet de filtrer des balises et leurs contenus
   * @param string $strContenu contenu à filtrer
   * @param string[] $arrBalises liste des balises
   * @return string contenu filtré
   * @author Gabor JAGER
   */
  public function filtrer_balises($strContenu, $arrBalises)
  {
    foreach($arrBalises as $intI => $strBalise)
    {
      $arrBalises[$intI] = '@<'.$strBalise.'[^>]*?>.*?</script>@si';
    }
    
    return preg_replace($arrBalises, '', $strContenu);
  }

  public function filtrer_balises_pour_csv($strContenu)
  {
    $strContenu = strip_tags($strContenu);
    $strContenu = trim($strContenu);

    return $strContenu;
  }
}
