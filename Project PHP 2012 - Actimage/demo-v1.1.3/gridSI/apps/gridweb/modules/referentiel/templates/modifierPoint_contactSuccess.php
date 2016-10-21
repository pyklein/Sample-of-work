<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php
if (isset($strContenant)) {
  $strRedirection = "?" . $strContenant . "=" . $idContenant;
} else {
  $strRedirection = "";
}
?>

<form action="" method="post" >
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_informations_generales") ?>
    </legend>

    <?php echo $objForm['telephone']->renderRow() ?>
    <?php echo $objForm['fax']->renderRow() ?>
    <?php echo $objForm['email']->renderRow() ?>
    <?php echo $objForm['email2']->renderRow() ?>

  </fieldset>

  <fieldset>
    <legend><?php echo libelle("msg_libelle_coordonnee_postales") ?></legend>

    <?php echo $objForm['adresse']->renderRow() ?>
    <?php echo $objForm['adresse2']->renderRow() ?>
    <?php echo $objForm['adresse3']->renderRow() ?>
    <?php echo $objForm['code_postal']->renderRow() ?>
    <?php echo $objForm['ville_id']->renderLabel()." : " ?>
    <?php echo $objForm['ville_id']->renderError() ?>
    <?php echo $objForm['ville_id']->render(array('class' => 'ville')) ?>
    <?php echo $objForm['complement_adresse']->renderLabel()." : " ?>
    <?php echo $objForm['complement_adresse']->renderError() ?>
    <?php echo $objForm['complement_adresse']->render(array('class' => 'complement')) ?>

    <hr class="separateur"/>

    <?php echo $objForm['adresse_etrangere']->renderRow(); ?>
    <?php echo $objForm['pays_id']->renderRow(); ?>

  </fieldset>

  <div class="boutons">
    <input type="submit" name="<?php echo $strContenant; ?>" value="<?php echo libelle("msg_bouton_modifier"); ?>" />
  </div>

</form>

<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "referentiel/listerPoint_contacts" . $strRedirection, array("class" => "picto bt_retour")); ?>
</div>
