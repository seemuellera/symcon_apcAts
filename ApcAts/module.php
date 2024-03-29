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
			Array("ident" => "Hostname", 				"caption" => "Hostname", 				"type" => "String", 	"profile" => false, 						"oid" => '1.3.6.1.4.1.318.1.1.8.4.1.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "FirmwareVersion", 		"caption" => "Firmware Version", 		"type" => "String", 	"profile" => false, 						"oid" => '1.3.6.1.4.1.318.1.1.8.1.2.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "ProductModel", 			"caption" => "Product Model", 			"type" => "String", 	"profile" => false, 						"oid" => '1.3.6.1.4.1.318.1.1.8.1.5.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "SerialNumber", 			"caption" => "Serial Number", 			"type" => "String", 	"profile" => false, 						"oid" => '1.3.6.1.4.1.318.1.1.8.1.6.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "CommunicationStatus", 	"caption" => "Communication Status",	"type" => "Integer", 	"profile" => "APCATS.CommunicationStatus", 	"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.1.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "SelectedSource", 			"caption" => "Selected Source", 		"type" => "Integer", 	"profile" => "APCATS.SelectedSource", 		"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.2.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "PreferredSource", 		"caption" => "Preferred Source", 		"type" => "Integer", 	"profile" => "APCATS.SelectedSource", 		"oid" => '1.3.6.1.4.1.318.1.1.8.4.2.0', 		"factor" => false, 	"writeable" => true ),
			Array("ident" => "RedundancyState", 		"caption" => "Redundancy State", 		"type" => "Integer", 	"profile" => "APCATS.RedundancyState", 		"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.3.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "OverCurrentState", 		"caption" => "Over Current State", 		"type" => "Integer", 	"profile" => "APCATS.PowerState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.4.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "5VSupplyState", 			"caption" => "5V Power Supply State", 	"type" => "Integer", 	"profile" => "APCATS.PowerState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.5.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "24VSupplyState", 			"caption" => "24V Power Supply State",	"type" => "Integer", 	"profile" => "APCATS.PowerState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.6.0', 		"factor" => false, 	"writeable" => false),
			Array("ident" => "SwitchStatus", 			"caption" => "Switch Status", 			"type" => "Integer", 	"profile" => "APCATS.PowerState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.10.0', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "FrontPanel", 				"caption" => "Front Panel Status", 		"type" => "Integer", 	"profile" => "APCATS.LockState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.11.0', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "FrontPanelLock", 			"caption" => "Front Panel Lock", 		"type" => "Integer", 	"profile" => "APCATS.LockState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.4.3.0', 		"factor" => false, 	"writeable" => true),
			Array("ident" => "SourceAStatus", 			"caption" => "Source A Status", 		"type" => "Integer", 	"profile" => "APCATS.PowerState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.12.0', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "SourceBStatus", 			"caption" => "Source B Status", 		"type" => "Integer", 	"profile" => "APCATS.PowerState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.13.0', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "PhaseSyncStatus", 		"caption" => "Phase Sync Status", 		"type" => "Integer", 	"profile" => "APCATS.SyncState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.14.0', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "HardwareStatus", 			"caption" => "Hardware Status", 		"type" => "Integer", 	"profile" => "APCATS.PowerState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.1.16.0', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "SourceAName", 			"caption" => "Source A Name", 			"type" => "String", 	"profile" => false, 						"oid" => '1.3.6.1.4.1.318.1.1.8.5.3.2.1.6.1', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "SourceBName", 			"caption" => "Source B Name", 			"type" => "String", 	"profile" => false, 						"oid" => '1.3.6.1.4.1.318.1.1.8.5.3.2.1.6.2', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "SourceAFrequency", 		"caption" => "Source A Frequency", 		"type" => "Float", 		"profile" => "~Hertz.50", 					"oid" => '1.3.6.1.4.1.318.1.1.8.5.3.2.1.4.1', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "SourceBFrequency", 		"caption" => "Source B Frequency", 		"type" => "Float", 		"profile" => "~Hertz.50", 					"oid" => '1.3.6.1.4.1.318.1.1.8.5.3.2.1.4.2', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "OutputFrequency", 		"caption" => "Output Frequency", 		"type" => "Float", 		"profile" => "~Hertz.50", 					"oid" => '1.3.6.1.4.1.318.1.1.8.5.4.2.1.4.1', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "OutputVoltage", 			"caption" => "Output Voltage", 			"type" => "Float", 		"profile" => "~Volt.230", 					"oid" => '1.3.6.1.4.1.318.1.1.8.5.4.3.1.3.1.1.1', 	"factor" => false, 	"writeable" => false),
			Array("ident" => "OutputCurrent", 			"caption" => "Output Current", 			"type" => "Float", 		"profile" => "~Ampere.16", 					"oid" => '1.3.6.1.4.1.318.1.1.8.5.4.3.1.4.1.1.1', 	"factor" => 0.1, 	"writeable" => false),
			Array("ident" => "OutputPower", 			"caption" => "Output Power", 			"type" => "Float", 		"profile" => "~Watt.3680", 					"oid" => '1.3.6.1.4.1.318.1.1.8.5.4.3.1.13.1.1.1', "factor" => false, 	"writeable" => false),
			Array("ident" => "OutputPhaseState", 		"caption" => "Output Phase State", 		"type" => "Integer", 	"profile" => "APCATS.PhaseState", 			"oid" => '1.3.6.1.4.1.318.1.1.8.5.4.3.1.19.1.1.1', 	"factor" => false, 	"writeable" => false),
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
		
		// Variable profiles
		$variableProfileSelectedSource = "APCATS.SelectedSource";
		if (IPS_VariableProfileExists($variableProfileSelectedSource) ) {

			IPS_DeleteVariableProfile($variableProfileSelectedSource);
		}			
		IPS_CreateVariableProfile($variableProfileSelectedSource, 1);
		IPS_SetVariableProfileIcon($variableProfileSelectedSource, "Electricity");
		IPS_SetVariableProfileAssociation($variableProfileSelectedSource, 1, "Source A", "", -1);
		IPS_SetVariableProfileAssociation($variableProfileSelectedSource, 2, "Source B", "", -1);
		IPS_SetVariableProfileAssociation($variableProfileSelectedSource, 3, "None", "", -1);

		// Variable profiles
		$variableProfileRedundancyState = "APCATS.RedundancyState";
		if (IPS_VariableProfileExists($variableProfileRedundancyState) ) {

			IPS_DeleteVariableProfile($variableProfileRedundancyState);
		}			
		IPS_CreateVariableProfile($variableProfileRedundancyState, 1);
		IPS_SetVariableProfileIcon($variableProfileRedundancyState, "Electricity");
		IPS_SetVariableProfileAssociation($variableProfileRedundancyState, 1, "Redundancy Lost", "Alert", 0xFF0000);
		IPS_SetVariableProfileAssociation($variableProfileRedundancyState, 2, "Fully Redundant", "Ok", 0x00FF00);

		// Variable profiles
		$variableProfilePowerStatus = "APCATS.PowerState";
		if (IPS_VariableProfileExists($variableProfilePowerStatus) ) {

			IPS_DeleteVariableProfile($variableProfilePowerStatus);
		}			
		IPS_CreateVariableProfile($variableProfilePowerStatus, 1);
		IPS_SetVariableProfileIcon($variableProfilePowerStatus, "Electricity");
		IPS_SetVariableProfileAssociation($variableProfilePowerStatus, 1, "Failed", "Alert", 0xFF0000);
		IPS_SetVariableProfileAssociation($variableProfilePowerStatus, 2, "OK", "Ok", 0x00FF00);

		// Variable profiles
		$variableProfileLockState = "APCATS.LockState";
		if (IPS_VariableProfileExists($variableProfileLockState) ) {

			IPS_DeleteVariableProfile($variableProfileLockState);
		}			
		IPS_CreateVariableProfile($variableProfileLockState, 1);
		IPS_SetVariableProfileIcon($variableProfileLockState, "Lock");
		IPS_SetVariableProfileAssociation($variableProfileLockState, 1, "Locked", "LockClosed", -1);
		IPS_SetVariableProfileAssociation($variableProfileLockState, 2, "Unlocked", "LockOpen", -1);

		// Variable profiles
		$variableProfileSyncState = "APCATS.SyncState";
		if (IPS_VariableProfileExists($variableProfileSyncState) ) {

			IPS_DeleteVariableProfile($variableProfileSyncState);
		}			
		IPS_CreateVariableProfile($variableProfileSyncState, 1);
		IPS_SetVariableProfileIcon($variableProfileSyncState, "Network");
		IPS_SetVariableProfileAssociation($variableProfileSyncState, 1, "In Sync", "Ok", 0x00FF00);
		IPS_SetVariableProfileAssociation($variableProfileSyncState, 2, "Out of Sync", "Alert", 0xFF0000);

		// Variable profiles
		$variableProfilePhaseState = "APCATS.PhaseState";
		if (IPS_VariableProfileExists($variableProfilePhaseState) ) {

			IPS_DeleteVariableProfile($variableProfilePhaseState);
		}			
		IPS_CreateVariableProfile($variableProfilePhaseState, 1);
		IPS_SetVariableProfileIcon($variableProfilePhaseState, "Elictricity");
		IPS_SetVariableProfileAssociation($variableProfilePhaseState, 1, "Normal", "Ok", 0x00FF00);
		IPS_SetVariableProfileAssociation($variableProfilePhaseState, 2, "Low Load", "Alert", 0xFFFF00);
		IPS_SetVariableProfileAssociation($variableProfilePhaseState, 3, "Near Overload", "Alert", 0xFFFF00);
		IPS_SetVariableProfileAssociation($variableProfilePhaseState, 4, "Overload", "Alert", 0xFF0000);

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

			$this->LogMessage("Unable to retrieve information via SNMP","CRIT");
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
		
			$mappingTable[$currentVariable['ident']] = $currentVariable['oid'];
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
			
				$oid = $currentVariable['oid'];
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