<?php use_helper("Message"); ?>

<h3>
  <?php echo libelle("msg_titre_dossier_bpi", array($dossierBpi)); ?>
</h3>

<?php echo message(); ?>

<p>
  <?php if ($boolContentieuxExist) :?>
    <?php echo libelle('msg_dossier_bpi_contentieux_exist');?>
  <?php endif; ?>
</p>
  
<?php include_partial('onglet_recompenses',array('arrInventeurs' => $arrInventeurs, 'checkInventeur' => $checkInventeur, 'dossierId' => $dossierId)) ?>

<div id="zone_cadre" class="reduit">
<?php if($boolBrevetDepose || $boolExterneEffective || $boolInterneEffective ){ ?>
  <!--
  <p>
    <?php if ($boolContentieuxExist) :?>
      <?php echo libelle('msg_dossier_bpi_contentieux_exist');?>
    <?php endif; ?>
  </p>
  -->
  <form action="" method="post" name="recompenses">

    <!--Prime au brevet-->
    <?php if($boolBrevetDepose):?>
     <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_recompenses_prime_au_brevet')?>
      </legend>
      <?php echo $objForm['date_versement_20']->renderRow(); ?>
      <?php if($boolExterneEffective) echo $objForm['date_versement_80']->renderRow(); ?>
    </fieldset>
    <?php endif; ?>

    <!--Exploitation Externe-->
    <?php if($boolExterneEffective):?>
     <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_exploitation_externe')?>
      </legend>
      <?php echo $objForm['date_decision_recompense']->renderRow(); ?>

      <br />
        <!-- Liste des redevances -->
        <?php if (count($arrExpExterne) != 0 ) : ?>
          <table class="mep">
            <thead>
              <tr>
                <th><?php echo libelle("msg_libelle_actions"); ?></th>
                <th><?php echo libelle("msg_libelle_redevance"); ?></th>
                <th><?php echo libelle("msg_libelle_montant_percu"); ?></th>
                <th><?php echo libelle("msg_libelle_recompenses_date_versement"); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($arrExpExterne as $intCle => $objExpExterne) { ?>
                <tr class="<?php echo $intCle%2 == 0 ? "pair" : "impair" ?>">
                  <td>
                    <?php
                    if(!isset($arrExpExterneNonSuppr[$objExpExterne->getRedevanceId()])){
                      echo link_to_grid("", "dossier_bpi/supprimerExploitationExterne?exploitation_id=".$objExpExterne->getId()."&dossier_id=".$dossierId."&inventeur_id=".$checkInventeur, array("class" => "picto_court bt_supprimer", "title" => libelle("msg_bouton_supprimer")));
                    }
                    ?>
                  </td>
                  <td><?php echo $objExpExterne->getRedevance()->afficheRedevanceDetaillee(); ?></td>
                  <td><?php echo formatMontantFr($objExpExterne->getMontant()); ?></td>
                  <td><?php echo formatDate($objExpExterne->getDateVersement()); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        <?php else: ?>
           <?php echo libelle("msg_libelle_recompenses_aucune_redevance"); ?>
        <?php endif; ?>

       <!-- Formulaire Exploitation Externe-->
         <?php echo $objExpExtForm['date_versement']->renderRow(); ?>
         <?php echo $objExpExtForm['redevance_id']->renderRow(); ?>
         <?php echo $objExpExtForm['montant']->render(); ?>

         <div class="boutons">
           <input type="submit" value="<?php echo  libelle("msg_bouton_ajouter_versement"); ?>" name="bouton_exploitation" />
         </div>

      </fieldset>
    <?php endif; ?>
    

    <!--Exploitation Interne-->
    <?php if($boolInterneEffective):?>
     <fieldset>
      <legend>
        <?php echo libelle('msg_libelle_exploitation_interne')?>
      </legend>
        <?php if($boolContentieuxExiste) echo "<p>".libelle('msg_recompense_contentieux_existe')."<br/><br/></p>" ; ?>
        <?php echo $objForm['Exploitation_interne']['date_decision_ouverture']->renderRow(); ?>
        <?php echo $objForm['Exploitation_interne']['rapporteur_id']->renderRow(); ?>
        <?php echo $objForm['Exploitation_interne']['montant']->renderRow(); ?>
        <?php echo $objForm['Exploitation_interne']['date_remise_rapport']->renderRow(); ?>
        <?php echo $objForm['Exploitation_interne']['date_commission']->renderRow(); ?>
        <?php echo $objForm['Exploitation_interne']['date_decision_recompense']->renderRow(); ?>
        <?php if($boolBrevetDepose) echo $objForm['Exploitation_interne']['date_versement']->renderRow(); ?>
        <?php if($boolBrevetDepose) echo $objForm['Exploitation_interne']['date_envoi_lettre']->renderRow(); ?>
    </fieldset>
    <?php endif; ?>
    
    <div class="boutons">
      <input type="submit" value="<?php echo  libelle("msg_bouton_enregistrer"); ?>" name="bouton_recompenses" />
    </div>
    
  </form>
  <?php
  } else {
    echo libelle('msg_libelle_aucune_recompense') ;
  }
  ?>

</div>

<?php include_partial('autreActions',array('id' => $dossierId)) ?>

<hr class="clear" />
<div class="left">
    <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_bpi/listerDossier_bpis", array("class" => "picto bt_retour")); ?>
</div>
