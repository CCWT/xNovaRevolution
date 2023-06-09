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

class ShowInfosPage
{
	private function GetNextJumpWaitTime($CurMoon)
	{
		global $resource;

		$JumpGateLevel = $CurMoon[$resource[43]];
		$LastJumpTime = $CurMoon['last_jump_time'];
		if ($JumpGateLevel > 0) {
			$NextJumpTime = $LastJumpTime + JUMPGATE_WAIT_TIME;
			if ($NextJumpTime >= TIMESTAMP) {
				$RestWait = $NextJumpTime - TIMESTAMP;
				$RestString = " " . pretty_time($RestWait);
			} else {
				$RestWait = 0;
				$RestString = "";
			}
		} else {
			$RestWait = 0;
			$RestString = "";
		}
		$RetValue['string'] = $RestString;
		$RetValue['value'] = $RestWait;

		return $RetValue;
	}

	private function DoFleetJump()
	{
		global $USER, $PLANET, $resource, $LNG, $db, $reslist;

		if (!$_POST)
			return false;

		$RestString = $this->GetNextJumpWaitTime($PLANET);
		$NextJumpTime = $RestString['value'];
		$JumpTime = TIMESTAMP;

		if ($NextJumpTime != 0)
			return $LNG['in_jump_gate_already_used'] . $RestString['string'];

		$TargetPlanet = request_var('jmpto', 0);
		$TargetGate = $db->uniquequery("SELECT `id`, `last_jump_time` FROM " . PLANETS . " WHERE `id` = '" . $TargetPlanet . "' AND `sprungtor` > '0';");

		if (!isset($TargetGate))
			return $LNG['in_jump_gate_doesnt_have_one'];

		$RestString = $this->GetNextJumpWaitTime($TargetGate);

		if ($RestString['value'] != 0)
			return $LNG['in_jump_gate_not_ready_target'] . $RestString['string'];

		$ShipArray = array();
		$SubQueryOri = "";
		$SubQueryDes = "";

		foreach ($reslist['fleet'] as $Ship) {
			$ShipArray[$Ship] = min(max(request_var('ship' . $Ship, 0.0), 0), $PLANET[$resource[$Ship]]);
			$SubQueryOri .= "`" . $resource[$Ship] . "` = `" . $resource[$Ship] . "` - '" . floattostring($ShipArray[$Ship]) . "', ";
			$SubQueryDes .= "`" . $resource[$Ship] . "` = `" . $resource[$Ship] . "` + '" . floattostring($ShipArray[$Ship]) . "', ";
			$PLANET[$resource[$Ship]] -= floattostring($ShipArray[$Ship]);
		}

		if (empty($SubQueryOri))
			return $LNG['in_jump_gate_error_data'];

		$SQL = "UPDATE " . PLANETS . " SET ";
		$SQL .= $SubQueryOri;
		$SQL .= "`last_jump_time` = '" . $JumpTime . "' ";
		$SQL .= "WHERE ";
		$SQL .= "`id` = '" . $PLANET['id'] . "';";
		$SQL .= "UPDATE " . PLANETS . " SET ";
		$SQL .= $SubQueryDes;
		$SQL .= "`last_jump_time` = '" . $JumpTime . "' ";
		$SQL .= "WHERE ";
		$SQL .= "`id` = '" . $TargetGate['id'] . "';";
		$db->multi_query($SQL);

		$PLANET['last_jump_time'] = $JumpTime;
		$RestString = $this->GetNextJumpWaitTime($PLANET);
		return $LNG['in_jump_gate_done'] . $RestString['string'];
	}

	private function BuildFleetListRows($PLANET)
	{
		global $reslist, $resource, $LNG;

		foreach ($reslist['fleet'] as $Ship) {
			if ($PLANET[$resource[$Ship]] <= 0)
				continue;

			$GateFleetList[] = array(
				'id' => $Ship,
				'name' => $LNG['tech'][$Ship],
				'max' => pretty_number($PLANET[$resource[$Ship]]),
			);
		}

		return $GateFleetList;
	}

	private function BuildJumpableMoonCombo($USER, $PLANET)
	{
		global $resource, $db;
		$QrySelectMoons = "SELECT id, galaxy, system, planet FROM " . PLANETS . " WHERE `id` != '" . $PLANET['id'] . "' AND `planet_type` = '3' AND `id_owner` = '" . $USER['id'] . "' AND `" . $resource[43] . "` > '0';";
		$MoonList = $db->query($QrySelectMoons);
		$Combo = "";
		while ($CurMoon = $db->fetch_array($MoonList)) {
			$RestString = $this->GetNextJumpWaitTime($CurMoon);
			$Combo .= "<option value=\"" . $CurMoon['id'] . "\">[" . $CurMoon['galaxy'] . ":" . $CurMoon['system'] . ":" . $CurMoon['planet'] . "] " . $CurMoon['name'] . $RestString['string'] . "</option>\n";
		}
		return $Combo;
	}

