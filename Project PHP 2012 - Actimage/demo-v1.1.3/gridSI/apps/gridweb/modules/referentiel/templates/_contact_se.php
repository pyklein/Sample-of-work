<?php use_helper("Message"); ?>
<?php echo message(); ?>

<form action="" method="post" <?php $objForm->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_informations_generales") ?>
    </legend>

    <?php echo $objForm['entite_id']->renderRow() ?>
    <?php echo $objForm['nom']->renderRow() ?>
    <?php echo $objForm['prenom']->renderRow() ?>
    <?php echo $objForm['email']->renderRow() ?>
    <?php echo $objForm['email2']->renderRow() ?>
    <?php echo $objForm['telephone']->renderRow() ?>
    <?php echo $objForm['fax']->renderRow() ?>
  </fieldset>
  <fieldset>
    <legend><?php echo libelle("msg_libelle_coordonnee_postales") ?></legend>
      <table>
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
      </table>
  </fieldset>

  <fieldset>
    <legend><?php echo libelle("msg_libelle_informations_complementaires") ?></legend>
      <table>
        <?php echo $objForm['information_libre']->renderRow() ?>
      </table>
  </fieldset>

  <div class ="boutons">
    <input type="submit" value="<?php echo ($objForm->getObject()->isNew()) ? libelle("msg_bouton_creer") : libelle("msg_bouton_enregistrer"); ?>" />
  </div>
  
</form>

<div class="left">
<?php echo link_to(libelle("msg_contact_se_bouton_retour_list"), "referentiel/listerContactSes", array("class" => "picto bt_retour")); ?>
</div>