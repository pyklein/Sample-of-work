<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>

<p>
  <span class="underline strong"><?php echo $objDossierBpi->getTitre(); ?></span>
  <br />
  <?php echo $objDossierBpi->getNumero();?>
</p>

<p>
  <?php echo $objDossierBpi->getRaw('description'); ?>
</p>

<!--Cadre Informations complémentaires -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_informations_complementaires") ?>
  </legend>
    <p><?php echo libelle("msg_dossier_bpi_hierarchie")." : ".$objDossierBpi->getHierarchieLocale(); ?></p>
    <p><?php echo libelle("msg_dossier_bpi_autorite")." : ".$objDossierBpi->getAutoriteDecision();?></p>
    <p><?php echo libelle("msg_libelle_dossier_bpi_statut_dossier")." : ".$objDossierBpi->getStatut_dossier_bpi(); ?></p>

    <?php if(($objDossierBpi['Attribution_droit']['droits_attribues'] == 1) && ($objDossierBpi['Attribution_droit']['date_decision_attribution'] != NULL)):?>
      <p><?php echo libelle("msg_libelle_dossier_bpi_date_decision_attribution_droit")." ".formatDate($objDossierBpi['Attribution_droit']['date_decision_attribution']); ?> </p>
    <?php endif;?>

    <p><?php echo libelle("msg_libelle_dossier")." ".strtolower($objDossierBpi->getEtat_partage()); ?></p>

    <?php if($objDossierBpi->getEst_classifie()):?>
      <p><?php echo libelle("msg_libelle_classification"); ?></p>
    <?php endif;?>
</fieldset>

<!--Cadre Analyse de brevetabilité-->
<fieldset>
  <legend>
    <?php echo libelle("msg_classement_analyse")?>
  </legend>
    <p><?php echo ($objDossierBpi->getEstBrevetable()? libelle("msg_libelle_dossier_bpi_invention_brevetable") : libelle("msg_libelle_dossier_bpi_invention_nonbrevetable"));?></p>
</fieldset>

<!--Cadre Liaison avec dossiers MIP-->
<?php if($intNbLiaisons != 0): ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_liaison_dossier_bpi_mip") ?>
    </legend>
      <table class="mep">
        <thead>
          <tr>
            <th><?php echo libelle("msg_libelle_numero") ?></th>
            <th><?php echo libelle("msg_libelle_intitule") ?></th>
            <th><?php echo libelle("msg_libelle_pilote") ?></th>
            <th><?php echo libelle("msg_libelle_statut") ?></th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($arrDossiersLies as $intCle => $objDossierMip):?>
            <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
              <td><?php echo $objDossierMip->getNumero() ?></td>
              <td><?php echo link_to($objDossierMip->getTitre(),"dossier_mip/voirDescriptionDossier_mip?id=".$objDossierMip->getId(), array('absolute_url' => true)) ?></td>
              <td><?php echo $objDossierMip->getPilote() ?></td>
              <td><?php echo $objDossierMip->getStatut_dossier_mip() ?></td>

            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
  </fieldset>
<?php endif;?>

<!--Cadres Inventeurs-->
<?php if($intNbInventeurs != 0): ?>



<table class="miseenpage">
  <tr>
    <?php foreach($objDossierBpi->getInventeurs() as $intI => $objInventeur):?>
      <td class="width_cinquante top">
      <?php $arrPartInventive = Part_inventiveTable::getInstance()->getPartInventiveByInventeur($objInventeur->getId(),$dossierId) ?>
      <?php $objClassement = Classement_invention_inventeurTable::getInstance()->findOneByConcerneIdAndDossierId($objInventeur->getId(),$dossierId);?>
        <fieldset>
          <legend>
            <?php echo libelle("msg_libelle_inventeur")?>
          </legend>
            <div><?php echo $objInventeur->getCivilite()." ".$objInventeur ?> </div>
            <div><a href="mailto:<?php echo $objInventeur->getEmail(); ?>"><?php echo $objInventeur->getEmail() ?></a></div>

            <?php if($objInventeur->getOrganisme()!== NULL):?>
              <div><?php echo $objInventeur->getOrganisme(); ?> </div>
              <div><?php echo $objInventeur->getService()->getIntitule(); ?> </div>
            <?php else:?>
              <?php echo '<br>';?>
            <?php endif;?>

            <?php if($objInventeur->getOrganisme_mindef()->getId() != NULL):?>
              <div><?php echo $objInventeur->getGrade()->getIntitule().' - '.$objInventeur->getOrganisme_mindef()->getIntitule(); ?> </div>
              <div><?php echo $objInventeur->getEntite()->getIntitule() ; ?></div>
            <?php else:?>
              <?php echo '<br>';?>
            <?php endif;?>

            <?php if($objInventeur->getTelephoneFixe()!= null):?>
              <div><?php echo libelle("msg_libelle_telephone") . " : " . $objInventeur->getTelephoneFixe() ; ?></div>
            <?php else:?>
              <?php echo '<br>';?>
            <?php endif;?>

            <?php if($objInventeur->getTelephoneMobile()!= null):?>
              <div><?php echo libelle("msg_libelle_telephone_mobile") . " : " . $objInventeur->getTelephoneMobile() ; ?></div>
            <?php else:?>
              <?php echo '<br>';?>
            <?php endif;?>

            <?php if($arrPartInventive[0] != null):?>
              <div><?php echo libelle("msg_libelle_part_inventive")." : ".$arrPartInventive[0]->getPartInventive()."%" ?> </div>
            <?php else:?>
              <?php echo '<br>';?>
            <?php endif;?>


            <?php if($objClassement[0] != null):?>
              <div>
                <?php echo libelle("msg_libelle_simple_classement")." : ".$objClassement[0]->getClassement_final()->getIntitule()." (".$objClassement[0]->getClassement_final().")";?>
              </div>
            <?php else:?>
              <?php echo '<br>';?>
            <?php endif;?>
        </fieldset>
      </td>
    <?php if ($intI%2 != 0) { ?>
      </tr>
  <tr>
    <?php } ?>
    <?php endforeach;?>
  </tr>
