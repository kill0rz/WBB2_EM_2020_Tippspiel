--------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_em2020_options`
-- 

DROP TABLE IF EXISTS `bb1_em2020_options`;
CREATE TABLE `bb1_em2020_options` (
  `em2020aktiv` int(1) NOT NULL default '1',
  `showrssnews` int(1) NOT NULL default '1',
  `rssnews` int(5) NOT NULL default '5',
  `rssnews_showfeed` varchar(10) NOT NULL default 'fifa',
  `emticker_width` int(5) NOT NULL default '800',
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
  `lastgame4emtipp` int(3) NOT NULL default '48',
  `gh_aktiv` int(1) NOT NULL default '0',
  `gh_infos` int(1) NOT NULL default '1',
  `gh_ab_normtipp` int(5) NOT NULL default '10',
  `gh_ab_emtipp` int(5) NOT NULL default '10',
  `gh_gut_normtipp_richtig` int(5) NOT NULL default '25',
  `gh_gut_normtipp_tendenz` int(5) NOT NULL default '15',
  `gh_gut_emtipp_richtig` int(5) NOT NULL default '150',
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
  `vprefix` varchar(50) NOT NULL default 'EM2020',
  `vgposthtml` int(11) NOT NULL default '0',
  `diskussionsthreadid` int(11) NOT NULL DEFAULT '0',
  `lasttageswertungreset` int(11) NOT NULL default '0',
  `showrssnews_method` int(11) NOT NULL default '0',
  `showtableonindex_nontippedgames` int(1) NOT NULL default '0',
  `showtableonindex_donegames` int(1) NOT NULL default '0',
  `showtableonindex_donegamescount` int(1) NOT NULL default '4'

) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_em2020_options`
-- 

INSERT INTO `bb1_em2020_options` (`message`) VALUES ('Hallo,\r\n\r\nhier das Ergebnis von Spiel [B]{vgp_gameid}[/B] der Gruppe [B]{vgp_gruppe}[/B].\r\n\r\nDas Spiel fand in {vgp_stadion}, am {vgp_datum} um {vgp_zeit} Uhr statt.\r\n\r\n[CENTER][B]{vgp_name1}[/B] {vgp_flagge1} - [B]{vgp_name2}[/B] {vgp_flagge2}[/CENTER]\r\n[CENTER][SIZE=16][B]{vgp_tore1}[/B] - [B]{vgp_tore2}[/B][/SIZE][/CENTER]\r\n\r\nGelbe-Karten: [B]{vgp_gk}[/B]\r\nRote-Karten: [B]{vgp_rk}[/B]\r\nElfmeter: [B]{vgp_elfer} [/B]\r\n\r\nEs haben [B]{vgp_anztipp}[/B] User am Tipp für das Spiel teilgenommen.\r\n\r\nHier mehr zum Spiel: {vgp_glink}\r\n\r\nMein Kommentar zum Spiel:\r\n {vgp_comment}\r\n\r\n[B][SIZE=16][CENTER]Aktuelles Top-User-Ranking:[/CENTER][/SIZE][/B]\r\n[CENTER]{vgp_user_ranking_01} [/CENTER]\r\n[CENTER]{vgp_user_ranking_02} [/CENTER]\r\n[CENTER]{vgp_user_ranking_03} [/CENTER]\r\n[CENTER]{vgp_user_ranking_04} [/CENTER]\r\n[CENTER]{vgp_user_ranking_05} [/CENTER]\r\n[CENTER]{vgp_user_ranking_06} [/CENTER]\r\n[CENTER]{vgp_user_ranking_07} [/CENTER]\r\n[CENTER]{vgp_user_ranking_08} [/CENTER]\r\n[CENTER]{vgp_user_ranking_09} [/CENTER]\r\n[CENTER]{vgp_user_ranking_10} [/CENTER]');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_em2020_punkte`
-- 

DROP TABLE IF EXISTS `bb1_em2020_punkte`;
CREATE TABLE `bb1_em2020_punkte` (
  `punkteid` int(2) unsigned NOT NULL auto_increment,
  `desc` varchar(100) NOT NULL default '',
  `wert` int(5) NOT NULL default '0',
  PRIMARY KEY  (`punkteid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Daten für Tabelle `bb1_em2020_punkte`
-- 

