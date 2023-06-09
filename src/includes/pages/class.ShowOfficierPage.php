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

class ShowOfficierPage
{
	private function IsOfficierAccessible($Officier)
	{
		global $USER, $requeriments, $resource, $pricelist;

		if (isset($requeriments[$Officier])) {
			$enabled = true;
			foreach ($requeriments[$Officier] as $ReqOfficier => $OfficierLevel) {
				if ($USER[$resource[$ReqOfficier]] < $OfficierLevel)
					return 0;
			}
		}

		return ($USER[$resource[$Officier]] < $pricelist[$Officier]['max']) ? 1 : -1;
	}

	public function UpdateExtra($Element)
	{
		global $USER, $db, $reslist, $resource, $ExtraDM;

		if ((floor($USER['darkmatter'] / $ExtraDM[$Element]['darkmatter'])) > 0 && in_array($Element, $reslist['dmfunc'])) {
			if ($USER[$resource[$Element]] == 0 || $USER[$resource[$Element]] < TIMESTAMP) {
				$USER[$resource[$Element]] = TIMESTAMP + $ExtraDM[$Element]['time'] * 3600;
				$USER['darkmatter'] -= $ExtraDM[$Element]['darkmatter'];
				$SQL = "UPDATE " . USERS . " SET ";
				$SQL .= "`" . $resource[$Element] . "` = '" . $USER[$resource[$Element]] . "' ";
				$SQL .= "WHERE ";
				$SQL .= "`id` = '" . $USER['id'] . "';";
				$db->query($SQL);
			}
		}
	}

	public function UpdateOfficier($Selected)
	{
		global $USER, $db, $reslist, $resource;

		if ((floor($USER['darkmatter'] / DM_PRO_OFFICIER_LEVEL)) > 0 && in_array($Selected, $reslist['officier']) && $this->IsOfficierAccessible($Selected) == 1) {
			$USER[$resource[$Selected]] += 1;
			$USER['darkmatter'] -= DM_PRO_OFFICIER_LEVEL;
			$SQL = "UPDATE " . USERS . " SET ";
			$SQL .= "`" . $resource[$Selected] . "` = '" . $USER[$resource[$Selected]] . "' ";
			$SQL .= "WHERE ";
			$SQL .= "`id` = '" . $USER['id'] . "';";
			$db->query($SQL);
		}
	}

	public function __construct()
	{
		global $USER, $CONF, $PLANET, $resource, $reslist, $LNG, $db, $ExtraDM, $OfficerInfo, $pricelist;

		$action = request_var('action', '');
		$Offi = request_var('offi', 0);
		$Extra = request_var('extra', 0);

		$PlanetRess = new ResourceUpdate();
		$PlanetRess->CalcResource();
		;

		if ($action == "send" && $USER['urlaubs_modus'] == 0) {
			if (!empty($Offi) && !CheckModule(18))
				$this->UpdateOfficier($Offi);
			elseif (!empty($Extra) && !CheckModule(8))
				$this->UpdateExtra($Extra);
		}

		$PlanetRess->SavePlanetToDB();
		$template = new template();
		$template->loadscript('officier.js');

		if (!CheckModule(8)) {
			foreach ($reslist['dmfunc'] as $Element) {
				if ($USER[$resource[$Element]] > TIMESTAMP) {
					$template->execscript("GetOfficerTime(" . $Element . ", " . ($USER[$resource[$Element]] - TIMESTAMP) . ");");
				}
				$ExtraDMList[] = array(
					'id' => $Element,
					'active' => $USER[$resource[$Element]] - TIMESTAMP,
					'price' => pretty_number($ExtraDM[$Element]['darkmatter']),
					'isok' => (($USER['darkmatter'] - $ExtraDM[$Element]['darkmatter']) >= 0) ? true : false,
					'time' => pretty_time($ExtraDM[$Element]['time'] * 3600),
					'name' => $LNG['tech'][$Element],
					'desc' => sprintf($LNG['res']['descriptions'][$Element], $ExtraDM[$Element]['add'] * 100),
				);
			}
		}

		if (!CheckModule(18)) {
			foreach ($reslist['officier'] as $Element) {
				if (($Result = $this->IsOfficierAccessible($Element)) === 0)
					continue;

				$description = $OfficerInfo[$Element]['info'] ? sprintf($LNG['info'][$Element]['description'], is_float($OfficerInfo[$Element]['info']) ? $OfficerInfo[$Element]['info'] * 100 : $OfficerInfo[$Element]['info'], $pricelist[$Element]['max']) : sprintf($LNG['info'][$Element]['description'], $pricelist[$Element]['max']);

				$OfficierList[] = array(
					'id' => $Element,
					'level' => $USER[$resource[$Element]],
					'name' => $LNG['tech'][$Element],
					'desc' => $description,
					'Result' => $Result,
				);
			}
		}

		$template->assign_vars(
			array(
				'ExtraDMList' => $ExtraDMList,
				'OfficierList' => $OfficierList,
				'user_darkmatter' => floor($USER['darkmatter'] / DM_PRO_OFFICIER_LEVEL),
				'of_max_lvl' => $LNG['of_max_lvl'],
				'of_recruit' => $LNG['of_recruit'],
				'of_darkmatter' => sprintf($LNG['of_points_per_thousand_darkmatter'], DM_PRO_OFFICIER_LEVEL, $LNG['Darkmatter']),
				'of_available_points' => $LNG['of_available_points'],
				'of_lvl' => $LNG['of_lvl'],
				'in_dest_durati' => $LNG['in_dest_durati'],
				'of_still' => $LNG['of_still'],
				'of_active' => $LNG['of_active'],
				'of_update' => $LNG['of_update'],
				'in_dest_durati' => $LNG['in_dest_durati'],
				'of_dm_trade' => sprintf($LNG['of_dm_trade'], $LNG['Darkmatter']),
			)
		);

		$template->show("officier_overview.tpl");
	}
}
?>

