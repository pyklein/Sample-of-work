<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>

<!--Section Brevet sur l'invention-->
<?php if($arrBrevets->count() > 0):?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_libelle_brevet_invention"); ?></span>
  </p>

  
  <ul class="liste_separe">
    <?php foreach($arrBrevets as $objBrevet):?>
    <li>
      <?php if($objBrevet['titre']!=NULL) echo $objBrevet->getTitre();
               echo " (";
              if($objBrevet['numero_demande'] != NULL) echo $objBrevet->getNumero_demande()." / ";
              if($objBrevet['numero_publication'] != NULL) echo $objBrevet->getNumero_publication();
              echo " )";

              if($objBrevet['type_depot_id']!=NULL) echo " - ".$objBrevet->getType_depot();
              if($objBrevet['phase_depot_brevet_id'] != NULL) echo " - ".$objBrevet->getPhase_depot_brevet();
              ?>
      
      <p><?php echo libelle("msg_libelle_responsable")." : ".$objBrevet->getResponsable();?></p>
      <?php if($objBrevet['contrat_id'] != NULL) { ?>
        <p>
          <?php
                 echo libelle("msg_libelle_contrat_signe_avec")." : ";
                 $arrSignataires = $objBrevet->getContrat()->getSignataire();
                 foreach ($arrSignataires as $intCle => $objSignataire)
                 {
                   if($intCle == (count($arrSignataires)-1))
                   {
                     echo $objSignataire->getOrganisme();
                   }
                   else
                   {
                     echo $objSignataire->getOrganisme().", ";
                   }
                 } ?>
        </p>
      <?php } ?>
        
      <?php if($objBrevet['date_decision_depot']!=NULL):?>
        <p><?php echo libelle("msg_libelle_date_decision_depot")." : ".formatDate($objBrevet->getDate_decision_depot()); ?></p>
      <?php endif;?>

      <?php if($objBrevet['date_objectif_depot']!=NULL):?>
        <p><?php echo libelle("msg_libelle_date_objectif_depot")." : ".formatDate($objBrevet->getDate_objectif_depot()); ?></p>
      <?php endif;?>

      <?php if($objBrevet['date_rapport_recherche']!=NULL):?>
        <p><?php echo libelle("msg_libelle_date_rapport_recherche")." : ".formatDate($objBrevet->getDate_rapport_recherche()); ?></p>
      <?php endif;?>

      <?php if($objBrevet['date_depot']!=NULL):?>
        <p><?php echo libelle("msg_libelle_date_depot")." : ".formatDate($objBrevet->getDate_depot()); ?></p>
      <?php endif;?>

      <?php if($objBrevet['date_obtention']!=NULL):?>
        <p><?php echo libelle("msg_libelle_date_obtention")." : ".formatDate($objBrevet->getDate_obtention()); ?></p>
      <?php endif;?>

      <?php if($objBrevet['date_rejet']!=NULL):?>
        <p><?php echo libelle("msg_libelle_date_rejet")." : ".formatDate($objBrevet->getDate_rejet()); ?></p>
      <?php endif;?>

      <?php if($objBrevet['date_cession']!=NULL):?>
        <p><?php echo libelle("msg_libelle_date_cession")." : ".formatDate($objBrevet->getDate_cession()); ?></p>
      <?php endif;?>
        
    </li>
    <?php endforeach;?>
  </ul>

  <!--Section Frais engagés dans le cadre des brevets-->
  <?php $dateCourant = "";
        $total = 0;
        $intNbFraisBrevet = 0;
  ?>

  <?php foreach($arrBrevets as $objBrevet)
        {
          if($objBrevet['somme_frais'] != NULL)
          {
            $intNbFraisBrevet++;
          }
        }
  ?>

  <?php if($intNbFraisBrevet > 0):?>
    <p>
      <span class="underline strong"><?php echo libelle("msg_libelle_frais_engages_brevets"); ?></span>
    </p>
  
    <table class="mep">
      <thead>
        <tr>
          <th>
            <?php echo libelle("msg_libelle_date") ?>
          </th>

          <?php foreach($arrBrevetsHeader as $objBrevet):?>
            <th>
              <?php echo $objBrevet->getTitre();?>
            </th>
          <?php endforeach;?>

          <th>
            <?php echo libelle("msg_libelle_total"); ?>
          </th>

        </tr>
      </thead>

      <tbody>
        
        <?php foreach ($arrBrevets as $intCle => $objBrevet):?>
          <tr class="<?php echo $intCle % 2 == 0 ? "pair" : "impair" ?>">
           
            <td>
              <?php if($objBrevet['date_reference'] != NULL){
                      echo formatDate($objBrevet->getDate_reference());
                      $dateCourant = $objBrevet->getDate_reference();
              }
              ?>
            </td>
           

            <?php for ($intI = 0; $intI < count($arrBrevetsHeader); $intI++):?>
              <td>
                <?php if($arrBrevetsHeader[$intI]['date_reference'] < $dateCourant && $arrBrevetsHeader[$intI]['somme_frais']!=NULL)
                      {
                        echo formatMontantFr($arrBrevetsHeader[$intI]->getSomme_frais());
                      }

                      else if($arrBrevetsHeader[$intI]['date_reference'] == $dateCourant && $arrBrevetsHeader[$intI]['somme_frais']!=NULL)
                      {
                        echo formatMontantFr($arrBrevetsHeader[$intI]->getSomme_frais());
                        $dateCourant = $arrBrevetsHeader[$intI]['date_reference'];
                        $total += $arrBrevetsHeader[$intI]->getSomme_frais();
                      }

                      else
                      {
                        echo "-";
                      }

                ?>
              </td>
            <?php endfor;?>

            <td>
              <?php echo formatMontantFr($total);?>
            </td>

          </tr>
        <?php endforeach;?>

      </tbody>
    </table>
  <?php endif;?>
