<?php

define('INITIAL_CONFIG_FILE','common/config_script_prod.ini'); //!!! SET THE PROPER DB
include('common/ITS_DatabaseForScripts_l.php');


function _get_activity_basic_data($typeID,&$db,$filterpattern = 'hicname',$name='ALL'){
		// This function returns an array with the IDs of all components or activities of type '$typeID' that contain '$name' in their Component ID 
	
		if(!isset($typeID)){
		  $db->writeLog("No Activity Type was provided");
		  return FALSE;
		}
		if(!isset($db)){
		  $db->writeLog("No db object was provided");
		  return FALSE;
		}
	
		$basicData = array();
		$i=0;
	
		$result = $db->_apiAction("ActivityRead", array("projectID" => $db->_projectID,"activityTypeID" => $typeID));
		if ( is_array($result) ){
			foreach ( $result as $item ){
				if ( $item['name'] == "ARRAYOFACTIVITY"  && key_exists('children',$item) && is_array($item['children']))
					foreach ( $item['children'] as $attrList ){
					        //print_r($attrList);
						$oneID = $db->_get_val($attrList,"ACTIVITY","ID");
						$actName = $db->_get_val($attrList,"ACTIVITY","NAME");
						if( $name !='ALL' && (!$oneID || !(strstr($actName,$name))) ) continue;
						$basicData[$i]["ID"] = $oneID;
						$basicData[$i]["NAME"] = $actName;
						foreach($attrList['children'] as $anAtrr){
						  if ( $anAtrr['name'] == "ACTIVITYSTATUS"  && key_exists('children',$anAtrr) && is_array($anAtrr['children'])){
						    //print("I am Here!!!\n");
						    $basicData[$i]["STATUSID"] = $db->_get_val($anAtrr,"ACTIVITYSTATUS","ID");
						    $basicData[$i]["STATUSCODE"] = $db->_get_val($anAtrr,"ACTIVITYSTATUS","CODE");
						  }
						}
						$i++;
					}
			}
			remove_duplicated_test($basicData,$filterpattern);
			return $basicData;
		}
		return 	FALSE;
	}
//------------------------------------------------------------------------

function _export_data( $data = array(), $baseName = 'data' ){
    
    if(!isset($data)) return FALSE;
    
    date_default_timezone_set('Europe/Paris');
    
    $fh = fopen($baseName.'_'.date('Ymd').'.xls', 'w');
    $flag = false;
    foreach($data as $row) {
        if(!$flag) {
        // display field/column names as first row
        fwrite($fh, implode("\t", array_keys($row)) . "\r\n");
        $flag = true;
        }
        fwrite($fh,implode("\t", array_values($row)) . "\r\n");
    }
  fclose($fh);
  return TRUE;
}
//------------------------------------------------------------------------

function remove_duplicated_test(&$actList,$filterpattern = NULL){
  if( empty($actList) || $filterpattern == NULL) return FALSE;
  
  // IMPORTANT: This function works as expected because $actList is already sorted by Decreasing ACTIVITYID
  $existingTestHICName = array();
  $keyToRemoveList = array();
  $hicName = NULL;
  $unsetList = array();
  //print('In remove_duplicated_test: '. $filterpattern."\n");
  foreach($actList as $key => $actPars){
 
    $toBeUnset = FALSE;
    if( $filterpattern == 'hicname' ){
     preg_match("/(AL|BL|AR|BR)+\d{6}/", $actPars['NAME'], $matches); //// Check if this a valid HIC Name like [AL|BL|AR|BR]NNNNNN.
    }else{
	$toBeUnset = TRUE; // The HIC name pattern was not found for on the activity name
    }
    if( $filterpattern == 'fullactname' ){
	$matches[0] = $actPars['NAME'];
    }
    if(array_key_exists(0, $matches)) { // It will then be the newest one according to IMPORTANT
      $hicName = $matches[0];
    //  $validHICNameFound = TRUE;
    }
    if( $hicName != NULL && array_search($hicName,$existingTestHICName) === FALSE  ){
	$existingTestHICName[] = $hicName; // Add the retested HIC Name to the list.
	continue;
    }else{
	$toBeUnset = TRUE; // An activity with the same name alredy exists in $existingTestHICName
    }
   
    if( $toBeUnset ){ // This block will be accessed only by the repeated test but not by the newest one, which will be in $existingTestHICName 
      $unsetList[$key] = $actPars['NAME']; //!!!
      unset($actList[$key]);
      continue;
    }
  }
  //print_r($unsetList); //!!!
  return TRUE;
}



//---------- Main ----------
// Instantiate a new database object
$db = new ITS_DatabaseForScripts(INITIAL_CONFIG_FILE);
$ssocookie = 'ssocookie.txt';
echo exec('cern-get-sso-cookie --krb -r -u '.$db->getBaseURL().'?WSDL -o '. $db->_ssocookie);  // Get a new cookie for SSO authentication using KERBEROS Credentials

$actTypesDef = $db->getActType();
$actTypeComposition = array();
//$filteredActivities = array();
$results = array();

// Filter the array for each type of activites by, for instance, the Activity Status. For NOT applying a filter set both values to 'NONE'
$filterData = 'STATUSCODE'; //'NONE';
$filterBy = 'OPEN'; //'NONE';

$filterpattern = 'hicname';

$allActivities = array();
$result = array();
$activityTotalNumber = array();
$activityTotalNumber_by_site = array();
$extendedAnalysis = False; // Set True if you want an extended (time-comsuming) data report and summary by "Activity Type" and "Location"


// Set the activity types to be read. The definition is found in variable $actTypes from "common/typedef_383.inc"

