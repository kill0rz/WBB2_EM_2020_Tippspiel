<?php 


// Diese Datei beinhaltet den Code für die TippspielMods. Damit muss nur noch diese Datei included werden.

// (C) kill0rz 2019

require_once './em2020_global.php';


// EM2020 *MOD Spieletabelle auf Forenindex* Anfang
// obere Tabelle: Noch nicht getippte Spiele

$result_tableonindex = $db->query("SELECT gameid FROM bb" . $n . "_em2020_spiele WHERE datetime < '" . intval($akttime + 86400) . "' AND datetime > '" . intval($akttime) . "' ORDER BY datetime ASC");
$tableonindex_gameids = array();
while ($row_tableonindex = $db->fetch_array($result_tableonindex)) {
	$tableonindex_gameids[] = $row_tableonindex["gameid"];
}

$tableonindex_gameids_tipped = array();
$result_tableonindex = $db->query("SELECT gameid FROM bb" . $n . "_em2020_usertipps WHERE userid = '" . $wbbuserdata['userid'] . "'");

while ($row_tableonindex = $db->fetch_array($result_tableonindex)) {
	$tableonindex_gameids_tipped[] = $row_tableonindex["gameid"];
}

$tableonindex_gameids_nottippedyet = array();
foreach ($tableonindex_gameids as $tableonindex_gameid) {
	if (!in_array($tableonindex_gameid, $tableonindex_gameids_tipped)) {
		$tableonindex_gameids_nottippedyet[] = $tableonindex_gameid;
	}
}
$result_tableonindex = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE gameid IN ('" .  join("','", $tableonindex_gameids_nottippedyet) . "') ORDER BY datetime ASC");

$em2020_showtableonindex_nontippedgames = false;
while ($row_tableonindex = $db->fetch_array($result_tableonindex)) {
	$em2020_showtableonindex_nontippedgames = true;
	$rowclass = getone($count++, "tablea", "tableb");
	$gamedate = formatdate($wbbuserdata['dateformat'], $row_tableonindex['datetime'], 1);
	$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
	$gametime = formatdate($wbbuserdata['timeformat'], $row_tableonindex['datetime']);

	$checkgame1 = $row_tableonindex['team_1_id']{
		0};
	$checkgame2 = $row_tableonindex['team_2_id']{
		0};
	if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "L") {
		$check1 = explode('-', $row_tableonindex['team_1_id']);
		if ($check1[1] == "A" || $check1[1] == "B" || $check1[1] == "C" || $check1[1] == "D" || $check1[1] == "E" || $check1[1] == "F" || $check1[1] == "G" || $check1[1] == "H") {
			$tabelle = $lang->items['LANG_EM2020_PHP_5'];
		} else {
			$tabelle = $lang->items['LANG_EM2020_PHP_7'];
		}

		if ($check1[0] == "W") {
			$teamname1 = $lang->items['LANG_EM2020_PHP_11'];
		}

		if ($check1[0] == "S") {
			$teamname1 = $lang->items['LANG_EM2020_PHP_12'];
		}

		if ($check1[0] == "L") {
			$teamname1 = $lang->items['LANG_EM2020_PHP_13'];
		}

		$teamname1 .= "&nbsp;{$tabelle}&nbsp;{$check1[1]}";
		$name1 = $teamname1;
		$flagge1 = "spacer.gif";
	}
	if ($checkgame2 == "W" || $checkgame2 == "S" || $checkgame2 == "L") {
		$check2 = explode('-', $row_tableonindex['team_2_id']);
		if ($check2[1] == "A" || $check2[1] == "B" || $check2[1] == "C" || $check2[1] == "D" || $check2[1] == "E" || $check2[1] == "F" || $check2[1] == "G" || $check2[1] == "H") {
			$tabelle = $lang->items['LANG_EM2020_PHP_5'];
		} else {
			$tabelle = $lang->items['LANG_EM2020_PHP_7'];
		}

		if ($check2[0] == "W") {
			$teamname2 = $lang->items['LANG_EM2020_PHP_11'];
		}

		if ($check2[0] == "S") {
			$teamname2 = $lang->items['LANG_EM2020_PHP_12'];
		}

		if ($check2[0] == "L") {
			$teamname2 = $lang->items['LANG_EM2020_PHP_13'];
		}

		$teamname2 .= "&nbsp;{$tabelle}&nbsp;$check2[1]";
		$name2 = $teamname2;
		$flagge2 = "spacer.gif";
	}

	for ($i = 0; $i < count($allids2); $i++) {
		if ($row_tableonindex['team_1_id'] == $allids2[$i]) {
			$teamname1 = $allnames2[$i];
			$name1 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_tableonindex['team_1_id']}{$SID_ARG_2ND}\">{$teamname1}</a>";
			$flagge1 = $allflags2[$i];
		}
		if ($row_tableonindex['team_2_id'] == $allids2[$i]) {
			$teamname2 = $allnames2[$i];
			$name2 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_tableonindex['team_2_id']}{$SID_ARG_2ND}\">{$teamname2}</a>";
			$flagge2 = $allflags2[$i];
		}
	}

	//mf Quote
	$quote1 = 0;
	$quote2 = 0;
	$minusanzahl = 0;

	$result_q = $db->query("SELECT * FROM bb" . $n . "_em2020_usertipps WHERE gameid = " . $row_tableonindex['gameid']);
	while ($row = $db->fetch_array($result_q)) {
		if ($row['goals_1'] > $row['goals_2']) {
			$quote1++;
		} elseif ($row['goals_2'] > $row['goals_1']) {
			$quote2++;
		} else {
			$minusanzahl++;
		}
	}

	list($anzahl) = $db->query_first("SELECT count(*) FROM bb" . $n . "_em2020_usertipps WHERE gameid = " . $row_tableonindex['gameid']);

	$anzahl -= $minusanzahl;
	if ($anzahl > 0) {
		$quote1 = round(($quote1 / $anzahl) * 100, 0);
		$quote2 = round(($quote2 / $anzahl) * 100, 0);
	}
	//!mf Quote

	eval("\$em2020_tableonindex_upper_bit .= \"" . $tpl->get("em2020_tableonindex_upper_bit") . "\";");
}

