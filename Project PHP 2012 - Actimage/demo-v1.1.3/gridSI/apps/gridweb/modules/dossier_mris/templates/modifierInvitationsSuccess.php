<?php use_helper("Message"); ?>

<?php echo message(); ?>

<?php include_partial('dossier_mris/gestion_commissions', array('strId' => $strId, 'ongletActif' => 4)) ?>

<div id="zone_cadre">
  <form action="" method="post">
    <div class="boutons">
      <input type="submit" value="Enregistrer"/>
    </div>
  </form>
  <fieldset>
    <legend><?php echo libelle('msg_liste_service_libelle_disponibles') ?></legend>
    <?php if ($objPager1->count() == 0) : ?>
      <?php echo libelle('msg_services_0_disponible') ?>
    <?php else : ?>
      <table class="mep">
        <thead>
          <tr>
            <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
            <th width="40%"><?php echo libelle("msg_libelle_intitule") ?></th>
            <th width="15%"><?php echo libelle("msg_libelle_abreviation") ?></th>
            <th width="40%"><?php echo libelle("msg_libelle_organisme") ?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($objPager1->getResults() as $clef => $objService): ?>
          <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
            <td>
              <?php echo link_to("", "dossier_mris/ajouterInvitationService?commission=".$strId."&service=".$objService->getId(), array("class" => "picto_court bt_ajouter", "title" => libelle("msg_bouton_ajouter"))); ?>
            </td>
            <td><?php echo $objService->getIntitule() ?></td>
            <td><?php echo $objService->getAbreviation() ?></td>
            <td><?php echo $objService->getOrganisme() ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <?php if ($objPager1->haveToPaginate()): ?>
        <?php include_partial('interface/paginateur', array('objPager' => $objPager1, 'strUrlRedirection' => $strUrlRedirection,'intIdPager' => '1')) ?>
      <?php endif; ?>

      <?php if ($objPager1->count() > 0) : ?>
        <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres, 'intIdPager' => '1')) ?>
      <?php endif; ?>

    <?php endif; ?>
  </fieldset>

  <fieldset>
    <legend><?php echo libelle('msg_liste_laboratoire_libelle_disponibles') ?></legend>
    <?php if ($objPager2->count() == 0) : ?>
      <?php echo libelle('msg_laboratoire_0_disponible') ?>
    <?php else : ?>
      <table class="mep">
        <thead>
          <tr>
            <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
            <th width="40%"><?php echo libelle("msg_libelle_intitule") ?></th>
            <th width="15%"><?php echo libelle("msg_libelle_abreviation") ?></th>
            <th width="40%"><?php echo libelle("msg_libelle_organisme_service") ?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($objPager2->getResults() as $clef => $objLaboratoire): ?>
          <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
            <td>
              <?php echo link_to("", "dossier_mris/ajouterInvitationLaboratoire?commission=".$strId."&laboratoire=".$objLaboratoire->getId(), array("class" => "picto_court bt_ajouter", "title" => libelle("msg_bouton_ajouter"))); ?>
            </td>
            <td><?php echo $objLaboratoire->getIntitule() ?></td>
            <td><?php echo $objLaboratoire->getAbreviation() ?></td>
            <td>
              <?php
                if ($objLaboratoire->hasOrganisme())
                {
                  echo $objLaboratoire->getOrganisme();
                } else if ($objLaboratoire->hasService())
                {
                  echo $objLaboratoire->getService();
                }
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <?php if ($objPager2->haveToPaginate()): ?>
        <?php include_partial('interface/paginateur', array('objPager' => $objPager2, 'strUrlRedirection' => $strUrlRedirection, 'intIdPager' => '2')) ?>
      <?php endif; ?>

      <?php if ($objPager2->count() > 0) : ?>
        <?php include_partial('interface/maxParPage', array('intSelectionne' => $intSelectionne, 'arrNombres' => $arrNombres, 'intIdPager' => '2')) ?>
      <?php endif; ?>

   <?php endif; ?>
  </fieldset>
  
  <fieldset>
    <legend><?php echo libelle('msg_liste_service_laboratoire_libelle_invites') ?></legend>
    <?php if (count($arrInvites) == 0) : ?>
      <?php echo libelle('msg_invites_0_concernes') ?>
    <?php else : ?>
      <table class="mep">
        <thead>
          <tr>
            <th width="5%"><?php echo libelle("msg_libelle_action") ?></th>
            <th width="40%"><?php echo libelle("msg_libelle_intitule") ?></th>
            <th width="55%"><?php echo libelle("msg_libelle_organisme_service") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($arrInvites as $clef => $arrLigne) : ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td>
                <?php
                  if ($arrLigne["invitation"]) {
                    $strVariable = "invitation=".$arrLigne["invitation_id"];
                    $obj = $arrLigne["invitation"];
                  } else if ($arrLigne["laboratoire"]) {
                    $strVariable = "laboratoire=".$arrLigne["laboratoire_id"];
                    $obj = $arrLigne["laboratoire"];
                  } else {
                    $strVariable = "service=".$arrLigne["service_id"];
                    $obj = $arrLigne["service"];
                  }
                  echo link_to("", "dossier_mris/retirerInvitation?commission=".$strId."&".$strVariable, array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_retirer")));
                ?>
              </td>
              <td>
                <?php 
                  if ($arrLigne["invitation"]) {
                    if (isset($arrLigne["invitation"]["laboratoire"])) {
                      echo $arrLigne["invitation"]["laboratoire"];
                    } else {
                      echo $arrLigne["invitation"]["service"];
                    }
                  } else {
                    echo $obj;
                  }
                ?>
              </td>
              <td>
                <?php
                  if ($arrLigne["invitation"]) {
                    if (isset($arrLigne["invitation"]["laboratoire"])) {
                      if ($arrLigne["invitation"]["laboratoire"]->hasOrganisme()) {
                        echo $arrLigne["invitation"]["laboratoire"]->getOrganisme();
                      } else {
                        echo $arrLigne["invitation"]["laboratoire"]->getService();
                      }
                    } else {
                      echo $arrLigne["invitation"]["service"]->getOrganisme();
                    }
                  } else if ($arrLigne["laboratoire"]) {
                    if ($arrLigne["laboratoire"]->hasOrganisme()) {
                      echo $arrLigne["laboratoire"]->getOrganisme();
                    } else {
                      echo $arrLigne["laboratoire"]->getService();
                    }
                  } else {
                    echo $arrLigne["service"]->getOrganisme();
                  }
                ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
   <?php endif; ?>
  </fieldset>

  <form action="" method="post">
    <div class="boutons">
      <input type="submit" value="Enregistrer"/>
    </div>
  </form>
</div>
<div>
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mris/listerCommissions", array("class" => "picto bt_retour")); ?>
</div>
