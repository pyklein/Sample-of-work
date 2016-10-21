
<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objForm->getObject())); ?>

<?php use_helper("Message"); ?>
<?php echo message(); ?>

<?php include_partial('dossier_mip/gestion_dossier_mip',array('strId' => $strDossierId, 'ongletActif' => 4)) ?>

<div id="zone_cadre" class="reduit">
  <form action="" method="post" enctype="multipart/formdata">
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
    <fieldset>
      <legend>
        <?php echo libelle("msg_valorisation_generalisation") ?>
      </legend>
      <?php echo $objForm['Valorisation']['date_demande_generalisation']->renderRow() ?>
      <?php echo $objForm['Valorisation']['destinataire_demande_generalisation']->renderRow() ?>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_valorisation_prix_recompense") ?>
      </legend>
      <table>
        <thead>
          <tr>
            <th/>
            <th/>
            <th><?php echo libelle("msg_valorisation_prix_libelle_selectionne") ?></th>
            <th><?php echo libelle("msg_valorisation_prix_libelle_laureat") ?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($arrPrix as $clef => $prix): ?>
          <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
            <td><?php echo $prix->getPrix()->getIntitule() ?></td>
            <td>
              <select name="annee_<?php echo $prix->getPrixId() ?>" class="autre">
                <?php foreach(range($prix['Dossier_mip']->getAnnee(), $prix['Dossier_mip']->getAnnee() +10) as $annee) : ?>
                  <option <?php if ($annee == $prix->getAnnee()) echo 'selected="true"' ?> ><?php echo $annee ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td><input type="checkbox" name="selectionne_<?php echo $prix->getPrixId() ?>" <?php  if ($prix->getEstSelectionne() == 1)  echo  'checked="true"' ?>></td>
            <td><input type="checkbox" name="obtenu_<?php echo $prix->getPrixId() ?>" <?php  if ($prix->getEstObtenu() == 1)  echo  'checked="true"' ?>></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_valorisation_brevet") ?>
      </legend>
      <?php if($arrDossiersBPI->count() != 0) : ?>
        <table class="mep">
          <thead>
            <tr>
              <th><?php echo libelle("msg_valorisation_dossier_bpi_libelle_numero") ?></th>
              <th><?php echo libelle("msg_libelle_intitule") ?></th>
              <th><?php echo libelle("msg_valorisation_dossier_mip_libelle_inventeurs") ?></th>
              <th><?php echo libelle("msg_valorisation_dossier_bpi_libelle_classement") ?></th>
              <th><?php echo libelle("msg_valorisation_dossier_bpi_libelle_brevet") ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($arrDossiersBPI as $clef => $dossier) : ?>
            <tr class="<?php echo $clef % 2 == 0 ? "pair" : "impair" ?>">
              <td><?php echo $dossier->getNumero(); ?></td>
              <td><?php echo $dossier->getTitre(); ?></td>
              <td><?php
              foreach($dossier->getInventeurs() as $inventeur){
                echo $inventeur;
                echo '<br />';
              }
              ?></td>
              <td><?php
              foreach($dossier->getInventeurs() as $inventeur){
                echo $inventeur->getClassementInventeurPourDossierBPI($dossier->getId());
                echo '<br />';
              }
              ?></td>
              <td><?php
              foreach($dossier->getBrevet() as $brevet){
                echo $brevet;
                echo '<br />';
              }
              ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
      <?php echo link_to(libelle('msg_valorisation_lier_dossier_mip_a_bpi') , 'dossier_mip/lierDossiers_bpi?dossier_mip='.$strDossierId, array("class" => "picto bt_liaison")) ?>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_valorisation_avantage_inconvenient") ?>
      </legend>
      <?php echo $objForm['Valorisation']['avantage_inconvenient']->renderRow() ?>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_valorisation_retour_experience") ?>
      </legend>
      <?php echo $objForm['Valorisation']['retour_experience']->renderRow() ?>
    </fieldset>

    <fieldset>
      <legend>
        <?php echo libelle("msg_valorisation_fiche_internet") ?>
      </legend>
      <?php echo $objForm['Valorisation']['fiche_internet']->renderRow() ?>
    </fieldset>
    
    <div class="boutons">
      <input type="submit" value="<?php echo libelle("msg_bouton_enregistrer_informations"); ?>" />
    </div>
  </form>
</div>

<?php include_partial('autreActions',array('id' => $strDossierId,'objDossier'=>$objForm->getObject())) ?>

<hr class="clear" />
<div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mips", array("class" => "picto bt_retour")); ?>
</div>
