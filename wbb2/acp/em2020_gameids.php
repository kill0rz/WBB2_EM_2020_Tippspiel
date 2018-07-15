<?php

// Konfiguration für die EM2020

$gameids = array(
	'lastgroupgame_a' => 34,
	'lastgroupgame_b' => 36,
	'lastgroupgame_c' => 38,
	'lastgroupgame_d' => 40,
	'lastgroupgame_e' => 42,
	'lastgroupgame_f' => 44,
	'lastgroupgame_g' => 46,
	'lastgroupgame_h' => 48,
	'vorrundenspiel' => 48,
	'achtelfinal1' => 49,
	'achtelfinal2' => 50,
	'achtelfinal3' => 51,
	'achtelfinal4' => 52,
	'achtelfinal5' => 53,
	'achtelfinal6' => 54,
	'achtelfinal7' => 55,
	'achtelfinal8' => 56,
	'viertelfinal1' => 57,
	'viertelfinal2' => 58,
	'viertelfinal3' => 59,
	'viertelfinal4' => 60,
	'halbfinal1' => 61,
	'halbfinal2' => 62,
	'spielumplatzdrei' => 63,
	'finale' => 64,
);

// Erklärung: für jedes Spiel werden die nächsten, direkt beeinflussten Spiele angegeben
// Diese Funktionalität wird für das Editieren der Spiele benötigt.
// Hier treten nur die Spiele auf, die kritisch sind (letzte Vorrundenspiele pro Gruppe + alles ab 8.Finale)
// Aufbau: {Gewinner/Verlier des Ausgangsspiels}-{Nummer des neuen Spiels}-{Team 1 oder 2 des neuen Spiels}
$gameids_kette = array(
	34 => array('W-50-1', 'W-51-2'),
	36 => array('W-50-1', 'W-51-2'),
	38 => array('W-49-1', 'W-52-2'),
	40 => array('W-49-1', 'W-52-2'),
	42 => array('W-54-1', 'W-56-2'),
	44 => array('W-54-1', 'W-56-2'),
	48 => array('W-53-1', 'W-55-2'),
	46 => array('W-53-1', 'W-55-2'),
	49 => array('W-57-1'),
	50 => array('W-57-2'),
	51 => array('W-60-1'),
	52 => array('W-60-2'),
	53 => array('W-58-2'),
	54 => array('W-58-1'),
	55 => array('W-59-2'),
	56 => array('W-59-1'),
	57 => array('W-61-2'),
	58 => array('W-61-1'),
	59 => array('W-62-2'),
	60 => array('W-62-1'),
	61 => array('W-64-1', 'L-63-1'),
	62 => array('W-64-2', 'L-63-2'),
);

$gruppenids = array("A", "B", "C", "D", "E", "F", "G", "H");

// Nur EM: Beste Dritte-Regelung
$spiele_mit_dritten = array(38, 39, 40, 41);
$spiele_mit_dritten_team2 = array("A/C/D", "B/E/F", "C/D/E", "A/B/F");
$spiele_mit_dritten_dritte_aus_gruppen = array(array("A", "C", "D"), array("B", "E", "F"), array("C", "D", "E"), array("A", "B", "F"));

function getSpieleMitDrittenTeam1() {
	global $lang;
	return array("{$lang->items['LANG_ACP_EM2020_CORRECT8_9']} B", "{$lang->items['LANG_ACP_EM2020_CORRECT8_9']} D", "{$lang->items['LANG_ACP_EM2020_CORRECT8_9']} A", "{$lang->items['LANG_ACP_EM2020_CORRECT8_9']} C");
}
// -

// Konfiguration Ende