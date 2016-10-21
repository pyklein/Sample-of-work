<?php use_helper("Photo"); ?>

<div>
  <p>
    <?php echo libelle("msg_dossier_mip_titre",array($objDossierMip->getNumero())); ?>
  </p>

  <p>
    <span class="underline"><?php echo $objDossierMip->getTitre(); ?></span>
    <br />
    <?php echo $objDossierMip->getAcronyme(); ?>
  </p>

  <div class="floatright">
        <?php if( strlen($objDossierMip->getPhotographie())>0 ) echo photo_tag( url_for("interface/chargerThumbnailUtilisateurMip?fichier=".$objDossierMip->getPhotographie()."&modele=dossier_mip" ),url_for("interface/telechargerPhoto?fichier=".$objDossierMip->getPhotographie()."&modele=dossier_mip")); ?>
  </div>

  <p>
    <?php echo $objDossierMip->getDescriptif(); ?>
  </p>

  <hr class="clear">

  <!--Cadre Informations complémentaires -->
  <fieldset>
        <legend>
            <?php echo libelle("msg_libelle_informations_complementaires") ?>
        </legend>

    <table>
      <tr>
        <td> <?php echo libelle("msg_libelle_organisme_armee") . " : " . $objDossierMip->getOrganisme_mindef()->getIntitule(); ?></td>
      </tr>
      <tr>
        <td> <?php echo libelle("msg_libelle_statut_dossier") . " : " . $objDossierMip['Statut_dossier_mip']; ?></td>
      </tr>
      <tr>
        <td><?php echo $objDossierMip->getNiveau_protection()->getAbreviation() . " - " . $objDossierMip->getNiveau_protection()->getIntitule(); ?></td>
      </tr>
    </table>
  </fieldset>

  <?php if($boolInnovateurExiste): ?>
    <?php if($objInnovateurprincipal):?>
      <!--Cadre Innovateur Principal -->
      <fieldset>
            <legend>
                <?php echo libelle("msg_libelle_innovateur_principal") ?>
            </legend>

        <div class="floatright">
          <?php if( strlen($objInnovateurprincipal->getPhotographie())>0 ) echo photo_tag(url_for("interface/chargerThumbnailUtilisateurMip?fichier=".$objInnovateurprincipal->getPhotographie()."&modele=utilisateur"  ), url_for("interface/telechargerPhoto?fichier=".$objInnovateurprincipal->getPhotographie()."&modele=utilisateur")); ?>
        </div>

        <div class="strong"><?php echo $objInnovateurprincipal->getCivilite()->getAbreviation() . " " . $objInnovateurprincipal; ?></div>
        <div><a href="mailto:<?php echo $objInnovateurprincipal->getEmail(); ?>"><?php echo $objInnovateurprincipal->getEmail(); ?></a></div>
        <div><?php echo $objInnovateurprincipal->getGrade()->getIntitule() . " - " . $objInnovateurprincipal->getOrganisme_mindef()->getIntitule(); ?></div>
        <div><?php echo $objInnovateurprincipal->getEntite()->getIntitule() ; ?></div>
        <div><?php if($objInnovateurprincipal->getTelephoneFixe()) echo libelle("msg_libelle_telephone") . " : " . $objInnovateurprincipal->getTelephoneFixe() ; ?></div>
        <div><?php if($objInnovateurprincipal->getTelephoneMobile()) echo libelle("msg_libelle_telephone_mobile") . " : " . $objInnovateurprincipal->getTelephoneMobile() ; ?></div>

      </fieldset>
    <?php endif;?>

    <!--Cadre Innovateurs secondaires  -->
    <?php foreach ($arrInnovateursSecondaires as $objInnovateur):?>
      <fieldset>
        <legend>
            <?php echo libelle("msg_libelle_innovateur") ?>
        </legend>

        <div class="floatright">
           <?php if( strlen($objInnovateur->getPhotographie())>0 ) echo photo_tag(url_for("interface/chargerThumbnailUtilisateurMip?fichier=".$objInnovateur->getPhotographie() ."&modele=utilisateur"), url_for("interface/telechargerPhoto?fichier=".$objInnovateur->getPhotographie()."&modele=utilisateur")); ?>
        </div>

        <div class="strong"><?php echo $objInnovateur->getCivilite()->getAbreviation() . " " . $objInnovateur; ?></div>
        <div><a href="mailto:<?php echo $objInnovateur->getEmail(); ?>"><?php echo $objInnovateur->getEmail(); ?></a></div>
        <div><?php echo $objInnovateur->getGrade()->getIntitule() . " - " . $objInnovateur->getOrganisme_mindef()->getIntitule(); ?></div>
        <div><?php echo $objInnovateur->getEntite()->getIntitule() ; ?></div>
        <div><?php if($objInnovateur->getTelephoneFixe()) echo libelle("msg_libelle_telephone") . " : " . $objInnovateur->getTelephoneFixe() ; ?></div>
        <div><?php if($objInnovateur->getTelephoneMobile()) echo libelle("msg_libelle_telephone_mobile") . " : " . $objInnovateur->getTelephoneMobile() ; ?></div>

      </fieldset>
    <?php endforeach;?>

  <?php endif; ?>

</div>

 <!--Bouton retour -->
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retourner"), "dossier_mip/listerDossier_mip_publiques", array("class" => "picto bt_retour")); ?>
</div>
