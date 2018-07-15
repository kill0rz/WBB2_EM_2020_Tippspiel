<?php

include "./wm2018_global.php";
$lang->load("WM2018");

$akttime = time();
$wm2018_meister = "";
$points = 0;
$meister = array();
$krone = '';
$count = 0;

eval("print(\"" . $hm_boxhead_tpl . "\");");

// Hier wird geprüft, welche action angesprochen werden soll
switch (trim($_GET['action'])) {
	case 'meister':
		// alle Tipps durchgehen
		$result_m = $db->query("SELECT tipp_wm,tipp_vwm FROM bb" . $n . "_wm2018_userpunkte");

		while ($row = $db->fetch_array($result_m)) {
			if ($row['tipp_wm'] > 0) {
				if (array_key_exists($row['tipp_wm'], $meister)) {
					$meister[$row['tipp_wm']] += 1;
				} else {
					$meister[$row['tipp_wm']] = 1;
				}
				$points += 1;
			}
			if ($row['tipp_vwm'] > 0) {
				if (array_key_exists($row['tipp_vwm'], $meister)) {
					$meister[$row['tipp_vwm']] += 0.5;
				} else {
					$meister[$row['tipp_vwm']] = 0.5;
				}
				if ($row['tipp_wm'] == 0) {
					$points += 0.5;
				}
			}
		}

		if ($points > 0) {
			// Teamnamen einfügen
			$count = 0;
			foreach (array_keys($meister) as $einzel) {
				list($teamname) = $db->query_first("SELECT name FROM bb" . $n . "_wm2018_teams WHERE teamid = " . $einzel);

				$sort[$count][0] = $teamname;
				$sort[$count][1] = $meister[$einzel];
				$count++;
			}

			function cmp($a, $b) {
				return ($a[1] < $b[1]);
			}

			usort($sort, "cmp");

			// ausgeben
			for ($lauf = 0; ($lauf < $count) && ($lauf < 3);) {
				$lauf++;

				$wm2018_meister .= "<tr><td class=\"tableb\"><font size=2>" . $lauf . "</font></td>";

				$wm2018_meister .= "<td class=\"tablea\"><font size=2><a href=\"wm2018.php?action=showusertipps\" alt='showusertipps'>";
				if ($lauf == 1) {
					$wm2018_meister .= "<b>" . $sort[$lauf - 1][0] . "</b>";
				} else {
					$wm2018_meister .= $sort[$lauf - 1][0];
				}
				$wm2018_meister .= "</a></font></td>";

				$wm2018_meister .= "<td class=\"tableb\"><img src=\"images/wm2018/";
				if (0 == 1) {
					$wm2018_meister .= "t_u.gif\" alt=\"t_u.gif";
				} else {
					$wm2018_meister .= "t_m.gif\" alt=\"t_m.gif";
				}
				$wm2018_meister .= "\"></td>";

				$wm2018_meister .= "<td class=\"tablea\"><font size=2 color=green>" . round(($sort[$lauf - 1][1] / $points) * 100, 0) . " %</font></td>";

				$wm2018_meister .= "</tr>";
			}
			eval("print(\"" . $tpl->get("wm2018_sponsor_portalboxen_wmmeister") . "\");");
		} // (point>0)
		break;

	case 'quote':
		$result_nextgames = $db->query("SELECT * FROM bb" . $n . "_wm2018_spiele WHERE datetime > '" . intval($akttime) . "' ORDER BY datetime ASC Limit 0,5");

		while ($row_nextgames = $db->fetch_array($result_nextgames)) {
			$rowclass = getone($count++, "tablea", "tableb");
			$gamedate = formatdate($wbbuserdata['dateformat'], $row_nextgames['datetime'], 1);
			$gametime = formatdate($wbbuserdata['timeformat'], $row_nextgames['datetime']);

			$checkgame1 = $row_nextgames['team_1_id']{0};
			$checkgame2 = $row_nextgames['team_2_id']{0};
			if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "L") {
				$check1 = explode('-', $row_nextgames['team_1_id']);
				if ($check1[1] == "A" || $check1[1] == "B" || $check1[1] == "C" || $check1[1] == "D" || $check1[1] == "E" || $check1[1] == "F" || $check1[1] == "G" || $check1[1] == "H") {
					$tabelle = $lang->items['LANG_WM2018_PHP_5'];
				} else {
					$tabelle = $lang->items['LANG_WM2018_PHP_7'];
				}

				if ($check1[0] == "W") {
					$teamname1 = $lang->items['LANG_WM2018_PHP_11'];
				}

				if ($check1[0] == "S") {
					$teamname1 = $lang->items['LANG_WM2018_PHP_12'];
				}

				if ($check1[0] == "L") {
					$teamname1 = $lang->items['LANG_WM2018_PHP_13'];
				}

				$teamname1 .= "&nbsp;$tabelle&nbsp;{$check1[1]}";
				$name1 = $teamname1;
				$flagge1 = "spacer.gif";
			}
			if ($checkgame2 == "W" || $checkgame2 == "S" || $checkgame2 == "L") {
				$check2 = explode('-', $row_nextgames['team_2_id']);
				if ($check2[1] == "A" || $check2[1] == "B" || $check2[1] == "C" || $check2[1] == "D" || $check2[1] == "E" || $check2[1] == "F" || $check1[1] == "G" || $check1[1] == "H") {
					$tabelle = $lang->items['LANG_WM2018_PHP_5'];
				} else {
					$tabelle = $lang->items['LANG_WM2018_PHP_7'];
				}

				if ($check2[0] == "W") {
					$teamname2 = $lang->items['LANG_WM2018_PHP_11'];
				}

				if ($check2[0] == "S") {
					$teamname2 = $lang->items['LANG_WM2018_PHP_12'];
				}

				if ($check2[0] == "L") {
					$teamname2 = $lang->items['LANG_WM2018_PHP_13'];
				}

				$teamname2 .= "&nbsp;$tabelle&nbsp;{$check2[1]}";
				$name2 = $teamname2;
				$flagge2 = "spacer.gif";
			}

			for ($i = 0; $i < count($allids2); $i++) {
				if ($row_nextgames['team_1_id'] == $allids2[$i]) {
					$teamname1 = $allnames2[$i];
					$name1 = "<a href=\"wm2018.php?action=showallgames&amp;teamid={$row_nextgames['team_1_id']}{$SID_ARG_2ND}\">{$teamname1}</a>";
					$flagge1 = $allflags2[$i];
				}
				if ($row_nextgames['team_2_id'] == $allids2[$i]) {
					$teamname2 = $allnames2[$i];
					$name2 = "<a href=\"wm2018.php?action=showallgames&amp;teamid={$row_nextgames['team_2_id']}{$SID_ARG_2ND}\">{$teamname2}</a>";
					$flagge2 = $allflags2[$i];
				}
			}

			//mf Quote
			getQuote($row['gameid']);
			//!mf Quote

			eval("\$wm2018_nextgames .= \"" . $tpl->get("wm2018_sponsor_wm2018_nextgames") . "\";");
		}
		eval("print(\"" . $tpl->get("wm2018_sponsor_portalboxen_wmtippnext5") . "\");");
		break;

	case 'rangliste':
		$result_topuser = $db->query('SELECT u.username,p.* FROM bb' . $n . '_wm2018_userpunkte p LEFT JOIN bb' . $n . "_users u USING (userid) ORDER BY punkte DESC, tipps_gesamt DESC Limit 0,{$wm2018_options['topuser']}");
		while ($row_topuser = $db->fetch_array($result_topuser)) {
			$rowclass = getone($count++, 'tablea', 'tableb');
			if ($count == 1) {
				$krone = '<img src="images/wm2018/krone.gif" alt="krone.gif"><br>';
			} else {
				$krone = '';
			}
			eval('$wm2018_topuser .= "' . $tpl->get('wm2018_sponsor_wm2018_topuser') . '";');
		}

		eval('print("' . $tpl->get('wm2018_sponsor_portalboxen_wmtippbest5') . '");');
		break;
}

eval("print(\"" . $hm_boxtail_tpl . "\");");

?>