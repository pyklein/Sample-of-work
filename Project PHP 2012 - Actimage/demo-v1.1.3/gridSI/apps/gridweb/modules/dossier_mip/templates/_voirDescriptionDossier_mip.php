<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>

<p>
  <span class="underline strong"><?php echo $objDossierMip->getTitre(); ?></span>
  <br />
  <?php echo $objDossierMip->getAcronyme(); ?>
</p>

<div class="floatright">
  <?php 
    if (strlen($objDossierMip->getPhotographie()) > 0) {
      echo photo_tag(photo_path("referentiel_mip/chargerThumbnailUtilisateurMip?modele=dossier_mip&fichier=".$objDossierMip->getPhotographie(), true, true, isset($pdf) ? true : false),
                     !isset($pdf) ? photo_path("interface/telechargerPhoto?modele=dossier_mip&fichier=".$objDossierMip->getPhotographie(), true, false, false) : "");
    }
  ?>
</div>

<p>
  <?php echo $objDossierMip->getDescriptif(); ?>
</p>

<!--Cadre Informations complémentaires -->
<fieldset>
  <legend>
    <?php echo libelle("msg_libelle_informations_complementaires") ?>
  </legend>

  <table>
    <tr>
      <td><?php echo libelle("msg_libelle_organisme_armee") . " : " . $objDossierMip->getOrganisme_mindef()->getIntitule(); ?></td>
      <td><?php echo libelle("msg_libelle_pilote") . " : " . $objDossierMip->getPilote(); ?></td>
    </tr>

    <tr>
      <td><?php echo libelle("msg_libelle_statut") . " : " . $objDossierMip->getStatut_dossier_mip()->getIntitule(); ?></td>
      <td><?php echo '<a href="mailto:'.$objDossierMip->getPilote()->getEmail().'">'.$objDossierMip->getPilote()->getEmail().'</a>'; ?></td>
    </tr>

    <tr>
      <td>
        <?php
        echo libelle("msg_libelle_dossier") . " " . $objDossierMip->getEtat_partage()->getIntitule() . " - ";
        echo $objDossierMip->getEstPublie() ? libelle("msg_libelle_publie") : libelle("msg_libelle_non_publie");
        ?>
      </td>
      <td><?php echo libelle("msg_libelle_telephone") . " : " . $objDossierMip->getPilote()->getTelephoneFixe(); ?></td>
    </tr>

    <tr>
      <td><?php echo $objDossierMip->getNiveau_protection()->getAbreviation() . " - " . $objDossierMip->getNiveau_protection()->getIntitule(); ?></td>
      <td></td>
    </tr>
  </table>
</fieldset>


<?php if($boolInnovateurExiste): ?>
  <?php if($objInnovateurprincipal != NULL):?>
    <!--Cadre Innovateur Principal -->
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_innovateur_principal") ?>
      </legend>

      <div class="floatright">
        <?php
          if ($objInnovateurprincipal->getPhotographie()) {
            echo photo_tag(photo_path("referentiel_mip/chargerThumbnailUtilisateurMip?fichier=".$objInnovateurprincipal->getPhotographie()."&modele=utilisateur", true, true, isset($pdf) ? true : false),
                           !isset($pdf) ? photo_path("interface/telechargerPhoto?fichier=".$objInnovateurprincipal->getPhotographie()."&modele=utilisateur", true, false, false) : "");
          }
        ?>
      </div>

      <div class="strong"><?php echo $objInnovateurprincipal->getCivilite()->getAbreviation() . " " . $objInnovateurprincipal; ?></div>
      <div><a href="mailto:<?php echo $objInnovateurprincipal->getEmail(); ?>"><?php echo $objInnovateurprincipal->getEmail(); ?></a></div>
      <div><?php echo $objInnovateurprincipal->getGrade()->getIntitule() . " - " . $objInnovateurprincipal->getOrganisme_mindef()->getIntitule(); ?></div>
      <div><?php echo $objInnovateurprincipal->getEntite()->getIntitule() ; ?></div>
      <div><?php if($objInnovateurprincipal->getTelephoneFixe()!= null) echo libelle("msg_libelle_telephone") . " : " . $objInnovateurprincipal->getTelephoneFixe() ; ?></div>
      <div><?php if($objInnovateurprincipal->getTelephoneMobile()!= null) echo libelle("msg_libelle_telephone_mobile") . " : " . $objInnovateurprincipal->getTelephoneMobile() ; ?></div>

    </fieldset>
  <?php endif;?>

  <!--Cadre Innovateurs secondaires  -->
  <?php foreach ($arrInnovateursSecondaires as $objInnovateur) { ?>
    <fieldset>
      <legend>
        <?php echo libelle("msg_libelle_innovateur") ?>
      </legend>

      <div class="floatright">
        <?php 
          if (strlen($objInnovateur->getPhotographie()) > 0) {
            echo photo_tag(photo_path("referentiel_mip/chargerThumbnailUtilisateurMip?fichier=".$objInnovateur->getPhotographie() ."&modele=utilisateur", true, true, isset($pdf) ? true : false),
                           !isset($pdf) ? photo_path("interface/telechargerPhoto?fichier=".$objInnovateur->getPhotographie()."&modele=utilisateur", true, false, false) : "");
          }
        ?>
      </div>

      <div class="strong"><?php echo $objInnovateur->getCivilite()->getAbreviation() . " " . $objInnovateur; ?></div>
      <div><a href="mailto:<?php echo $objInnovateur->getEmail(); ?>"><?php echo $objInnovateur->getEmail(); ?></a></div>
      <div><?php echo $objInnovateur->getGrade()->getIntitule() . " - " . $objInnovateur->getOrganisme_mindef()->getIntitule(); ?></div>
      <div><?php echo $objInnovateur->getEntite()->getIntitule() ; ?></div>
      <div><?php if($objInnovateur->getTelephoneFixe()!=null) echo libelle("msg_libelle_telephone") . " : " . $objInnovateur->getTelephoneFixe() ; ?></div>
      <div><?php if($objInnovateur->getTelephoneMobile()!=null) echo libelle("msg_libelle_telephone_mobile") . " : " . $objInnovateur->getTelephoneMobile() ; ?></div>

    </fieldset>

  <?php } ?>

<?php endif; ?>

<?php if (count($arrEvenements) > 0
        && ($sf_user->hasCredential('SUP-MIP') || $sf_user->hasCredential('USR-MIP'))): ?>

  <!--Cadre Evènements -->
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_evenements") ?>
    </legend>

    <?php foreach ($arrEvenements as $objEvenement) { ?>
      <p>
        <span class="underline"> <?php echo formatDate($objEvenement->getDate()) ?> </span>
        <br />
        <?php echo $objEvenement->getRaw('evenement'); ?>
      </p>

    <?php } ?>
  </fieldset>

<?php endif; ?>

<?php if (count($arrRemarques) > 0
        && ($boolEstInnovateurDuDossier || $sf_user->hasCredential('SUP-MIP') || $sf_user->hasCredential('USR-MIP')) ): ?>
  
  <!--Cadre Remarques -->
  <fieldset>
    <legend>
      <?php echo libelle("msg_libelle_remarques") ?>
    </legend>

    <?php foreach ($arrRemarques as $objRemarque) { ?>
      <p><?php echo $objRemarque->getRaw('contenu'); ?></p>
    <?php } ?>

  </fieldset>

<?php endif; ?>
