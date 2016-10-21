
<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php include_partial('dossier_mris/onglet_dossier', array('strNomModel' => $strTypeDossier, 'strId' => $strId, 'ongletActif' => 2)) ?>

<div id="zone_cadre" class="reduit">

   <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_choix_proposant") ?>
      </legend>

      <form action="" method="post">
        <?php echo $objDossierForm; ?>
        <div class="boutons">
           <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_choix"); ?>" />
        </div>
      </form>
  </fieldset>

  <?php if($boolIsAdminMris): ?>
   <h4>
      <?php echo libelle("msg_libelle_ajout_proposant") ?>
   </h4>

  <form action="" method="post">
  <fieldset>
    <legend>
      <?php echo libelle("msg_etudiant_fieldset_info_identite") ?>
    </legend>
    <table>
      <tbody>
        <?php
          echo $objEtudiantForm['civilite_id']->renderLabel();
          echo ' : ';
          echo $objEtudiantForm['civilite_id']->render();
          echo $objEtudiantForm['nom']->renderRow();
          echo $objEtudiantForm['nom_jeunefille']->renderRow();
          echo $objEtudiantForm['prenom']->renderRow();
          echo $objEtudiantForm['date_naissance']->renderRow();
          echo $objEtudiantForm['lieu_naissance']->renderRow();
          echo $objEtudiantForm['nationalite_id']->renderRow();
        ?>
      </tbody>
    </table>
  </fieldset>

  <fieldset>
    <legend>
      <?php echo libelle("msg_etudiant_fieldset_coord") ?>
    </legend>
    <table>
      <tbody>
        <?php
          echo $objEtudiantForm['email']->renderRow();
          echo $objEtudiantForm['email2']->renderRow();
          echo $objEtudiantForm['adresse']->renderRow();
          echo $objEtudiantForm['adresse2']->renderRow();
          echo $objEtudiantForm['adresse3']->renderRow();
          echo $objEtudiantForm['code_postal']->renderRow();
          echo $objEtudiantForm['ville_id']->renderLabel()." : ";
          echo $objEtudiantForm['ville_id']->renderError();
          echo $objEtudiantForm['ville_id']->render(array('class' => 'ville'));
          echo $objEtudiantForm['complement_adresse']->renderLabel()." : ";
          echo $objEtudiantForm['complement_adresse']->renderError();
          echo $objEtudiantForm['complement_adresse']->render(array('class' => 'complement'));
          echo $objEtudiantForm['telephone_fixe']->renderRow();
          echo $objEtudiantForm['telephone_mobile']->renderRow();
        ?>
      </tbody>
    </table>
  </fieldset>

  <div class="boutons">
    <input type="submit" value="<?php echo libelle('msg_bouton_ajouter_choisir_proposant'); ?>" />
  </div>
  </form>
  <?php endif; ?>
</div>

<?php include_partial('autreActionsMris',array('strNomModel'=>$strTypeDossier, 'id' => $strId)) ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_dossier"), "dossier_mris/lister".$strTypeDossier."s", array("class" => "picto bt_retour")); ?>
</div>
