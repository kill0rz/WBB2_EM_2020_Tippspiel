<?php
/**
 *    MOD                  : WM-2006/2014/EM-2016/WM-2018/EM-2020 Tippspiel
 *    file                 : em2020.php
 *    copyright            : WM2006-Tippspiel © 2006 batida444
 *    copyright            : WM2014-Tippspiel © 2014 Viktor
 *    copyright            : EM2016-Tippspiel © 2016 @ kill0rz
 *    copyright            : WM2018-Tippspiel © 2018 @ kill0rz
 *    copyright            : EM2020-Tippspiel © 2020 @ kill0rz
 *    web                  : www.v-gn.de
 *    Boardversion         : Burning Board wBB 2.3
 */

$filename = "em2020.php";

require "./global.php";
require_once "./em2020_global.php";
include "./acp/em2020_gameids.php";
$lang->load("EM2020");

if (isset($_REQUEST['action'])) {
	$action = trim($_REQUEST['action']);
} else {
	$action = "index";
}

if ($em2020_options['em2020aktiv'] == 0 || !$wbbuserdata['can_em2020_see']) {
	redirect($lang->get("LANG_EM2020_PHP_1"), $url = "index.php" . $SID_ARG_1ST);
}

$em2020userdata = $db->query_first("SELECT userid,tipp_em,tipp_vem FROM bb" . $n . "_em2020_userpunkte WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
if ($em2020userdata['tipp_em'] != 0) {
	$userwmtipp = $em2020userdata['tipp_em'];
}

if ($em2020userdata['tipp_vem'] != 0) {
	$uservwmtipp = $em2020userdata['tipp_vem'];
}

if (!empty($em2020userdata['userid'])) {
	$userdatayes = 1;
}

if ($em2020_options['gh_aktiv'] == 1) {
	$waehrung = $db->query_first("SELECT waehrung FROM bb" . $n . "_guthaben");
	$waehrung = $waehrung['waehrung'];
}

$lastgame4emtipp = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . intval($em2020_options['lastgame4emtipp']) . "'");
$lastgamedate = formatdate($wbbuserdata['dateformat'], $lastgame4emtipp['datetime']);
$lastgametime = formatdate($wbbuserdata['timeformat'], $lastgame4emtipp['datetime']);

// ++++++++++++++++++
// +++ Startseite +++
// ++++++++++++++++++
if ($action == "index") {
	require_once "./em2020_modcode.php";
	// FIFA/UEFA News Anfang
	if ($em2020_options['showrssnews'] == 1) {
		if ($em2020_options['rssnews_showfeed'] == "fifa") {
			$count = "0";
			$newsem2020total = "";
			$feedurl = "http://de.fifa.com/worldcup/news/rss.xml";
			if ($em2020_options['showrssnews_method'] == "0" && function_exists('curl_version')) {
				$data = file_get_contents($feedurl);
			} else {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $feedurl);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$data = curl_exec($ch);
				curl_close($ch);
			}
			preg_match_all("/<item>(.+)<\/item>/sU", $data, $items);
			foreach ($items[1] as $item) {
				$count++;
				if ($count <= $em2020_options['rssnews']) {
					preg_match("/<title>(.+)<\/title>/U", $item, $title);
					preg_match("/<link>(.+)<\/link>/U", $item, $link);
					$title1 = $title[1];
					$title1 = substr($title1, 9);
					$title1 = substr($title1, 0, -3);
					// $title1 = utf8_decode($title1);
					$title2 = $title1;
					if (wbb_strlen($title1) > 50) {
						$title1 = wbb_substr($title1, 0, 50) . "...";
					}

					$newsem2020total .= "&raquo; <a href=\"{$link[1]}\" target=\"_blank\" title=\"{$title2}\">{$title1}</a><br />";
				}
			}
		} else {
			/*
				 * FeedImport: Importiere RSS 2.0-Feeds und gib die Inhalte aus
				 * Quelle: http:/www-coding.de/rss-feed-import-mit-php/
				 * (hier findest du auch Beispiele und Erläuterungen)
			*/

			class RSSImport {
				private $__feedInfo = array(), $feedItems = array();

				// Konstruktor: Verarbeitung des Feeds aus $feedUrl //
				public function __construct($feedUrl) {
					$xml = simplexml_load_file($feedUrl, 'SimpleXMLElement', LIBXML_NOCDATA);

					if (!$xml) {
						// Fehler: Es handelt es sich um kein gültiges XML-Dokument //
						return false;
					} else {
						// Feed-Informationen speichern //
						$this->feedInfo['title'] = $xml->channel->title[0];
						$this->feedInfo['link'] = $xml->channel->link[0];

						if (isset($xml->channel->description)) {
							$this->feedInfo['description'] = $xml->channel->description[0];
						}

						if (isset($xml->channel->lastBuildDate)) {
							$this->feedInfo['updated'] = $xml->channel->lastBuildDate[0];
						}

						// Einträge speichern //
						$this->__saveItems($xml);
					}
				}

				// Liefert die Feed-Informationen für ein Element, z.B. 'title' oder für alle (false) aus //
				public function getFeedInfo($element = false) {
					if ($element && isset($this->feedInfo[$element])) {
						// Einzelnes Element zurückgeben //
						return $this->feedInfo[$element];
					} elseif (!$element) {
						// Komplettes Array zurückgeben //
						return $this->feedInfo;
					}

					// Keine Ausgabe -> Fehler //
					return false;
				}

				// Liefert die Informationen als Array für einen Eintrag mit der ID $id oder für alle (false) //
				public function getItems($id = false) {
					if ($id && isset($this->feedItems)) {
						// Informationen für einen Eintrag //
						return $this->feedItems[$id];
					} elseif (!$id) {
						// Informationen für alle Einträge //
						return $this->feedItems;
					}

					// Keine Ausgabe -> Fehler //
					return false;
				}

				// Speichern der einzelnen RSS-Einträge in $this -> feedItems //
				private function __saveItems($xml) {
					foreach ($xml->channel->item as $item) {
						// Zeit in einen Timestamp umwandeln //
						$itemDate = DateTime::createFromFormat('D, d M Y H:i:s O', $item->pubDate);

						$this->feedItems[] = array(
							'title' => $item->title,
							'link' => $item->link,
							'published' => $itemDate->format('U'),
							'content' => $item->description,
						);
					}
				}
			}

			$count = "0";
			$newsem2020total = "";
			$feed = new RSSImport('http://de.uefa.com/rssfeed/news/rss.xml');
			if ($feed) {
				$items = $feed->getItems();
				foreach ($items AS $item) {
					$count++;
					if ($count <= $em2020_options['rssnews']) {
						$newsem2020total .= "&raquo; <a href='{$item['link']}' target='_blank' title='{$item['title']}''>" . $item['title'] . "</a><br />";
					}
				}
			}
		}
	}
	// FIFA/UEFA News Ende

	// Persönliche Box Anfang
	if ($wbbuserdata['userid']) {
		$result_userdata = $db->query_first("SELECT * FROM bb" . $n . "_em2020_userpunkte WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
		if (!$result_userdata['tipps_gesamt']) {
			$tippsgesamt = $lang->items['LANG_EM2020_PHP_2'];
		} else {
			$tippsgesamt = "<b><a href=\"em2020.php?action=showusertippsdetail&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\">{$result_userdata['tipps_gesamt']}</a></b>";
		}
		eval("\$lang->items['LANG_EM2020_TPL_INDEX_4'] = \"" . $lang->get4eval("LANG_EM2020_TPL_INDEX_4") . "\";");
	}
	// Persönliche Box Ende

	// Next X Games Anfang
	$result_nextgames = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE datetime > '" . intval($akttime) . "' ORDER BY datetime ASC Limit 0,{$em2020_options['nextxgames']}");
	while ($row_nextgames = $db->fetch_array($result_nextgames)) {
		$rowclass = getone($count++, "tablea", "tableb");
		$gamedate = formatdate($wbbuserdata['dateformat'], $row_nextgames['datetime'], 1);
		$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
		$gametime = formatdate($wbbuserdata['timeformat'], $row_nextgames['datetime']);

		$checkgame1 = $row_nextgames['team_1_id']{
			0};
		$checkgame2 = $row_nextgames['team_2_id']{
			0};
		if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "L") {
			$check1 = explode('-', $row_nextgames['team_1_id']);
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
			$check2 = explode('-', $row_nextgames['team_2_id']);
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
			if ($row_nextgames['team_1_id'] == $allids2[$i]) {
				$teamname1 = $allnames2[$i];
				$name1 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_nextgames['team_1_id']}{$SID_ARG_2ND}\">{$teamname1}</a>";
				$flagge1 = $allflags2[$i];
			}
			if ($row_nextgames['team_2_id'] == $allids2[$i]) {
				$teamname2 = $allnames2[$i];
				$name2 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_nextgames['team_2_id']}{$SID_ARG_2ND}\">{$teamname2}</a>";
				$flagge2 = $allflags2[$i];
			}
		}

		//mf Quote
		getQuote($row_nextgames['gameid']);
		//!mf Quote

		eval("\$em2020_nextgames .= \"" . $tpl->get("em2020_nextgames") . "\";");
	}
	// Next X Games Ende

	// WM beendet ?
	if ($em2020_options['1st'] > 0) {
		$result_1st = $db->query_first("SELECT name, flagge FROM bb" . $n . "_em2020_teams WHERE teamid = '" . intval($em2020_options['1st']) . "'");
		$result_2nd = $db->query_first("SELECT name, flagge FROM bb" . $n . "_em2020_teams WHERE teamid = '" . intval($em2020_options['2nd']) . "'");
	}
	// WM beendet ?

	// Gruppentabelle Anfang
	if (isset($_REQUEST['gruppensort'])) {
		$gruppensort = wbb_trim($_REQUEST['gruppensort']);
	} else {
		$gruppensort = "A";
	}

	$gruppensort = substr($gruppensort, 0, 1);
	$result_gruppentabelle = $db->query("SELECT * FROM bb" . $n . "_em2020_teams WHERE gruppe = '" . addslashes($gruppensort) . "' ORDER BY punkte DESC, td DESC, g DESC");
	while ($row_gruppentabelle = $db->fetch_array($result_gruppentabelle)) {
		$rowclass = getone($count++, "tablea", "tableb");
		eval("\$em2020_gruppentabelle .= \"" . $tpl->get("em2020_gruppentabelle") . "\";");
	}
	// Gruppentabelle Ende

	// Punkteverteilung Anfang
	$result_punkte = $db->query("SELECT * FROM bb" . $n . "_em2020_punkte ORDER BY punkteid");
	$em2020_punkte = '';
	while ($row_punkte = $db->fetch_array($result_punkte)) {
		$rowclass = getone($count++, "tablea", "tableb");
		if ($row_punkte['punkteid'] == 2 && $em2020_options['tendenz'] == 0) {
			$count++;
		} elseif ($row_punkte['punkteid'] == 3 && $em2020_options['gk_jn'] == 0) {
			$count++;
		} elseif ($row_punkte['punkteid'] == 4 && $em2020_options['rk_jn'] == 0) {
			$count++;
		} elseif ($row_punkte['punkteid'] == 5 && $em2020_options['elfer_jn'] == 0) {
			$count++;
		} elseif (($row_punkte['punkteid'] == 6 || $row_punkte['punkteid'] == 7) && $em2020_options['winnertipp_jn'] == 0) {
			$count++;
		} else {
			eval("\$em2020_punkte .= \"" . $tpl->get("em2020_punkte") . "\";");
		}

	}
	// Punkteverteilung Ende

	// Top-X-User Anfang
	$count = 0;
	$result_topuser = $db->query("SELECT u.username,p.* FROM bb" . $n . "_em2020_userpunkte p LEFT JOIN bb" . $n . "_users u USING (userid) ORDER BY punkte DESC, ((tipps_richtig+tipps_tendenz)/tipps_falsch) DESC,tipps_gesamt DESC Limit 0,{$em2020_options['topuser']}");
	while ($row_topuser = $db->fetch_array($result_topuser)) {
		$rowclass = getone($count++, "tablea", "tableb");
		//** Ranking Start *//
		$em2020_rank_merk = $em2020_rank_merk + 1;
		if ($em2020_punkte_merk != $row_topuser['punkte']) {
			$em2020_rank = $em2020_rank_merk;
			$em2020_punkte_merk = $row_topuser['punkte'];
		}
		if ($em2020_rank == 1) {
			$em2020_userrank = "<img src=\"images/em2020/em2020_rank_1.gif\" border=\"0\" alt=\"em2020_rank_1.gif\" title=\"\" />";
		}

		if ($em2020_rank == 2) {
			$em2020_userrank = "<img src=\"images/em2020/em2020_rank_2.gif\" border=\"0\" alt=\"em2020_rank_2.gif\" title=\"\" />";
		}

		if ($em2020_rank == 3) {
			$em2020_userrank = "<img src=\"images/em2020/em2020_rank_3.gif\" border=\"0\" alt=\"em2020_rank_3.gif\" title=\"\" />";
		}

		if ($em2020_rank > 3) {
			$em2020_userrank = "<b>$em2020_rank</b>";
		}
		//** Ranking Ende *//

		$richtig = $row_topuser['tipps_richtig'] + $row_topuser['tipps_tendenz'];
		if (($richtig + $row_topuser['tipps_falsch']) > 0) {
			$quote = round($richtig * 100 / ($richtig + $row_topuser['tipps_falsch']));
		} else {
			$quote = 0;
		}

		// Tageswertung *Anfang*
		$vortag = $db->query_first("SELECT userid,pos,punkte FROM bb" . $n . "_em2020_vortag WHERE userid = '" . intval($row_topuser['userid']) . "'");

		$tagerg = $row_topuser['punkte'] - $vortag['punkte'];
		if ($tagerg >= 0) {
			$tagerg = "+" . $tagerg;
		}

		if (!isset($vortag['pos']) || $vortag['pos'] > $em2020_rank) {
			$tagtendenz = "<img src=\"images/em2020/hoch.jpg\" alt='hoch'>";
		} elseif ($vortag['pos'] == $em2020_rank) {
			$tagtendenz = "<img src=\"images/em2020/gleich.gif\" alt='gleich'>";
		} else {
			$tagtendenz = "<img src=\"images/em2020/runter.jpg\" alt='runter'>";
		}

		if ($em2020_rank == 1) {
			$krone = "<img src=\"images/em2020/krone.gif\" alt='krone'>";
		} else {
			$krone = "";
		}
		// Tageswertung *Ende*

		eval("\$em2020_topuser .= \"" . $tpl->get("em2020_topuser") . "\";");
	}

	//** Weltmeisterquote Start **//
	$em2020_meisterquote = '';
	$wmtipp_tipps_gesamt = '';
	list($wmtipp_tipps_gesamt) = $db->query_first("SELECT COUNT(tipp_em) FROM bb" . $n . "_em2020_userpunkte WHERE tipp_em > 0");
	$result = $db->query("SELECT tipp_em, COUNT(tipp_em) AS anzahl FROM bb" . $n . "_em2020_userpunkte
						WHERE tipp_em > 0
						GROUP BY tipp_em
						ORDER BY anzahl DESC");
	while ($quote_wmtipp = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		for ($i = 0; $i < count($allids2); $i++, $count++) {
			if ($quote_wmtipp['tipp_em'] == $allids2[$i]) {
				$teamname1 = $allnames2[$i];
				$name1 = $teamname1;
				$flagge1 = $allflags2[$i];
				//** gleiche Tipps zählen
				$wmtipp_tipps = $quote_wmtipp['anzahl'];
				//** Quote berechnen
				$wmtipp_quote = round($wmtipp_tipps * 100 / $wmtipp_tipps_gesamt);
			}
		}
		eval("\$em2020_meisterquote .= \"" . $tpl->get("em2020_meisterquote") . "\";");
	}
	//** Weltmeisterquote Ende **//

	// Top-X-User Ende

	// Offene Ergebnisse Anfang
	$result_nextgames = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE datetime+6300 < '" . intval($akttime) . "' AND game_goals_1 = '' AND game_goals_1 = '' ORDER BY datetime ASC Limit 0,{$em2020_options['nonaddedgamescount']};");
	while ($row_nextgames = $db->fetch_array($result_nextgames)) {
		$em2020_nonaddedgameresults = true;
		$rowclass = getone($count++, "tablea", "tableb");
		$gamedate = formatdate($wbbuserdata['dateformat'], $row_nextgames['datetime'], 1);
		$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
		$gametime = formatdate($wbbuserdata['timeformat'], $row_nextgames['datetime']);

		$checkgame1 = $row_nextgames['team_1_id']{
			0};
		$checkgame2 = $row_nextgames['team_2_id']{
			0};
		if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "L") {
			$check1 = explode('-', $row_nextgames['team_1_id']);
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
			$check2 = explode('-', $row_nextgames['team_2_id']);
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
			if ($row_nextgames['team_1_id'] == $allids2[$i]) {
				$teamname1 = $allnames2[$i];
				$name1 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_nextgames['team_1_id']}{$SID_ARG_2ND}\">{$teamname1}</a>";
				$flagge1 = $allflags2[$i];
			}
			if ($row_nextgames['team_2_id'] == $allids2[$i]) {
				$teamname2 = $allnames2[$i];
				$name2 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_nextgames['team_2_id']}{$SID_ARG_2ND}\">{$teamname2}</a>";
				$flagge2 = $allflags2[$i];
			}
		}

		//mf Quote
		getQuote($row_nextgames['gameid']);
		//!mf Quote

		eval("\$em2020_nonaddedgames .= \"" . $tpl->get("em2020_nonaddedgames") . "\";");
	}
	// Next X Games Ende
	// Offene Ergebnisse Ende

	// Aktuell laufende Spiele Anfang
	$result_nextgames = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE datetime < '" . intval($akttime) . "' AND datetime+6300 > '" . intval($akttime) . "' AND game_goals_1 = '' AND game_goals_1 = '' ORDER BY datetime ASC Limit 0,{$em2020_options['currentgamescount']};");
	while ($row_nextgames = $db->fetch_array($result_nextgames)) {
		$em2020_currentgameplaying = true;
		$rowclass = getone($count++, "tablea", "tableb");
		$gamedate = formatdate($wbbuserdata['dateformat'], $row_nextgames['datetime'], 1);
		$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
		$gametime = formatdate($wbbuserdata['timeformat'], $row_nextgames['datetime']);

		$checkgame1 = $row_nextgames['team_1_id']{
			0};
		$checkgame2 = $row_nextgames['team_2_id']{
			0};
		if ($checkgame1 == "W" || $checkgame1 == "S" || $checkgame1 == "L") {
			$check1 = explode('-', $row_nextgames['team_1_id']);
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
			$check2 = explode('-', $row_nextgames['team_2_id']);
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
			if ($row_nextgames['team_1_id'] == $allids2[$i]) {
				$teamname1 = $allnames2[$i];
				$name1 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_nextgames['team_1_id']}{$SID_ARG_2ND}\">{$teamname1}</a>";
				$flagge1 = $allflags2[$i];
			}
			if ($row_nextgames['team_2_id'] == $allids2[$i]) {
				$teamname2 = $allnames2[$i];
				$name2 = "<a href=\"em2020.php?action=showallgames&amp;teamid={$row_nextgames['team_2_id']}{$SID_ARG_2ND}\">{$teamname2}</a>";
				$flagge2 = $allflags2[$i];
			}
		}

		//mf Quote
		getQuote($row_nextgames['gameid']);
		//!mf Quote

		eval("\$em2020_currentgames .= \"" . $tpl->get("em2020_currentgames") . "\";");
	}
	// Next X Games Ende
	// Aktuell laufende Spiele Ende

	eval("\$lang->items['LANG_EM2020_TPL_INDEX_8'] = \"" . $lang->get4eval("LANG_EM2020_TPL_INDEX_8") . "\";");
	eval("\$lang->items['LANG_EM2020_TPL_INDEX_32'] = \"" . $lang->get4eval("LANG_EM2020_TPL_INDEX_32") . "\";");
	eval("\$tpl->output(\"" . $tpl->get("em2020_index") . "\");");
}

