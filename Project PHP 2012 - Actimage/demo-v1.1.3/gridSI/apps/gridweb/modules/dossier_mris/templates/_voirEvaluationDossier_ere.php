<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>

<div class="strong"><?php echo libelle("msg_dossier_mris_evaluation_finale", array($evaluationFinaleEre)); ?></div>

<fieldset class="top_douze">
  <legend><?php echo libelle("msg_commission_libelle_est_preselection"); ?></legend>
  <?php if ($evaluationPreselectionEre->count()==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucune_evaluation"); ?>
    </div>
  <?php endif; ?>
  <?php if ($evaluationPreselectionEre->count()>0):  ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_critere_evaluation"); ?></th>
          <th><?php echo libelle("msg_libelle_note"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $i=0; ?>
          <?php  foreach ($evaluationPreselectionEre as $evaluationEre) : ?>
            <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
              <td><?php echo $evaluationEre->getNote()->getIntitule() ?></td>
              <td>
                <?php if ($evaluationEre->getValeurNoteId()) {
                  echo $evaluationEre->getValeur_note()->getIntitule();
                } else {
                  echo "-";
                } ?>
              </td>
            </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
            <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
              <td><?php echo libelle("msg_libelle_evaluation_globale") ?></td>
              <td>
                <?php if ($evaluationGlobalePreselectionEre->getValeurNoteId()) {
                  echo $evaluationGlobalePreselectionEre->getValeur_note()->getIntitule();
                } else {
                  echo "-";
                } ?>
             </td>
            </tr>
      </tbody>
    </table>
  <?php endif; ?>
</fieldset>

<fieldset>
  <legend><?php echo libelle("msg_commission_libelle_est_selection"); ?></legend>
  <?php if (count($evaluationSelectionEre)==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucune_evaluation"); ?>
    </div>
  <?php endif; ?>
  <?php if (count($evaluationSelectionEre)>0):  ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_critere_evaluation"); ?></th>
          <?php $nbInvitationsEre = $invitationListe->count();
            foreach ($invitationListe as $evaluationInvitation) : ?>
            <th>
              <?php if ($evaluationInvitation->getInvitation()->getServiceId()) {
                echo $evaluationInvitation->getInvitation()->getService()->getIntitule();
              } else {
                echo $evaluationInvitation->getInvitation()->getLaboratoire()->getIntitule();
              }  ?>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php $i=0; ?>
        <?php foreach ($notesListe as $noteSelectionEre) : ?>
          <tr>
            <td><?php echo $noteSelectionEre->getIntitule(); ?></td>
            <?php if (isset($evaluationSelectionEre[$noteSelectionEre->getId()])) { ?>
              <?php foreach ($evaluationSelectionEre[$noteSelectionEre->getId()] as $evaluationInvitation) : ?>
                <td>
                  <?php if ($evaluationInvitation->getValeurNoteId()) {
                    echo $evaluationInvitation->getValeur_note()->getIntitule();
                  } else {
                    echo "-";
                  } ?>
                </td>
              <?php endforeach; ?>
            <?php } else {
                for ($cptrEre = 0; $cptrEre < $nbInvitationsEre; $cptrEre++) {
                  echo "<td>-</td>";
                }
            } ?>
          </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
          <tr>
            <td><?php echo libelle("msg_libelle_evaluation_globale"); ?></td>
            <?php if ($evaluationGlobaleSelectionEre->count() > 0) { ?>
              <?php foreach ($evaluationGlobaleSelectionEre as $evaluationGlobaleInvitation) : ?>
                <td>
                  <?php if ($evaluationGlobaleInvitation->getValeurNoteId()) {
                    echo $evaluationGlobaleInvitation->getValeur_note()->getIntitule();
                  } else {
                    echo "-";
                  } ?>
                </td>
              <?php endforeach; ?>
            <?php } else {
                for ($cptrEre = 0; $cptrEre < $nbInvitationsEre; $cptrEre++) {
                  echo "<td>-</td>";
                }
            } ?>
          </tr>
      </tbody>
    </table>
  <?php endif; ?>
</fieldset>