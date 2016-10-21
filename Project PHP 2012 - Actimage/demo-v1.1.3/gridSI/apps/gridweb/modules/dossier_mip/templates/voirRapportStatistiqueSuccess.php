<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>
<?php use_stylesheets_for_form($objFormFiltre) ?>
<?php use_javascripts_for_form($objFormFiltre) ?>

<?php echo message(); ?>

<?php if (isset($pdf)) : ?>
  <?php use_helper("Pdf"); ?>
  <?php echo pdf_debut(); ?>
  <?php echo 'Le ' . date("d/m/y") . ' à ' . date("H:i:s"); ?><br>
  <?php if ($boolFiltres) : ?>
    <fieldset>
      <legend>
         <?php echo libelle('msg_libelle_filtres') ?>
      </legend>
    <?php if (!$boolStatuts) : ?>
      <?php echo $headerFiltreStatut ?><br>
    <?php endif; ?>
    <?php if (!$boolOrganismesMindef) : ?>
      <?php echo $headerFiltreOrg ?><br>
    <?php endif; ?>
    <?php if (!$boolNiveaux) : ?>
      <?php echo $headerFiltreNiv ?><br>
    <?php endif; ?>
    <?php echo $headerFiltreAnnee ?><br>
    </fieldset>
  <?php endif; ?>
<?php else : ?>
  <!-- Filtre -->
  <?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre,'strValueSubmit' => 'bouton_generer_rapport','boolReinitialiser' => true)) ?>

  <!-- Bouton export PDF -->
  <div class="right">
    <?php echo link_to_grid(libelle("msg_bouton_export_pdf"), "dossier_mip/exporterRapportStatistiquePDF", array("class" => "picto bt_export_pdf", "target" => "_blank")); ?>
  </div>
<?php endif; ?>

<?php if ($boolStatuts) : ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_statistiques_fieldset_statut") ?>
    </legend>
    <?php if (!isset($pdf)) : ?>
    <div class="right">
       <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mip/exporterRapportStatistiqueCSV?typeStat=statut',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
    </div>
    <?php endif; ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_statut") ?></th>
          <th width="20%"><?php echo libelle("msg_libelle_nombre_dossier") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($resultatsStatuts as $index => $countStatut) :?>
          <tr class="<?php echo $index % 2 ? "pair" : "impair" ?>">
            <td><?php echo $countStatut->key() ?></td>
            <td class="center"><?php echo $countStatut->current() ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </fieldset>
<?php endif; ?>
  
<?php if ($boolAnnees && count($resultatsAnnees)> 0) : ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_statistiques_fieldset_annee") ?>
    </legend>
    <?php if (!isset($pdf)) : ?>
    <div class="right">
       <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mip/exporterRapportStatistiqueCSV?typeStat=annees',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
    </div>
    <?php endif; ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_annee") ?></th>
          <th width="20%"><?php echo libelle("msg_libelle_nombre_dossier_ouvert") ?></th>
          <th width="20%"><?php echo libelle("msg_libelle_nombre_dossier_clos") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($resultatsAnnees as $index => $countAnnee) :?>
          <tr class="<?php echo $index % 2 ? "pair" : "impair" ?>">
            <td><?php echo $countAnnee->key() ?></td>
            <td class="center"><?php $count = $countAnnee->current(); echo $count['ouvert'] ?></td>
            <td class="center"><?php echo $count['clos'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </fieldset>
<?php endif; ?>
<?php if ($boolOrganismesMindef) : ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_statistiques_fieldset_organisme") ?>
    </legend>
    <?php if (!isset($pdf)) : ?>
    <div class="right">
       <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mip/exporterRapportStatistiqueCSV?typeStat=organismesMindef',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
    </div>
    <?php endif; ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_organisme_armee") ?></th>
          <th width="20%"><?php echo libelle("msg_libelle_nombre_dossier") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($resultatsOrganismesMindef as $index => $countOrganisme) :?>
          <tr class="<?php echo $index % 2 ? "pair" : "impair" ?>">
            <td><?php echo $countOrganisme->key() ?></td>
            <td class="center"><?php echo $countOrganisme->current() ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </fieldset>
<?php endif; ?>
<?php if ($boolNiveaux) : ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_statistiques_fieldset_niveau") ?>
    </legend>
    <?php if (!isset($pdf)) : ?>
    <div class="right">
       <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mip/exporterRapportStatistiqueCSV?typeStat=niveaux',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
    </div>
    <?php endif; ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_niveau_protection") ?></th>
          <th width="20%"><?php echo libelle("msg_libelle_nombre_dossier") ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($resultatsNiveaux as $index => $countNiveau) :?>
          <tr class="<?php echo $index % 2 ? "pair" : "impair" ?>">
            <td><?php echo $countNiveau->key() ?></td>
            <td class="center"><?php echo $countNiveau->current() ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </fieldset>
<?php endif; ?>
<fieldset>
  <legend>
    <?php echo libelle("msg_statistiques_fieldset_controle") ?>
  </legend>
  <?php if (!isset($pdf)) : ?>
  <div class="right">
     <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mip/exporterRapportStatistiqueCSV?typeStat=etatsControle',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
  </div>
  <?php endif; ?>
  <table class="mep">
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_etat_controle") ?></th>
        <th width="20%"><?php echo libelle("msg_libelle_nombre_dossier") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($resultatsEtatControle as $index => $countEtat) :?>
        <tr class="<?php echo $index % 2 ? "pair" : "impair" ?>">
          <td><?php echo $countEtat->key() ?></td>
          <td class="center"><?php echo $countEtat->current() ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</fieldset>
<fieldset>
  <legend>
    <?php echo libelle("msg_statistiques_fieldset_brevet") ?>
  </legend>
  <?php if (!isset($pdf)) : ?>
  <div class="right">
     <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mip/ExporterRapportStatistiqueCSV?typeStat=brevets',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
  </div>
  <?php endif; ?>
  <table class="mep">
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_type_information") ?></th>
        <th width="20%"><?php echo libelle("msg_libelle_nombre_dossier") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($resultatsBrevets as $index => $countEtatBrevets) :?>
        <tr class="<?php echo $index % 2 ? "pair" : "impair" ?>">
          <td><?php echo $countEtatBrevets->key() ?></td>
          <td class="center"><?php echo $countEtatBrevets->current() ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</fieldset>

<?php if (isset($pdf)) : ?>
    <?php echo pdf_fin('Rapport Statistique.pdf','Rapport Statistique'); ?>
<?php endif; ?>