</table>


<?php endif;?>

<!--Cadre Actions menés-->
<table>
  <tr>
    <?php if($intNbActions > 0):?>
      <td class="width_cinquante top">
      <!--  Initialisation de la date courante-->
      <?php $dateCourant = "";?>
        <fieldset>
          <legend>
            <?php echo libelle("msg_libelle_actions_menees"); ?>
          </legend>
          <?php foreach ($arrActions as $objAction):?>
            <?php $dateAction = $objAction->getDate_action()?>

              <span class="underline">
                <?php if($dateAction != $dateCourant)
                  {
                    echo formatDate($objAction->getDate_action());
                    $dateCourant = $dateAction;
                  }
                ?>
              </span>
            <ul>
              <li><?php echo $objAction->getRaw('description'); ?></li>
            </ul>

          <?php endforeach;?>
        </fieldset>
      </td>
  
  
<?php endif;?>

<!--Cadre Remarques  -->
  <?php if($intNbRemarques > 0):?>
      <td class="width_cinquante top">
      <fieldset>
        <legend>
          <?php echo libelle("msg_libelle_remarques")?>
        </legend>
          <?php foreach($arrRemarques as $objRemarque):?>
        <ul>
            <li><?php echo $objRemarque->getRaw('contenu') ?></li>
        </ul>
          <?php endforeach; ?>

        </fieldset>
      </td>

  <?php endif;?>
  </tr>
</table>


<!--Cadre Contentieux-->
<?php if($boolContentieuxExiste): ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_contentieux");?>
    </legend>
      <?php if($boolContentieuxExiste) echo "<p>".libelle('msg_libelle_description_dossier_bpi_contentieux_existe') ."</p>";?>
      <?php if($boolCnisExiste) echo "<p>".libelle('msg_libelle_description_dossier_bpi_cnis_existe') ."</p>";?>
  </fieldset>
<?php endif;?>


<!--Cadre Documents joints-->
<?php if ($objDocumentsJoints->count()!= 0): ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_documents_joints"); ?>
    </legend>
    <ul>
   <?php foreach ($objDocumentsJoints as $objDocumentJoint): ?>
      <li>
         <?php 
         if ($objDocumentJoint->getTitre() != "") {?>                 
                 <a href="<?php echo url_for('dossier_bpi/telechargerDocument_bpi_joint?id='.$objDocumentJoint->getId()) ?>" ><?php echo $objDocumentJoint->getTitre()." - " ?></a>
         <?php } ?>
         <a href="<?php echo url_for('dossier_bpi/telechargerDocument_bpi_joint?id='.$objDocumentJoint->getId()) ?>"><?php echo $objDocumentJoint->getFichierOrig() ?></a> - 
         <?php echo $objDocumentJoint->getStatut_dossier_bpi(); ?>
      </li>
         <br/>
      <?php endforeach ?>
    </ul>
  </fieldset>
 <?php endif; ?>
 
 <!--Cadre Documents joints-->
<?php if ($objDocumentsReferences->count()!= 0): ?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_documents_references"); ?>
    </legend>
    <ul>
   <?php foreach ($objDocumentsReferences as $objDocumentReference): ?>
      <li>
         <?php 
         if ($objDocumentReference->getTitre() != "") {?>                 
                 <a href="<?php echo url_for('dossier_bpi/telechargerDocument_bpi_reference?id='.$objDocumentReference->getId()) ?>" ><?php echo $objDocumentReference->getTitre()." - " ?></a>
         <?php } ?>
         <a href="<?php echo url_for('dossier_bpi/telechargerDocument_bpi_joint?id='.$objDocumentReference->getId()) ?>"><?php echo $objDocumentReference->getFichier()?></a> - 
         <?php echo $objDocumentReference->getStatut_dossier_bpi(); ?>
      </li>
         <br/>
      <?php endforeach ?>
    </ul>
  </fieldset>
 <?php endif; ?>

