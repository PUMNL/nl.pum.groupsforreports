<?php

/**
 * Class for PUM specific groups for reports
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 7 Apr 2016
 * @license AGPL-3.0
 */
class CRM_Groupsforreports_GroupReport
{
  protected $_groups = array();
  protected $_reports = array();
  /**
   * CRM_Groupsforreports_Groups constructor.
   */
  function __construct()
  {
    $groups = array(
      'Anamon_120',
      'Business_Link_Coordinators_21',
      'Country_Coordinators_Gabrielle_105',
      'Programme_Managers_58',
      'Projectmanagers_82',
      'Project_Officers_54',
      'Sector_Coordinators_55'
    );
    $this->_reports['CRM_Civireports_Form_Report_MyProjectIntake'] = $groups;
    $this->_reports ['CRM_Casereports_Form_Report_PumProjects'] = $groups;
    $groups[] = 'Grant_Coordinators_96';
    $this->_reports['CRM_Casereports_Form_Report_MainActivities'] = $groups;
    foreach ($groups as $groupName) {
      try {
        $groupId = civicrm_api3('Group', 'Getvalue', array('name' => $groupName, 'return' => 'id'));
        $this->_groups[$groupName] = $groupId;
      } catch (CiviCRM_API3_Exception $ex) {}
    }
  }

  /**
   * Method to get the group ids for the report
   * 
   * @param string $reportClass
   * @return array
   * @static
   */
  public static function getGroupsForReport($reportClass) 
  {
    $result = array();
    $groupsForReports = new CRM_Groupsforreports_GroupReport();
    foreach ($groupsForReports->_reports[$reportClass] as $groupName) {
      $result[] = $groupsForReports->_groups[$groupName];
    }
    return $result;
  }
}