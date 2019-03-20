<?php

require_once 'i3vali.civix.php';
use CRM_I3vali_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function i3vali_civicrm_pre($op, $objectName, $id, &$params) {
  CRM_Core_Error::debug_log_message("$op, $objectName, $id");

  if ($objectName == 'Individual') {
    if ($op == 'create' || $op == 'edit') {

      // generate origin signature
      $stack = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 25);
      //    $basepath = '/var/www/civicrm/aivl/sites/all/modules/civicrm/'; // TODO: how do you get this?
      //    $basepath_length = strlen($basepath);
      //    $origin = '';
      //    foreach ($stack as $entry) {
      //      $origin .= $entry['file'] . ':' . $entry['line'] . "\n";
      //    }
      //    CRM_Core_Error::debug_log_message("Origin: $origin");

      // check if signature should pass
      $pass = FALSE;
      foreach ($stack as $entry) {
        if (preg_match("#CRM[/]Contribute[/]Form[/]Contribution[/]Confirm.php#", $entry['file'])) {
          $pass = TRUE;
          continue;
        }
      }
      if (!$pass) return;

      // ok, let's go!
      if ($op == 'create') {
        // identify contact via XCM
        CRM_Core_Error::debug_log_message("Contact.getorcreate: " . json_encode($params));
        $contact = civicrm_api3('Contact', 'getorcreate', $params);
        $params['id'] = $contact['id'];
      } else {
        // contact already identified
        $params['id'] = $id;
      }

      // call i3val
      CRM_Core_Error::debug_log_message("Contact.request_update: " . json_encode($params));
      civicrm_api3('Contact', 'request_update', $params);

      // strip parameters from update
      $strip_params = ['first_name', 'last_name', 'gender_id', 'prefix_id'];
      foreach ($strip_params as $strip_param) {
        if (isset($params[$strip_param])) {
          unset($params[$strip_param]);
        }
      }
    }
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function i3vali_civicrm_config(&$config) {
  _i3vali_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function i3vali_civicrm_xmlMenu(&$files) {
  _i3vali_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function i3vali_civicrm_install() {
  _i3vali_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function i3vali_civicrm_postInstall() {
  _i3vali_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function i3vali_civicrm_uninstall() {
  _i3vali_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function i3vali_civicrm_enable() {
  _i3vali_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function i3vali_civicrm_disable() {
  _i3vali_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function i3vali_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _i3vali_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function i3vali_civicrm_managed(&$entities) {
  _i3vali_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function i3vali_civicrm_caseTypes(&$caseTypes) {
  _i3vali_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function i3vali_civicrm_angularModules(&$angularModules) {
  _i3vali_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function i3vali_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _i3vali_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function i3vali_civicrm_entityTypes(&$entityTypes) {
  _i3vali_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function i3vali_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function i3vali_civicrm_navigationMenu(&$menu) {
  _i3vali_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _i3vali_civix_navigationMenu($menu);
} // */
