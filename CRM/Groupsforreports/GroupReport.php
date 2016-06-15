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
      'Country_Coordinators_Gabrielle_105',
      //'Programme_Managers_58',
      'Projectmanagers_82',
      'Project_Officers_54',
      'Sector_Coordinators_55'
    );
    $this->_reports ['CRM_Casereports_Form_Report_PumProjects'] = $groups;
    $this->_reports ['CRM_Threepeas_Form_Report_PumProjects'] = $groups;

    $groups[] = 'Business_Link_Coordinators_21';

    $this->_reports['CRM_Civireports_Form_Report_MyProjectIntake'] = $groups;
    $this->_reports['CRM_Casereports_Form_Report_ProjectIntake'] = $groups;

    $groups[] = 'Grant_Coordinators_96';

    $this->_reports['CRM_Casereports_Form_Report_MainActivities'] = $groups;

    foreach ($groups as $groupName) {
      try {
        $apiGroupId = civicrm_api3('Group', 'Getvalue', array('name' => $groupName, 'return' => 'id'));
        $groupId = (int) $apiGroupId;
        $this->_groups[$groupId] = $groupName;
      } catch (CiviCRM_API3_Exception $ex) {}
    }
  }

  /**
   * Method to get group members
   *
   * @param int $groupId
   * @return array
   */
  private function getGroupMembers($groupId) {
    $result = array();
    $groupContactParams = array('group_id' => $groupId, 'options' => array('limit' => 99999));
    try {
      $members = civicrm_api3('GroupContact', 'Get', $groupContactParams);
      foreach ($members['values'] as $member) {
        $result[$member['contact_id']] = $member['contact_id'];
      }
    } catch (CiviCRM_API3_Exception $ex) {
    }
    return $result;
  }


  /**
   * Method to get the group ids for the report
   * 
   * @param string $reportClass
   * @return array
   * @static
   */
  public static function getGroupMembersForReport($reportClass) 
  {
    $result = array();
    $groupsForReports = new CRM_Groupsforreports_GroupReport();
    foreach ($groupsForReports->_reports[$reportClass] as $groupId) {
      $result = $result + $groupsForReports->getGroupMembers($groupId);
    }
    return $result;
  }
}