// +++++++++++++++++
// ++ Ergebnisse +++
// +++++++++++++++++
if ($action == "showresults") {
	if (isset($_REQUEST['auswahl'])) {
		$auswahl = intval($_REQUEST['auswahl']);
	} else {
		// Prüfen, ob ein Tab vorausgewählt werden kann
		// Keinen Tab wählen, wenn WM vorbei ist
		if ($em2020_options['1st'] == 0) {
			$curr_timestamp = time();
			$auswahl = "1";

			// Achtelfinale
			$result = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid=" . intval($gameids['achtelfinal1']) . ";");
			if ($result['datetime'] < $curr_timestamp) {
				$auswahl = "2";
			}

			// Viertelfinale
			$result = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid=" . intval($gameids['viertelfinal1']) . ";");
			if ($result['datetime'] < $curr_timestamp) {
				$auswahl = "3";
			}

			// Halbfinale
			$result = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid=" . intval($gameids['halbfinal1']) . ";");
			if ($result['datetime'] < $curr_timestamp) {
				$auswahl = "4";
			}

			// Spiel um Platz 3
			$result = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid=" . intval($gameids['spielumplatzdrei']) . ";");
			if ($result['datetime'] < $curr_timestamp) {
				$auswahl = "5";
			}

			// Finale
			$result = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid=" . intval($gameids['finale']) . ";");
			if ($result['datetime'] < $curr_timestamp) {
				$auswahl = "6";
			}
		} else {
			$auswahl = "1";
		}
	}

	if ($auswahl == 1) {
		$gruppen = implode($gruppenids, ",");
		$type = $lang->items['LANG_EM2020_PHP_3'];
	}
	if ($auswahl == 2) {
		$gruppen = "8";
		$type = $lang->items['LANG_EM2020_PHP_4'];
		$tabelle = $lang->items['LANG_EM2020_PHP_5'];
	}
	if ($auswahl == 3) {
		$gruppen = "4";
		$type = $lang->items['LANG_EM2020_PHP_6'];
		$tabelle = $lang->items['LANG_EM2020_PHP_7'];
	}
	if ($auswahl == 4) {
		$gruppen = "2";
		$type = $lang->items['LANG_EM2020_PHP_8'];
		$tabelle = $lang->items['LANG_EM2020_PHP_7'];
	}
	if ($auswahl == 5) {
		$gruppen = "3";
		$type = $lang->items['LANG_EM2020_PHP_9'];
		$tabelle = $lang->items['LANG_EM2020_PHP_7'];
	}
	if ($auswahl == 6) {
		$gruppen = "1";
		$type = $lang->items['LANG_EM2020_PHP_10'];
		$tabelle = $lang->items['LANG_EM2020_PHP_7'];
	}
	$result_gruppen = explode(',', $gruppen);
	for ($rg = 0; $rg < count($result_gruppen); $rg++) {
		if ($auswahl == 1) {
			$type .= $result_gruppen[$rg];
		}

		$result = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE gruppe = '" . $result_gruppen[$rg] . "' ORDER BY datetime ASC");
		while ($row = $db->fetch_array($result)) {
			$rowclass = getone($count++, "tablea", "tableb");
			$gamedate = formatdate($wbbuserdata['dateformat'], $row['datetime'], 1);
			$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
			$gametime = formatdate($wbbuserdata['timeformat'], $row['datetime']);
			$flagge1 = "spacer.gif";
			$flagge2 = "spacer.gif";
			for ($i = 0; $i < count($allids2); $i++) {
				if ($row['team_1_id'] == $allids2[$i]) {
					$name1 = $allnames2[$i];
					$flagge1 = $allflags2[$i];
					$done1 = 1;
				}
				if ($row['team_2_id'] == $allids2[$i]) {
					$name2 = $allnames2[$i];
					$flagge2 = $allflags2[$i];
					$done2 = 1;
				}
			}
			if ($done1 == 0) {
				$result_vorrunde = explode('-', $row['team_1_id']);
				if ($result_vorrunde[0] == "W") {
					$name1 = $lang->items['LANG_EM2020_PHP_11'];
				}

				if ($result_vorrunde[0] == "S") {
					$name1 = $lang->items['LANG_EM2020_PHP_12'];
				}

				if ($result_vorrunde[0] == "V") {
					$name1 = $lang->items['LANG_EM2020_PHP_13'];
				}

				$name1 .= "&nbsp;{$tabelle}&nbsp;{$result_vorrunde[1]}";
			}
			if ($done2 == 0) {
				$result_vorrunde = explode('-', $row['team_2_id']);
				if ($result_vorrunde[0] == "W") {
					$name2 = $lang->items['LANG_EM2020_PHP_11'];
				}

				if ($result_vorrunde[0] == "S") {
					$name2 = $lang->items['LANG_EM2020_PHP_12'];
				}

				if ($result_vorrunde[0] == "V") {
					$name2 = $lang->items['LANG_EM2020_PHP_13'];
				}

				$name2 .= "&nbsp;{$tabelle}&nbsp;{$result_vorrunde[1]}";
			}
			$gamedetails = '';
			if ($row['game_goals_1'] != '' && $row['game_goals_2'] != '') {
				$gamedetails = "<a href=\"em2020.php?action=gamedetails&amp;gameid={$row['gameid']}{$SID_ARG_2ND}\"><img src=\"images/em2020/details.gif\" border=\"0\"alt=\"{$lang->items['LANG_EM2020_PHP_14']}\" title=\"{$lang->items['LANG_EM2020_PHP_14']}\"></a>";
			}

			if ($row['tipps'] > 0) {
				$spieltipps = "<a href=\"em2020.php?action=tippsprogame&amp;gameid={$row['gameid']}{$SID_ARG_2ND}\">{$row['tipps']}</a>";
			} else {
				$spieltipps = $row['tipps'];
			}

			//mf Quote
			getQuote($row['gameid']);
			//!mf Quote

			eval("\$em2020_showresult_bit_bit .= \"" . $tpl->get("em2020_showresult_bit_bit") . "\";");
			$done1 = 0;
			$done2 = 0;
		}
		eval("\$em2020_showresult_bit .= \"" . $tpl->get("em2020_showresult_bit") . "\";");
		$em2020_showresult_bit_bit = '';
		if ($auswahl == 1) {
			$type = substr("$type", 0, -1);
		}

	}
	eval("\$tpl->output(\"" . $tpl->get("em2020_showresults") . "\");");
}
// +++++++++++++++++++++
// ++ Tipp-Übersicht +++
// +++++++++++++++++++++
if ($action == "maketipp") {
	if (!$wbbuserdata['can_em2020_use']) {
		redirect($lang->get("LANG_EM2020_PHP_15"), $url = "index.php" . $SID_ARG_1ST);
	}

	if (isset($_REQUEST['games_art'])) {
		$games_art = intval($_REQUEST['games_art']);
	} else {
		$games_art = "1";
	}

	if ($games_art == 1) {
		$gamesart = $lang->items['LANG_EM2020_PHP_16'];
	}

	if ($games_art == 2) {
		$gamesart = $lang->items['LANG_EM2020_PHP_17'];
	}

	$serverdate = formatdate($wbbuserdata['dateformat'], $akttime);
	$servertime = formatdate($wbbuserdata['timeformat'], $akttime);
	$tipptime2 = $akttime + $em2020_options['tipptime'];
	$templatetime = $em2020_options['tipptime'] / 60;
	// regex is to test whether i valid team is aleady known and hide non-tippable games from table
	$result = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE game_goals_1 = '' AND game_goals_2 = '' AND team_1_id IS NOT NULL AND team_2_id IS NOT NULL AND team_1_id REGEXP '^-?[0-9]+$' AND team_2_id REGEXP '^-?[0-9]+$' AND datetime > {$tipptime2} ORDER BY datetime ASC");
	while ($row = $db->fetch_array($result)) {
		unset($name1);
		unset($flagge1);
		unset($flagge2);
		unset($name2);
		$rowclass = getone($count++, "tablea", "tableb");
		$date = formatdate($wbbuserdata['dateformat'], $row['datetime'], 1);
		$time = formatdate($wbbuserdata['timeformat'], $row['datetime']);
		$timetipp = $row['datetime'] - $em2020_options['tipptime'];
		$date2 = formatdate($wbbuserdata['dateformat'], $timetipp, 1);
		$time2 = formatdate($wbbuserdata['timeformat'], $timetipp);
		if ($row['gruppe'] == 'A' || 'B' || 'C' || 'D' || 'E' || 'F' || 'G' || 'H') {
			$type = $lang->items['LANG_EM2020_PHP_18'];
		}

		if ($row['gruppe'] == '8') {
			$type = $lang->items['LANG_EM2020_PHP_4'];
		}

		if ($row['gruppe'] == '4') {
			$type = $lang->items['LANG_EM2020_PHP_6'];
		}

		if ($row['gruppe'] == '2') {
			$type = $lang->items['LANG_EM2020_PHP_8'];
		}

		if ($row['gruppe'] == '3') {
			$type = $lang->items['LANG_EM2020_PHP_9'];
		}

		if ($row['gruppe'] == '1') {
			$type = $lang->items['LANG_EM2020_PHP_10'];
		}

		for ($i = 0; $i < count($allids2); $i++) {
			if ($row['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
			}
			if ($row['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
			}
		}
		if ((!in_array($row['gameid'], $allusertippgameids2) && ($games_art == 1 && $outputcount < 10)) || ($games_art == 2 && !in_array($row['gameid'], $allusertippgameids2))) {
			$outputcount++;
			eval("\$em2020_maketipp_bit .= \"" . $tpl->get("em2020_maketipp_bit") . "\";");
		} else {
			$count++;
		}
	}

	//check if wm and vwm tipp still possible
	$result = $db->query("SELECT gameid FROM bb" . $n . "_em2020_spiele WHERE team_1_id AND team_2_id AND game_goals_1 != '' AND game_goals_2 != '' ORDER BY datetime ASC");
	$lastgametipped = $db->num_rows($result);

	if ($em2020_options['winnertipp_jn'] == 1 && $em2020_options['lastgame4emtipp'] > $lastgametipped) {
		eval("\$em2020_maketipp_bit_bit .= \"" . $tpl->get("em2020_maketipp_bit_bit") . "\";");
	}

	eval("\$em2020_maketipp_bit_bit_bit .= \"" . $tpl->get("em2020_maketipp_bit_bit_bit") . "\";");

	eval("\$lang->items['LANG_EM2020_TPL_MAKETIPP_5'] = \"" . $lang->get4eval("LANG_EM2020_TPL_MAKETIPP_5") . "\";");
	eval("\$lang->items['LANG_EM2020_TPL_MAKETIPP_7'] = \"" . $lang->get4eval("LANG_EM2020_TPL_MAKETIPP_7") . "\";");
	eval("\$tpl->output(\"" . $tpl->get("em2020_maketipp") . "\");");
}
// +++++++++++++++++++
// ++ Tipp abgeben +++
// +++++++++++++++++++
if ($action == "tippabgabe") {
	if (!$wbbuserdata['can_em2020_use']) {
		redirect($lang->get("LANG_EM2020_PHP_15"), $url = "index.php" . $SID_ARG_1ST);
	}

	if (isset($_POST['send'])) {
		// Erneute Prüfung der Tippabgabezeit
		$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . intval($_POST['gameid']) . "'");
		$time2 = $result_time['datetime'] - $em2020_options['tipptime'];
		if ($akttime > $time2) {
			redirect($lang->get("LANG_EM2020_PHP_20"), $url = "em2020.php?action=maketipp" . $SID_ARG_2ND);
		}

		// Prüfen, ob User schon dieses Spiel getippt hat
		$tipp_exist = $db->query_first("SELECT gameid FROM bb" . $n . "_em2020_usertipps WHERE userid = '" . intval($wbbuserdata['userid']) . "' AND gameid = '" . intval($_POST['gameid']) . "'");
		if ($tipp_exist['gameid']) {
			redirect($lang->get("LANG_EM2020_PHP_43"), $url = "em2020.php?action=maketipp" . $SID_ARG_2ND);
		}

		// Prüfen ob Achtelfinale, Viertelfinale, Halbfinale oder Finale und Tipp unentschieden
		if (intval($_POST['gameid']) > $gameids['vorrundenspiel'] && intval($_POST['tipp_1']) == intval($_POST['tipp_2'])) {
			redirect($lang->get("LANG_EM2020_PHP_41"), $url = "em2020.php?action=tippabgabe&amp;gameid={$_POST['gameid']}" . $SID_ARG_2ND);
		}

		// +++++++++++++++++++++++++++++++++++
		$tippok = '1';
		$gk = '-1';
		$rk = '-1';
		$elfer = '-1';
		if (!preg_match("/^[0-9]{1,}/", $_POST['tipp_1'])) {
			$tippok = 0;
		}

		if (!preg_match("/^[0-9]{1,}/", $_POST['tipp_2'])) {
			$tippok = 0;
		}

		if ($em2020_options['gk_jn'] == 1 && $_POST['tipp_gk'] == -1) {
			$tippok = 0;
		} elseif ($em2020_options['gk_jn'] == 1 && $_POST['tipp_gk'] != -1) {
			$gk = $_POST['tipp_gk'];
		}
		if ($em2020_options['rk_jn'] == 1 && $_POST['tipp_rk'] == -1) {
			$tippok = 0;
		} elseif ($em2020_options['rk_jn'] == 1 && $_POST['tipp_rk'] != -1) {
			$rk = $_POST['tipp_rk'];
		}
		if ($em2020_options['elfer_jn'] == 1 && $_POST['tipp_elfer'] == -1) {
			$tippok = 0;
		} elseif ($em2020_options['elfer_jn'] == 1 && $_POST['tipp_elfer'] != -1) {
			$elfer = $_POST['tipp_elfer'];
		}
		if ($tippok == 1) {
			$db->unbuffered_query("INSERT INTO bb" . $n . "_em2020_usertipps (userid,gameid,goals_1,goals_2,gk,rk,elfer) VALUES ('" . intval($wbbuserdata['userid']) . "','" . intval($_POST['gameid']) . "','" . intval($_POST['tipp_1']) . "','" . intval($_POST['tipp_2']) . "','" . intval($gk) . "','" . intval($rk) . "','" . intval($elfer) . "')");
			if ($userdatayes == 1) {
				$db->unbuffered_query("UPDATE bb" . $n . "_em2020_userpunkte SET tipps_gesamt=tipps_gesamt+1 WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
			}
			if ($userdatayes == 0) {
				$db->unbuffered_query("INSERT INTO bb" . $n . "_em2020_userpunkte (userid,punkte,tipps_gesamt,tipps_richtig,tipps_falsch,tipps_tendenz,tipp_em,tipp_vem) VALUES ('" . intval($wbbuserdata['userid']) . "','0','1','0','0','0','0','0')");
			}
			// Guthaben aktiv ? Dann speichern
			if ($em2020_options['gh_aktiv'] == 1) {
				$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2020_PHP_21'] . "#" . intval($_POST['gameid']) . ")','" . $em2020_options['gh_ab_normtipp'] . "','" . $lang->items['LANG_EM2020_PHP_22'] . "')");
				$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2020_options['gh_ab_normtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
			}
			// +++++++++++++++++++++++++++++++
			$db->unbuffered_query("UPDATE bb" . $n . "_em2020_spiele SET tipps=tipps+1 WHERE gameid = '" . intval($_POST['gameid']) . "'");
			header("Location: em2020.php?action=tipok{$SID_ARG_2ND_UN}");
		} else {
			$error = $lang->items['LANG_EM2020_PHP_23'];
		}
	}
	// Prüfen ob Guthaben aktiv und noch genug Guthaben vorhanden
	if ($em2020_options['gh_aktiv'] == 1) {
		if ($wbbuserdata['guthaben'] < $em2020_options['gh_ab_normtipp']) {
			redirect($lang->get("LANG_EM2020_PHP_24"), $url = "em2020.php?action=maketipp" . $SID_ARG_2ND);
		}

	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// Prüfen, ob User schon dieses Spiel getippt hat
	$tipp_exist = $db->query_first("SELECT gameid FROM bb" . $n . "_em2020_usertipps WHERE userid = '" . intval($wbbuserdata['userid']) . "' AND gameid = '" . intval($_REQUEST['gameid']) . "'");
	if ($tipp_exist['gameid']) {
		redirect($lang->get("LANG_EM2020_PHP_43"), $url = "em2020.php?action=maketipp" . $SID_ARG_2ND);
	}

	$result_game = $db->query_first("SELECT * FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	$date = formatdate($wbbuserdata['dateformat'], $result_game['datetime'], 1);
	$time = formatdate($wbbuserdata['timeformat'], $result_game['datetime']);
	for ($i = 0; $i < count($allids2); $i++) {
		if ($result_game['team_1_id'] == $allids2[$i]) {
			$name1 = $allnames2[$i];
			$flagge1 = $allflags2[$i];
		}
		if ($result_game['team_2_id'] == $allids2[$i]) {
			$name2 = $allnames2[$i];
			$flagge2 = $allflags2[$i];
		}
	}
	if ($em2020_options['winnertipp_jn'] == 1) {
		if ($userwmtipp == 0) {
			for ($i = 0; $i < count($allids2); $i++) {
				if ($userwmtipp != $allids2[$i]) {
					eval("\$em2020_auswahl_wmtipp .= \"" . $tpl->get("em2020_auswahl_wmtipp") . "\";");
				}
			}
			eval("\$lang->items['LANG_EM2020_TPL_TIPPABGABE_WM_2'] = \"" . $lang->get4eval("LANG_EM2020_TPL_TIPPABGABE_WM_2") . "\";");
			eval("\$em2020_tippabgabe_wm .= \"" . $tpl->get("em2020_tippabgabe_wm") . "\";");
		}
	}
	if ($em2020_options['winnertipp_jn'] == 1) {
		if ($uservwmtipp == 0) {
			for ($j = 0; $j < count($allids2); $j++) {
				if ($uservwmtipp != $allids2[$j]) {
					eval("\$em2020_auswahl_vwmtipp .= \"" . $tpl->get("em2020_auswahl_vwmtipp") . "\";");
				} else {
					eval("\$em2020_auswahl_vwmtipp .= \"" . $tpl->get("em2020_auswahl_vwmtipp_selected") . "\";");
				}
			}
			eval("\$lang->items['LANG_EM2020_TPL_tippabgabe_vwm_2'] = \"" . $lang->get4eval("LANG_EM2020_TPL_tippabgabe_vwm_2") . "\";");
			eval("\$em2020_tippabgabe_vwm .= \"" . $tpl->get("em2020_tippabgabe_vwm") . "\";");
		}
	}
	if ($em2020_options['gk_jn'] == 1) {
		eval("\$em2020_tippabgabe_gk .= \"" . $tpl->get("em2020_tippabgabe_gk") . "\";");
	}

	if ($em2020_options['rk_jn'] == 1) {
		eval("\$em2020_tippabgabe_rk .= \"" . $tpl->get("em2020_tippabgabe_rk") . "\";");
	}

	if ($em2020_options['elfer_jn'] == 1) {
		eval("\$em2020_tippabgabe_elfer .= \"" . $tpl->get("em2020_tippabgabe_elfer") . "\";");
	}

	eval("\$lang->items['LANG_EM2020_TPL_TIPPABGABE_5'] = \"" . $lang->get4eval("LANG_EM2020_TPL_TIPPABGABE_5") . "\";");
	eval("\$tpl->output(\"" . $tpl->get("em2020_tippabgabe") . "\");");
}
// ++++++++++++++++++
// ++ Tipp ist OK +++
// ++++++++++++++++++
if ($action == "tipok") {
	eval("\$tpl->output(\"" . $tpl->get("em2020_tipok") . "\");");
}
// ++++++++++++++++++++++++
// ++ Weltmeister-Tipp ++
// ++++++++++++++++++++++++
if ($action == "tippabgabe_wm") {
	if (isset($_POST['send'])) {
		// Erneute Prüfung der Tippabgabezeit
		$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . $em2020_options['lastgame4emtipp'] . "'");
		$time2 = $result_time['datetime'] - $em2020_options['tipptime'];
		if ($akttime > $time2) {
			redirect($lang->get("LANG_EM2020_PHP_20"), $url = "em2020.php?action=maketipp" . $SID_ARG_2ND);
		}

		// +++++++++++++++++++++++++++++++++++
		if ($_POST['tipp_em'] != -1) {
			if ($em2020_options['winnertipp_jn'] == 1 && ($uservwmtipp != intval($_POST['tipp_em'])) && $userdatayes == 0) {
				$db->query("INSERT INTO bb" . $n . "_em2020_userpunkte (userid,punkte,tipps_gesamt,tipps_richtig,tipps_falsch,tipps_tendenz,tipp_em,tipp_vem) VALUES ('" . intval($wbbuserdata['userid']) . "','0','0','0','0','0','" . intval($_POST['tipp_em']) . "','0')");
				// Guthaben aktiv ? Dann speichern
				if ($em2020_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2020_PHP_25'] . "','" . $em2020_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2020_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2020_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2020.php?action=tipok{$SID_ARG_2ND_UN}");
			} elseif ($em2020_options['winnertipp_jn'] == 1 && ($uservwmtipp != intval($_POST['tipp_em'])) && $userdatayes == 1) {
				$db->query("UPDATE bb" . $n . "_em2020_userpunkte SET tipp_em = '" . intval($_POST['tipp_em']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
				// Guthaben aktiv ? Dann speichern
				if ($em2020_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2020_PHP_25'] . "','" . $em2020_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2020_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2020_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2020.php?action=tipok{$SID_ARG_2ND_UN}");
			}
		} else {
			header("Location: em2020.php?action=tippabgabe&amp;gameid={$gameid}{$SID_ARG_2ND_UN}");
		}
	}
}
// +++++++++++++++++++++++++++
// ++ VizeWeltmeister-Tipp +++
// +++++++++++++++++++++++++++
if ($action == "tippabgabe_vwm") {
	if (isset($_POST['send'])) {
		// Erneute Prüfung der Tippabgabezeit
		$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . $em2020_options['lastgame4emtipp'] . "'");
		$time2 = $result_time['datetime'] - $em2020_options['tipptime'];
		if ($akttime > $time2) {
			redirect($lang->get("LANG_EM2020_PHP_20"), $url = "em2020.php?action=maketipp" . $SID_ARG_2ND);
		}

		// +++++++++++++++++++++++++++++++++++
		if ($_POST['tipp_vem'] != -1) {
			if ($em2020_options['winnertipp_jn'] == 1 && ($userwmtipp != $_POST['tipp_vem']) && $userdatayes == 0) {
				$db->query("INSERT INTO bb" . $n . "_em2020_userpunkte (userid,punkte,tipps_gesamt,tipps_richtig,tipps_falsch,tipps_tendenz,tipp_em,tipp_vem) VALUES ('" . intval($wbbuserdata['userid']) . "','0','0','0','0','0','0','" . intval($_POST['tipp_vem']) . "')");
				// Guthaben aktiv ? Dann speichern
				if ($em2020_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2020_PHP_26'] . "','" . $em2020_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2020_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2020_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2020.php?action=tipok{$SID_ARG_2ND_UN}");
			}
			if ($em2020_options['winnertipp_jn'] == 1 && ($userwmtipp != intval($_POST['tipp_vem'])) && $userdatayes == 1) {
				$db->query("UPDATE bb" . $n . "_em2020_userpunkte SET tipp_vem = '" . intval($_POST['tipp_vem']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
				// Guthaben aktiv ? Dann speichern
				if ($em2020_options['gh_aktiv'] == 1) {
					$db->query("INSERT INTO bb" . $n . "_kontoauszug VALUES ('','" . intval($wbbuserdata['userid']) . "','" . time() . "','" . $lang->items['LANG_EM2020_PHP_26'] . "','" . $em2020_options['gh_ab_emtipp'] . "','" . $lang->items['LANG_EM2020_PHP_22'] . "')");
					$db->query("UPDATE bb" . $n . "_users SET guthaben=guthaben-'" . $em2020_options['gh_ab_emtipp'] . "' WHERE userid='" . intval($wbbuserdata['userid']) . "'");
				}
				// +++++++++++++++++++++++++++++++
				header("Location: em2020.php?action=tipok{$SID_ARG_2ND_UN}");
			}
			header("Location: em2020.php?action=maketipp");
		} else {
			header("Location: em2020.php?action=tippabgabe&amp;gameid={$gameid}{$SID_ARG_2ND_UN}");
		}
	} else {
		header("Location: em2020.php?action=maketipp");
	}
}
// ++++++++++++++++++++++++
// ++ Usertipps ansehen +++
// ++++++++++++++++++++++++
if ($action == "showusertipps") {
	$result = $db->query("SELECT up.*,uu.username FROM bb" . $n . "_em2020_userpunkte up LEFT JOIN bb" . $n . "_users uu ON up.userid=uu.userid ORDER BY punkte DESC, tipps_gesamt DESC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		if ($row['tipp_em'] == 0) {
			$image_wmtipp = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_27']}\" title=\"{$lang->items['LANG_EM2020_PHP_27']}\" />";
		} else {
			for ($i = 0; $i < count($allids2); $i++) {
				if ($wbbuserdata['userid'] == intval($row['userid'])) {
					if ($row['tipp_em'] == $allids2[$i]) {
						$image_wmtipp = "<img src=\"images/em2020/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
					}
				} else {
					if ($akttime > $lastgame4emtipp['datetime']) {
						if ($row['tipp_em'] == $allids2[$i]) {
							$image_wmtipp = "<img src=\"images/em2020/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
						}
					} else {
						$image_wmtipp = "<img src=\"images/em2020/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
					}
				}
			}
		}
		if ($row['tipp_vem'] == 0) {
			$image_vwmtipp = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_28']}\" title=\"{$lang->items['LANG_EM2020_PHP_28']}\" />";
		} else {
			for ($i = 0; $i < count($allids2); $i++) {
				if ($wbbuserdata['userid'] == intval($row['userid'])) {
					if ($row['tipp_vem'] == $allids2[$i]) {
						$image_vwmtipp = "<img src=\"images/em2020/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
					}
				} else {
					if ($akttime > $lastgame4emtipp['datetime']) {
						if ($row['tipp_vem'] == $allids2[$i]) {
							$image_vwmtipp = "<img src=\"images/em2020/flaggen/$allflags2[$i]\" border=\"0\" alt=\"$allnames2[$i]\" title=\"$allnames2[$i]\" />";
						}
					} else {
						$image_vwmtipp = "<img src=\"images/em2020/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
					}
				}
			}
		}
		eval("\$em2020_showusertipps_bit .= \"" . $tpl->get("em2020_showusertipps_bit") . "\";");
	}
	eval("\$tpl->output(\"" . $tpl->get("em2020_showusertipps") . "\");");
}
// ++++++++++++++++++++++++++++++++++
// ++ Usertipps im Detail ansehen +++
// ++++++++++++++++++++++++++++++++++
if ($action == "showusertippsdetail") {
	if (isset($_REQUEST['userid']) && trim($_REQUEST['userid']) != '') {
		$result_username = $db->query_first("SELECT username FROM bb" . $n . "_users WHERE userid = '" . intval($_REQUEST['userid']) . "'");
		// Weltmeister und VizeWeltmeister auslesen und anzeigen
		$wmtipp_done = '0';
		$vwmtipp_done = '0';
		$result_wmtipp = $db->query_first("SELECT tipp_em,tipp_vem FROM bb" . $n . "_em2020_userpunkte WHERE userid = '" . intval($_REQUEST['userid']) . "'");
		if ($result_wmtipp['tipp_em'] == '0') {
			if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
				$wmtipp_name = "<a href=\"em2020.php?action=wmtipp_only" . $SID_ARG_2ND . "\">{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_12']}</a>";
			}

			if ($wbbuserdata['userid'] != intval($_REQUEST['userid'])) {
				$wmtipp_name = "{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_12']}";
			}

			$wmtipp_flagge = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_16']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_16']}\" />";
			$wmtipp_done = '1';
		}
		if ($result_wmtipp['tipp_vem'] == '0') {
			if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
				$vwmtipp_name = "<a href=\"em2020.php?action=wmtipp_only" . $SID_ARG_2ND . "\">{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_12']}</a>";
			}

			if ($wbbuserdata['userid'] != intval($_REQUEST['userid'])) {
				$vwmtipp_name = "{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_12']}";
			}

			$vwmtipp_flagge = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_16']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_16']}\" />";
			$vwmtipp_done = '1';
		}
		if ($wmtipp_done == '0' || $vwmtipp_done == '0') {
			for ($ii = 0; $ii < count($allids2); $ii++) {
				if ($result_wmtipp['tipp_em'] != '0' && $result_wmtipp['tipp_em'] == $allids2[$ii]) {
					if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
						$wmtipp_name = $allnames2[$ii];
						$wmtipp_flagge = "<img src=\"images/em2020/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$wmtipp_name\" title=\"$wmtipp_name\" />";
						$wmtipp_edit = '';
						if ($lastgame4emtipp['datetime'] > $akttime) {
							$wmtipp_edit = "&nbsp;<a href=\"em2020.php?action=editwmtipp&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\"><img src=\"images/em2020/edit.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_14']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_14']}\" /></a>";
						}
					} else {
						if ($akttime > $lastgame4emtipp['datetime']) {
							$wmtipp_name = $allnames2[$ii];
							$wmtipp_flagge = "<img src=\"images/em2020/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$wmtipp_name\" title=\"$wmtipp_name\" />";
							$wmtipp_edit = '';
						} else {
							$wmtipp_name = "<b>{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}</b>";
							$wmtipp_flagge = "<img src=\"images/em2020/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
						}
					}
				}
				if ($result_wmtipp['tipp_vem'] != '0' && $result_wmtipp['tipp_vem'] == $allids2[$ii]) {
					if ($wbbuserdata['userid'] == intval($_REQUEST['userid'])) {
						$vwmtipp_name = $allnames2[$ii];
						$vwmtipp_flagge = "<img src=\"images/em2020/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$vwmtipp_name\" title=\"$vwmtipp_name\" />";
						$vwmtipp_edit = '';
						if ($lastgame4emtipp['datetime'] > $akttime) {
							$vwmtipp_edit = "&nbsp;<a href=\"em2020.php?action=editvwmtipp&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\"><img src=\"images/em2020/edit.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_14']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_14']}\" /></a>";
						}
					} else {
						if ($akttime > $lastgame4emtipp['datetime']) {
							$vwmtipp_name = $allnames2[$ii];
							$vwmtipp_flagge = "<img src=\"images/em2020/flaggen/$allflags2[$ii]\" border=\"0\" alt=\"$vwmtipp_name\" title=\"$vwmtipp_name\" />";
							$vwmtipp_edit = '';
						} else {
							$vwmtipp_name = "<b>{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}</b>";
							$vwmtipp_flagge = "<img src=\"images/em2020/flaggen/unknown.png\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_15']}\" />";
						}
					}
				}
			}
		}

		// Alle Spieltipps auslesen und anzeigen
		$result_game = $db->query("SELECT ut.*,g.* FROM bb" . $n . "_em2020_usertipps ut LEFT JOIN bb" . $n . "_em2020_spiele g ON ut.gameid=g.gameid WHERE userid = '" . intval($_REQUEST['userid']) . "' ORDER BY g.datetime ASC");
		while ($row_game = $db->fetch_array($result_game)) {
			$rowclass = getone($count++, "tablea", "tableb");
			$edittipp = '';
			if (intval($_REQUEST['userid']) == $wbbuserdata['userid']) {
				if (($row_game['datetime'] - $akttime) > $em2020_options['tipptime']) {
					$edittipp = "&nbsp;<a href=\"em2020.php?action=edittipp&amp;gameid={$row_game['gameid']}&amp;userid={$wbbuserdata['userid']}{$SID_ARG_2ND}\"><img src=\"images/em2020/edit.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_14']}\" title=\"{$lang->items['LANG_EM2020_TPL_SHOWUSERTIPPSDETAIL_14']}\" /></a>";
				}
			}
			for ($i = 0; $i < count($allids2); $i++) {
				if ($row_game['team_1_id'] == $allids2[$i]) {
					$name1 = $allnames2[$i];
					$flagge1 = $allflags2[$i];
				}
				if ($row_game['team_2_id'] == $allids2[$i]) {
					$name2 = $allnames2[$i];
					$flagge2 = $allflags2[$i];
				}
			}
			$gamedate = formatdate($wbbuserdata['dateformat'], $row_game['datetime'], 1);
			$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
			$gametime = formatdate($wbbuserdata['timeformat'], $row_game['datetime']);

			if ($row_game['gk'] == 1) {
				$image_gk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}

			if ($row_game['gk'] == 0) {
				$image_gk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}

			if ($row_game['gk'] == -1) {
				$image_gk = "<img src=\"images/em2020/spacer.gif\" border=\"0\" alt=\"spacer.gif\" title=\"\" />";
			}

			if ($row_game['rk'] == 1) {
				$image_rk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}

			if ($row_game['rk'] == 0) {
				$image_rk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}

			if ($row_game['rk'] == -1) {
				$image_rk = "<img src=\"images/em2020/spacer.gif\" border=\"0\" alt=\"spacer.gif\" title=\"\" />";
			}

			if ($row_game['elfer'] == 1) {
				$image_elfer = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}

			if ($row_game['elfer'] == 0) {
				$image_elfer = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}

			if ($row_game['elfer'] == -1) {
				$image_elfer = "<img src=\"images/em2020/spacer.gif\" border=\"0\" alt=\"spacer.gif\" title=\"\" />";
			}

			if ($row_game['game_goals_1'] != '' && $row_game['game_goals_2'] != '') {
				if ($row_game['game_gk'] == $row_game['gk']) {
					$tippright_gk = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
				}

				if ($row_game['game_gk'] != $row_game['gk'] && $row_game['gk'] != -1) {
					$tippright_gk = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
				}

				if ($row_game['game_rk'] == $row_game['rk']) {
					$tippright_rk = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
				}

				if ($row_game['game_rk'] != $row_game['rk'] && $row_game['rk'] != -1) {
					$tippright_rk = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
				}

				if ($row_game['game_elfer'] == $row_game['elfer']) {
					$tippright_elfer = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
				}

				if ($row_game['game_elfer'] != $row_game['elfer'] && $row_game['elfer'] != -1) {
					$tippright_elfer = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
				}

				$ende = 0;
				// +++++++++++++++++++ 1. Prüfung
				// Tipp exakt richtig ?
				if ($row_game['game_goals_1'] == $row_game['goals_1'] && $row_game['game_goals_2'] == $row_game['goals_2']) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
					$ende = 1;
				}
				// +++++++++++++++++++
				// +++++++++++++++++++ 2. Prüfung
				// Spiel unentschieden, Tipp unentschieden, Tendenz richtig ?
				if ($ende == 0) {
					if ($em2020_options['tendenz'] == 1) {
						if (($row_game['game_goals_1'] == $row_game['game_goals_2']) && ($row_game['goals_1'] == $row_game['goals_2'])) {
							$tippright_result = "&nbsp;<img src=\"images/em2020/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_33']}\" title=\"{$lang->items['LANG_EM2020_PHP_33']}\" />";
							$ende = 1;
						}
					}
					if ($em2020_options['tendenz'] == 0) {
						if (($row_game['game_goals_1'] == $row_game['game_goals_2']) && ($row_game['goals_1'] == $row_game['goals_2'])) {
							$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
							$ende = 1;
						}
					}
				}
				// +++++++++++++++++++
				// +++++++++++++++++++ 3. Prüfung
				// Spiel unentschieden, Tipp Sieg
				if ($ende == 0) {
					if (($row_game['game_goals_1'] == $row_game['game_goals_2']) && ($row_game['goals_1'] != $row_game['goals_2'])) {
						$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
						$ende = 1;
					}
				}
				// +++++++++++++++++++
				// +++++++++++++++++++ 4. Prüfung
				// Spiel Sieg, Tipp Sieg (falsch), Tendenz richtig ?
				if ($ende == 0) {
					if ($em2020_options['tendenz'] == 1) {
						if (($row_game['game_goals_1'] < $row_game['game_goals_2']) && ($row_game['goals_1'] < $row_game['goals_2']) || ($row_game['game_goals_1'] > $row_game['game_goals_2']) && ($row_game['goals_1'] > $row_game['goals_2'])) {
							$tippright_result = "&nbsp;<img src=\"images/em2020/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_33']}\" title=\"{$lang->items['LANG_EM2020_PHP_33']}\" />";
							$ende = 1;
						}
					}
					if ($em2020_options['tendenz'] == 0) {
						if (($row_game['game_goals_1'] < $row_game['game_goals_2']) && ($row_game['goals_1'] < $row_game['goals_2']) || ($row_game['game_goals_1'] > $row_game['game_goals_2']) && ($row_game['goals_1'] > $row_game['goals_2'])) {
							$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
							$ende = 1;
						}
					}
				}
				// +++++++++++++++++++
				// +++++++++++++++++++ 5. Prüfung
				// Spiel Sieg, Tipp Niederlage
				// Siel Niederlage, Tipp Sieg
				// Spiel Sieg, Tipp unentschieden
				if ($ende == 0) {
					if (($row_game['game_goals_1'] < $row_game['game_goals_2']) && ($row_game['goals_1'] > $row_game['goals_2']) || ($row_game['game_goals_1'] > $row_game['game_goals_2']) && ($row_game['goals_1'] < $row_game['goals_2']) || ($row_game['game_goals_1'] != $row_game['game_goals_2']) && ($row_game['goals_1'] == $row_game['goals_2'])) {
						$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
						$ende = 1;
					}
				}
				// +++++++++++++++++++
			}
			// Tipp nur anzeigen, wenn Spiel schon gespielt
			if ($wbbuserdata['userid'] != intval($_REQUEST['userid'])) {
				if ($row_game['datetime'] < $akttime) {
					eval("\$em2020_showusertippsdetail_bit .= \"" . $tpl->get("em2020_showusertippsdetail_bit") . "\";");
				}
			} else {
				eval("\$em2020_showusertippsdetail_bit .= \"" . $tpl->get("em2020_showusertippsdetail_bit") . "\";");
			}

			$tippright_gk = '';
			$tippright_rk = '';
			$tippright_elfer = '';
			$tippright_result = '';
			$abc = '';
		}
		eval("\$tpl->output(\"" . $tpl->get("em2020_showusertippsdetail") . "\");");
	} else {
		redirect($lang->get("LANG_EM2020_PHP_61"), $url = "em2020.php?action=showusertipps" . $SID_ARG_1ST);
	}
}
// +++++++++++++++++++++++++++++++++++++++++++
// ++ Alle Spiele einer Mannschaft ansehen +++
// +++++++++++++++++++++++++++++++++++++++++++
if ($action == "showallgames") {
	$result = $db->query("SELECT * FROM bb" . $n . "_em2020_spiele WHERE team_1_id = '" . intval($_REQUEST['teamid']) . "' OR team_2_id = '" . intval($_REQUEST['teamid']) . "' ORDER BY datetime ASC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");
		$gamedate = formatdate($wbbuserdata['dateformat'], $row['datetime']);
		$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
		$gametime = formatdate($wbbuserdata['timeformat'], $row['datetime']);
		if ($row['gruppe'] == 'A' || 'B' || 'C' || 'D' || 'E' || 'F' || 'G' || 'H') {
			$type = $lang->items['LANG_EM2020_PHP_18'];
		}

		if ($row['gruppe'] == '8') {
			$type = $lang->items['LANG_EM2020_PHP_4'];
		}

		if ($row['gruppe'] == '4') {
			$type = $lang->items['LANG_EM2020_PHP_6'];
		}

		if ($row['gruppe'] == '2') {
			$type = $lang->items['LANG_EM2020_PHP_8'];
		}

		if ($row['gruppe'] == '3') {
			$type = $lang->items['LANG_EM2020_PHP_9'];
		}

		if ($row['gruppe'] == '1') {
			$type = $lang->items['LANG_EM2020_PHP_10'];
		}

		for ($i = 0; $i < count($allids2); $i++) {
			if (intval($_REQUEST['teamid']) == $allids2[$i]) {
				$name = $allnames2[$i];
				$name_alt = $name;
				$flagge = $allflags2[$i];
			}
			if ($row['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
				$name1_alt = $name1;
				if (intval($_REQUEST['teamid']) == $row['team_1_id']) {
					$name1 = "<b>" . $name1 . "</b>";
				}

			}
			if ($row['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
				$name2_alt = $name2;
				if (intval($_REQUEST['teamid']) == $row['team_2_id']) {
					$name2 = "<b>" . $name2 . "</b>";
				}

			}
		}
		$gamedetails = '';

		//mf Quote
		getQuote($row['gameid']);
		//!mf Quote

		if ($row['game_goals_1'] != '' && $row['game_goals_2'] != '') {
			$gamedetails = "<a href=\"em2020.php?action=gamedetails&amp;gameid={$row['gameid']}{$SID_ARG_2ND}\"><img src=\"images/em2020/details.gif\" border=\"0\"alt=\"{$lang->items['LANG_EM2020_PHP_14']}\" title=\"{$lang->items['LANG_EM2020_PHP_14']}\"></a>";
		}

		eval("\$em2020_showallgames_bit .= \"" . $tpl->get("em2020_showallgames_bit") . "\";");
		$name1 = '';
		$name2 = '';
		$name1_alt = '';
		$name2_alt = '';
		$flagge1 = '';
		$flagge2 = '';
	}
	eval("\$tpl->output(\"" . $tpl->get("em2020_showallgames") . "\");");
}
// +++++++++++++++++++++++++++++++++++++
// ++ Details zu einem Spiel ansehen +++
// +++++++++++++++++++++++++++++++++++++
if ($action == "gamedetails") {
	$result = $db->query_first("SELECT * FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	$gamedate = formatdate($wbbuserdata['dateformat'], $result['datetime']);
	$gamedate = preg_replace("/((<b>)?[a-zA-Z]*(<\/b>)?),/", "$1", $gamedate);
	$gametime = formatdate($wbbuserdata['timeformat'], $result['datetime']);
	if ($result['gruppe'] == 'A' || 'B' || 'C' || 'D' || 'E' || 'F' || 'G' || 'H') {
		$type = $lang->items['LANG_EM2020_PHP_18'];
	}

	if ($result['gruppe'] == '8') {
		$type = $lang->items['LANG_EM2020_PHP_4'];
	}

	if ($result['gruppe'] == '4') {
		$type = $lang->items['LANG_EM2020_PHP_6'];
	}

	if ($result['gruppe'] == '2') {
		$type = $lang->items['LANG_EM2020_PHP_8'];
	}

	if ($result['gruppe'] == '3') {
		$type = $lang->items['LANG_EM2020_PHP_9'];
	}

	if ($result['gruppe'] == '1') {
		$type = $lang->items['LANG_EM2020_PHP_10'];
	}

	for ($i = 0; $i < count($allids2); $i++) {
		if ($result['team_1_id'] == $allids2[$i]) {
			$name1 = $allnames2[$i];
			$flagge1 = $allflags2[$i];
		}
		if ($result['team_2_id'] == $allids2[$i]) {
			$name2 = $allnames2[$i];
			$flagge2 = $allflags2[$i];
		}
	}
	if (!empty($result['game_goals_1']) || $result['game_goals_1'] == '0') {
		if ($em2020_options['gk_jn'] == 1) {
			if ($result['game_gk'] == 1) {
				$gamed_gk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_34']}</span></td></tr>";
			}
			if ($result['game_gk'] == 0) {
				$gamed_gk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_35']}</span></td></tr>";
			}
		}
		if ($em2020_options['rk_jn'] == 1) {
			if ($result['game_rk'] == 1) {
				$gamed_rk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_36']}</span></td></tr>";
			}

			if ($result['game_rk'] == 0) {
				$gamed_rk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_37']}</span></td></tr>";
				$gamed_rk = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_37']}</span></td></tr>";
			}
		}
		if ($em2020_options['elfer_jn'] == 1) {
			if ($result['game_elfer'] == 1) {
				$gamed_elfer = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_38']}</span></td></tr>";
			}
			if ($result['game_elfer'] == 0) {
				$gamed_elfer = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_39']}</span></td></tr>";
			}
		}
	} else {
		$gamed_gk = '';
		$gamed_rk = '';
		$gamed_elfer = '';
		$gamed_stillrunning = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\">{$lang->items['LANG_EM2020_PHP_62']}</span></td></tr>";
	}

	$linkjn = 0;
	if (!empty($result['gamelink'])) {
		$linkjn = 1;
		$link = "<tr><td class=\"tablea\" align=\"center\"><span class=\"normalfont\"><a href=\"{$result['gamelink']}\" target=\"_blank\">{$lang->items['LANG_EM2020_PHP_40']}</a></span></td></tr>";
	}
	$commentjn = 0;
	if (!empty($result['gamecomment'])) {
		$commentjn = 1;
		$comment1 = nl2br($result['gamecomment']);
		$comment2 = "<tr><td class=\"tablea\" align=\"left\"><span class=\"normalfont\">{$comment1}</span></td></tr>";
	}

	//1:1-Kopie von tippsprogame

	// Tipps nur anzeigen, wenn Spiel schon gespielt
	$result_gamedetails = $db->query_first("SELECT * FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	if ($result_gamedetails['datetime'] > $akttime) {
		redirect($lang->get("LANG_EM2020_PHP_60"), $url = "em2020.php?action=showresults" . $SID_ARG_1ST);
	}

	$result_tippsprograme_include = $db->query("SELECT ut.*,u.username FROM bb" . $n . "_em2020_usertipps ut LEFT JOIN bb" . $n . "_users u ON ut.userid=u.userid WHERE gameid = '" . intval($_REQUEST['gameid']) . "' ORDER BY userid ASC");
	while ($row = $db->fetch_array($result_tippsprograme_include)) {
		$rowclass = getone($count++, "tablea", "tableb");
		if ($em2020_options['gk_jn'] == 1) {
			if ($row['gk'] == 0) {
				$game_gk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}

			if ($row['gk'] == 1) {
				$game_gk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
		}
		if ($em2020_options['rk_jn'] == 1) {
			if ($row['rk'] == 0) {
				$game_rk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}

			if ($row['rk'] == 1) {
				$game_rk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
		}
		if ($em2020_options['elfer_jn'] == 1) {
			if ($row['elfer'] == 0) {
				$game_elfer = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}

			if ($row['elfer'] == 1) {
				$game_elfer = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
		}

		// Tendenzbildchen
		// Result

		$ende = 0;
		// +++++++++++++++++++ 1. Prüfung
		// Tipp exakt richtig ?
		if ($result_gamedetails['game_goals_1'] == $row['goals_1'] && $result_gamedetails['game_goals_2'] == $row['goals_2']) {
			$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			$ende = 1;
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 2. Prüfung
		// Spiel unentschieden, Tipp unentschieden, Tendenz richtig ?
		if ($ende == 0) {
			if ($em2020_options['tendenz'] == 1) {
				if (($result_gamedetails['game_goals_1'] == $result_gamedetails['game_goals_2']) && ($row['goals_1'] == $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_33']}\" title=\"{$lang->items['LANG_EM2020_PHP_33']}\" />";
					$ende = 1;
				}
			}
			if ($em2020_options['tendenz'] == 0) {
				if (($result_gamedetails['game_goals_1'] == $result_gamedetails['game_goals_2']) && ($row['goals_1'] == $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
					$ende = 1;
				}
			}
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 3. Prüfung
		// Spiel unentschieden, Tipp Sieg
		if ($ende == 0) {
			if (($result_gamedetails['game_goals_1'] == $result_gamedetails['game_goals_2']) && ($row['goals_1'] != $row['goals_2'])) {
				$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
				$ende = 1;
			}
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 4. Prüfung
		// Spiel Sieg, Tipp Sieg (falsch), Tendenz richtig ?
		if ($ende == 0) {
			if ($em2020_options['tendenz'] == 1) {
				if (($result_gamedetails['game_goals_1'] < $result_gamedetails['game_goals_2']) && ($row['goals_1'] < $row['goals_2']) || ($result_gamedetails['game_goals_1'] > $result_gamedetails['game_goals_2']) && ($row['goals_1'] > $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_33']}\" title=\"{$lang->items['LANG_EM2020_PHP_33']}\" />";
					$ende = 1;
				}
			}
			if ($em2020_options['tendenz'] == 0) {
				if (($result_gamedetails['game_goals_1'] < $result_gamedetails['game_goals_2']) && ($row['goals_1'] < $row['goals_2']) || ($result_gamedetails['game_goals_1'] > $result_gamedetails['game_goals_2']) && ($row['goals_1'] > $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
					$ende = 1;
				}
			}
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 5. Prüfung
		// Spiel Sieg, Tipp Niederlage
		// Siel Niederlage, Tipp Sieg
		// Spiel Sieg, Tipp unentschieden
		if ($ende == 0) {
			if (($result_gamedetails['game_goals_1'] < $result_gamedetails['game_goals_2']) && ($row['goals_1'] > $row['goals_2']) || ($result_gamedetails['game_goals_1'] > $result_gamedetails['game_goals_2']) && ($row['goals_1'] < $row['goals_2']) || ($result_gamedetails['game_goals_1'] != $result_gamedetails['game_goals_2']) && ($row['goals_1'] == $row['goals_2'])) {
				$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
				$ende = 1;
			}
		}

		// +++++++++++++++++++

		if ($em2020_options['gk_jn'] == 1) {
			if ($row['gk'] == 0) {
				$game_gk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";

			}
			if ($row['gk'] == 1) {
				$game_gk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
			// Prüfung, ob User richtig lag
			if ($row['gk'] == $result_gamedetails['game_gk']) {
				$tippright_gk = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			} else {
				$tippright_gk = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
			}

		}
		if ($em2020_options['rk_jn'] == 1) {
			if ($row['rk'] == 0) {
				$game_rk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}
			if ($row['rk'] == 1) {
				$game_rk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
			// Prüfung, ob User richtig lag
			if ($row['rk'] == $result_gamedetails['game_rk']) {
				$tippright_rk = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			} else {
				$tippright_rk = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
			}
		}
		if ($em2020_options['elfer_jn'] == 1) {
			if ($row['elfer'] == 0) {
				$game_elfer = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}
			if ($row['elfer'] == 1) {
				$game_elfer = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
			// Prüfung, ob User richtig lag
			if ($row['elfer'] == $result_gamedetails['game_elfer']) {
				$tippright_elfer = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			} else {
				$tippright_elfer = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
			}
		}

		if (!empty($result_gamedetails['game_goals_1']) || $result_gamedetails['game_goals_1'] == '0') {
			eval("\$em2020_tippsprogame_bit .= \"" . $tpl->get("em2020_tippsprogame_bit") . "\";");
		} else {
			eval("\$em2020_tippsprogame_bit .= \"" . $tpl->get("em2020_tippsprogame_bit_gameisbeeingplayed") . "\";");
		}
	}
	eval("\$em2020_tippsprogame_include .= \"" . $tpl->get("em2020_tippsprogame_include") . "\";");
	eval("\$tpl->output(\"" . $tpl->get("em2020_gamedetails") . "\");");
}
// ++++++++++++++++++++++++++++++++++++++++++++
// ++ Alle Usertipps zu einem Spiel ansehen +++
// ++++++++++++++++++++++++++++++++++++++++++++
if ($action == "tippsprogame") {
	// Tipps nur anzeigen, wenn Spiel schon gespielt
	$result_gamedetails = $db->query_first("SELECT * FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . intval($_REQUEST['gameid']) . "'");
	if ($result_gamedetails['datetime'] > $akttime) {
		redirect($lang->get("LANG_EM2020_PHP_60"), $url = "em2020.php?action=showresults" . $SID_ARG_1ST);
	}

	$result = $db->query("SELECT ut.*,u.username FROM bb" . $n . "_em2020_usertipps ut LEFT JOIN bb" . $n . "_users u ON ut.userid=u.userid WHERE gameid = '" . intval($_REQUEST['gameid']) . "' ORDER BY userid ASC");
	while ($row = $db->fetch_array($result)) {
		$rowclass = getone($count++, "tablea", "tableb");

		// Tendenzbildchen
		// Result

		$ende = 0;
		// +++++++++++++++++++ 1. Prüfung
		// Tipp exakt richtig ?
		if ($result_gamedetails['game_goals_1'] == $row['goals_1'] && $result_gamedetails['game_goals_2'] == $row['goals_2']) {
			$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			$ende = 1;
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 2. Prüfung
		// Spiel unentschieden, Tipp unentschieden, Tendenz richtig ?
		if ($ende == 0) {
			if ($em2020_options['tendenz'] == 1) {
				if (($result_gamedetails['game_goals_1'] == $result_gamedetails['game_goals_2']) && ($row['goals_1'] == $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_33']}\" title=\"{$lang->items['LANG_EM2020_PHP_33']}\" />";
					$ende = 1;
				}
			}
			if ($em2020_options['tendenz'] == 0) {
				if (($result_gamedetails['game_goals_1'] == $result_gamedetails['game_goals_2']) && ($row['goals_1'] == $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
					$ende = 1;
				}
			}
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 3. Prüfung
		// Spiel unentschieden, Tipp Sieg
		if ($ende == 0) {
			if (($result_gamedetails['game_goals_1'] == $result_gamedetails['game_goals_2']) && ($row['goals_1'] != $row['goals_2'])) {
				$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
				$ende = 1;
			}
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 4. Prüfung
		// Spiel Sieg, Tipp Sieg (falsch), Tendenz richtig ?
		if ($ende == 0) {
			if ($em2020_options['tendenz'] == 1) {
				if (($result_gamedetails['game_goals_1'] < $result_gamedetails['game_goals_2']) && ($row['goals_1'] < $row['goals_2']) || ($result_gamedetails['game_goals_1'] > $result_gamedetails['game_goals_2']) && ($row['goals_1'] > $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/tendenz.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_33']}\" title=\"{$lang->items['LANG_EM2020_PHP_33']}\" />";
					$ende = 1;
				}
			}
			if ($em2020_options['tendenz'] == 0) {
				if (($result_gamedetails['game_goals_1'] < $result_gamedetails['game_goals_2']) && ($row['goals_1'] < $row['goals_2']) || ($result_gamedetails['game_goals_1'] > $result_gamedetails['game_goals_2']) && ($row['goals_1'] > $row['goals_2'])) {
					$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
					$ende = 1;
				}
			}
		}
		// +++++++++++++++++++
		// +++++++++++++++++++ 5. Prüfung
		// Spiel Sieg, Tipp Niederlage
		// Siel Niederlage, Tipp Sieg
		// Spiel Sieg, Tipp unentschieden
		if ($ende == 0) {
			if (($result_gamedetails['game_goals_1'] < $result_gamedetails['game_goals_2']) && ($row['goals_1'] > $row['goals_2']) || ($result_gamedetails['game_goals_1'] > $result_gamedetails['game_goals_2']) && ($row['goals_1'] < $row['goals_2']) || ($result_gamedetails['game_goals_1'] != $result_gamedetails['game_goals_2']) && ($row['goals_1'] == $row['goals_2'])) {
				$tippright_result = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
				$ende = 1;
			}
		}
		// +++++++++++++++++++

		if ($em2020_options['gk_jn'] == 1) {
			if ($row['gk'] == 0) {
				$game_gk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";

			}
			if ($row['gk'] == 1) {
				$game_gk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
			// Prüfung, ob User richtig lag
			if ($row['gk'] == $result_gamedetails['game_gk']) {
				$tippright_gk = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			} else {
				$tippright_gk = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
			}

		}
		if ($em2020_options['rk_jn'] == 1) {
			if ($row['rk'] == 0) {
				$game_rk = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}
			if ($row['rk'] == 1) {
				$game_rk = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
			// Prüfung, ob User richtig lag
			if ($row['rk'] == $result_gamedetails['game_rk']) {
				$tippright_rk = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			} else {
				$tippright_rk = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
			}
		}
		if ($em2020_options['elfer_jn'] == 1) {
			if ($row['elfer'] == 0) {
				$game_elfer = "<img src=\"images/em2020/notok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_30']}\" title=\"{$lang->items['LANG_EM2020_PHP_30']}\" />";
			}
			if ($row['elfer'] == 1) {
				$game_elfer = "<img src=\"images/em2020/ok.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_29']}\" title=\"{$lang->items['LANG_EM2020_PHP_29']}\" />";
			}
			// Prüfung, ob User richtig lag
			if ($row['elfer'] == $result_gamedetails['game_elfer']) {
				$tippright_elfer = "&nbsp;<img src=\"images/em2020/thumbs_up.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_31']}\" title=\"{$lang->items['LANG_EM2020_PHP_31']}\" />";
			} else {
				$tippright_elfer = "&nbsp;<img src=\"images/em2020/thumbs_down.gif\" border=\"0\" alt=\"{$lang->items['LANG_EM2020_PHP_32']}\" title=\"{$lang->items['LANG_EM2020_PHP_32']}\" />";
			}
		}
		if (!empty($result_gamedetails['game_goals_1']) || $result_gamedetails['game_goals_1'] == '0') {
			eval("\$em2020_tippsprogame_bit .= \"" . $tpl->get("em2020_tippsprogame_bit") . "\";");
		} else {
			eval("\$em2020_tippsprogame_bit .= \"" . $tpl->get("em2020_tippsprogame_bit_gameisbeeingplayed") . "\";");
		}
	}
	eval("\$tpl->output(\"" . $tpl->get("em2020_tippsprogame") . "\");");
}
// ++++++++++++++++++++++++++
// ++ Usertipps editieren +++
// ++++++++++++++++++++++++++
if ($action == "edittipp") {
	// Speichern des geänderten Tipps
	if (isset($_POST['send'])) {
		// Erneute Prüfung der Mindesttippabgabezeit
		if ((intval($_POST['datetime']) - $akttime) < $em2020_options['tipptime']) {
			redirect($lang->get("LANG_EM2020_PHP_44"), $url = "em2020.php" . $SID_ARG_1ST);
		}

		// Prüfen ob Achtelfinale, Viertelfinale, Halbfinale, Spiel um Platz 3 oder Finale und Tipp unentschieden
		if (intval($_POST['gameid']) > $gameids['vorrundenspiel'] && intval($_POST['tipp_1']) == intval($_POST['tipp_2'])) {
			redirect($lang->get("LANG_EM2020_PHP_41"), $url = "em2020.php?action=edittipp&amp;gameid={$_POST['gameid']}&amp;userid={$wbbuserdata['userid']}" . $SID_ARG_2ND);
		}

		$tippok = 1;
		$gk = -1;
		$rk = -1;
		$elfer = -1;
		if (!preg_match("/^[0-9]{1,}/", intval($_POST['tipp_1']))) {
			$tippok = 0;
		}

		if (!preg_match("/^[0-9]{1,}/", intval($_POST['tipp_2']))) {
			$tippok = 0;
		}

		if ($em2020_options['gk_jn'] == 1 && intval($_POST['tipp_gk']) == -1) {
			$tippok = 0;
		} elseif ($em2020_options['gk_jn'] == 1 && intval($_POST['tipp_gk']) != -1) {
			$gk = $_POST['tipp_gk'];
		}
		if ($em2020_options['rk_jn'] == 1 && intval($_POST['tipp_rk']) == -1) {
			$tippok = 0;
		} elseif ($em2020_options['rk_jn'] == 1 && intval($_POST['tipp_rk']) != -1) {
			$rk = intval($_POST['tipp_rk']);
		}
		if ($em2020_options['elfer_jn'] == 1 && intval($_POST['tipp_elfer']) == -1) {
			$tippok = 0;
		} elseif ($em2020_options['elfer_jn'] == 1 && intval($_POST['tipp_elfer']) != -1) {
			$elfer = intval($_POST['tipp_elfer']);
		}
		if ($tippok == 1) {
			$db->unbuffered_query("UPDATE bb" . $n . "_em2020_usertipps SET goals_1 = '" . intval($_POST['tipp_1']) . "', goals_2 = '" . intval($_POST['tipp_2']) . "', gk = '$gk', rk = '$rk', elfer = '$elfer' WHERE gameid = '" . intval($_POST['gameid']) . "' AND userid = '" . intval($wbbuserdata['userid']) . "'");
			redirect($lang->get("LANG_EM2020_PHP_45"), $url = "em2020.php?action=showusertippsdetail&amp;userid={$wbbuserdata['userid']}" . $SID_ARG_1ST);
		} elseif ($tippok == 0) {
			redirect($lang->get("LANG_EM2020_PHP_46"), $url = "em2020.php?action=edittipp&amp;gameid=" . intval($_POST['gameid']) . "&amp;userid={$wbbuserdata['userid']}" . $SID_ARG_2ND);
		}
	}
	// Anzeigen des zu ändernden Tipps
	// User ist auch der, der er zu sein scheint ?
	if (intval($_REQUEST['userid']) != $wbbuserdata['userid']) {
		redirect($lang->get("LANG_EM2020_PHP_47"), $url = "em2020.php" . $SID_ARG_1ST);
	}

	// Tipp von diesem User existiert auch ?
	$checktipp = $db->query_first("SELECT gameid FROM bb" . $n . "_em2020_usertipps WHERE gameid = '" . intval($_REQUEST['gameid']) . "' AND userid = '" . intval($_REQUEST['userid']) . "'");
	if (!$checktipp['gameid']) {
		redirect($lang->get("LANG_EM2020_PHP_48"), $url = "em2020.php" . $SID_ARG_1ST);
	}

	$result_game = $db->query("SELECT ut.*,g.* FROM bb" . $n . "_em2020_usertipps ut LEFT JOIN bb" . $n . "_em2020_spiele g ON ut.gameid=g.gameid WHERE ut.gameid = '" . intval($_REQUEST['gameid']) . "' AND ut.userid = '" . intval($_REQUEST['userid']) . "'");
	while ($row_game = $db->fetch_array($result_game)) {
		// Mindesttippabgabezeit noch nicht erreicht ?
		if (($row_game['datetime'] - $akttime) < $em2020_options['tipptime']) {
			redirect($lang->get("LANG_EM2020_PHP_49"), $url = "em2020.php" . $SID_ARG_1ST);
		}

		for ($i = 0; $i < count($allids2); $i++) {
			if ($row_game['team_1_id'] == $allids2[$i]) {
				$name1 = $allnames2[$i];
				$flagge1 = $allflags2[$i];
			}
			if ($row_game['team_2_id'] == $allids2[$i]) {
				$name2 = $allnames2[$i];
				$flagge2 = $allflags2[$i];
			}
		}
		if ($em2020_options['gk_jn'] == 1) {
			$tipp_gk_jn = array(1 => '', 2 => '');
			if (isset($row_game['gk'])) {
				$tipp_gk_jn[$row_game['gk']] = ' selected="selected"';
			}

			eval("\$em2020_tippedit_gk .= \"" . $tpl->get("em2020_tippedit_gk") . "\";");
		}
		if ($em2020_options['rk_jn'] == 1) {
			$tipp_rk_jn = array(1 => '', 2 => '');
			if (isset($row_game['rk'])) {
				$tipp_rk_jn[$row_game['rk']] = ' selected="selected"';
			}

			eval("\$em2020_tippedit_rk .= \"" . $tpl->get("em2020_tippedit_rk") . "\";");
		}
		if ($em2020_options['elfer_jn'] == 1) {
			$tipp_elfer_jn = array(1 => '', 2 => '');
			if (isset($row_game['elfer'])) {
				$tipp_elfer_jn[$row_game['elfer']] = ' selected="selected"';
			}

			eval("\$em2020_tippedit_elfer .= \"" . $tpl->get("em2020_tippedit_elfer") . "\";");
		}
		eval("\$tpl->output(\"" . $tpl->get("em2020_tippedit") . "\");");
	}
}
// ++++++++++++++++++++++++
// ++ WM-Tipp editieren +++
// ++++++++++++++++++++++++
if ($action == "editwmtipp") {
	if ($lastgame4emtipp['datetime'] < $akttime) {
		redirect($lang->get("LANG_EM2020_PHP_50"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}

	// +++++++++++++++++++++++++++++++++++
	if (isset($_POST['send'])) {
		if ($_POST['tipp_em'] == -1) {
			redirect($lang->get("LANG_EM2020_PHP_51"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
		}

		$db->unbuffered_query("UPDATE bb" . $n . "_em2020_userpunkte SET tipp_em = '" . intval($_POST['tipp_em']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
		redirect($lang->get("LANG_EM2020_PHP_52"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}
	// +++++++++++++++++++++++++++++++++++
	if ($_REQUEST['userid'] != $wbbuserdata['userid']) {
		redirect($lang->get("LANG_EM2020_PHP_53"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}

	$result = $db->query_first("SELECT tipp_em, tipp_vem FROM bb" . $n . "_em2020_userpunkte WHERE userid = '" . intval($_REQUEST['userid']) . "'");
	if (!$result['tipp_em']) {
		redirect($lang->get("LANG_EM2020_PHP_54"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}

	for ($j = 0; $j < count($allids2); $j++) {
		if ($result['tipp_em'] == $allids2[$j]) {
			$wm_name = $allnames2[$j];
			$wm_flagge = "<img src=\"images/em2020/flaggen/{$allflags2[$j]}\" alt=\"{$wm_name}\" title=\"{$wm_name}\" />";
		}
	}
	for ($i = 0; $i < count($allids2); $i++) {
		if ($result['tipp_em'] != $allids2[$i] && $result['tipp_vem'] != $allids2[$i]) {
			eval("\$em2020_auswahl_wmtipp .= \"" . $tpl->get("em2020_auswahl_wmtipp") . "\";");
		}
	}
	eval("\$tpl->output(\"" . $tpl->get("em2020_editwmtipp") . "\");");
}
// +++++++++++++++++++++++++++++
// ++ Vize-WM-Tipp editieren +++
// +++++++++++++++++++++++++++++
if ($action == "editvwmtipp") {
	if ($lastgame4emtipp['datetime'] < $akttime) {
		redirect($lang->get("LANG_EM2020_PHP_55"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}

	// +++++++++++++++++++++++++++++++++++
	if (isset($_POST['send'])) {
		if ($_POST['tipp_vem'] == -1) {
			redirect($lang->get("LANG_EM2020_PHP_56"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
		}

		$db->unbuffered_query("UPDATE bb" . $n . "_em2020_userpunkte SET tipp_vem = '" . intval($_POST['tipp_vem']) . "' WHERE userid = '" . intval($wbbuserdata['userid']) . "'");
		redirect($lang->get("LANG_EM2020_PHP_57"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}
	// +++++++++++++++++++++++++++++++++++
	if ($_REQUEST['userid'] != $wbbuserdata['userid']) {
		redirect($lang->get("LANG_EM2020_PHP_58"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}

	$result = $db->query_first("SELECT tipp_em, tipp_vem FROM bb" . $n . "_em2020_userpunkte WHERE userid = '" . intval($_REQUEST['userid']) . "'");
	if (!$result['tipp_vem']) {
		redirect($lang->get("LANG_EM2020_PHP_59"), $url = "em2020.php?action=maketipp" . $SID_ARG_1ST);
	}

	for ($j = 0; $j < count($allids2); $j++) {
		if ($result['tipp_vem'] == $allids2[$j]) {
			$vwm_name = $allnames2[$j];
			$vwm_flagge = "<img src=\"images/em2020/flaggen/{$allflags2[$j]}\" alt=\"$vwm_name\" title=\"$vwm_name\" />";
		}
	}
	for ($j = 0; $j < count($allids2); $j++) {
		if ($result['tipp_vem'] != $allids2[$j] && $result['tipp_em'] != $allids2[$j]) {
			eval("\$em2020_auswahl_vwmtipp .= \"" . $tpl->get("em2020_auswahl_vwmtipp") . "\";");
		} else {
			eval("\$em2020_auswahl_vwmtipp .= \"" . $tpl->get("em2020_auswahl_vwmtipp_selected") . "\";");
		}
	}
	eval("\$tpl->output(\"" . $tpl->get("em2020_editvwmtipp") . "\");");
}

if ($action == "wmtipp_only") {
	// Prüfen auf genug Tippzeit
	$result_time = $db->query_first("SELECT datetime FROM bb" . $n . "_em2020_spiele WHERE gameid = '" . $em2020_options['lastgame4emtipp'] . "'");
	$time2 = $result_time['datetime'] - $em2020_options['tipptime'];
	if ($akttime > $time2) {
		redirect($lang->get("LANG_EM2020_PHP_20"), $url = "em2020.php?action=maketipp" . $SID_ARG_2ND);
	}

	if ($em2020_options['winnertipp_jn'] == 1) {
		$selected = '';
		for ($i = 0; $i < count($allids2); $i++) {
			if ($userwmtipp != $allids2[$i]) {
				eval("\$em2020_auswahl_wmtipp .= \"" . $tpl->get("em2020_auswahl_wmtipp") . "\";");
			} else {
				eval("\$em2020_auswahl_wmtipp .= \"" . $tpl->get("em2020_auswahl_wmtipp_selected") . "\";");
			}
		}
		eval("\$lang->items['LANG_EM2020_TPL_TIPPABGABE_WM_2'] = \"" . $lang->get4eval("LANG_EM2020_TPL_TIPPABGABE_WM_2") . "\";");
		eval("\$em2020_tippabgabe_wm.= \"" . $tpl->get("em2020_tippabgabe_wm") . "\";");
	}
	if ($em2020_options['winnertipp_jn'] == 1) {
		$selected = '';
		for ($j = 0; $j < count($allids2); $j++) {
			if ($uservwmtipp != $allids2[$j]) {
				eval("\$em2020_auswahl_vwmtipp .= \"" . $tpl->get("em2020_auswahl_vwmtipp") . "\";");
			} else {
				eval("\$em2020_auswahl_vwmtipp .= \"" . $tpl->get("em2020_auswahl_vwmtipp_selected") . "\";");
			}
		}
		eval("\$lang->items['LANG_EM2020_TPL_tippabgabe_vwm_2'] = \"" . $lang->get4eval("LANG_EM2020_TPL_tippabgabe_vwm_2") . "\";");
		eval("\$em2020_tippabgabe_vwm .= \"" . $tpl->get("em2020_tippabgabe_vwm") . "\";");
	}
	eval("\$tpl->output(\"" . $tpl->get("em2020_wmtipp_only") . "\");");
}

?>
