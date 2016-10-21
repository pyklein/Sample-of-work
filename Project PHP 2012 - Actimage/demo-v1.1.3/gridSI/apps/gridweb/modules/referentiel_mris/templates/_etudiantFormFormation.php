<?php use_stylesheets_for_form($objForm) ?>
<?php use_javascripts_for_form($objForm) ?>
<?php use_helper("Message"); ?>
<?php echo message();?>

<?php if (isset($strId)): ?>
  <?php include_partial('referentiel_mris/gestion_etudiant',array('strId' => $strId, 'ongletActif' => 3)) ?>
<?php endif; ?>

<div>
  <div id="zone_cadre">
    <form action=" " method="post">

      <fieldset>
        <legend>
          <?php echo libelle("msg_etudiant_fieldset_cursus") ?>
        </legend>
        <table>
          <tbody>
            <?php
//            echo $objForm;
              echo $objForm['type_cursus_id']->renderRow();
              echo $objForm['autre_cursus']->renderRow();
              echo $objForm['a_master']->renderRow();
              echo $objForm['mention']->renderRow();
            ?>
          </tbody>
        </table>
      </fieldset>

      <fieldset>
        <legend>
          <?php echo libelle("msg_etudiant_fieldset_description") ?>
        </legend>
        <table>
          <tbody>
            <?php echo $objForm['description_formation']->renderRow();?>
          </tbody>
        </table>
      </fieldset>

    <div class="boutons">
      <input type="submit" value=<?php echo libelle('msg_bouton_enregistrer'); ?> />
    </div>
    </form>
    &nbsp;
    <script type='text/javascript'>
      enableElementOnSelectValue('<?php echo $objForm["type_cursus_id"]->renderId(); ?>', '', '<?php echo $objForm["autre_cursus"]->renderId(); ?>');
    </script>
  </div>
  <div>
    <?php echo link_to(libelle("msg_etudiants_bouton_retour_liste"),'referentiel_mris/listerEtudiants',array('class' => 'picto bt_retour'))  ?>
  </div>
</div>