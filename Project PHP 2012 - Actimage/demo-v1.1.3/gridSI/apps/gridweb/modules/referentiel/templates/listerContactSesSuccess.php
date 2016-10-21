<?php use_helper("Message"); ?>

<?php echo message(); ?>

<div class="right">
  <?php echo link_to_grid(libelle("msg_contact_se_bouton_nouveau_contact"), "referentiel/creerContactSe", array("class" => "picto bt_ajouter", 'title' => libelle("msg_contact_se_bouton_nouveau_contact"))); ?>
</div>

<table class="mep">
  <caption>
    <?php echo ($objPager->count()==0) ? libelle("msg_contact_se_0_resultat") : libelle("msg_contact_se_nombre_resultat",array($objPager->count())); ?>
  </caption>
  <?php if ($objPager->count()>0):  ?>
    <thead>
      <tr>
        <th><?php echo libelle("msg_libelle_action")?></th>
        <th><?php echo libelle("msg_libelle_nom")?></th>
        <th><?php echo libelle("msg_libelle_prenom")?></th>
        <th><?php echo libelle("msg_libelle_email")?></th>
        <th><?php echo libelle("msg_libelle_telephone")?></th>
        <th><?php echo libelle("msg_libelle_entite_affectation")?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objPager->getResults() as $clef => $contactSe): ?>
        <tr class="<?php echo $clef%2 == 0 ? "pair" : "impair" ?>">
          <td>
            <?php if ($objUtilisateurCourrant->peutGererContactSe($contactSe)) : ?>
              <?php echo link_to_grid(' ','referentiel/modifierContactSe?contact_se_id='.$contactSe->getId(),array("class" => "picto_court bt_modifier", "title"=>libelle("msg_bouton_modifier"))); ?>
            <?php endif; ?>
          </td>
          <td><?php echo $contactSe->getNom() ?></td>
          <td><?php echo $contactSe->getPrenom() ?></td>
          <td><?php echo $contactSe->getEmail() ?></td>
          <td><?php echo $contactSe->getTelephone() ?></td>
          <td><?php echo $contactSe->getEntite()->getNomHierarchique() ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  <?php endif; ?>
</table>

<?php if ($objPager->count()>0):  ?>
  <?php if ($objPager->haveToPaginate()): ?>
    <?php include_partial('interface/paginateur', array('objPager' => $objPager,'strUrlRedirection' => $strUrlRedirection)) ?>
  <?php endif; ?>

  <?php if ($objPager->count() > 0) : ?>
    <?php include_partial('interface/maxParPage',array('intSelectionne' => $intSelectionne,'arrNombres' => $arrNombres)) ?>
  <?php endif; ?>
<?php endif; ?>

<hr class="clear" />
<div class="left">
  <?php echo link_to(libelle("msg_bouton_retour_administration"), "referentiel/index", array("class" => "picto bt_retour")); ?>
</div>