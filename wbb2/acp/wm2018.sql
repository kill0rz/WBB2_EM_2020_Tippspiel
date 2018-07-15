--------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_options`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_options`;
CREATE TABLE `bb1_wm2018_options` (
  `wm2018aktiv` int(1) NOT NULL default '1',
  `showrssnews` int(1) NOT NULL default '1',
  `rssnews` int(5) NOT NULL default '5',
  `rssnews_showfeed` varchar(10) NOT NULL default 'fifa',
  `wmticker_width` int(5) NOT NULL default '800',
  `nextxgames` int(3) NOT NULL default '4',
  `nonaddedgamescount` int(3) NOT NULL default '4',
  `currentgamescount` int(3) NOT NULL default '4',
  `topuser` int(3) NOT NULL default '10',
  `tipptime` int(10) NOT NULL default '300',
  `tendenz` int(1) NOT NULL default '1',
  `gk_jn` int(1) NOT NULL default '1',
  `rk_jn` int(1) NOT NULL default '1',
  `elfer_jn` int(1) NOT NULL default '1',
  `winnertipp_jn` int(1) NOT NULL default '1',
  `lastgame4wmtipp` int(3) NOT NULL default '48',
  `gh_aktiv` int(1) NOT NULL default '0',
  `gh_infos` int(1) NOT NULL default '1',
  `gh_ab_normtipp` int(5) NOT NULL default '10',
  `gh_ab_wmtipp` int(5) NOT NULL default '10',
  `gh_gut_normtipp_richtig` int(5) NOT NULL default '25',
  `gh_gut_normtipp_tendenz` int(5) NOT NULL default '15',
  `gh_gut_wmtipp_richtig` int(5) NOT NULL default '150',
  `1st` int(3) NOT NULL default '0',
  `2nd` int(3) NOT NULL default '0',
  `3rd` int(3) NOT NULL default '0',
  `ebay_rel_aktiv` int(1) NOT NULL default '0',
  `ebay_pub_id` int(11) NOT NULL default '178702',
  `ebay_cat` int(11) NOT NULL default '0',
  `po_aktiv` int(1) NOT NULL default '0',
  `vgposttid` int(11) NOT NULL default '0',
  `vgpostuid` int(11) NOT NULL default '0',
  `viconid` int(11) NOT NULL default '0',
  `vgthema` varchar(100) NOT NULL default 'Ergebnis: {vgp_name1} - {vgp_name2}',
  `message` text NOT NULL,
  `vboardid` int(11) NOT NULL default '0',
  `vprefix` varchar(50) NOT NULL default 'WM2018',
  `vgposthtml` int(11) NOT NULL default '0',
  `diskussionsthreadid` int(11) NOT NULL DEFAULT '0',
  `lasttageswertungreset` int(11) NOT NULL default '0',
  `showrssnews_method` int(11) NOT NULL default '0',
  `showtableonindex_nontippedgames` int(1) NOT NULL default '0',
  `showtableonindex_donegames` int(1) NOT NULL default '0',
  `showtableonindex_donegamescount` int(1) NOT NULL default '4'

) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_wm2018_options`
-- 

INSERT INTO `bb1_wm2018_options` (`message`) VALUES ('Hallo,\r\n\r\nhier das Ergebnis von Spiel [B]{vgp_gameid}[/B] der Gruppe [B]{vgp_gruppe}[/B].\r\n\r\nDas Spiel fand in {vgp_stadion}, am {vgp_datum} um {vgp_zeit} Uhr statt.\r\n\r\n[CENTER][B]{vgp_name1}[/B] {vgp_flagge1} - [B]{vgp_name2}[/B] {vgp_flagge2}[/CENTER]\r\n[CENTER][SIZE=16][B]{vgp_tore1}[/B] - [B]{vgp_tore2}[/B][/SIZE][/CENTER]\r\n\r\nGelbe-Karten: [B]{vgp_gk}[/B]\r\nRote-Karten: [B]{vgp_rk}[/B]\r\nElfmeter: [B]{vgp_elfer} [/B]\r\n\r\nEs haben [B]{vgp_anztipp}[/B] User am Tipp für das Spiel teilgenommen.\r\n\r\nHier mehr zum Spiel: {vgp_glink}\r\n\r\nMein Kommentar zum Spiel:\r\n {vgp_comment}\r\n\r\n[B][SIZE=16][CENTER]Aktuelles Top-User-Ranking:[/CENTER][/SIZE][/B]\r\n[CENTER]{vgp_user_ranking_01} [/CENTER]\r\n[CENTER]{vgp_user_ranking_02} [/CENTER]\r\n[CENTER]{vgp_user_ranking_03} [/CENTER]\r\n[CENTER]{vgp_user_ranking_04} [/CENTER]\r\n[CENTER]{vgp_user_ranking_05} [/CENTER]\r\n[CENTER]{vgp_user_ranking_06} [/CENTER]\r\n[CENTER]{vgp_user_ranking_07} [/CENTER]\r\n[CENTER]{vgp_user_ranking_08} [/CENTER]\r\n[CENTER]{vgp_user_ranking_09} [/CENTER]\r\n[CENTER]{vgp_user_ranking_10} [/CENTER]');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_punkte`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_punkte`;
CREATE TABLE `bb1_wm2018_punkte` (
  `punkteid` int(2) unsigned NOT NULL auto_increment,
  `desc` varchar(100) NOT NULL default '',
  `wert` int(5) NOT NULL default '0',
  PRIMARY KEY  (`punkteid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Daten für Tabelle `bb1_wm2018_punkte`
