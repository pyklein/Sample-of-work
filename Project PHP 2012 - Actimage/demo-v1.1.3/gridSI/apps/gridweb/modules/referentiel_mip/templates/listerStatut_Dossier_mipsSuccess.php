<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_bouton_ajouter_statut"), "referentiel_mip/creerStatut_Dossier_mip",array("class" =>"picto bt_ajouter")); ?>
</div>

<?php if ($objStatuts->count()!= 0): ?>
  <table class="mep">
    <caption>
      <?php echo libelle("msg_statuts_nombre_resultat",array($objStatuts->count())); ?>
    </caption>

    <th><?php echo libelle("msg_libelle_action"); ?></th>
    <th><?php echo libelle("msg_libelle_intitule"); ?></th>
    <th><?php echo libelle("msg_libelle_abreviation"); ?></th>
    <th><?php echo libelle("msg_libelle_statut"); ?></th>

    <?php foreach ($objStatuts as $intCle => $objStatut): ?>
      <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
        <td>
          <?php if($objStatut->getEstActif()) {echo link_to("","referentiel_mip/modifierStatut_Dossier_mip?id=".$objStatut->getId(), array("class" => "picto_court bt_modifier","title" => libelle("msg_bouton_modifier")));} ?>
          <?php
          echo $objStatut->getEstActif() ?
                  link_to_grid("","referentiel_mip/changerActivationStatutDossierMip?id=".$objStatut->getId(), array("class" => "picto_court bt_desactiver","title"=> libelle("msg_bouton_desactiver"))) :
                  link_to_grid("","referentiel_mip/changerActivationStatutDossierMip?id=".$objStatut->getId(), array("class" => "picto_court bt_activer","title" => libelle("msg_bouton_activer")))
          ?>
        </td>
        <td>
          <?php echo $objStatut->getIntitule(); ?>
        </td>
        <td>
          <?php echo $objStatut->getAbreviation(); ?>
        </td>
        <td>
          <?php echo $objStatut->getEstActif()? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"); ?>
        </td>
     <?php endforeach ?>
  </table>

  <?php else: ?>
    <table class="mep">
      <caption>
        <?php echo  libelle("msg_statut_aucun_resultat"); ?>
      </caption>
    </table>

<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>