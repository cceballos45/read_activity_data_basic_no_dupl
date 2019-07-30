<?php

//------------------------------------------------------------------------------------------

class xml2Array {
    // helper class to conver XML to array
   
    var $arrOutput = array();
    var $resParser;
    var $strXmlData;
   
    function parse($strInputXML) {
   
            $this->resParser = xml_parser_create ();
            xml_set_object($this->resParser,$this);
            xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");
           
            xml_set_character_data_handler($this->resParser, "tagData");
       
            $this->strXmlData = xml_parse($this->resParser,$strInputXML );
            if(!$this->strXmlData) {
               die(sprintf("XML error: %s at line %d",
                           xml_error_string(xml_get_error_code($this->resParser)),
                           xml_get_current_line_number($this->resParser)));
            }
                           
            xml_parser_free($this->resParser);
           
            return $this->arrOutput;
    }
	
	
    function tagOpen($parser, $name, $attrs) {
		
       $tag=array("name"=>$name,"attrs"=>$attrs);
       array_push($this->arrOutput,$tag);
    }
   
    
	function tagData($parser, $tagData) {
		
       if(trim($tagData)) {
            if(isset($this->arrOutput[count($this->arrOutput)-1]['tagData'])) {
                $this->arrOutput[count($this->arrOutput)-1]['tagData'] .= $tagData;
            }
            else {
                $this->arrOutput[count($this->arrOutput)-1]['tagData'] = $tagData;
            }
       }
    }
	
   
    function tagClosed($parser, $name) {
		
       $this->arrOutput[count($this->arrOutput)-2]['children'][] = $this->arrOutput[count($this->arrOutput)-1];
       array_pop($this->arrOutput);
    }
} // class xml2Array

//==========================================================================================

class ITS_DatabaseForScripts { // This class implements general methods to interact with the ALICE production management database
	
	public $_base_url="";
	public $_ssocookie="";
	public $_compType = array();
	public $_actType = array();
	public $_actStatusID = array();
	public $_actResult = array();	
	public $_compParams = array();
	public $_actParams = array();
	public $_api_params = array();
	public $_config_array = array();
	public $_projectID;
	public $_timezone;
	public $_logsPath;
	public $_errorLog;
		
//----------------------------------------------------------------------
	
	public function __construct($configFile){
	
		// Read the initial configuration file
		$this->_config_array = $this->readConfigFile($configFile);
		$this->_setLogsPath($this->_config_array['logsPath']);
		$this->_setTimezone($this->_config_array['timezone']);
		$this->_setURL($this->_config_array['base_url']);
		$this->_ssocookie = $this->_config_array['ssocookie'];
	      
		// Include the file with the project-specific definitions
		require($this->_config_array['pojectDefFile']);
		
		$this->_eosMAM_URL = $this->_config_array['eosurl'].'/'.$this->_config_array['MAM'];

		$this->_setProjectID($projectID);
		$this->_setCompTypes($compType);
		$this->_setActTypes($actType);
		$this->_setActStatusIDs($actStatusID);
		$this->_setActResults($actResult);
		
	}
//----------------------------------------------------------------------
	
	public function _apiAction($api_func, $currParams){ // Function for executing any of the API functions via SSO and returning the resulting array.
		
		$file_headers = @get_headers($this->_base_url);
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found'){ // Check the network conection
		  $this->errLog("URL:" . $this->_base_url . " is NOT reachable. Please check your network connection. 
		                You may also try to restart the Apache server by typing 'sudo systemctl restart httpd.service' in a Terminal window.",FALSE);
		  return FALSE;    
		}
                
		$url = $this->_base_url.'/'. $api_func .'?'. http_build_query($currParams, "", "&"); // Build the query
		$url = str_replace('&', '\&', $url); // This is for escaping the "&" in the curl command for passing more than one parameter.

		$curlcommand = 'curl -L --cookie '.$this->_ssocookie.' --cookie-jar '.$this->_ssocookie.' '.$url; // Build the cURL shell command
		$k = 0;
		while(1){
		  $content = trim(shell_exec($curlcommand)); // Execute the command in a shell
		  if(!strpos($content,"?xml")){
		    $k++;
		    if( $k > 5 ){
		      $this->errLog("The API function is not reachable. Please check the SSO cookie authentication.",FALSE);
		      return;
		    }
		    print("Sleeping...".$k."\n");
		    sleep(15);
		  }else break;
		  
		 }

		$objXML = new xml2Array();
		$arrOutput = $objXML->parse($content); // Convert the XML into an array

		return $arrOutput;
	
	}
	


//----------------------------------------------------------------------	
	