<?php endif;?>

<!--    Section Contrats sur l'invention-->
<?php if($intNbContrats > 0):?>
  <p>
    <span class="underline strong"><?php echo libelle("msg_libelle_contrat_invention"); ?></span>
  </p>

  <ul class="liste_separe">
    <?php foreach($arrContrats as $objContrat):?>
    <?php $arrTypesContrat = Contrat_type_contratTable::getInstance()->getTypeContratById($objContrat->getId());?>
    
    
    <li>
      
        <!--Organisme-->
        <?php echo libelle("msg_libelle_contrat_avec")." : ";
              $arrSignataires = $objContrat->getSignataire();
              foreach($arrSignataires as $intCle => $objSignataire)
              {
                if($intCle == (count($arrSignataires)-1))
                {
                  echo $objSignataire->getOrganisme();
                }
                else
                {
                  echo $objSignataire->getOrganisme().", ";
                }
              }
            //Types de contrat
              echo " - ";
              foreach($arrTypesContrat as $intCle => $objTypeContrat)
              {
                if($intCle == (count($arrTypesContrat)-1))
                {
                  echo $objTypeContrat->getType_contrat();
                }
                else
                {
                  echo $objTypeContrat->getType_contrat().", ";
                }
              }
              //Statut du contrat
              echo " - ".$objContrat->getStatut_contrat();
        ?>
      

      <?php if($objContrat['numero_mb'] != NULL ):?>
        <p><?php echo libelle("msg_libelle_numero_rnb")." : ".$objContrat->getNumero_mb(); ?></p>
      <?php endif;?>

      <?php if($objContrat['juriste_id'] != NULL ):?>
        <p><?php echo libelle("msg_libelle_juriste")." : ".$objContrat->getJuriste(); ?></p>
      <?php endif;?>

      <?php if($objContrat['date_redaction'] != NULL):?>
        <p><?php echo libelle("msg_contrat_libelle_date_redaction")." : ".formatDate($objContrat->getDate_redaction()); ?> </p>
      <?php endif;?>

      <?php if($objContrat['date_proposition'] != NULL):?>
        <p><?php echo libelle("msg_contrat_libelle_date_proposition")." : ".formatDate($objContrat->getDate_proposition()); ?> </p>
      <?php endif;?>

      <?php if($objContrat['date_signature'] != NULL):?>
        <p><?php echo libelle("msg_contrat_libelle_date_signature")." : ".formatDate($objContrat->getDate_signature()); ?> </p>
      <?php endif;?>

      <?php if($objContrat['date_inscription_mb'] != NULL):?>
        <p><?php echo libelle("msg_contrat_libelle_date_inscription_mb")." : ".formatDate($objContrat->getDate_inscription_mb()); ?> </p>
      <?php endif;?>

    </li>

    <?php endforeach; ?>
  </ul>
<?php endif;?>
  




