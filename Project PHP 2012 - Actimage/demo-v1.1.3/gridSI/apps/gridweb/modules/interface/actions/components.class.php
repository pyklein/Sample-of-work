<?php
/**
 * Description of componentsclass
 *
 * @author benjamin
 */
class interfaceComponents extends sfComponents
{
    public function executeFilAriane()
    {
        // affichage du fil d'ariane
        $this->objAriane = new Ariane();
    }
}
?>