	public function _get_val( $array, $attr1, $attr2){ // Function for getting the value of a specific parameter.
		
		if( is_array($array) ){
			$my_array[] = $array;
			foreach( $my_array as $element){
				if ( is_array($element) && key_exists('name',$element) && $element['name'] == $attr1 && is_array($element['children'])){
				foreach( $element['children'] as $attr_to_get )
					if( $attr_to_get['name'] == $attr2 && key_exists('tagData',$attr_to_get)){
						$result = $attr_to_get['tagData'];
						return $result;	
					
					}
		        }
			}
		}

		return FALSE;		
	}
	
//----------------------------------------------------------------------		
	public function _read_act_type_composition($activityTypeID){ // Function to read and return the input/output component types of an activity and their quantity
	    
	    $result = $this->_apiAction("ActivityTypeReadAll", array("activityTypeID" => $activityTypeID)); // Execute the 'ActivityTypeReadAll' API function for getting the complete array of varible values for this activity type
		if ( !is_array($result[0]['children']) ) return FALSE;
			foreach ( $result[0]['children'] as $item ) // Get the array that holds the children components
				if ( $item['name'] == "ACTIVITYTYPECOMPONENTTYPE"  && key_exists('children',$item) && is_array($item['children'])){
				    foreach ( $item['children'] as $actCompTypeComposition ){ // Iterate for the Component Type Composition of this type of activity
					    if( is_array($actCompTypeComposition['children'] ))
						foreach($actCompTypeComposition['children'] as $compAttr)
							//	print_r($compAttr);
							if( $compAttr['name'] == "COMPONENTTYPE" && is_array($compAttr['children'])){
									// Get the composant type
								if(!($compTypeID = $this->_get_val($compAttr,"COMPONENTTYPE","ID"))){
								  $this->errLog("the COMPONENTTYPE ID is missiing in Activity Type ID: " . $activityTypeID); 
								  return;
								}
								$compTypeName = $this->_get_val($compAttr,"COMPONENTTYPE","NAME");
							    }
						// Get the ActivityTypeComponentTypeFull ID
						if(!($actCompTypeID = $this->_get_val($actCompTypeComposition,"ACTIVITYTYPECOMPONENTTYPEFULL","ID"))){ 
						  $this->errLog("the ACTIVITYTYPECOMPONENTTYPEFULL ID is missiing in Activity Type ID: " . $activityTypeID);
						  return;
						}
					    // Get the amount and direction of composant of this type
						if(!($quantity  = $this->_get_val($actCompTypeComposition,"ACTIVITYTYPECOMPONENTTYPEFULL","QUANTITY"))){
						  $this->errLog("the QUANTITY is missiing for  component type " . $compTypeID . " in Activity Type ID: " . $activityTypeID); 
						  return;
						}
					    if(!($direction = $this->_get_val($actCompTypeComposition,"ACTIVITYTYPECOMPONENTTYPEFULL","DIRECTION"))){
					      $this->errLog("the DIRECTION is missiing for  component type " . $compTypeID . " in Activity Type ID: " . $activityTypeID); 
					      return;
					    }
					    
					    $_actTypeCompTypes[$direction][$compTypeID] = array(
																"actCompTypeID" => $actCompTypeID,
																"qtty" => $quantity,
																"compTypeName" => $compTypeName
															);
					}
				}
		    return $_actTypeCompTypes;
	}
//----------------------------------------------------------------------
	public function read_act_data($actID = NULL){
            
            $activityData = array();
            $dataList = array('ID','NAME','STARTDATE','ACTTYPEID','ACTTYPENAME','ACTRESID','ACTRESNAME','LOCATION','LOCATIONID','STATUSID','STATUSCODE','COMPONENTS');
            foreach($dataList as $key => $data){ // Set all data values to 'N/A'
	      $activityData[$data] = 'N/A';
            }
	    
	    $result = $this->_apiAction("ActivityReadOne", array('ID' => $actID));
	    if ( !is_array($result[0]['children']) ) return FALSE;
	    $i = 0;	    
	    foreach ( $result as $item ){
		if ( $item['name'] == "ACTIVITY"  && key_exists('children',$item) && is_array($item['children'])){
		    $activityData['ID'] = $this->_get_val($item,"ACTIVITY","ID"); // Get the activity name
		    $activityData['NAME'] = $this->_get_val($item,"ACTIVITY","NAME"); // Get the activity name
		    $activityData['STARTDATE']  = $this->_get_val($item,"ACTIVITY","STARTDATE"); // Get the activity start date
		    $activityData['ENDDATE']  = $this->_get_val($item,"ACTIVITY","ENDDATE"); // Get the activity start date
		    $activityData['LOTID']  = $this->_get_val($item,"ACTIVITY","LOTID");
		    $activityData['POSITION']  = $this->_get_val($item,"ACTIVITY","POSITION");
		    foreach($item['children'] as $actFields){
		      if ( $actFields['name'] == "ACTIVITYRESULT"  && key_exists('children',$actFields) && is_array($actFields['children'])){
			$activityData['ACTRESID'] = $this->_get_val($actFields,"ACTIVITYRESULT","ID");
			$activityData['ACTRESNAME'] = $this->_get_val($actFields,"ACTIVITYRESULT","NAME");
		      }
		      if ( $actFields['name'] == "ACTIVITYTYPE"  && key_exists('children',$actFields) && is_array($actFields['children'])){
			$activityData['ACTTYPEID'] = $this->_get_val($actFields,"ACTIVITYTYPE","ID");
			$activityData['ACTTYPENAME'] = $this->_get_val($actFields,"ACTIVITYTYPE","NAME");
		      }
		      if ( $actFields['name'] == "ACTIVITYLOCATION"  && key_exists('children',$actFields) && is_array($actFields['children'])){
			$activityData['LOCATION'] = $this->_get_val($actFields,"ACTIVITYLOCATION","NAME");
			$activityData['LOCATIONID'] = $this->_get_val($actFields,"ACTIVITYLOCATION","ID");
		      }
		      if ( $actFields['name'] == "ACTIVITYSTATUS"  && key_exists('children',$actFields) && is_array($actFields['children'])){
			$activityData['STATUSID'] = $this->_get_val($actFields,"ACTIVITYSTATUS","ID");
			$activityData['STATUSCODE'] = $this->_get_val($actFields,"ACTIVITYSTATUS","CODE");
		      }
		      if ( $actFields['name'] == "COMPONENTS"  && key_exists('children',$actFields) && is_array($actFields['children'])){
			//unset($activityData['COMPONENTS']);
			$activityData['COMPONENTS'] = array();
			foreach($actFields['children'] as $actComponents){
			  if( $actComponents['name'] == "ACTIVITYCOMPONENT" && key_exists('children',$actComponents) && is_array($actComponents['children'])){
			    foreach($actComponents['children'] as $actComponentsInner1){
			      if( $actComponentsInner1['name'] == "ACTIVITYTYPECOMPONENTTYPE" && key_exists('children',$actComponentsInner1) && is_array($actComponentsInner1['children'])){
				$dir =  $this->_get_val($actComponentsInner1,"ACTIVITYTYPECOMPONENTTYPE","DIRECTION");
			      }
			      if( $actComponentsInner1['name'] == "COMPONENT" && key_exists('children',$actComponentsInner1) && is_array($actComponentsInner1['children'])){
				$compID =  $this->_get_val($actComponentsInner1,"COMPONENT","ID");
				$compName =  $this->_get_val($actComponentsInner1,"COMPONENT","COMPONENTID");
			      
				foreach($actComponentsInner1['children'] as $actComponentsInner2){
				  if( $actComponentsInner2['name'] == "COMPONENTTYPE" && key_exists('children',$actComponentsInner2) && is_array($actComponentsInner2['children'])){
				    $compTypeID = $this->_get_val($actComponentsInner2,"COMPONENTTYPE","ID");
				    $activityData['COMPONENTS'][$dir][$compTypeID][]["ID"] = array('ID'=>$compID, 'NAME'=>$compName) ;
				  }
				}
			      }
			    }
			  }
			}
		      }
		    }
		}
	    }

	    return $activityData;
	}
//----------------------------------------------------------------------


public function _export_data( $data = array(), $baseName = 'data', $includeDate = TRUE, $createACopy = TRUE, $ext = '.xls', $separator = "\t"){
    
    if(!isset($data)) return FALSE;
    
    date_default_timezone_set('Europe/Paris');
    
    $outputFileName = ($includeDate == TRUE) ? $baseName.'_'.date('Ymd').$ext :  $baseName.$ext;
    
    if( $createACopy && file_exists($outputFileName) ){
      $shellcommand = 'mv '.$outputFileName.' '.$outputFileName.'_cpy';
      shell_exec($shellcommand);
    }
    
    $fh = fopen($outputFileName, 'w');
    $flag = false;
    foreach($data as $row) {
        if(!$flag) {
        // display field/column names as first row
        fwrite($fh, implode($separator, array_keys($row)) . "\r\n");
        $flag = true;
        }
        fwrite($fh,implode($separator, array_values($row)) . "\r\n");
    }
  fclose($fh);
  return TRUE;
}
//----------------------------------------------------------------------