-- 

INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (1, 'Exaktes Ergebnis', 10);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (2, 'Tendenz richtig', 5);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (3, 'Gelbe Karten', 3);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (4, 'Rote Karten', 3);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (5, 'Elfmeter', 3);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (6, 'Weltmeister', 100);
INSERT INTO `bb1_wm2018_punkte` (`punkteid`, `desc`, `wert`) VALUES (7, 'Vize-Weltmeister', 100);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_spiele`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_spiele`;
CREATE TABLE `bb1_wm2018_spiele` (
  `gameid` int(5) unsigned NOT NULL auto_increment,
  `gruppe` varchar(5) NOT NULL default '',
  `datetime` int(11) NOT NULL default '0',
  `stadion` varchar(50) NOT NULL default '',
  `team_1_id` varchar(5) NOT NULL default '0',
  `team_2_id` varchar(5) NOT NULL default '0',
  `game_gk` int(1) NOT NULL default '0',
  `game_rk` int(1) NOT NULL default '0',
  `game_elfer` int(1) NOT NULL default '0',
  `game_goals_1` char(2) NOT NULL default '',
  `game_goals_2` char(2) NOT NULL default '',
  `gamelink` varchar(16000) NOT NULL default '',
  `gamecomment` text NOT NULL,
  `tipps` int(5) NOT NULL default '0',
  `post_id` int(10),
  PRIMARY KEY  (`gameid`)
) ENGINE=MyISAM AUTO_INCREMENT=52 ;

-- 
-- Daten für Tabelle `bb1_wm2018_spiele`
-- 

