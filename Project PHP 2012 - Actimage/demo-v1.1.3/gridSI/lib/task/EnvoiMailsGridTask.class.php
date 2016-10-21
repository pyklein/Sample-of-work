<?php

/**
 * Classe représentant la tache symfony d'envoi des mails stoqués en base.
 * Projet : GRID
 * Module : N.A
 * Date de création : 28/02/2011
 * Auteur : William Richards
 *
 */
class EnvoiMailsGridTask extends GridTask {

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:mails --application=gridweb
   * @param   Console   application   spécifie l'application dont la configuration doit être chargée
   * @param   Console   env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure() {

    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'mails';
    $this->briefDescription = 'Envoi des mails planifiés';

    parent::configure();
  }

  protected function execute($arguments = array(), $options = array()) {

    // init d'execution
    $this->debut($arguments, $options);

    //configuration et initialisation de swift mailer
    $objSmtp = Swift_SmtpTransport::newInstance(sfConfig::get('app_mail_adresse'), sfConfig::get('app_mail_port'));
    $objSmtp->setUsername(sfConfig::get('app_mail_utilisateur'));
    $objSmtp->setPassword(sfConfig::get('app_mail_motdepasse'));
    $objMailer = Swift_Mailer::newInstance($objSmtp);

    $boolDemo = sfConfig::get('app_mail_en_demo');

    //Récupération des mails à envoyer puis envoi de ceux-ci
    $arrEmailsAEnvoyer = Doctrine_Core::getTable('Mail')->retrieveMailsAEnvoyer();
    $intReussi = 0;
    $intErreur = 0;
    foreach ($arrEmailsAEnvoyer as $objEmail) {
      $this->logSection('Mail à envoyer : ' , $objEmail->getSujet() . ' à ' . $objEmail->getDestinataire());

      $objMessage = Swift_Message::newInstance();
      $objMessage->setFrom(sfConfig::get("app_mail_expediteur"));
      $objMessage->setSubject($objEmail->getSujet());
      $objMessage->setBody($objEmail->getMessage(), 'text/html');
      $objMessage->setTo($objEmail->getDestinataire());

      try {
        if (!($boolDemo && substr($objEmail->getDestinataire(), -13) != '@actimage.com')){
          //Limite l'envoi des mails différent de @actimage.com en environnement démo
          $objMailer->send($objMessage);
        }
        $objEmail->setStatutId(2);
        $objEmail->save();
        $this->logSection('Mail envoyé : ' , $objEmail->getSujet() . ' à ' . $objEmail->getDestinataire());
        $intReussi++;
      } catch (Exception $exc) {
        $objEmail->setNombreTentative($objEmail->getNombreTentative() + 1);
        $objEmail->save();
        $this->logSection('Echec envoi de mail: ' , $objEmail->getSujet() . ' à ' . $objEmail->getDestinataire() . '  Erreur:' . $exc->getMessage());
        if ($options['env'] != 'prod') {
          echo $exc->getTraceAsString();
        }
        $intErreur++;
      }
    }

    // fin d'execution
    $this->fin(false, libelle("msg_tache_rapport_mails", array($intErreur, count($arrEmailsAEnvoyer))));
  }

}