	public function __construct()
	{
		global $USER, $PLANET, $dpath, $LNG, $resource, $pricelist, $reslist, $CombatCaps, $ProdGrid, $CONF, $OfficerInfo;

		$BuildID = request_var('gid', 0);

		$template = new template();
		$template->isPopup(true);

		if (in_array($BuildID, $reslist['prod']) && $BuildID != 212) {
			$BuildLevelFactor = 10;
			$BuildTemp = $PLANET['temp_max'];
			$CurrentBuildtLvl = $PLANET[$resource[$BuildID]];
			$BuildEnergy = $USER[$resource[113]];
			/*$BuildLevel     	= ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
			$Prod[1]         	= (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $CONF['resource_multiplier']) * (1 + (TIMESTAMP - $USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0));
			$Prod[2]         	= (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $CONF['resource_multiplier']) * (1 + (TIMESTAMP - $USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0));
			$Prod[7]          	= (floor(eval($ProdGrid[$BuildID]['formule']['norio'])     * $CONF['resource_multiplier']) * (1 + (TIMESTAMP - $USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0));
			$Prod[3]          	= (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $CONF['resource_multiplier']) * (1 + (TIMESTAMP - $USER[$resource[703]] <= 0) ? ($ExtraDM[703]['add']) : 0));
			$Prod[4] 			= (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']) * (1 + (TIMESTAMP - $USER[$resource[704]] <= 0) ? ($ExtraDM[704]['add']) : 0));
			$Prod[12] 			= (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']));*/
			$BuildLevel = max($CurrentBuildtLvl, 1);
			$Prod[1] = round(eval($ProdGrid[$BuildID]['formule']['metal']) * $CONF['resource_multiplier']);
			$Prod[2] = round(eval($ProdGrid[$BuildID]['formule']['crystal']) * $CONF['resource_multiplier']);
			$Prod[7] = round(eval($ProdGrid[$BuildID]['formule']['norio']) * $CONF['resource_multiplier']);
			$Prod[3] = round(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $CONF['resource_multiplier']);
			$Prod[4] = round(eval($ProdGrid[$BuildID]['formule']['energy']) * $CONF['resource_multiplier']);
			$Prod[12] = round(eval($ProdGrid[$BuildID]['formule']['energy']) * $CONF['resource_multiplier']);
			$BuildStartLvl = max($CurrentBuildtLvl - 2, 1);

			$ActualProd = floor($Prod[$BuildID]);
			$ActualNeed = $BuildID != 12 ? floor($Prod[4]) : floor($Prod[3]);

			$ProdFirst = 0;

			for ($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++) {
				/*$Prod[1] 	= floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $CONF['resource_multiplier']);
				$Prod[2] 	= floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $CONF['resource_multiplier']);
				$Prod[3] 	= floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $CONF['resource_multiplier']);
				$Prod[4] 	= floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']);
				$Prod[7] 	= floor(eval($ProdGrid[$BuildID]['formule']['norio'])     * $CONF['resource_multiplier']);
				$Prod[12] 	= floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $CONF['resource_multiplier']);*/
				$Prod[1] = round(eval($ProdGrid[$BuildID]['formule']['metal']) * $CONF['resource_multiplier']);
				$Prod[2] = round(eval($ProdGrid[$BuildID]['formule']['crystal']) * $CONF['resource_multiplier']);
				$Prod[3] = round(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $CONF['resource_multiplier']);
				$Prod[7] = round(eval($ProdGrid[$BuildID]['formule']['norio']) * $CONF['resource_multiplier']);
				$Prod[4] = round(eval($ProdGrid[$BuildID]['formule']['energy']) * $CONF['resource_multiplier']);
				$Prod[12] = round(eval($ProdGrid[$BuildID]['formule']['energy']) * $CONF['resource_multiplier']);

				$NeesRess = $BuildID != 12 ? floor($Prod[4]) : floor($Prod[3]);

				$prod = pretty_number(floor($Prod[$BuildID]));
				$prod_diff = colorNumber(pretty_number(floor($Prod[$BuildID] - $ActualProd)));
				$need = colorNumber(pretty_number(floor($NeesRess)));
				$need_diff = colorNumber(pretty_number(floor($NeesRess - $ActualNeed)));

				if ($ProdFirst == 0)
					$ProdFirst = floor($Prod[$BuildID]);

				$ProductionTable[] = array(
					'BuildLevel' => $BuildLevel,
					'prod' => $prod,
					'prod_diff' => $prod_diff,
					'need' => $need,
					'need_diff' => $need_diff,
				);
			}
		} elseif (in_array($BuildID, $reslist['fleet'])) {
			for ($Type = 200; $Type < 500; $Type++) {
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$LNG['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];

				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$LNG['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$LNG['in_struct_pt']] = pretty_number($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal'] + $pricelist[$BuildID]['norio']);
			$FleetInfo[$LNG['in_shield_pt']] = pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$LNG['in_attack_pt']] = pretty_number($CombatCaps[$BuildID]['attack']);
			$FleetInfo[$LNG['in_capacity']] = pretty_number($pricelist[$BuildID]['capacity']);
			$FleetInfo[$LNG['in_base_speed']][] = pretty_number($pricelist[$BuildID]['speed']);
			$FleetInfo[$LNG['in_consumption']][] = pretty_number($pricelist[$BuildID]['consumption']);
			$FleetInfo[$LNG['in_base_speed']][] = pretty_number($pricelist[$BuildID]['speed2']);
			$FleetInfo[$LNG['in_consumption']][] = pretty_number($pricelist[$BuildID]['consumption2']);
		} elseif (in_array($BuildID, $reslist['defense'])) {
			for ($Type = 200; $Type < 500; $Type++) {
				if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
					$RapidFire['to'][$LNG['tech'][$Type]] = $CombatCaps[$BuildID]['sd'][$Type];

				if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
					$RapidFire['from'][$LNG['tech'][$Type]] = $CombatCaps[$Type]['sd'][$BuildID];
			}

			$FleetInfo[$LNG['in_struct_pt']] = pretty_number($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal'] + $pricelist[$BuildID]['norio']);
			$FleetInfo[$LNG['in_shield_pt']] = pretty_number($CombatCaps[$BuildID]['shield']);
			$FleetInfo[$LNG['in_attack_pt']] = pretty_number($CombatCaps[$BuildID]['attack']);
		} elseif ($BuildID == 43 && $PLANET[$resource[43]] > 0) {
			$template->loadscript('flotten.js');
			$GateFleetList['jump'] = $this->DoFleetJump();
			$RestString = $this->GetNextJumpWaitTime($PLANET);
			if ($RestString['value'] != 0) {
				include_once(ROOT_PATH . 'includes/functions/InsertJavaScriptChronoApplet.php');
				$template->assign_vars(
					array(
						'gate_time_script' => InsertJavaScriptChronoApplet("Gate", "1", $RestString['value'], true),
						'gate_script_go' => InsertJavaScriptChronoApplet("Gate", "1", $RestString['value'], false),
					)
				);
			}

			$GateFleetList['start_link'] = BuildPlanetAdressLink($PLANET);
			$GateFleetList['moons'] = $this->BuildJumpableMoonCombo($USER, $PLANET);
			$GateFleetList['fleets'] = $this->BuildFleetListRows($PLANET);
		}
		if (in_array($BuildID, $reslist['officier'])) {
			$description = $OfficerInfo[$BuildID]['info'] ? sprintf($LNG['info'][$BuildID]['description'], ((is_float($OfficerInfo[$BuildID]['info'])) ? $OfficerInfo[$BuildID]['info'] * 100 : $OfficerInfo[$BuildID]['info']), $pricelist[$BuildID]['max']) : sprintf($LNG['info'][$BuildID]['description'], $pricelist[$BuildID]['max']);
		} else {
			$description = $LNG['info'][$BuildID]['description'];
		}
		$template->assign_vars(
			array(
				'id' => $BuildID,
				'name' => $LNG['info'][$BuildID]['name'],
				'image' => $BuildID,
				'description' => $description,
				'ProductionTable' => $ProductionTable,
				'RapidFire' => $RapidFire,
				'Level' => $CurrentBuildtLvl,
				'FleetInfo' => $FleetInfo,
				'GateFleetList' => $GateFleetList,
				'in_jump_gate_jump' => $LNG['in_jump_gate_jump'],
				'gate_ship_dispo' => $LNG['in_jump_gate_available'],
				'in_level' => $LNG['in_level'],
				'in_prod_p_hour' => $LNG['in_prod_p_hour'],
				'in_difference' => $LNG['in_difference'],
				'in_used_energy' => $LNG['in_used_energy'],
				'in_prod_energy' => $LNG['in_prod_energy'],
				'in_used_deuter' => $LNG['in_used_deuter'],
				'in_rf_again' => $LNG['in_rf_again'],
				'in_rf_from' => $LNG['in_rf_from'],
				'in_jump_gate_select_ships' => $LNG['in_jump_gate_select_ships'],
				'in_jump_gate_start_moon' => $LNG['in_jump_gate_start_moon'],
				'in_jump_gate_finish_moon' => $LNG['in_jump_gate_finish_moon'],
				'in_jump_gate_wait_time' => $LNG['in_jump_gate_wait_time'],
			)
		);

		$template->show('info_overview.tpl');
	}
}
?>