// untere Tabelle: Letzte X Spiele

$result_tableonindex = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE datetime < '" . $akttime . "' ORDER BY datetime DESC LIMIT {$em2020_options['showtableonindex_donegamescount']};");

if ($db->num_rows($result_tableonindex) < $em2020_options['showtableonindex_donegamescount']) {
	$em2020_showtableonindex_maxdonegames = $db->num_rows($result_tableonindex);
} else {
	$em2020_showtableonindex_maxdonegames = $em2020_options['showtableonindex_donegamescount'];
}

$em2020_showtableonindex_donegames = false;
while ($row_tableonindex = $db->fetch_array($result_tableonindex)) {
	$em2020_showtableonindex_donegames = true;
	$rowclass = getone($count++, "tablea", "tableb");
	$gamedate = formatdate($wbbuserdata['dateformat'], $row_tableonindex['datetime'], 1);
	$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
	$gametime = formatdate($wbbuserdata['timeformat'], $row_tableonindex['datetime']);

	$checkgame1 = $row_tableonindex['team_1_id']{
		0};
	$checkgame2 = $row_tableonindex['team_2_id']{
		0};
	if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "L") {
		$check1 = explode('-', $row_tableonindex['team_1_id']);
		if ($check1[1] == "A" || $check1[1] == "B" || $check1[1] == "C" || $check1[1] == "D" || $check1[1] == "E" || $check1[1] == "F" || $check1[1] == "G" || $check1[1] == "H") {
			$tabelle = $lang->items['LANG_EM2020_PHP_5'];
		} else {
			$tabelle = $lang->items['LANG_EM2020_PHP_7'];
		}

		if ($check1[0] == "W") {
			$teamname1 = $lang->items['LANG_EM2020_PHP_11'];
		}

		if ($check1[0] == "S") {
			$teamname1 = $lang->items['LANG_EM2020_PHP_12'];
		}

		if ($check1[0] == "L") {
			$teamname1 = $lang->items['LANG_EM2020_PHP_13'];
		}

		$teamname1 .= "&nbsp;{$tabelle}&nbsp;{$check1[1]}";
		$name1 = $teamname1;
		$flagge1 = "spacer.gif";
	}
	if ($checkgame2 == "W" || $checkgame2 == "S" || $checkgame2 == "L") {
		$check2 = explode('-', $row_tableonindex['team_2_id']);
		if ($check2[1] == "A" || $check2[1] == "B" || $check2[1] == "C" || $check2[1] == "D" || $check2[1] == "E" || $check2[1] == "F" || $check2[1] == "G" || $check2[1] == "H") {
			$tabelle = $lang->items['LANG_EM2020_PHP_5'];
		} else {
			$tabelle = $lang->items['LANG_EM2020_PHP_7'];
		}

		if ($check2[0] == "W") {
			$teamname2 = $lang->items['LANG_EM2020_PHP_11'];
		}

		if ($check2[0] == "S") {
			$teamname2 = $lang->items['LANG_EM2020_PHP_12'];
		}

		if ($check2[0] == "L") {
			$teamname2 = $lang->items['LANG_EM2020_PHP_13'];
		}

		$teamname2 .= "&nbsp;{$tabelle}&nbsp;$check2[1]";
		$name2 = $teamname2;
		$flagge2 = "spacer.gif";
	}

	for ($i = 0; $i < count($allids2); $i++) {
		if ($row_tableonindex['team_1_id'] == $allids2[$i]) {
			$teamname1 = $allnames2[$i];
			$name1 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_tableonindex['team_1_id']}{$SID_ARG_2ND}\">{$teamname1}</a>";
			$flagge1 = $allflags2[$i];
		}
		if ($row_tableonindex['team_2_id'] == $allids2[$i]) {
			$teamname2 = $allnames2[$i];
			$name2 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_tableonindex['team_2_id']}{$SID_ARG_2ND}\">{$teamname2}</a>";
			$flagge2 = $allflags2[$i];
		}
	}

	//mf Quote
	$quote1 = 0;
	$quote2 = 0;
	$minusanzahl = 0;

	$result_q = $db->query("SELECT * FROM bb" . $n . "_em2020_usertipps WHERE gameid = " . $row_tableonindex['gameid']);
	while ($row = $db->fetch_array($result_q)) {
		if ($row['goals_1'] > $row['goals_2']) {
			$quote1++;
		} elseif ($row['goals_2'] > $row['goals_1']) {
			$quote2++;
		} else {
			$minusanzahl++;
		}
	}

	list($anzahl) = $db->query_first("SELECT count(*) FROM bb" . $n . "_em2020_usertipps WHERE gameid = " . $row_tableonindex['gameid']);

	$anzahl -= $minusanzahl;
	if ($anzahl > 0) {
		$quote1 = round(($quote1 / $anzahl) * 100, 0);
		$quote2 = round(($quote2 / $anzahl) * 100, 0);
	}
	//!mf Quote

	eval("\$lang->items['LANG_EM2020_TPL_INDEX_38'] = \"" . $lang->get4eval("LANG_EM2020_TPL_INDEX_38") . "\";");
	eval("\$em2020_tableonindex_lower_bit .= \"" . $tpl->get("em2020_tableonindex_lower_bit") . "\";");
}
// EM2020 *MOD Spieletabelle auf Forenindex* Ende

 ?>