INSERT INTO `bb1_em2020_punkte` (`punkteid`, `desc`, `wert`) VALUES (1, 'Exaktes Ergebnis', 10);
INSERT INTO `bb1_em2020_punkte` (`punkteid`, `desc`, `wert`) VALUES (2, 'Tendenz richtig', 5);
INSERT INTO `bb1_em2020_punkte` (`punkteid`, `desc`, `wert`) VALUES (3, 'Gelbe Karten', 3);
INSERT INTO `bb1_em2020_punkte` (`punkteid`, `desc`, `wert`) VALUES (4, 'Rote Karten', 3);
INSERT INTO `bb1_em2020_punkte` (`punkteid`, `desc`, `wert`) VALUES (5, 'Elfmeter', 3);
INSERT INTO `bb1_em2020_punkte` (`punkteid`, `desc`, `wert`) VALUES (6, 'Europameister', 150);
INSERT INTO `bb1_em2020_punkte` (`punkteid`, `desc`, `wert`) VALUES (7, 'Vize-Europameister', 100);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_em2020_spiele`
-- 

DROP TABLE IF EXISTS `bb1_em2020_spiele`;
CREATE TABLE `bb1_em2020_spiele` (
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
-- Daten für Tabelle `bb1_em2020_spiele`
-- 

INSERT INTO `bb1_em2020_spiele` (`gameid`, `gruppe`, `datetime`, `stadion`, `team_1_id`, `team_2_id`, `game_gk`, `game_rk`, `game_elfer`, `game_goals_1`, `game_goals_2`, `gamelink`, `gamecomment`, `tipps`) VALUES
(1,  'A', 1591995600, 'Rom', '1', '2', 0, 0, 0, '', '', '', '', 0),
(2,  'A', 000000000, 'Baku', '3', '4', 0, 0, 0, '', '', '', '', 0),
(3,  'B', 000000000, 'Kopenhagen', '7', '8', 0, 0, 0, '', '', '', '', 0),
(4,  'B', 000000000, 'Sankt Petersburg', '5', '6', 0, 0, 0, '', '', '', '', 0),
(5,  'C', 000000000, 'Amsterdam', '9', '10', 0, 0, 0, '', '', '', '', 0),
(6,  'C', 000000000, 'Bukarest', '13', '14', 0, 0, 0, '', '', '', '', 0),
(7,  'D', 000000000, 'London', '11', '12', 0, 0, 0, '', '', '', '', 0),
(8,  'D', 000000000, 'Glasgow', '15', '16', 0, 0, 0, '', '', '', '', 0),
(9,  'E', 000000000, 'Bilbao', '19', '20', 0, 0, 0, '', '', '', '', 0),
(10, 'E', 000000000, 'Dublin', '21', '22', 0, 0, 0, '', '', '', '', 0),
(11, 'F', 000000000, 'Budapest', '17', '18', 0, 0, 0, '', '', '', '', 0),
(12, 'F', 000000000, 'München', '23', '24', 0, 0, 0, '', '', '', '', 0),
(13, 'A', 000000000, 'Baku', '1', '3', 0, 0, 0, '', '', '', '', 0),
(14, 'A', 000000000, 'Rom', '5', '7', 0, 0, 0, '', '', '', '', 0),
(15, 'B', 000000000, 'Sankt Petersburg', '4', '2', 0, 0, 0, '', '', '', '', 0),
(16, 'B', 000000000, 'Kopenhagen', '8', '6', 0, 0, 0, '', '', '', '', 0),
(17, 'C', 000000000, 'Amsterdam', '12', '10', 0, 0, 0, '', '', '', '', 0),
(18, 'C', 000000000, 'Bukarest', '9', '11', 0, 0, 0, '', '', '', '', 0),
(19, 'D', 000000000, 'Glasgow', '13', '15', 0, 0, 0, '', '', '', '', 0),
(20, 'D', 000000000, 'London', '17', '19', 0, 0, 0, '', '', '', '', 0),
(21, 'D', 000000000, 'Dublin', '16', '14', 0, 0, 0, '', '', '', '', 0),
(22, 'E', 000000000, 'Bilbao', '20', '18', 0, 0, 0, '', '', '', '', 0),
(23, 'E', 000000000, 'Budapest', '25', '27', 0, 0, 0, '', '', '', '', 0),
(24, 'F', 000000000, 'München', '24', '22', 0, 0, 0, '', '', '', '', 0),
(25, 'F', 000000000, 'Baku', '21', '23', 0, 0, 0, '', '', '', '', 0),
(26, 'A', 000000000, 'Rom', '28', '26', 0, 0, 0, '', '', '', '', 0),
(27, 'A', 000000000, 'Kopenhagen', '32', '30', 0, 0, 0, '', '', '', '', 0),
(28, 'B', 000000000, 'Sankt Petersburg', '29', '31', 0, 0, 0, '', '', '', '', 0),
(29, 'B', 000000000, 'Amsterdam', '4', '1', 0, 0, 0, '', '', '', '', 0),
(30, 'C', 000000000, 'Bukarest', '2', '3', 0, 0, 0, '', '', '', '', 0),
(31, 'C', 000000000, 'Glasgow', '2', '3', 0, 0, 0, '', '', '', '', 0),
(32, 'C', 000000000, 'London', '2', '3', 0, 0, 0, '', '', '', '', 0),
(33, 'C', 000000000, 'Bilbao', '2', '3', 0, 0, 0, '', '', '', '', 0),
(34, 'C', 000000000, 'Dublin', '2', '3', 0, 0, 0, '', '', '', '', 0),
(35, 'C', 000000000, 'Budapest', '2', '3', 0, 0, 0, '', '', '', '', 0),
(36, 'C', 000000000, 'München', '2', '3', 0, 0, 0, '', '', '', '', 0), #todo prüfen

(37, '8', 000000000, 'London', 'W-A', 'S-C', 0, 0, 0, '', '', '', '', 0),
(38, '8', 000000000, 'Amsterdam', 'S-A', 'S-C', 0, 0, 0, '', '', '', '', 0),
(39, '8', 000000000, 'Bilbao', 'W-B', 'D-A/D/E/F', 0, 0, 0, '', '', '', '', 0),
(40, '8', 000000000, 'Budapest', 'W-C', 'D-D/E/F', 0, 0, 0, '', '', '', '', 0),
(41, '8', 000000000, 'Bukarest', 'W-F', 'D-A/B/C', 0, 0, 0, '', '', '', '', 0),
(42, '8', 000000000, 'Kopenhagen', 'S-D', 'S-E', 0, 0, 0, '', '', '', '', 0),
(43, '8', 000000000, 'Glasgow', 'S-D', 'D-A/B/C/D', 0, 0, 0, '', '', '', '', 0),
(44, '8', 000000000, 'Dublin', 'W-D', 'S-F', 0, 0, 0, '', '', '', '', 0),
(45, '4', 1593799200, 'Sankt Petersburg', 'W-40', 'W-41', 0, 0, 0, '', '', '', '', 0),
(46, '4', 1593810000, 'München', 'W-38', 'W-36', 0, 0, 0, '', '', '', '', 0),
(47, '4', 1593894400, 'Baku', 'W-39', 'W-37', 0, 0, 0, '', '', '', '', 0),
(48, '4', 1593896400, 'Rom', 'W-42', 'W-43', 0, 0, 0, '', '', '', '', 0),
(49, '2', 1594155600, 'London', 'W-44', 'W-45', 0, 0, 0, '', '', '', '', 0),
(50, '2', 1594242000, 'London', 'L-46', 'L-47', 0, 0, 0, '', '', '', '', 0),
(51, '1', 1594587600, 'London', 'W-48', 'W-49', 0, 0, 0, '', '', '', '', 0);
# hint: https://www.fussball-wm.pro/em-2020/spielplan/

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_em2020_teams`
-- 

