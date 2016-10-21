<?php use_helper("Photo"); ?>

<?php include_partial("interface/conteneurFiltre",array("objFormFiltre"=>$objFormFiltre, "boolReinitialiser" => true)) ?>

<br>

<div class="underline">
  <?php echo libelle("msg_libelle_nb_dossiers_trouves",array($intNbDossiersTrouves,$intNbDossiersProposition)) ;?>
</div>

<br>

<table class="miseenpage">
  <tr>
    <td colspan="2">
      <!--Groupement Répartition par domaines scientifiques-->
      <?php if (isset($chartPropositionDS)):?>
        <fieldset>
          <legend>
            <?php echo libelle("msg_statistiques_ere_proposition_dom_scientifiques") ?>
          </legend>
            <div class="right">
              <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mris/exporterRapportStatistiqueCSV?typeStat=Proposition_DS&typeDossier=Dossier_ere',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
            </div>

            <?php echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartPropositionDS)); ?>
        </fieldset>
      <?php endif;?>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <?php if (isset($chartDossierDS)):?>
        <fieldset>
          <legend>
            <?php echo libelle("msg_statistiques_ere_dossier_dom_scientifiques") ?>
          </legend>
            <div class="right">
              <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mris/exporterRapportStatistiqueCSV?typeStat=Dossier_DS&typeDossier=Dossier_ere',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
            </div>

            <?php echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartDossierDS)); ?>
        </fieldset>
      <?php endif;?>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <!--Groupement répartition des propositions et dossiers par région-->
      <?php if (isset($chartRegion)):?>
        <fieldset>
          <legend>
            <?php echo libelle("msg_statistiques_ere_region") ?>
          </legend>
            <div class="right">
              <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mris/exporterRapportStatistiqueCSV?typeStat=region&typeDossier=Dossier_ere',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
            </div>

            <?php echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartRegion)); ?>
        </fieldset>
      <?php endif;?>
    </td>
  </tr>
  <tr>
    <td class="width_cinquante top">
      <!--Groupements répartition par origine-->
      <?php if (isset($chartPropositionOrigine)):?>
        <fieldset>
          <legend>
            <?php echo libelle("msg_statistiques_ere_proposition_origine") ?>
          </legend>
            <div class="right">
              <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mris/exporterRapportStatistiqueCSV?typeStat=proposition_origine&typeDossier=Dossier_ere',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
            </div>

            <?php echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartPropositionOrigine)); ?>
        </fieldset>
      <?php endif;?>
    </td>
    <td class="width_cinquante top">
      <?php if (isset($chartDossierOrigine)):?>
        <fieldset>
          <legend>
            <?php echo libelle("msg_statistiques_ere_dossier_origine") ?>
          </legend>
            <div class="right">
              <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mris/exporterRapportStatistiqueCSV?typeStat=dossier_origine&typeDossier=Dossier_ere',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
            </div>

            <?php echo photo_tag(photo_path("interface/chargerChart?fichier=".$chartDossierOrigine)); ?>
        </fieldset>
      <?php endif;?>
    </td>
  </tr>
</table>

<hr class="clear">

<!--Section Nombre de dossiers par organisme-->

<?php if($intTotalProposition > 0 ):?>
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_nb_dossier_par_organisme");?>
    </legend>

    <div class="right">
       <?php echo link_to_grid(libelle("msg_bouton_export_csv"),'dossier_mris/exporterRapportStatistiqueCSV?typeStat=organisme&typeDossier=Dossier_ere',array("class" => "picto bt_export_csv", "title"=>libelle("msg_bouton_export_csv"))); ?>
    </div>

    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_organisme");?></th>
          <th><?php echo libelle("msg_libelle_nb_propositions");?></th>
          <th><?php echo libelle("msg_libelle_nb_dossiers");?></th>
        </tr>
      </thead>
      <tbody>

        <?php foreach($resultatsOrganismesProposition as $index => $countOrganisme) :?>
          <tr class="<?php echo $index % 2 ? "pair" : "impair" ?>">
            <td><?php echo $countOrganisme->key() ?></td>
            <td class="center"><?php echo $countOrganisme->current() ?></td>
            <td class="center"><?php echo $resultatsOrganismesDossiers[$index]->current() ?></td>
          </tr>
        <?php endforeach; ?>

        <tr class="<?php echo $index % 2 == 0 ? "pair" : "impair" ?>">
            <td><?php echo libelle("msg_libelle_total");?></td>
            <td class="center"><?php echo $intTotalProposition ;?></td>
            <td class="center"><?php echo $intTotalValide ;?></td>
        </tr>

      </tbody>
    </table>
  </fieldset>
<?php endif;?>




