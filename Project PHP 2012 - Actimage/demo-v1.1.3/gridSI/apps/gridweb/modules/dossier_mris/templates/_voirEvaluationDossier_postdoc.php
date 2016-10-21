<?php use_helper("Format"); ?>
<?php use_helper("Photo"); ?>
<?php use_helper("Libelle"); ?>

<div class="strong"><?php echo libelle("msg_dossier_mris_evaluation_finale", array($evaluationFinalePostdoc)); ?></div>

<fieldset class="top_douze">
  <legend><?php echo libelle("msg_commission_libelle_est_preselection"); ?></legend>
   <?php if ($evaluationPreselectionPostdoc->count()==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucune_evaluation"); ?>
    </div>
  <?php endif; ?>
  <?php if ($evaluationPreselectionPostdoc->count()>0):  ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_critere_evaluation"); ?></th>
          <th><?php echo libelle("msg_libelle_note"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $i=0; ?>
          <?php  foreach ($evaluationPreselectionPostdoc as $evaluationPostdoc) : ?>
            <tr class="<?php echo $i%2 == 0 ? "pair" : "impair" ?>">
              <td><?php echo $evaluationPostdoc->getNote()->getIntitule() ?></td>
              <td>
                <?php if ($evaluationPostdoc->getValeurNoteId()) {
                  echo $evaluationPostdoc->getValeur_note()->getIntitule();
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
                <?php if ($evaluationGlobalePreselectionPostdoc->getValeurNoteId()) {
                  echo $evaluationGlobalePreselectionPostdoc->getValeur_note()->getIntitule();
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
  <?php if (count($evaluationSelectionPostdoc)==0): ?>
    <div class="center">
      <?php echo libelle("msg_dossier_mris_aucune_evaluation"); ?>
    </div>
  <?php endif; ?>
  <?php if (count($evaluationSelectionPostdoc)>0):  ?>
    <table class="mep">
      <thead>
        <tr>
          <th><?php echo libelle("msg_libelle_critere_evaluation"); ?></th>
          <?php $nbInvitationsPostdoc = $invitationListe->count();
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
        <?php foreach ($notesListe as $noteSelectionPostdoc) : ?>
          <tr>
            <td><?php echo $noteSelectionPostdoc->getIntitule(); ?></td>
            <?php if (isset($evaluationSelectionPostdoc[$noteSelectionPostdoc->getId()])) { ?>
              <?php foreach ($evaluationSelectionPostdoc[$noteSelectionPostdoc->getId()] as $evaluationInvitation) : ?>
                <td>
                  <?php if ($evaluationInvitation->getValeurNoteId()) {
                    echo $evaluationInvitation->getValeur_note()->getIntitule();
                  } else {
                    echo "-";
                  } ?>
                </td>
              <?php endforeach; ?>
            <?php } else {
                for ($cptrPostdoc = 0; $cptrPostdoc < $nbInvitationsPostdoc; $cptrPostdoc++) {
                  echo "<td>-</td>";
                }
            } ?>
          </tr>
          <?php $i++; ?>
        <?php endforeach; ?>
          <tr>
            <td><?php echo libelle("msg_libelle_evaluation_globale"); ?></td>
            <?php if ($evaluationGlobaleSelectionPostdoc->count() > 0) { ?>
              <?php foreach ($evaluationGlobaleSelectionPostdoc as $evaluationGlobaleInvitation) : ?>
                <td>
                  <?php if ($evaluationGlobaleInvitation->getValeurNoteId()) {
                    echo $evaluationGlobaleInvitation->getValeur_note()->getIntitule();
                  } else {
                    echo "-";
                  } ?>
                </td>
              <?php endforeach; ?>
            <?php } else {
                for ($cptrPostdoc = 0; $cptrPostdoc < $nbInvitationsPostdoc; $cptrPostdoc++) {
                  echo "<td>-</td>";
                }
            } ?>
          </tr>
      </tbody>
    </table>
  <?php endif; ?>
</fieldset>