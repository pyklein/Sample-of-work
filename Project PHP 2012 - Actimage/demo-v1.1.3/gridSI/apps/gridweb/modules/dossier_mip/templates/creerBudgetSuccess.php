<?php use_helper("Message"); ?>
<?php //use_javascript("jquery/jshashtable-2.1.js"); ?>
<?php //use_javascript("jquery/jquery.numberformatter-1.2.2.js"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objContenant)); ?>

<?php echo message(); ?>

<form action="" method="post">
  <fieldset>
    <legend>
      <?php echo libelle("msg_module_dossier_mip_action_creerbudget") ?>
    </legend>
    <?php echo $objForm; ?>
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_creer"); ?>" />
    </div>
  </fieldset>
</form>

<script type="text/javascript">
//  $('#budget_form_montant').change(function() {
//    $(this).parseNumber({format:"#,### €", locale:"fr"});
//    $(this).formatNumber({format:"#,### €", locale:"fr"});
////    var tst = $(this).parseNumber({format:"#,###.00", locale:"fr"}, false);
////
////    alert(tst);
//  });
//  $('#budget_form_montant').keyup(function() {
//    $('#budget_form_montant').change();
//  });
</script>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/suiviFinancierDossier_mips?dossier_mip=".$idContenant, array("class" => "picto bt_retour")); ?>
</div>