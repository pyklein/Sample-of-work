<?php use_helper("Format"); ?>

<?php if($objValorisation):?>
  <p>
    <?php if($objValorisation->getEst_evalue())
          {
            echo libelle("msg_libelle_brevet_evaluee");
          }
          else
          {
            echo libelle("msg_libelle_brevet_non_evaluee");
          }
    ?>
  </p>

  <?php if($objValorisation->getCommentaire()):?>
    <p>
       <?php echo $objValorisation->getRaw('commentaire');?>
    </p>
  <?php endif;?>
  <br>
<?php endif;?>


<!--------------------------------------------Section Valorisation Externe--------------------------------------->
<?php if($arrValorisationExternes->count() > 0):?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_valorisation_externe") ?></span>
  </p>

  <table class="mep">
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_organisme") ?></th>
        <th><?php echo libelle("msg_libelle_statut") ?></th>
        <th><?php echo libelle("msg_libelle_contrat") ?></th>
        <th><?php echo libelle("msg_libelle_statut_contrat") ?></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($arrValorisationExternes as $intCle => $objValorisationExterne):?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td><?php echo $objValorisationExterne->getOrganisme() ?></td>
          <td><?php echo $objValorisationExterne->getStatut_valorisation_externe() ?></td>
          <td><?php if($objValorisationExterne['contrat_id'] != NULL ) echo $objValorisationExterne->getContrat();?></td>
          <td><?php if($objValorisationExterne['contrat_id'] != NULL ) echo $objValorisationExterne->getContrat()->getStatut_contrat();?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <br>
<?php endif;?>

<!---------------------------------------Section Valorisation Interne------------------------------------------->
<?php if($arrValorisationInternes->count() > 0):?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_valorisation_interne") ?></span>
  </p>

  <table class="mep">
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_organisme") ?></th>
        <th><?php echo libelle("msg_libelle_date_debut_exploitation") ?></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($arrValorisationInternes as $intCle => $objValorisationInterne):?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td><?php echo $objValorisationInterne->getOrganisme_mindef() ?></td>
          <td><?php if($objValorisationInterne['date_debut_exploitation'] != NULL)  echo formatDate($objValorisationInterne->getDate_debut_exploitation()) ?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <br>
<?php endif;?>

<!-----------------------------------Section Exploitation------------------------------------------>
<?php if($arrExploitation->count() > 0):?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_libelle_exploitation") ?></span>
  </p>

  <ul>
    <?php foreach($arrExploitation as $objExploitation):?>
      <?php if($objExploitation->getEst_par_inventeur()):?>
        <li>
          <?php echo libelle("msg_libelle_est_par_inventeur");?>
        </li>
      <?php endif;?>

      <?php if($objExploitation['nature_interne_id'] != NULL ):?>
        <li>
          <?php echo libelle("msg_libelle_interne")." - ".$objExploitation->getNature_interne();?>
        </li>
      <?php endif;?>

      <?php if($objExploitation['nature_externe_id'] != NULL ):?>
        <li>
          <?php echo libelle("msg_libelle_externe")." - ".$objExploitation->getNature_externe();?>
        </li>
      <?php endif;?>
      
    <?php endforeach;?>
  </ul>
  <br>
<?php endif;?>

<!--------------------------------------------Section Redevances liées à l'invention------------------------------>
<?php if($arrRedevances->count() > 0): ?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_libelle_redevance_liees_invention") ?></span>
  </p>

  <table class="mep">
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_organisme") ?></th>
        <th><?php echo libelle("msg_libelle_type") ?></th>
        <th><?php echo libelle("msg_libelle_montant") ?></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($arrRedevances as $intCle => $objRedevance):?>
        <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
          <td><?php echo $objRedevance->getOrganisme() ?></td>
          <td><?php echo $objRedevance->getType_redevance() ?></td>
          <td><?php echo formatMontantFr($objRedevance->getMontant()) ; ?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <br>
<?php endif;?>

<!------------------------------------Section Exploitation Externe---------------------------------------->
 
<?php if($intNbExploitationExterne > 0): ?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_libelle_recompenses_exploitation_externe") ?></span>
  </p>

  <table class="mep">
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_redevance") ?></th>
          <?php foreach($arrInventeurs as $objInventeur):?>
            <th><?php echo libelle("msg_libelle_montant_e")." ".$objInventeur->getNom();?></th>
            <th><?php echo libelle("msg_libelle_versement")." ".$objInventeur->getNom();?></th>
          <?php endforeach;?>
      </tr>
    </thead>

    <tbody>
      <?php $intMontantCourant=0;?>
      <?php foreach ($arrRedevances as $intCle => $objRedevance):?>
          <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
            <td><?php echo $objRedevance->getOrganisme()." - ".$objRedevance->getType_redevance() ?></td>

            <?php foreach($arrInventeurs as $objInventeur):?>

                      <td>

                        <?php $arrExploitationExterne = Exploitation_externeTable::getInstance()->getExploitationExterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                        <?php foreach ($arrExploitationExterne as $intCle => $objExploitationExterne):?>


                          <?php if($objExploitationExterne->getRedevance()->getOrganisme()->getId() == $objRedevance->getOrganisme()->getId()): ?>
                            <?php if($objExploitationExterne->getMontant() != $intMontantCourant):?>
                                  <?php echo formatMontantFr($objExploitationExterne->getMontant()) ;
                                  $intMontantCourant = $objExploitationExterne->getMontant();
                                  ?>
                        

                          <?php endif; ?>
                        <?php endif;?>
                        

                        <?php endforeach;?>

                      </td>
                      <td>
                        <?php foreach ($arrExploitationExterne as $intCle => $objExploitationExterne):?>

                          <?php if($objExploitationExterne->getRedevance()->getOrganisme()->getId() == $objRedevance->getOrganisme()->getId()): ?>
                            <?php echo formatDate($objExploitationExterne->getDate_versement()) ; ?>
                        <br>
                        
                          <?php endif; ?>

                        <?php endforeach;?>
                        

                      </td>

           <?php endforeach;?>

                
          </tr>

      <?php endforeach;?>  
    </tbody>
  </table>
  <br>