	protected function _setURL($base_url){
		
		if( empty($base_url) ){
		  $this->errLog("The API functions URL is not defined",FALSE);
		  return FALSE;
		}
		$this->_base_url = $base_url;
				
		return TRUE;
		
	}
//----------------------------------------------------------------------

	protected function readConfigFile($filename,$process_sections = FALSE){
		if( !file_exists($filename) ){
		  $this->errLog("File " . $filename . " not found!",FALSE);
		  return;
		}
		$config_array = parse_ini_file($filename, $process_sections); // Read the configuration file
		
		return $config_array;
	}
//----------------------------------------------------------------------	
	
	public function writeLog($message, $logFile, $writeTime = TRUE){
	
		$maxLines = 3000;
		date_default_timezone_set($this->_timezone);
		$today = date('Y.m.d G:i:s');
		$logMessage = ($writeTime) ? $today . "(" . $this->_timezone . ") - ". $message . "\n" : $message . "\n";

		if($this->_getLines($logFile) > $maxLines){
		  exec('rm '.$logFile); // remove log file if it has more than $maxLines lines
		}
		
		$fh = fopen($logFile, 'a');
		fwrite($fh, $logMessage);
		fclose($fh);
		
		return $message;
				
	}
//----------------------------------------------------------------------

	public function errLog($message,$placeHolder = TRUE){

		$logFile =  $this->_logsPath .'/error.log';
		print( $this->writeLog($message, $logFile)."\n");
		exit(0);
		//return;
	}
//----------------------------------------------------------------------	