DROP TABLE IF EXISTS `bb1_em2020_teams`;
CREATE TABLE `bb1_em2020_teams` (
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
-- Daten für Tabelle `bb1_em2020_teams`
-- 

INSERT INTO `bb1_em2020_teams` (`teamid`, `name`, `gruppe`, `flagge`, `spiele`, `g`, `v`, `u`, `td`, `punkte`) VALUES
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
-- Tabellenstruktur für Tabelle `bb1_em2020_userpunkte`
-- 

DROP TABLE IF EXISTS `bb1_em2020_userpunkte`;
CREATE TABLE `bb1_em2020_userpunkte` (
  `userid` int(5) NOT NULL default '0',
  `punkte` int(10) NOT NULL default '0',
  `tipps_gesamt` int(5) NOT NULL default '0',
  `tipps_richtig` int(5) NOT NULL default '0',
  `tipps_falsch` int(5) NOT NULL default '0',
  `tipps_tendenz` int(5) NOT NULL default '0',
  `tipp_em` int(5) NOT NULL default '0',
  `tipp_vem` int(5) NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_em2020_userpunkte`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `bb1_em2020_usertipps`
-- 

DROP TABLE IF EXISTS `bb1_em2020_usertipps`;
CREATE TABLE `bb1_em2020_usertipps` (
  `userid` int(11) NOT NULL default '0',
  `gameid` int(5) NOT NULL default '0',
  `goals_1` int(2) NOT NULL default '0',
  `goals_2` int(2) NOT NULL default '0',
  `gk` smallint(5) NOT NULL default '0',
  `rk` smallint(5) NOT NULL default '0',
  `elfer` smallint(5) NOT NULL default '0'
) ENGINE=MyISAM;

-- 
-- Daten für Tabelle `bb1_em2020_usertipps`
-- 

DROP TABLE IF EXISTS `bb1_em2020_bestedrittetmp`;
CREATE TABLE `bb1_em2020_bestedrittetmp` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `teamid` int(11) NOT NULL,
 `punkte` int(11) NOT NULL,
 `td` int(11) NOT NULL,
 `g` int(11) NOT NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `bb1_em2020_vortag`;
CREATE TABLE `bb1_em2020_vortag` (
  `pos` int(3) NOT NULL AUTO_INCREMENT,
  `userid` int(5) DEFAULT NULL,
  `punkte` int(10) DEFAULT NULL,
  PRIMARY KEY (`pos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- UNIQUE für Tabelle `bb1_em2020_userpunkte` setzen
-- 

ALTER TABLE `bb1_em2020_userpunkte` ADD UNIQUE(`userid`);
ALTER TABLE `bb1_em2020_vortag` ADD `id` int(5) NULL AUTO_INCREMENT UNIQUE FIRST, CHANGE `userid` `userid` int(10) NULL AFTER `id`, CHANGE `pos` `pos` int(10) NOT NULL AFTER `punkte`;
ALTER TABLE `bb1_em2020_vortag` ADD PRIMARY KEY `id` (`id`), DROP INDEX `PRIMARY`;

-- Fix falsche Spielzeiten wegen Sommerzeit
-- UPDATE `bb1_em2020_spiele` SET `datetime` = `datetime`-3600;
