<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of chargerThumbnailEtudiantAction
 *
 * @author Jihad
 */
class chargerThumbnailEtudiantAction extends gridAction{

  public function  execute($request) {
     $this->chargerThumbnail($request->getParameter("path"),$request->getParameter("fichier"));
  }
}
?>