	protected function _getLines($file){
	
	  $lines = 0;
	  if ($f = fopen($file, 'rb')){

	      while (!feof($f)) {
		  $lines += substr_count(fread($f, 8192), "\n");
	      }

	      fclose($f);
	    }

	    return $lines;
	}
//----------------------------------------------------------------------	

	private function _setProjectID($projectID = NULL){
		if(!$projectID){
		  $this->errLog("The project's ID number has not been defined",FALSE);
		  return FALSE;
		}
		$this->_projectID = $projectID;
			
		return TRUE;
	}
//----------------------------------------------------------------------	

	private function _setCompTypes($compType){
		
		$this->_compType = array(); // Reset the array
		if( !($compType) ){
		  $this->errLog("The project's specific Component Types IDs are not defined",FALSE);
		  return FALSE;
		}
		$this->_compType = $compType;
		
		return TRUE;
	}
//----------------------------------------------------------------------	

	private function _setActTypes($actType){
	
		$this->_actType = array(); // Reset the array
		if( !($actType) ){
		  $this->errLog("The project's specific Activity Types IDs are not defined",FALSE);
		  return FALSE;
		}
		$this->_actType = $actType;
	
		return TRUE;
	}
//----------------------------------------------------------------------	

	private function _setActStatusIDs($actStatusID){

		$this->_actStatusID = array(); // Reset the array
		if( !($actStatusID) ){
		  $this->errLog("The project's specific Activity Status IDs are not defined",FALSE);
		  return FALSE;
		}
		$this->_actStatusID = $actStatusID;

		return TRUE;
	}
//----------------------------------------------------------------------	

	private function _setActResults($actResult){

		$this->_actResult = array(); // Reset the array
		if( !($actResult) ){
		  $this->errLog("The project's specific Activity Results are not defined",FALSE);
		  return FALSE;
		}
		$this->_actResult = $actResult;

		return TRUE;
	}
//----------------------------------------------------------------------	

	protected function _setLogsPath($logsPath = NULL){
	
		if($logsPath == NULL){
		   print("Error: The logs path is not declared\n");
		   return FALSE;
		}
		$this->_logsPath = $logsPath;
		//Set also the error.log file path
		$this->_errorLog = $this->_logsPath.'/error.log';
		
		return TRUE;
	}
//----------------------------------------------------------------------	

	protected function _setTimezone($timezone){

		$this->_timezone = $timezone;
			
		if ( !in_array($timezone, DateTimeZone::listIdentifiers()) ) {
			$this->_timezone = 'UTC';
			print("\n". $this->writeLog("Warning: Default timezone value '".$timezone."' is not valid. 'UTC' used.",$this->_errorLog) . "\n\n");
		}
		
		return TRUE;
	}
//----------------------------------------------------------------------	
	public function getLogsPath(){
		if(strlen(trim($this->_logsPath)) !=0 ) return $this->_logsPath;
		
		return FALSE;
	}
//----------------------------------------------------------------------	
	public function getActType(){
		if($this->_actType) return $this->_actType;
	
		return FALSE;
	}
//----------------------------------------------------------------------	
	public function getCompType(){
		if($this->_compType) return $this->_compType;
	
		return FALSE;
	}
//----------------------------------------------------------------------	
	public function getBaseURL(){
		if($this->_base_url) return $this->_base_url;
	
		return FALSE;
	}


} // class ITS_DatabaseForScripts