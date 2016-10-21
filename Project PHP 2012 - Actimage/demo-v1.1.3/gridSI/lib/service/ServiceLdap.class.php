<?php

/**
 * Description of UtilLdap : Gère la connection, authentification des utilisateurs au travers du LDAP
 * ainsi que la récupération des données pour mise à jour des infos dans GRID.
 *
 * @author William
 */
class ServiceLdap {

  protected $_strAdresse;
  protected $_strDNBase;
  protected $_strAdmin;
  protected $_strPass;
  protected $_strAttributRdn;
  protected $_identifiantConnection = null;

  public function __construct($strAdresse = null, $DNBase = null, $strAdmin = null, $strPass = null, $strAttributRdn = null) {
//surcharge conf
    if ($strAdresse == null) {
      $strAdresse = sfConfig::get("app_ldap_adresse").":".sfConfig::get("app_ldap_port");
    }
    if ($strAdresse != null) {
      $this->_strAdresse = $strAdresse;
    }
    if ($DNBase == null) {
      $DNBase = sfConfig::get("app_ldap_base");
    }
    if ($DNBase != null) {
      $this->_strDNBase = $DNBase;
    }
    if ($strAdmin == null) {
      $strAdmin = sfConfig::get("app_ldap_utilisateur");
    }
    if ($strAdmin != null) {
      $this->_strAdmin = $strAdmin;
    }
    if ($strPass == null) {
      $strPass = sfConfig::get("app_ldap_motdepasse");
    }
    if ($strPass != null) {
      $this->_strPass = $strPass;
    }
    if ($strAttributRdn == null) {
      $strAttributRdn = sfConfig::get("app_ldap_attribut_rdn");
    }
    if ($strAttributRdn != null) {
      $this->_strAttributRdn = $strAttributRdn;
    }


//initialisation et connection
    $this->_identifiantConnection = ldap_connect($this->_strAdresse);
    ldap_set_option($this->_identifiantConnection, LDAP_OPT_PROTOCOL_VERSION, 3);

    // 2 seconds pour le timeout de reseau
    ldap_set_option($this->_identifiantConnection, LDAP_OPT_NETWORK_TIMEOUT, sfConfig::get('app_ldap_timeout'));

    if (!@ldap_bind($this->_identifiantConnection, $this->_strAdmin, $this->_strPass)) {
      throw new Exception('Echec connection LDAP');
    }
  }

  /**
   *  Cherche l'utilisateur ayant l'email donné dans la base, récupère son CN, puis essaye de bind au LDAP avec cn + pass
   * @param string $strEmail
   * @param string $strPass
   * @return bool si l'utilisateur à été trouvé et que le bind à réussi.
   */
  public function authentifierUtilisateurLDAP($strEmail, $strPass) {
    $resultatRecherche = ldap_search($this->_identifiantConnection, $this->_strDNBase, "mail=$strEmail");
    $arrResultat = ldap_get_entries($this->_identifiantConnection, $resultatRecherche);
    if ($arrResultat['count'] == 1) {
      $strCnUtilisateur = $arrResultat[0][$this->_strAttributRdn][0];
      $IdentifiantConnectionTest = ldap_connect($this->_strAdresse);
      ldap_set_option($IdentifiantConnectionTest, LDAP_OPT_PROTOCOL_VERSION, 3);
      if (@ldap_bind($IdentifiantConnectionTest, "$this->_strAttributRdn=$strCnUtilisateur,$this->_strDNBase", $strPass)) {
        ldap_unbind($IdentifiantConnectionTest);
        return true;
      }
    } else {
      throw new Exception("Authentification LDAP échouée");
    }
  }

  /**
   *  Récupère les informations présentes sur le LDAP
   * @param string $strEmail Email de l'utilisateur pour lequel on souhaite récuperer les données
   * @return array tableau sous la forme : (champGrid => valeure) Attention, les valeures sont des abréviations ou intitulés, pas les objets du référentiel
   */
  public function recupereInformations($strEmail) {
    $arrCorrespondances = sfConfig::get("app_ldap_correspondances");
    $arrInfos = array();
    $resultatRecherche = ldap_search($this->_identifiantConnection, $this->_strDNBase, "mail=$strEmail");
    $arrResultat = ldap_get_entries($this->_identifiantConnection, $resultatRecherche);
    if ($arrResultat['count'] == 1) {
      foreach ($arrCorrespondances as $clefLdap => $clefGrid) {
        if (isset($arrResultat[0][$clefLdap])) {
          if ($clefLdap == "departmentnumber") {
            $org = explode('/', $arrResultat[0][$clefLdap][0]);
            $arrInfos[$clefGrid] = $org[1];
          } else {
            $arrInfos[$clefGrid] = $arrResultat[0][$clefLdap][0];
          }
        }
      }
      return $arrInfos;
    } else {
      return false;
    }
  }

  public function __destruct() {
    if ($this->_identifiantConnection != null) {
      ldap_unbind($this->_identifiantConnection);
    }
  }

}

class utilisateurLdapNonInscrisException extends Exception {
  
}

?>
