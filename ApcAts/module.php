<?php

// Klassendefinition
class ApcAts extends IPSModule {
 
	// Der Konstruktor des Moduls
	// Überschreibt den Standard Kontruktor von IPS
	public function __construct($InstanceID) {
		// Diese Zeile nicht löschen
		parent::__construct($InstanceID);

		// Selbsterstellter Code
		// Define all the data
		$this->snmpVariables = Array(
			Array("ident" => "FirmwareVersion", 		"caption" => "Firmware Version", 		"type" => "String", 	"profile" => false, 						"oid" => '.1.3.6.1.4.1.318.1.1.8.1.2.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "ProductModel", 			"caption" => "Product Model", 			"type" => "String", 	"profile" => false, 						"oid" => '.1.3.6.1.4.1.318.1.1.8.1.5.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "SerialNumber", 			"caption" => "Serial Number", 			"type" => "String", 	"profile" => false, 						"oid" => '.1.3.6.1.4.1.318.1.1.8.1.6.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "CommunicationStatus", 	"caption" => "Serial Number", 			"type" => "Integer", 	"profile" => "APCATS.CommunicationStatus", 	"oid" => '.1.3.6.1.4.1.318.1.1.8.5.1.1.0', 		"factor" => false, 	"writeable" => false)
		);
	}
 
	// Überschreibt die interne IPS_Create($id) Funktion
	public function Create() {
		
		// Diese Zeile nicht löschen.
		parent::Create();

		// Properties
		$this->RegisterPropertyString("Sender","ApcAts");
		$this->RegisterPropertyInteger("RefreshInterval",0);
		$this->RegisterPropertyInteger("SnmpInstance",0);
		$this->RegisterPropertyInteger("OutletIndex",0);
		$this->RegisterPropertyBoolean("DebugOutput",false);

		// Variable profiles
		$variableProfileCommunicationStatus = "APCATS.CommunicationStatus";
		if (IPS_VariableProfileExists($variableProfileCommunicationStatus) ) {
		
			IPS_DeleteVariableProfile($variableProfileCommunicationStatus);
		}			
		IPS_CreateVariableProfile($variableProfileCommunicationStatus, 1);
		IPS_SetVariableProfileIcon($variableProfileCommunicationStatus, "Talk");
		IPS_SetVariableProfileAssociation($variableProfileCommunicationStatus, 1, "ATS Never Discovered", "", 0xFF0000);
		IPS_SetVariableProfileAssociation($variableProfileCommunicationStatus, 2, "ATS Communication Established", "", 0x00FF00);
		IPS_SetVariableProfileAssociation($variableProfileCommunicationStatus, 3, "ATS Communication Lost", "", 0xFF0000);
		
		// Variables
		$stringVariables = $this->GetVariablesByType("String");
		foreach ($stringVariables as $currentVariable) {

			if ($currentVariable['profile']) {

				$this->RegisterVariableString($currentVariable['ident'], $currentVariable['caption'], $currentVariable['profile']);
			}
			else {

				$this->RegisterVariableString($currentVariable['ident'], $currentVariable['caption']);
			}
		}

		$stringVariables = $this->GetVariablesByType("Float");
		foreach ($stringVariables as $currentVariable) {

			if ($currentVariable['profile']) {

				$this->RegisterVariableFloat($currentVariable['ident'], $currentVariable['caption'], $currentVariable['profile']);
			}
			else {

				$this->RegisterVariableFloat($currentVariable['ident'], $currentVariable['caption']);
			}
		}
		
		$stringVariables = $this->GetVariablesByType("Integer");
		foreach ($stringVariables as $currentVariable) {

			if ($currentVariable['profile']) {

				$this->RegisterVariableInteger($currentVariable['ident'], $currentVariable['caption'], $currentVariable['profile']);
			}
			else {

				$this->RegisterVariableInteger($currentVariable['ident'], $currentVariable['caption']);
			}
		}
		
		// Timer
		$this->RegisterTimer("RefreshInformation", 0, 'APCATS_RefreshInformation($_IPS[\'TARGET\']);');

	}

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {

		$newInterval = $this->ReadPropertyInteger("RefreshInterval") * 1000;
		$this->SetTimerInterval("RefreshInformation", $newInterval);

		// Editable values
		$writeableIdents = $this->GetWriteableVariableIdents();
		if (count($writeableIdents) > 0) {

			foreach ($writeableIdents as $currentIdent) {

				$this->EnableAction($currentIdent);
			}
		}

		// Diese Zeile nicht löschen
		parent::ApplyChanges();
	}

	public function RequestAction($Ident, $Value) {
	
		// Route values based on dynamic arrays
		$writeableIdents = $this->GetWriteableVariableIdents();
		if (count($writeableIdents) > 0) {

			if (in_array($Ident, $writeableIdents)) {

				$this->SetWriteableVariable($Ident, $Value);
				SetValue($this->GetIDForIdent($Ident), $Value);
			}
		}
	
		// Fallback for static defined idents
		switch ($Ident) {
		
			default:
				$this->LogMessage("Invalid Ident: $Ident","CRIT");
		}

		// Refresh after changing something
		$this->RefreshInformation();
	}

	public function GetConfigurationForm() {

        	
		// Initialize the form
		$form = Array(
            		"elements" => Array(),
					"actions" => Array()
        		);

		// Add the Elements
		$form['elements'][] = Array("type" => "NumberSpinner", "name" => "RefreshInterval", "caption" => "Refresh Interval");
		$form['elements'][] = Array("type" => "CheckBox", "name" => "DebugOutput", "caption" => "Enable Debug Output");
		$form['elements'][] = Array("type" => "SelectInstance", "name" => "SnmpInstance", "caption" => "SNMP instance");

		// Add the buttons for the test center
        $form['actions'][] = Array("type" => "Button", "label" => "Refresh Overall Status", "onClick" => 'APCATS_RefreshInformation($id);');

		// Return the completed form
		return json_encode($form);

	}


        /**
	* Get the list of robots linked to this profile and modifies the Select list to allow the user to select them.
        *
        */
    public function RefreshInformation() {

		$oid_mapping_table 		= $this->GetOidMappingTable();
		$factor_mapping_table 	= $this->GetFactorMappingTable();

		$this->UpdateVariables($oid_mapping_table, $factor_mapping_table);
	}

	// Version 1.0
	protected function LogMessage($message, $severity = 'INFO') {
		
		$logMappings = Array();
		// $logMappings['DEBUG'] 	= 10206; Deactivated the normal debug, because it is not active
		$logMappings['DEBUG'] 	= 10201;
		$logMappings['INFO']	= 10201;
		$logMappings['NOTIFY']	= 10203;
		$logMappings['WARN'] 	= 10204;
		$logMappings['CRIT']	= 10205;
		
		if ( ($severity == 'DEBUG') && ($this->ReadPropertyBoolean('DebugOutput') == false )) {
			
			return;
		}
		
		$messageComplete = $severity . " - " . $message;
		parent::LogMessage($messageComplete, $logMappings[$severity]);
	}
		
	
	protected function UpdateVariables($oids, $factors) {
	
		$result = $this->SnmpGet($oids);
		
		foreach ($oids as $varIdent => $varOid) {
		
			if (array_key_exists($varIdent, $factors)) {

				$this->LogMessage("Using Conversion Factor " . $factors[$varIdent] . " for Ident $varIdent", "DEBUG");

				SetValue($this->GetIDForIdent($varIdent), $result[$varOid] * $factors[$varIdent]);
			}
			else {
			
				SetValue($this->GetIDForIdent($varIdent), $result[$varOid]);
			}
		}
	}

	protected function SnmpGet($oids) {
	
		$result = IPSSNMP_ReadSNMP($this->ReadPropertyInteger("SnmpInstance"), $oids);	
		
		if (count($result) == 0) {

			$this-LogMessage("Unable to retrieve information via SNMP","CRIT");
			$this->SetStatus(200);
			return false;
		}
		else {

			$this->SetStatus(102);
		}

		$this->LogMessage("Number of SNMP entries found: " . count($result), "DEBUG");

		return $result;
	}

	protected function GetVariablesByType($type) {

		$variables = Array();

		foreach ($this->snmpVariables as $currentVariable) {

			if($currentVariable['type'] == $type) {

				$variables[] = $currentVariable;
			}
		}

		return $variables;
	}

	protected function GetOidMappingTable() {

		$mappingTable = Array();

		foreach ($this->snmpVariables as $currentVariable) {
		
			$mappingTable[$currentVariable['ident']] = $currentVariable['oid'] . "." . $this->ReadPropertyInteger("OutletIndex");
		}

		return $mappingTable;
	}

	protected function GetFactorMappingTable() {

		$mappingTable = Array();

		foreach ($this->snmpVariables as $currentVariable) {
		
			if ($currentVariable['factor']) {
			
				$mappingTable[$currentVariable['ident']] = $currentVariable['factor'];
			}
		}

		return $mappingTable;
	}

	protected function GetWriteableVariableIdents() {

		$idents = Array();

		foreach ($this->snmpVariables as $currentVariable) {
		
			if ($currentVariable['writeable']) {
			
				$idents[] = $currentVariable['ident'];
			}
		}

		return $idents;
	}

	protected function SetWriteableVariable($ident, $value) {

		foreach ($this->snmpVariables as $currentVariable) {
		
			if ($currentVariable['ident'] == $ident) {
			
				$oid = $currentVariable['oid'] . "." . $this->ReadPropertyInteger("OutletIndex");
				if ($currentVariable['type'] == 'String') {
					
					$type = 's';
				}
				else {

					$type = 'i';
				}
				if ($currentVariable['factor']) {

					$value = $value * (1 / $currentVariable['factor']);
				}
			}
		}

		IPSSNMP_WriteSNMPbyOID($this->ReadPropertyInteger("SnmpInstance"), $oid, $value, $type);		
	}
}