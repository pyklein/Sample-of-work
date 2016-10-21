<?php
/*
 * @author Antonin KALK
 */
?>

<?php use_helper("Message"); ?>

<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($dossierBpi)); ?>
</h3>

<?php echo message(); ?>

<?php include_partial('onglet_contentieux', array('arrInventeurs' => $arrInventeurs, 'ongletActif' => 2, 'checkInventeur' => $checkInventeur, 'dossierId' => $dossierId)) ?>

<div id="zone_cadre" class="reduit">

  <form action="" method="post" >
 <!--Organisme extérieur-->
  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_organisme_exterieur') ?>
    </legend>
    <?php echo $objForm['contentieux_contrat']['organisme_id']->renderRow(array('id' => 'contrat')); ?>
    <?php echo $objForm['contentieux_absence_contrat']['organisme_id']->renderLabel(libelle("msg_libelle_organisme_absence_contrat")); ?>
    <?php //echo $objForm['contentieux_absence_contrat']['organisme_id']->renderError(); ?>
    <?php echo $objForm['contentieux_absence_contrat']['organisme_id']->render(array('id' => 'absence_contrat')); ?>
  </fieldset>

   <!--Sur l'interprétation d'un contrat de Licence / Cession ou présumée contrefaçon-->
  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_interpretation') ?>
    </legend>
    <?php echo $objForm['contentieux_contrat']['est_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_contrat']['commentaire_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_contrat']['date_accord']->renderRow(); ?>
  </fieldset>

  <!--En absence de contrat-->
  <fieldset>
    <legend>
      <?php echo libelle('msg_libelle_absence_contrat') ?>
    </legend>
    <?php echo $objForm['contentieux_absence_contrat']['est_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_absence_contrat']['commentaire_desaccord']->renderRow(); ?>
    <?php echo $objForm['contentieux_absence_contrat']['date_accord']->renderRow(); ?>
  </fieldset>
   <div class="boutons">
      <input type="submit" value="<?php echo  libelle("msg_bouton_enregistrer"); ?>" name="bouton_recompenses" />
    </div>
  </form>
  
</div>

<?php include_partial('autreActions', array('id' => $dossierId)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>
<?php /* si javascript activé sinon afficher 2 comboBox */ ?>
<script type="text/javascript">
  $(document).ready( function() { BindEvent() } );
  
  function BindEvent()
  {
    $("#contrat").change( function() { SetSel (); } );
    $("#absence_contrat").hide();
    $(".formulaire_ligne + label").hide();
    $("#absence_contrat + a").hide();
  }
  
  function SetSel()
  {
       var value = $("#contrat").val();
       $("#absence_contrat").val(value);
  }
</script>