<?php endif;?>

<!------------------------------------Section Exploitation Interne---------------------------------------->
<?php if($intNbExploitationInterne > 0): ?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_libelle_recompenses_exploitation_interne") ?></span>
  </p>

  <table class="mep">
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_information") ?></th>
        
        <?php foreach($arrInventeurs as $objInventeur):?>
          <th><?php echo $objInventeur->getNom();?></th>
        <?php endforeach;?>

      </tr>
    </thead>

    <tbody>
      <?php foreach ($arrInventeurs as $objInventeur):?>
        <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
          <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
            
<!--      Montant-->
            <tr class="pair">
              <td><?php echo libelle("msg_libelle_montant_e") ?></td>
              

              <?php foreach ($arrInventeurs as $objInventeur):?>
                <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                  <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
                    <td><?php echo formatMontantFr($objExploitationInterne->getMontant()) ?></td>
                    
                  <?php endforeach;?>
                <?php endforeach;?>
            </tr>

<!--            Rapporteur-->
            <tr class="impair">
              <td><?php echo libelle("msg_libelle_rapporteur") ?></td>


              <?php foreach ($arrInventeurs as $objInventeur):?>
                <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                  <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
                    <td><?php echo $objExploitationInterne->getRapporteur() ?></td>

                  <?php endforeach;?>
                <?php endforeach;?>
            </tr>

<!--            Date de remise de rapport-->
            <tr class="pair">
              <td><?php echo libelle("msg_libelle_recompenses_date_remise_rapport") ?></td>


              <?php foreach ($arrInventeurs as $objInventeur):?>
                <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                  <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
                    <td><?php if($objExploitationInterne['date_remise_rapport'] !=NULL) echo formatDate($objExploitationInterne->getDate_remise_rapport()) ?></td>

                  <?php endforeach;?>
                <?php endforeach;?>
            </tr>

<!--            Date de commission-->
            <tr class="impair">
              <td><?php echo libelle("msg_libelle_recompenses_date_commission") ?></td>


              <?php foreach ($arrInventeurs as $objInventeur):?>
                <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                  <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
                    <td><?php if($objExploitationInterne['date_commission'] !=NULL) echo formatDate($objExploitationInterne->getDate_commission()) ?></td>

                  <?php endforeach;?>
                <?php endforeach;?>
            </tr>

<!--            Date de décision de recompense-->
            <tr class="pair">
              <td><?php echo libelle("msg_libelle_recompenses_date_decision_recompense") ?></td>


              <?php foreach ($arrInventeurs as $objInventeur):?>
                <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                  <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
                    <td><?php if($objExploitationInterne['date_decision_recompense'] !=NULL) echo formatDate($objExploitationInterne->getDate_decision_recompense()) ?></td>

                  <?php endforeach;?>
                <?php endforeach;?>
            </tr>

<!--            Date de recompense-->
            <tr class="impair">
              <td><?php echo libelle("msg_libelle_recompenses_date_versement") ?></td>


              <?php foreach ($arrInventeurs as $objInventeur):?>
                <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                  <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
                    <td><?php if($objExploitationInterne['date_versement'] !=NULL) echo formatDate($objExploitationInterne->getDate_versement()) ?></td>

                  <?php endforeach;?>
                <?php endforeach;?>
            </tr>

<!--Date d'envoi de la lettre de versement-->
            <tr class="pair">
              <td><?php echo libelle("msg_libelle_recompenses_date_envoi_lettre") ?></td>


              <?php foreach ($arrInventeurs as $objInventeur):?>
                <?php $arrExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossierParInventeur($dossierId,$objInventeur->getId());?>
                  <?php foreach ($arrExploitationInterne as $intCle => $objExploitationInterne):?>
                    <td><?php if($objExploitationInterne['date_envoi_lettre'] !=NULL) echo formatDate($objExploitationInterne->getDate_envoi_lettre()) ?></td>

                  <?php endforeach;?>
                <?php endforeach;?>
            </tr>

          <?php endforeach;?>
      <?php endforeach;?>
    </tbody>
  </table>
  <br>
<?php endif;?>