
<?php use_helper("Message"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>
<?php use_helper("Format"); ?>

<?php use_javascript("utilAjax.js") ?>

<?php echo message(); ?>

<table>
  <tbody>
    <tr>
      <td class="width_cinquante top">
        <fieldset>
          <legend><?php echo libelle("msg_supervision_espace_disque_legende") ?></legend>
          <?php echo photo_tag(photo_path("interface/chargerChart?fichier=".$nomChart)); ?>
        </fieldset>
      </td>
      <td class="width_cinquante top">
        <fieldset>
          <legend><?php echo libelle("msg_supervision_date_heure_legende") ?></legend>
          <div class="supervision_field_div">
            <?php 
              $utilDate = new UtilDate();
              echo libelle("msg_supervision_date_heure", array(date("d") . " " . $utilDate->getMoisFrByNumero(date("n")). " " . date("Y"),date("H\hi")));
            ?>
          </div>
        </fieldset>
        <fieldset>
          <legend><?php echo libelle("msg_supervision_connexions_legende") ?></legend>
          <div class="supervision_field_div">
            <?php echo libelle("msg_supervision_connexions_chaine", array($cptrValue, $dateHistoCompteur)) ?>
            <form name="reinitialiser" action="" class="top_douze" method="post">
              <input type="submit" value="<?php echo libelle('msg_bouton_reinitialiser'); ?>" />
            </form>
            <div class="top_douze">
              <?php echo link_to_grid(libelle("msg_supervision_connexions_bouton_export"),'supervision/exportHistoriqueCSV',array("class" => "picto bt_export_csv")); ?>
            </div>
          </div>
        </fieldset>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <fieldset>
          <legend><?php echo libelle("msg_supervision_taches") ?></legend>
          <div id="taches">
            <?php include_component("supervision", "voirTaches"); ?>
          </div>
          <script type="text/javascript">
            periodicalUpdater("<?php echo url_for("supervision/voirTaches"); ?>", 2000, "#taches");
          </script>
        </fieldset>
      </td>
    </tr>
  </tbody>
</table>