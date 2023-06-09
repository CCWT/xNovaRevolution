<?php

/**
_  \_/ |\ | /��\ \  / /\    |��) |_� \  / /��\ |  |   |��|�` | /��\ |\ |5
�  /�\ | \| \__/  \/ /--\   |��\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
* @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
* @link: http://www.xnovarevolution.con.ar
* @package 2Moons
* @author Slaver <slaver7@gmail.com>
* @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
* @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
* @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
* @version 1.3 (2011-01-21)
* @link http://code.google.com/p/2moons/
* Please do not remove the credits
*/

class ShowShipyardPage
{
	private function GetMaxConstructibleElements($Element)
	{
		global $pricelist, $PLANET, $USER;

		if ($pricelist[$Element]['metal'] != 0)
			$MAX[] = floor($PLANET['metal'] / $pricelist[$Element]['metal']);

		if ($pricelist[$Element]['crystal'] != 0)
			$MAX[] = floor($PLANET['crystal'] / $pricelist[$Element]['crystal']);

		if ($pricelist[$Element]['deuterium'] != 0)
			$MAX[] = floor($PLANET['deuterium'] / $pricelist[$Element]['deuterium']);

		if ($pricelist[$Element]['norio'] != 0)
			$MAX[] = floor($PLANET['norio'] / $pricelist[$Element]['norio']);

		if ($pricelist[$Element]['darkmatter'] != 0)
			$MAX[] = floor($USER['darkmatter'] / $pricelist[$Element]['darkmatter']);

		if ($pricelist[$Element]['energy_max'] != 0)
			$MAX[] = floor($PLANET['energy_max'] / $pricelist[$Element]['energy_max']);

		return min($MAX);
	}

	private function GetElementRessources($Element, $Count)
	{
		global $pricelist;

		$ResType['metal'] = ($pricelist[$Element]['metal'] * $Count);
		$ResType['crystal'] = ($pricelist[$Element]['crystal'] * $Count);
		$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
		$ResType['norio'] = ($pricelist[$Element]['norio'] * $Count);
		$ResType['darkmatter'] = ($pricelist[$Element]['darkmatter'] * $Count);

		return $ResType;
	}

	private function CancelAuftr($CancelArray)
	{
		global $USER, $PLANET;
		$ElementQueue = explode(';', $PLANET['b_hangar_id']);
		foreach ($CancelArray as $ID => $Auftr) {
			if ($Auftr == 0)
				$PLANET['b_hangar'] = 0;

			$ElementQ = explode(',', $ElementQueue[$Auftr]);
			$Element = $ElementQ[0];
			$Count = $ElementQ[1];

			if ($Element == 214 && $USER['rpg_destructeur'] == 1)
				$Count = $Count / 2;

			$Resses = $this->GetElementRessources($Element, $Count);
			$PLANET['metal'] += $Resses['metal'] * 0.6;
			$PLANET['crystal'] += $Resses['crystal'] * 0.6;
			$PLANET['deuterium'] += $Resses['deuterium'] * 0.6;
			$PLANET['norio'] += $Resses['norio'] * 0.6;
			$USER['darkmatter'] += $Resses['darkmatter'] * 0.6;
			unset($ElementQueue[$Auftr]);
		}
		$PLANET['b_hangar_id'] = implode(';', $ElementQueue);
		FirePHP::getInstance(true)->log("Queue(Hanger): " . $PLANET['b_hangar_id']);
	}

	private function GetRestPrice($Element, $Factor = true)
	{
		global $USER, $PLANET, $pricelist, $resource, $LNG;

		if ($Factor)
			$level = isset($PLANET[$resource[$Element]]) ? $PLANET[$resource[$Element]] : $USER[$resource[$Element]];

		$array = array(
			'metal' => $LNG['Metal'],
			'crystal' => $LNG['Crystal'],
			'deuterium' => $LNG['Deuterium'],
			'norio' => $LNG['Norio'],
			'energy_max' => $LNG['Energy'],
			'darkmatter' => $LNG['Darkmatter'],
		);

		$restprice = array();
		foreach ($array as $ResType => $ResTitle) {
			if ($pricelist[$Element][$ResType] == 0)
				continue;

			$cost = $Factor ? floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level)) : floor($pricelist[$Element][$ResType]);

