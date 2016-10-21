<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre, 'boolReinitialiser' => $boolReinitialiser)) ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_etudiant"), "referentiel_mris/creerEtudiant",array("class" =>"picto bt_ajouter")); ?>
</div>

<?php if ($objPager->getNbResults() != 0): ?>
  <table class="mep">

    <caption>
      <?php echo libelle("msg_etudiants_nombre_resultat",array($objPager->getNbResults()) ); ?>
    </caption>
   
    <th><?php echo libelle("msg_libelle_action"); ?></th>
    <th><?php echo libelle("msg_libelle_etudiant_nom"); ?></th>
    <th><?php echo libelle("msg_libelle_etudiant_prenom"); ?></th>
    <th><?php echo libelle("msg_libelle_email"); ?></th>
    <th><?php echo libelle("msg_libelle_statut"); ?></th>
    <th><?php echo libelle("msg_libelle_statut_systeme"); ?></th>

    <?php foreach ($objPager->getResults() as $intCle => $objEtudiant ): ?>
      <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php echo link_to_grid("","referentiel_mris/modifierEtudiant?id=".$objEtudiant->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier"))); ?>
          <?php
          echo $objEtudiant->getEstActif() ?
                  link_to_grid("","referentiel_mris/changerActivationEtudiant?id=".$objEtudiant->getId(), array("class" => "picto_court bt_desactiver","title"=> libelle("msg_bouton_desactiver"))) :
                  link_to_grid("","referentiel_mris/changerActivationEtudiant?id=".$objEtudiant->getId(), array("class" => "picto_court bt_activer","title" => libelle("msg_bouton_activer")))
          ?>
        </td>
        <td>
          <?php echo $objEtudiant->getNom(); ?>
        </td>
        <td>
          <?php echo $objEtudiant->getPrenom(); ?>
        </td>
        <td>
          <?php echo $objEtudiant->getEmail(); ?>
        </td>
        <td>
          <?php echo "Etudiant" ?>
        </td>
        <td>
          <?php echo $objEtudiant->getEstActif()? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?>
        </td>
     <?php endforeach ?>
  </table>
  <br>
  <?php if ($objPager->haveToPaginate()) : ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>
  
<?php else: ?>
    <table class="mep">
      <caption>
        <?php echo libelle("msg_etudiant_aucun_resultat"); ?>
      </caption>
    </table>

<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>