INSERT INTO `bb1_wm2018_spiele` (`gameid`, `gruppe`, `datetime`, `stadion`, `team_1_id`, `team_2_id`, `game_gk`, `game_rk`, `game_elfer`, `game_goals_1`, `game_goals_2`, `gamelink`, `gamecomment`, `tipps`) VALUES
(1, 'A',  1528992000, 'Moskau',  '1',  '2',  0,  0,  0,  '', '', '', '', 0),
(2, 'A',  1529067600, 'Jekaterinburg',  '3',  '4',  0,  0,  0,  '', '', '', '', 0),
(3, 'B',  1529078400, 'Sotschi',  '7',  '8',  0,  0,  0,  '', '', '', '', 0),
(4, 'B',  1529089200, 'Sankt Petersburg',  '5',  '6',  0,  0,  0,  '', '', '', '', 0),
(5, 'C',  1529146800, 'Kasan',  '9',  '10',  0,  0,  0,  '', '', '', '', 0),
(6, 'D',  1529157600, 'Moskau',  '13',  '14',  0,  0,  0,  '', '', '', '', 0),
(7, 'C',  1529168400, 'Saransk',  '11',  '12',  0,  0,  0,  '', '', '', '', 0),
(8, 'D',  1529179200, 'Kaliningrad',  '15',  '16',  0,  0,  0,  '', '', '', '', 0),
(9, 'E',  1529240400, 'Rostow am Don',  '19',  '20',  0,  0,  0,  '', '', '', '', 0),
(10, 'F',  1529251200, 'Moskau',  '21',  '22',  0,  0,  0,  '', '', '', '', 0),
(11, 'E',  1529262000, 'Samara',  '17',  '18',  0,  0,  0,  '', '', '', '', 0),
(12, 'F',  1529326800, 'Nischni Nowgorod',  '23',  '24',  0,  0,  0,  '', '', '', '', 0),
(13,  'G',  1529337600, 'Sotschi',  '25',  '26',  0,  0,  0,  '', '', '', '', 0),
(14,  'G',  1529348400, 'Wolgograd',  '27',  '28',  0,  0,  0,  '', '', '', '', 0),
(15,  'H',  1529413200, 'Moskau',  '31',  '32',  0,  0,  0,  '', '', '', '', 0),
(16,  'H',  1529424000, 'Saransk',  '29',  '30',  0,  0,  0,  '', '', '', '', 0),
(17,  'A',  1529434800, 'Sankt Petersburg',  '1',  '3',  0,  0,  0,  '', '', '', '', 0),
(18,  'B',  1529499600, 'Moskau',  '5',  '7',  0,  0,  0,  '', '', '', '', 0),
(19,  'A',  1529510400, 'Rostow am Don',  '4',  '2',  0,  0,  0,  '', '', '', '', 0),
(20,  'B',  1529521200, 'Kasan',  '8',  '6',  0,  0,  0,  '', '', '', '', 0),
(21,  'C',  1529586000, 'Kaliningrad',  '12',  '10',  0,  0,  0,  '', '', '', '', 0),
(22,  'C',  1529596800, 'Samara',  '9',  '11',  0,  0,  0,  '', '', '', '', 0),
(23,  'D',  1529607600, 'Nischni Nowgorod',  '13',  '15',  0,  0,  0,  '', '', '', '', 0),
(24,  'E',  1529672400, 'Sankt Petersburg',  '17',  '19',  0,  0,  0,  '', '', '', '', 0),
(25,  'D',  1529683200, 'Wolgograd',  '16',  '14',  0,  0,  0,  '', '', '', '', 0),
(26,  'E',  1529694000, 'Jekaterinburg',  '20',  '18',  0,  0,  0,  '', '', '', '', 0),
(27,  'G',  1529758800, 'Moskau',  '25',  '27',  0,  0,  0,  '', '', '', '', 0),
(28,  'F',  1529769600, 'Sotschi',  '24',  '22',  0,  0,  0,  '', '', '', '', 0),
(29,  'F',  1529780400, 'Rostow am Don',  '21',  '23',  0,  0,  0,  '', '', '', '', 0),
(30,  'G',  1529845200, 'Nischni Nowgorod',  '28',  '26',  0,  0,  0,  '', '', '', '', 0),
(31,  'H',  1529856000, 'Kasan',  '32',  '30',  0,  0,  0,  '', '', '', '', 0),
(32,  'H',  1529866800, 'Kaliningrad',  '29',  '31',  0,  0,  0,  '', '', '', '', 0),
(33,  'A',  1529938800, 'Samara',  '4',  '1',  0,  0,  0,  '', '', '', '', 0),
(34,  'A',  1529938800, 'Wolgograd',  '2',  '3',  0,  0,  0,  '', '', '', '', 0),
(35,  'B',  1529953200, 'Saransk',  '6',  '7',  0,  0,  0,  '', '', '', '', 0),
(36,  'B',  1529953200, 'Jekaterinburg',  '8',  '5',  0,  0,  0,  '', '', '', '', 0),
(37,  'C',  1530025200, 'Moskau',  '12',  '9',  0,  0,  0,  '', '', '', '', 0),
(38,  'C',  1530025200, 'Sotschi',  '10',  '11',  0,  0,  0,  '', '', '', '', 0),
(39,  'D',  1530039600, 'Sankt Petersburg',  '14',  '15',  0,  0,  0,  '', '', '', '', 0),
(40,  'D',  1530039600, 'Rostow am Don',  '16',  '13',  0,  0,  0,  '', '', '', '', 0),
(41,  'F',  1530111600, 'Kasan',  '20',  '17',  0,  0,  0,  '', '', '', '', 0),
(42,  'F',  1530111600, 'Kaliningrad',  '18',  '19',  0,  0,  0,  '', '', '', '', 0),
(43,  'E',  1530126000, 'Moskau',  '24',  '21',  0,  0,  0,  '', '', '', '', 0),
(44,  'E',  1530126000, 'Nischni Nowgorod',  '22',  '23',  0,  0,  0,  '', '', '', '', 0),
(45,  'H',  1530198000, 'Wolgograd',  '28',  '25',  0,  0,  0,  '', '', '', '', 0),
(46,  'H',  1530198000, 'Samara',  '26',  '27',  0,  0,  0,  '', '', '', '', 0),
(47,  'G',  1530212400, 'Jekaterinburg',  '29',  '32',  0,  0,  0,  '', '', '', '', 0),
(48,  'G',  1530212400, 'Saransk',  '30',  '31',  0,  0,  0,  '', '', '', '', 0),
(49,  '8',  1530370800, 'Sotschi',  'W-C',  'S-D',  0,  0,  0,  '', '', '', '', 0),
(50,  '8',  1530385200, 'Kasan',  'W-A',  'S-B',  0,  0,  0,  '', '', '', '', 0),
(51,  '8',  1530457200, 'Moskau',  'W-B',  'S-A',  0,  0,  0,  '', '', '', '', 0),
(52,  '8',  1530471600, 'Nischni Nowgorod',  'W-D',  'S-C',  0,  0,  0,  '', '', '', '', 0),
(53,  '8',  1530543600, 'Samara',  'W-G',  'S-H',  0,  0,  0,  '', '', '', '', 0),
(54,  '8',  1530558000, 'Rostow am Don',  'W-E',  'S-F',  0,  0,  0,  '', '', '', '', 0),
(55,  '8',  1530630000, 'Sankt Petersburg',  'W-H',  'S-G',  0,  0,  0,  '', '', '', '', 0),
(56,  '8',  1530644400, 'Moskau',  'W-F',  'S-E',  0,  0,  0,  '', '', '', '', 0),
(57,  '4',  1530889200, 'Nischni Nowgorod',  'W-49', 'W-50', 0,  0,  0,  '', '', '', '', 0),
(58,  '4',  1530903600, 'Kasan',  'W-54', 'W-53', 0,  0,  0,  '', '', '', '', 0),
(59,  '4',  1530975600, 'Sotschi',  'W-56', 'W-55', 0,  0,  0,  '', '', '', '', 0),
(60,  '4',  1530990000, 'Samara',  'W-51', 'W-52', 0,  0,  0,  '', '', '', '', 0),
(61,  '2',  1531249200, 'Sankt Petersburg',  'W-58', 'W-57', 0,  0,  0,  '', '', '', '', 0),
(62,  '2',  1531335600, 'Moskau',  'W-60', 'W-59', 0,  0,  0,  '', '', '', '', 0),
(63,  '3',  1531580400, 'Sankt Petersburg',  'L-61', 'L-62', 0,  0,  0,  '', '', '', '', 0),
(64,  '1',  1531670400, 'Moskau',  'W-61', 'W-62', 0,  0,  0,  '', '', '', '', 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_teams`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_teams`;
CREATE TABLE `bb1_wm2018_teams` (
  `teamid` int(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `gruppe` varchar(10) NOT NULL default '',
  `flagge` varchar(50) NOT NULL default '',
  `spiele` int(2) NOT NULL default '0',
  `g` int(2) NOT NULL default '0',
  `v` int(2) NOT NULL default '0',
  `u` int(2) NOT NULL default '0',
  `td` int(2) NOT NULL default '0',
  `punkte` int(3) NOT NULL default '0',
  PRIMARY KEY  (`teamid`)
) ENGINE=MyISAM AUTO_INCREMENT=33 ;

-- 
-- Daten für Tabelle `bb1_wm2018_teams`
-- 

INSERT INTO `bb1_wm2018_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES
(1, 'Russland', 'A',  'ru.png', 0,  0,  0,  0,  0,  0),
(2, 'Saudi-Arabien',  'A',  'sa.png',  0,  0,  0,  0,  0,  0),
(3, '&Auml;gypten',  'A',  'eg.png',  0,  0,  0,  0,  0,  0),
(4, 'Uruguay',  'A',  'uy.png',  0,  0,  0,  0,  0,  0),
(5, 'Portugal',  'B',  'pt.png',  0,  0,  0,  0,  0,  0),
(6, 'Spanien',  'B',  'es.png',  0,  0,  0,  0,  0,  0),
(7, 'Marokko',  'B',  'ma.png',  0,  0,  0,  0,  0,  0),
(8, 'Iran',  'B',  'ir.png',  0,  0,  0,  0,  0,  0),
(9, 'Frankreich',  'C',  'fr.png',  0,  0,  0,  0,  0,  0),
(10,  'Australien',  'C',  'au.png',  0,  0,  0,  0,  0,  0),
(11,  'Peru',  'C',  'pe.png',  0,  0,  0,  0,  0,  0),
(12,  'D&auml;nemark',  'C',  'dk.png',  0,  0,  0,  0,  0,  0),
(13,  'Argentinien',  'D',  'ar.png',  0,  0,  0,  0,  0,  0),
(14,  'Island',  'D',  'is.png',  0,  0,  0,  0,  0,  0),
(15,  'Kroatien',  'D',  'hr.png',  0,  0,  0,  0,  0,  0),
(16,  'Nigeria',  'D',  'ng.png',  0,  0,  0,  0,  0,  0),
(17,  'Brasilien',  'E',  'br.png',  0,  0,  0,  0,  0,  0),
(18,  'Schweiz',  'E',  'ch.png',  0,  0,  0,  0,  0,  0),
(19,  'Costa Rica',  'E',  'cr.png',  0,  0,  0,  0,  0,  0),
(20,  'Serbien',  'E',  'rs.png',  0,  0,  0,  0,  0,  0),
(21,  'Deutschland',  'F',  'de.png',  0,  0,  0,  0,  0,  0),
(22,  'Mexiko',  'F',  'mx.png',  0,  0,  0,  0,  0,  0),
(23,  'Schweden',  'F',  'se.png',  0,  0,  0,  0,  0,  0),
(24,  'S&uuml;dkorea',  'F',  'kr.png',  0,  0,  0,  0,  0,  0),
(25,  'Belgien',  'G',  'be.png',  0,  0,  0,  0,  0,  0),
(26,  'Panama',  'G',  'pa.png',  0,  0,  0,  0,  0,  0),
(27,  'Tunesien',  'G',  'tn.png',  0,  0,  0,  0,  0,  0),
(28,  'England',  'G',  'gb.png',  0,  0,  0,  0,  0,  0),
(29,  'Polen',  'H',  'pl.png',  0,  0,  0,  0,  0,  0),
(30,  'Senegal',  'H',  'sn.png',  0,  0,  0,  0,  0,  0),
(31,  'Kolumbien',  'H',  'co.png',  0,  0,  0,  0,  0,  0),
(32,  'Japan',  'H',  'jp.png',  0,  0,  0,  0,  0,  0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_userpunkte`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_userpunkte`;
CREATE TABLE `bb1_wm2018_userpunkte` (
  `userid` int(5) NOT NULL default '0',
  `punkte` int(10) NOT NULL default '0',
  `tipps_gesamt` int(5) NOT NULL default '0',
  `tipps_richtig` int(5) NOT NULL default '0',
  `tipps_falsch` int(5) NOT NULL default '0',
  `tipps_tendenz` int(5) NOT NULL default '0',
  `tipp_wm` int(5) NOT NULL default '0',
  `tipp_vwm` int(5) NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_wm2018_userpunkte`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_wm2018_usertipps`
-- 

DROP TABLE IF EXISTS `bb1_wm2018_usertipps`;
CREATE TABLE `bb1_wm2018_usertipps` (
  `userid` int(11) NOT NULL default '0',
  `gameid` int(5) NOT NULL default '0',
  `goals_1` int(2) NOT NULL default '0',
  `goals_2` int(2) NOT NULL default '0',
  `gk` smallint(5) NOT NULL default '0',
  `rk` smallint(5) NOT NULL default '0',
  `elfer` smallint(5) NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_wm2018_usertipps`
-- 

-- DROP TABLE IF EXISTS `bb1_wm2018_bestedrittetmp`;
-- CREATE TABLE `bb1_wm2018_bestedrittetmp` (
--  `ID` int(11) NOT NULL AUTO_INCREMENT,
--  `teamid` int(11) NOT NULL,
--  `punkte` int(11) NOT NULL,
--  `td` int(11) NOT NULL,
--  `g` int(11) NOT NULL,
--  PRIMARY KEY (`ID`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `bb1_wm2018_vortag`;
CREATE TABLE `bb1_wm2018_vortag` (
  `pos` int(3) NOT NULL AUTO_INCREMENT,
  `userid` int(5) DEFAULT NULL,
  `punkte` int(10) DEFAULT NULL,
  PRIMARY KEY (`pos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- UNIQUE für Tabelle `bb1_wm2018_userpunkte` setzen
-- 

ALTER TABLE `bb1_wm2018_userpunkte` ADD UNIQUE(`userid`);
ALTER TABLE `bb1_wm2018_vortag` ADD `id` int(5) NULL AUTO_INCREMENT UNIQUE FIRST, CHANGE `userid` `userid` int(10) NULL AFTER `id`, CHANGE `pos` `pos` int(10) NOT NULL AFTER `punkte`;
ALTER TABLE `bb1_wm2018_vortag` ADD PRIMARY KEY `id` (`id`), DROP INDEX `PRIMARY`;

-- 03.06.2018: Fix falscher Spiele in Gruppen
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'E' WHERE `gameid` = '41';
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'E' WHERE `gameid` = '42';
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'F' WHERE `gameid` = '43';
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'F' WHERE `gameid` = '44';
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'G' WHERE `gameid` = '45';
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'G' WHERE `gameid` = '46';
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'H' WHERE `gameid` = '47';
UPDATE `bb1_wm2018_spiele` SET `gruppe` = 'H' WHERE `gameid` = '48';

-- 10.06.2018: Fix falsche Spielzeiten wegen Sommerzeit
UPDATE `bb1_wm2018_spiele` SET `datetime` = `datetime`-3600;

-- 24.06.2018: Fix falsche eingetragene Spieldaten
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530108000' WHERE `gameid` = '43';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530108000' WHERE `gameid` = '44';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530122400' WHERE `gameid` = '41';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530122400' WHERE `gameid` = '42';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530194400' WHERE `gameid` = '48';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530194400', `team_1_id` = '32', `team_2_id` = '29' WHERE `gameid` = '47';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530208800' WHERE `gameid` = '45';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530208800' WHERE `gameid` = '46';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530540000' WHERE `gameid` = '54';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530554400' WHERE `gameid` = '53';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530626400' WHERE `gameid` = '56';
UPDATE `bb1_wm2018_spiele` SET `datetime` = '1530640800' WHERE `gameid` = '55';
UPDATE `bb1_wm2018_spiele` SET `team_1_id` = 'W-53', `team_2_id` = 'W-54' WHERE `gameid` = '58';
UPDATE `bb1_wm2018_spiele` SET `team_1_id` = 'W-55', `team_2_id` = 'W-56' WHERE `gameid` = '59';
UPDATE `bb1_wm2018_spiele` SET `team_1_id` = 'W-59', `team_2_id` = 'W-60' WHERE `gameid` = '62';
UPDATE `bb1_wm2018_spiele` SET `team_1_id` = 'W-57', `team_2_id` = 'W-58' WHERE `gameid` = '61';