			$restprice[$ResTitle] = pretty_number(max($cost - (($PLANET[$ResType]) ? $PLANET[$ResType] : $USER[$ResType]), 0));
		}

		return $restprice;
	}

	public function FleetBuildingPage()
	{
		global $PLANET, $USER, $LNG, $resource, $dpath, $db, $reslist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');

		$template = new template();

		if ($PLANET[$resource[21]] == 0) {
			$template->message($LNG['bd_shipyard_required']);
			exit;
		}

		$fmenge = $_POST['fmenge'];
		$cancel = request_var('auftr', range(0, MAX_FLEET_OR_DEFS_IN_BUILD - 1));
		$action = request_var('action', '');

		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();

		$NotBuilding = true;

		if (!empty($PLANET['b_building_id'])) {
			$CurrentQueue = $PLANET['b_building_id'];
			$QueueArray = explode(";", $CurrentQueue);

			for ($i = 0; $i < count($QueueArray); $i++) {
				$ListIDArray = explode(",", $QueueArray[$i]);
				if ($ListIDArray[0] == 21 || $ListIDArray[0] == 15) {
					$NotBuilding = false;
					break;
				}
			}
		}

		if (!empty($fmenge) && $NotBuilding == true && $USER['urlaubs_modus'] == 0) {
			$AddedInQueue = false;

			$ebuild = explode(";", $PLANET['b_hangar_id']);
			if (count($ebuild) - 1 >= MAX_FLEET_OR_DEFS_IN_BUILD) {
				$template->message(sprintf($LNG['bd_max_builds'], MAX_FLEET_OR_DEFS_IN_BUILD), "?page=buildings&mode=fleet", 3);
				exit;
			}
			foreach ($fmenge as $Element => $Count) {
				if (empty($Count) || !in_array($Element, $reslist['fleet']))
					continue;

				$Count = is_numeric($Count) ? round($Count) : 0;
				$Count = max(min($Count, MAX_FLEET_OR_DEFS_PER_ROW), 0);
				$MaxElements = $this->GetMaxConstructibleElements($Element); # Fixed
				$Count = min($MaxElements, $Count);

				if (empty($Element) || empty($Count) || !IsTechnologieAccessible($USER, $PLANET, $Element))
					continue;

				$Ressource = $this->GetElementRessources($Element, $Count);
				$PLANET['metal'] -= $Ressource['metal'];
				$PLANET['crystal'] -= $Ressource['crystal'];
				$PLANET['deuterium'] -= $Ressource['deuterium'];
				$PLANET['norio'] -= $Ressource['norio'];
				$USER['darkmatter'] -= $Ressource['darkmatter'];

				$PLANET['b_hangar_id'] .= $Element . ',' . floattostring($Count) . ';';
			}
		}

		if ($action == "delete" && is_array($cancel) && $USER['urlaubs_modus'] == 0)
			$this->CancelAuftr($cancel);

		$PlanetRess->SavePlanetToDB();

		foreach ($reslist['fleet'] as $Element) {
			if (IsTechnologieAccessible($USER, $PLANET, $Element)) {
				$FleetList[] = array(
					'id' => $Element,
					'name' => $LNG['tech'][$Element],
					'descriptions' => $LNG['res']['descriptions'][$Element],
					'price' => GetElementPrice($USER, $PLANET, $Element, false),
					'restprice' => $this->GetRestPrice($Element, false),
					'time' => pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
					'IsAvailable' => IsElementBuyable($USER, $PLANET, $Element, false),
					'GetMaxAmount' => floattostring($this->GetMaxConstructibleElements($Element)),
					'Available' => pretty_number($PLANET[$resource[$Element]]),
				);
			}
		}

		$Buildlist = array();

		if (!empty($PLANET['b_hangar_id'])) {
			$ElementQueue = explode(';', $PLANET['b_hangar_id']);
			$Shipyard = array();
			$QueueTime = 0;
			foreach ($ElementQueue as $ElementLine => $Element) {
				if (empty($Element))
					continue;

				$Element = explode(',', $Element);
				$ElementTime = GetBuildingTime($USER, $PLANET, $Element[0]);
				$QueueTime += $ElementTime * $Element[1];
				$Shipyard[] = array($LNG['tech'][$Element[0]], $Element[1], $ElementTime);
			}

			$template->loadscript('bcmath.js');
			$template->loadscript('shipyard.js');
			$template->execscript('ShipyardInit();');

			$Buildlist = array(
				'Queue' => $Shipyard,
				'b_hangar_id_plus' => $PLANET['b_hangar'],
				'pretty_time_b_hangar' => pretty_time(max($QueueTime - $PLANET['b_hangar'], 0)),
			);
		}

		$template->assign_vars(
			array(
				'FleetList' => $FleetList,
				'NotBuilding' => $NotBuilding,
				'bd_available' => $LNG['bd_available'],
				'bd_remaining' => $LNG['bd_remaining'],
				'fgf_time' => $LNG['fgf_time'],
				'bd_build_ships' => $LNG['bd_build_ships'],
				'bd_building_shipyard' => $LNG['bd_building_shipyard'],
				'bd_completed' => $LNG['bd_completed'],
				'bd_cancel_warning' => $LNG['bd_cancel_warning'],
				'bd_cancel_send' => $LNG['bd_cancel_send'],
				'bd_actual_production' => $LNG['bd_actual_production'],
				'bd_operating' => $LNG['bd_operating'],
				'BuildList' => json_encode($Buildlist),
				'maxlength' => strlen(MAX_FLEET_OR_DEFS_PER_ROW),
			)
		);
		$template->show("shipyard_fleet.tpl");
	}

	public function DefensesBuildingPage()
	{
		global $USER, $PLANET, $LNG, $resource, $dpath, $reslist;

		include_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
		include_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');

		$template = new template();

		if ($PLANET[$resource[21]] == 0) {
			$template->message($LNG['bd_shipyard_required']);
			exit;
		}

		$fmenge = $_POST['fmenge'];
		$cancel = request_var('auftr', range(0, MAX_FLEET_OR_DEFS_IN_BUILD - 1));
		$action = request_var('action', '');

		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		$NotBuilding = true;

		if (!empty($PLANET['b_building_id'])) {
			$CurrentQueue = $PLANET['b_building_id'];
			$QueueArray = explode(";", $CurrentQueue);

			for ($i = 0; $i < count($QueueArray); $i++) {
				$ListIDArray = explode(",", $QueueArray[$i]);
				if ($ListIDArray[0] == 21 || $ListIDArray[0] == 15) {
					$NotBuilding = false;
					break;
				}
			}
		}

		if (isset($fmenge) && $NotBuilding == true && $USER['urlaubs_modus'] == 0) {
			$ebuild = explode(";", $PLANET['b_hangar_id']);
			if (count($ebuild) - 1 >= MAX_FLEET_OR_DEFS_IN_BUILD) {
				$template->message(sprintf($LNG['bd_max_builds'], MAX_FLEET_OR_DEFS_IN_BUILD), "?page=buildings&mode=fleet", 3);
				exit;
			}

			$Missiles[502] = $PLANET[$resource[502]];
			$Missiles[503] = $PLANET[$resource[503]];
			$SiloSize = $PLANET[$resource[44]];
			$MaxMissiles = $SiloSize * 10;
			$BuildQueue = $PLANET['b_hangar_id'];
			$BuildArray = explode(";", $BuildQueue);

			for ($QElement = 0; $QElement < count($BuildArray); $QElement++) {
				$ElmentArray = explode(",", $BuildArray[$QElement]);
				if (isset($Missiles[$ElmentArray[0]]))
					$Missiles[$ElmentArray[0]] += $ElmentArray[1];
			}

			foreach ($fmenge as $Element => $Count) {
				if (empty($Count) || !in_array($Element, $reslist['defense']))
					continue;

				$Count = is_numeric($Count) ? $Count : 0;
				$Count = max(min($Count, MAX_FLEET_OR_DEFS_PER_ROW), 0);
				$MaxElements = $this->GetMaxConstructibleElements($Element);

				if (empty($Element) || empty($Count) || empty($MaxElements) || !IsTechnologieAccessible($USER, $PLANET, $Element))
					continue;

				if ($Element == 502 || $Element == 503) {
					$ActuMissiles = $Missiles[502] + (2 * $Missiles[503]);
					$MissilesSpace = $MaxMissiles - $ActuMissiles;
					$Count = $Element == 502 ? min($Count, $MissilesSpace) : min($Count, floor($MissilesSpace / 2));

					$Count = min($Count, $MaxElements);

					$Missiles[$Element] += $Count;
				} elseif (in_array($Element, $reslist['one'])) {
					$Count = ($PLANET[$resource[$Element]] == 0 && strpos($PLANET['b_hangar_id'], $Element . ',') === false) ? 1 : 0;
				} else {
					$Count = min($Count, $MaxElements);
				}

				if ($Count < 1)
					continue;

				$Ressource = $this->GetElementRessources($Element, $Count);

				$PLANET['metal'] -= $Ressource['metal'];
				$PLANET['crystal'] -= $Ressource['crystal'];
				$PLANET['deuterium'] -= $Ressource['deuterium'];
				$PLANET['norio'] -= $Ressource['norio'];
				$USER['darkmatter'] -= $Ressource['darkmatter'];

				$PLANET['b_hangar_id'] .= $Element . ',' . floattostring($Count) . ';';
			}
		}

		if ($action == "delete" && is_array($cancel) && $USER['urlaubs_modus'] == 0)
			$this->CancelAuftr($cancel);

		$PlanetRess->SavePlanetToDB();

		foreach ($reslist['defense'] as $Element) {
			if (!IsTechnologieAccessible($USER, $PLANET, $Element))
				continue;

			$DefenseList[] = array(
				'id' => $Element,
				'name' => $LNG['tech'][$Element],
				'descriptions' => $LNG['res']['descriptions'][$Element],
				'price' => GetElementPrice($USER, $PLANET, $Element, false),
				'restprice' => $this->GetRestPrice($Element),
				'time' => pretty_time(GetBuildingTime($USER, $PLANET, $Element)),
				'IsAvailable' => IsElementBuyable($USER, $PLANET, $Element, false),
				'GetMaxAmount' => floattostring($this->GetMaxConstructibleElements($Element)),
				'Available' => pretty_number($PLANET[$resource[$Element]]),
				'AlreadyBuild' => (in_array($Element, $reslist['one']) && (strpos($PLANET['b_hangar_id'], $Element . ",") !== false || $PLANET[$resource[$Element]] != 0)) ? true : false,
			);
		}

		$Buildlist = array();
		if (!empty($PLANET['b_hangar_id'])) {
			$ElementQueue = explode(';', $PLANET['b_hangar_id']);
			$Shipyard = array();
			$QueueTime = 0;
			foreach ($ElementQueue as $ElementLine => $Element) {
				if (empty($Element))
					continue;

				$Element = explode(',', $Element);
				$ElementTime = GetBuildingTime($USER, $PLANET, $Element[0]);
				$QueueTime += $ElementTime * $Element[1];
				$Shipyard[] = array($LNG['tech'][$Element[0]], $Element[1], $ElementTime);
			}

			$template->loadscript('bcmath.js');
			$template->loadscript('shipyard.js');
			$template->execscript('ShipyardInit();');

			$Buildlist = array(
				'Queue' => $Shipyard,
				'b_hangar_id_plus' => $PLANET['b_hangar'],
				'pretty_time_b_hangar' => pretty_time(max($QueueTime - $PLANET['b_hangar'], 0)),
			);
		}

		$template->assign_vars(
			array(
				'DefenseList' => $DefenseList,
				'NotBuilding' => $NotBuilding,
				'bd_available' => $LNG['bd_available'],
				'bd_remaining' => $LNG['bd_remaining'],
				'fgf_time' => $LNG['fgf_time'],
				'bd_build_ships' => $LNG['bd_build_ships'],
				'bd_building_shipyard' => $LNG['bd_building_shipyard'],
				'bd_protection_shield_only_one' => $LNG['bd_protection_shield_only_one'],
				'bd_cancel_warning' => $LNG['bd_cancel_warning'],
				'bd_cancel_send' => $LNG['bd_cancel_send'],
				'bd_operating' => $LNG['bd_operating'],
				'bd_actual_production' => $LNG['bd_actual_production'],
				'BuildList' => json_encode($Buildlist),
				'maxlength' => strlen(MAX_FLEET_OR_DEFS_PER_ROW),
			)
		);
		$template->show("shipyard_defense.tpl");
	}
}
?>

