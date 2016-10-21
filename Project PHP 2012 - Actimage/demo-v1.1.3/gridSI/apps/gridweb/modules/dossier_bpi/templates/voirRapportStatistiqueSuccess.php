<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>
<?php use_stylesheets_for_form($objFormFiltre) ?>
<?php use_javascripts_for_form($objFormFiltre) ?>

<?php echo message(); ?>

<?php if (isset($pdf)) : ?>
  <?php use_stylesheet('pdf.css') ?>
  <?php use_helper("Pdf"); ?>
  <?php echo pdf_debut(); ?>
  <?php echo 'Le ' . date("d/m/y") . ' à ' . date("H:i:s"); ?><br>
  <?php if ($boolFiltre) : ?>
    <fieldset>
      <legend>
         <?php echo libelle('msg_libelle_filtres') ?>
      </legend>
    <?php if (isset($headerOrganismesMindef)) : ?>
      <?php echo $headerOrganismesMindef ?><br>
    <?php endif; ?>
    <?php if (isset($headerEntite)) : ?>
      <?php echo $headerEntite ?><br>
    <?php endif; ?>
    <?php if (isset($headerAnnee)) : ?>
      <?php echo $headerAnnee ?><br>
    <?php endif; ?>
    </fieldset>
  <?php endif; ?>
<?php else : ?>
  <?php include_partial('interface/conteneurFiltre', array('objFormFiltre' => $objFormFiltre,'strValueSubmit' => 'bouton_generer_rapport','boolReinitialiser' => true)) ?>

  <div class="right">
      <?php echo link_to_grid(libelle("msg_bouton_export_pdf"), "dossier_bpi/exporterRapportStatistiquePDF", array("class" => "picto bt_export_pdf", "target" => "_blank")); ?>
  </div>
<?php endif; ?>

<div id="statistique_bpi_info_nombre">
   <?php echo libelle("msg_statistiques_bpi_libelle_total", array($nbDossierTotal)); ?>
</div>

<?php $etatTable = 0; ?>
<!--bpi_stat_table
bpi_stat_td_moitie-->

<table class="miseenpage">
  <tbody>
   <?php if (isset($chartClassement))  { ?>
        <?php if ($etatTable == 0) { ?>
          <tr>
        <?php } ?>
        <td class="width_cinquante top">
          <fieldset>
            <legend><?php echo libelle("msg_statistiques_bpi_libelle_graph_classement") ?></legend>
            <?php if (isset($pdf)) {
                 echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartClassement, true, false, true));
            } else
                  echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartClassement));
            ?>
          </fieldset>
        </td>
        <?php $etatTable++;
          if ($etatTable == 2) {
            $etatTable = 0;
          ?>
          </tr>
        <?php } ?>
<?php } ?>

<?php if (isset($chartOrganismesMindef))  { ?>
       <?php if ($etatTable == 0) { ?>
          <tr>
        <?php } ?>
          <td class="width_cinquante top">
            <fieldset>
            <legend><?php echo libelle("msg_statistiques_bpi_libelle_graph_organisme") ?></legend>
            <?php if (isset($pdf))
                 echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartOrganismesMindef, true, false, true));
              else
                  echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartOrganismesMindef));
            ?>
        </fieldset>
      </td>
      <?php $etatTable++;
          if ($etatTable == 2) { 
            $etatTable = 0;
          ?>
          </tr>
        <?php } ?>
<?php } ?>

<?php if (isset($chartBrevet))  { ?>
       <?php if ($etatTable == 0) { ?>
          <tr>
        <?php } ?>
        <td class="width_cinquante top">
          <fieldset>
          <legend><?php echo libelle("msg_statistiques_bpi_libelle_graph_brevet") ?></legend>
          <?php if (isset($pdf))
               echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartBrevet, true, false, true));
            else
                echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartBrevet));
          ?>
          </fieldset>
      </td>
      <?php $etatTable++;
          if ($etatTable == 2) {
            $etatTable = 0;
          ?>
          </tr>
        <?php } ?>
<?php } ?>

<?php if (isset($chartAnnee))  { ?>
       <?php if ($etatTable == 0) { ?>
          <tr>
        <?php } ?>
        <td class="width_cinquante top">
          <fieldset>
          <legend><?php echo libelle("msg_statistiques_bpi_libelle_graph_annee") ?></legend>
          <?php if (isset($pdf))
               echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartAnnee, true, false, true));
            else
                echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartAnnee));
          ?>
          </fieldset>
      </td>
      <?php $etatTable++;
          if ($etatTable == 2) {
            $etatTable = 0;
          ?>
          </tr>
        <?php } ?>
<?php } ?>

 <?php if ($etatTable == 1) {
            $etatTable = 0;
 ?>
          <td class="width_cinquante top"></td></tr>
 <?php } ?>

<?php if (isset($tableEntite))  { ?>
  <tr><td colspan="2">

      <fieldset>
          <legend><?php echo libelle("msg_statistiques_bpi_libelle_graph_entite") ?></legend>
          <table class="mep">
            <thead>
              <tr>
                <th><?php echo libelle("msg_statistiques_bpi_libelle_graph_entite_th") ?></th>
                <th width="20%"></th>
              </tr>
            </thead>
            <tbody>
              <?php $tableCptr = 1;
              foreach($tableEntite as $index => $compte) :?>
                <?php if ($compte > 0) {
                  $tableCptr = 1 - $tableCptr; ?>
                <tr class="<?php echo $tableCptr == 0 ? "pair" : "impair" ?>">
                  <td><?php echo $index ?></td>
                  <td><?php echo $compte ?></td>
                </tr>
              <?php }
              endforeach; ?>
            </tbody>
          </table>
        </fieldset>
  </td></tr>
<?php } ?>
  </tbody>
</table>
<?php if (isset($pdf)) : ?>
    <?php echo pdf_fin('Rapport Statistique.pdf','Rapport Statistique'); ?>
<?php endif; ?>