$actTypes = array(
	          $actTypesDef['MLSTVRECTEST'],
	          $actTypesDef['OLSTVRECTEST'],
            //      $actTypesDef['MLHSQUALTEST'],
            //      $actTypesDef['OLHSQUALTEST'],
            //      $actTypesDef['OBHICQUALTEST'],
            //      $actTypesDef['OBHICENDUTEST'],
            //      $actTypesDef['OBHICREC'],
            //      $actTypesDef['OBHICIMPTEST'],
            //      $actTypesDef['OBHICTABCUT'],
            //      $actTypesDef['OBHICONMLCPPWRTEST'],
            //      $actTypesDef['OBHICONOLCPPWRTEST'],
            //      $actTypesDef['OBHICRECTEST'],
            //      $actTypesDef['OBHICASS'],
	    //      $actTypesDef['IBHICQUALTEST'],
            //      $actTypesDef['IBSTAVEQUALTEST'],
	    //      $actTypesDef['MLHSLOASS'],
	    //      $actTypesDef['MLHSUPASS'],
	    //      $actTypesDef['MLSTVASS'],
	    //      $actTypesDef['OLHSLOASS'],
	    //      $actTypesDef['OLHSUPASS'],
	    //      $actTypesDef['OLSTVASS'],
            ); 
            

foreach($actTypes as $actType){ // Loop over the acivity types 
  // Create an array with the input/output composition for each activity type
  $actTypeComposition[$actType["id"]] = array("ACTTYPENAME" => $actType["name"], 
					      "COMPONENTS"  =>  $db->_read_act_type_composition($actType["id"])
					     );
					     
  // Get all the activities IDs by Activity Type
  print('ACTTYPE:'.$actType["id"]."\n-------------\n");//!!!
  
  
  switch ($actType["id"]){
    case $actTypesDef['OBHICREC']["id"]:
    case $actTypesDef['OBHICRECTEST']["id"]:
	$filterpattern = 'hicname';
	break;
    default:
	$filterpattern = 'fullactname';
  }
  $allActivities[$actType["id"]] = _get_activity_basic_data($actType["id"],$db,$filterpattern); 


  if($filterData !='NONE' && $filterBy !='NONE'){ // If a filter has been set
    $filteredActivitiestmp[$actType["id"]] = array_filter($allActivities[$actType["id"]], function ($var) use ($filterBy,$filterData) {
    return ($var[$filterData] == $filterBy);
    });
  }else{ // If a filter has NOT been set
    $filteredActivitiestmp[$actType["id"]] = $allActivities[$actType["id"]];
  }
  
  $db->_export_data($filteredActivitiestmp[$actType["id"]],'Data/ActData_'.preg_replace('/(\s+|\/)/', '_', $actType["name"]),FALSE); 
 
 
  // Get a summary over all activites by Acitivity Type
  $activityTotalNumber[] = array( 'ACTTYPE' => $actType["name"],
				  'TOTAL' => count($filteredActivitiestmp[$actType["id"]]),
			        );
  
  // Get a summary over all activites by Acitivity Type AND Activity Location
  $k = 0;
  if ($extendedAnalysis){
    foreach($filteredActivitiestmp[$actType["id"]] as $key => $actBasicData){ // Loop over all types of activities that passed the filter
	$oneActData = $db->read_act_data($actBasicData['ID']); // Read all the data of this activity
	// Conform the array with the summary information
	if( !key_exists((string)$actType["id"].'-'.$oneActData['LOCATIONID'],$activityTotalNumber_by_site) ){
	    $activityTotalNumber_by_site[(string)$actType["id"].'-'.$oneActData['LOCATIONID']] = array();
	}
	if( !key_exists('TOTAL',$activityTotalNumber_by_site[(string)$actType["id"].'-'.$oneActData['LOCATIONID']]) ){
	    $activityTotalNumber_by_site[(string)$actType["id"].'-'.$oneActData['LOCATIONID']]['LOCATION'] = $oneActData['LOCATION'];
	    $activityTotalNumber_by_site[(string)$actType["id"].'-'.$oneActData['LOCATIONID']]['ACTIVITYTYPE'] = $oneActData['ACTTYPENAME'];
	    $activityTotalNumber_by_site[(string)$actType["id"].'-'.$oneActData['LOCATIONID']]['TOTAL'] = 1;
	    $filteredActivitiestmp[$actType["id"]][$key]['LOCATION'] = $oneActData['LOCATION']; // Add the location to the detailed activity list
	}else{
	    $activityTotalNumber_by_site[(string)$actType["id"].'-'.$oneActData['LOCATIONID']]['TOTAL'] += 1;
	    $filteredActivitiestmp[$actType["id"]][$key]['LOCATION'] = $oneActData['LOCATION']; // Add the location to the detailed activity list
	}
	
    /*/ ------ Control Test ------ //
	$k++;
	if( $k > 15 ){
	    $k = 0;
	    break;
	}
    // --------------------------- /*/
	
    } //($filteredActivitiestmp[$actType["id"]
    $db->_export_data($activityTotalNumber_by_site,'Data/Summary_wo_duplicate_by_Site_ActType_'.$actType["id"]);
    $db->_export_data($filteredActivitiestmp[$actType["id"]],'Data/ActData_'.preg_replace('/(\s+|\/)/', '_', $actType["name"]).'_w_Location',FALSE);
  }// if ($extendedAnalysis)
}

print_r($activityTotalNumber);
$db->_export_data($activityTotalNumber,'Data/Summary_wo_duplicate'); 
if ($extendedAnalysis)
    $db->_export_data($activityTotalNumber_by_site,'Data/Summary_wo_duplicate_by_Site');


?>
