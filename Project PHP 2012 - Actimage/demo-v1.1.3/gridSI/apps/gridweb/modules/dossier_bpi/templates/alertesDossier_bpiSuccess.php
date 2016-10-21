<?php use_helper("Message"); ?>
<?php use_helper("Format"); ?>

<?php include_partial("dossier_mip/dossierHeader", array("objDossier" => $objDossier)); ?>

<?php echo message(); ?>

<div class="reduit">
  <?php if ($objDossier->getEstActif()): ?>

    <?php
      if (!(isset($arrErreurs['actions']) && count(isset($arrErreurs['actions'])) > 0)
              && !(isset($arrErreurs['classements']) && count(isset($arrErreurs['classements'])) > 0)
              && !(isset($arrErreurs['droits']) && count(isset($arrErreurs['droits'])) > 0)
              && !(isset($arrErreurs['brevets']) && count(isset($arrErreurs['brevets'])) > 0)
              && !(isset($arrErreurs['primes']) && count(isset($arrErreurs['primes'])) > 0)) { ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_libelle_alertes") ?>
        </legend>
          <?php echo libelle("msg_libelle_pas_alerte"); ?>
      </fieldset>
    <?php } ?>


    <!-- Groupement actions à mener -->
    <?php if (isset($arrErreurs['actions']) && count(isset($arrErreurs['actions'])) > 0) : ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_libelle_actions_a_mener") ?>
        </legend>
        <ul>
          <?php foreach($arrErreurs['actions'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              <?php echo libelle("msg_libelle_acion_a_mener_par", array($arrErreur["objet"]->getPilote(), formatDate($arrErreur["echeance"]))); ?>
              <?php if ($arrErreur["alertes"] != "") { ?>
                <br />
                <?php echo libelle("msg_libelle_alertes_envoyees", array($arrErreur["alertes"])); ?>
              <?php } ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    <?php endif; ?>

    <!-- Groupement délai pour le classement de l'invention -->
    <?php if (isset($arrErreurs['classements']) && count($arrErreurs['classements']) > 0) : ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_libelle_delai_classement_invention") ?>
        </legend>
        <ul>
          <?php foreach($arrErreurs['classements'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              <?php echo libelle("msg_libelle_classement_invention_pour", array(formatDate($arrErreur["echeance"]))); ?>
              <?php if ($arrErreur["alertes"] != "") { ?>
                <br />
                <?php echo libelle("msg_libelle_alertes_envoyees", array($arrErreur["alertes"])); ?>
              <?php } ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    <?php endif; ?>

    <!-- Groupement attribution des droits -->
    <?php if (isset($arrErreurs['droits']) && count($arrErreurs['droits']) > 0) : ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_libelle_attribution_droits") ?>
        </legend>
        <ul>
          <?php foreach($arrErreurs['droits'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              <?php echo libelle("msg_libelle_attribution_non_renseignee", array(formatDate($arrErreur["echeance"]))); ?>
              <?php if ($arrErreur["alertes"] != "") { ?>
                <br />
                <?php echo libelle("msg_libelle_alertes_envoyees", array($arrErreur["alertes"])); ?>
              <?php } ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    <?php endif; ?>

    <!-- Groupement brevets -->
    <?php if (isset($arrErreurs['brevets']) && count($arrErreurs['brevets']) > 0) : ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_libelle_brevets") ?>
        </legend>
        <ul>
          <?php foreach($arrErreurs['brevets'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              <?php echo libelle("msg_libelle_extension_brevet_pour", array($arrErreur["objet"]->getTitre(), formatDate($arrErreur["echeance"]))); ?>
              <?php if ($arrErreur["alertes"] != "") { ?>
                <br />
                <?php echo libelle("msg_libelle_alertes_envoyees", array($arrErreur["alertes"])); ?>
              <?php } ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    <?php endif; ?>

    <!-- Groupement prime au brevets -->
    <?php if (isset($arrErreurs['primes']) && count($arrErreurs['primes']) > 0) : ?>
      <fieldset>
        <legend>
          <?php echo libelle("msg_libelle_prime_au_brevet") ?>
        </legend>
        <ul>
          <?php foreach($arrErreurs['primes'] as $arrErreur) : ?>
            <li class="<?php echo $arrErreur["class"] ?>">
              <?php echo libelle("msg_libelle_versement_20_non_indique", array(formatDate($arrErreur["echeance"]))); ?>
              <?php if ($arrErreur["alertes"] != "") { ?>
                <br />
                <?php echo libelle("msg_libelle_alertes_envoyees", array($arrErreur["alertes"])); ?>
              <?php } ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    <?php endif; ?>

  <?php else : ?>
    <?php echo libelle('msg_dossier_mip_controle_ras',array($objDossier)); ?>
  <?php endif; ?>
    
</div>

<?php include_partial('dossier_bpi/autreActions',array('id' => $objDossier->getId())) ?>

<hr class="clear"/>
<div class="left">
  <?php echo link_to_grid_retour(libelle("msg_bouton_retourner"), array("class" => "picto bt_retour")); ?>
</div>

