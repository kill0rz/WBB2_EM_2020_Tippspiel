<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_WM2018_TPL_MAKETIPP_1']}</title>
	$headinclude
	<script language="Javascript" type="text/javascript">
	<!--
	var clockid = new Array();
	var clockidoutside = new Array();
	var i_clock = -1;
	var thistime = new Date();
	var hours = thistime.getHours();
	var minutes = thistime.getMinutes();
	var seconds = thistime.getSeconds();
	if (eval(hours) < 10) { hours = "0" + hours; }
	if (eval(minutes) < 10) { minutes = "0" + minutes; }
	if (seconds < 10) { seconds = "0" + seconds; }
	var thistime = hours + ":" + minutes + ":" + seconds;

	function writeclock() {
		i_clock++;
		if (document.all || document.getElementById || document.layers) {
			clockid[i_clock] = "clock" + i_clock;
			document.write("<span id='" + clockid[i_clock] + "' style='position:relative'>" + thistime + "<\/span>");
		}
	}

	function clockon() {
		thistime = new Date();
		hours = thistime.getHours();
		minutes = thistime.getMinutes();
		seconds = thistime.getSeconds();
		if (eval(hours) < 10) { hours = "0" + hours; }
		if (eval(minutes) < 10) { minutes = "0" + minutes; }
		if (seconds < 10) { seconds = "0" + seconds; }
		thistime = hours + ":" + minutes + ":" + seconds;

		if (document.all) {
			for (i = 0; i <= clockid.length - 1; i++) {
				var thisclock = eval(clockid[i]);
				thisclock.innerHTML = thistime;
			}
		}

		if (document.getElementById) {
			for (i = 0; i <= clockid.length - 1; i++) {
				document.getElementById(clockid[i]).innerHTML = thistime;
			}
		}
		setTimeout("clockon()",1000);
	}
	window.onload = clockon();
	//-->
	</script>
</head>

<body>
	$header
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tablea">
				<table cellpadding="0" cellspacing="0" border="0" style="width:{$style['tableinwidth']}">
					<tr class="tablea_fc">
						<td align="left">
							<span class="smallfont">
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="em2020.php?action=index{$SID_ARG_2ND}">{$lang->items['LANG_WM2018_TPL_MAKETIPP_2']}</a> &raquo; {$lang->items['LANG_WM2018_TPL_MAKETIPP_3']}</b>
							</span>
						</td>
						<td align="right">
							<span class="smallfont">
								<b>$usercbar</b>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br /> $em2020_header
	<br /> $em2020_maketipp_bit_bit
	<br /> $em2020_maketipp_bit_bit_bit
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tabletitle" align="center" colspan="2">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_MAKETIPP_4']}</u>
					</b>
				</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="left" width="60%">
				<span class="smallfont">
					<b>{$lang->items['LANG_WM2018_TPL_MAKETIPP_5']}</b>
				</span>
			</td>
			<td class="tableb" align="center" width="40%">
				<span class="smallfont">
					<b>{$lang->items['LANG_WM2018_TPL_MAKETIPP_6']}</b>
				</span>
				<hr size="{$style['tableincellspacing']}" class="threadline" />
				<span class="smallfont">
					<b>{$lang->items['LANG_WM2018_TPL_MAKETIPP_7']}</span>
			</td>
		</tr>
		<tr>
			<td class="tablea" align="center" colspan="2">
				<span class="smallfont">
					<b>{$lang->items['LANG_WM2018_TPL_MAKETIPP_8']}</b>
					<a href="em2020.php?action=maketipp&amp;games_art=1{$SID_ARG_2ND}">
						<b>{$lang->items['LANG_WM2018_TPL_MAKETIPP_9']}</b>
					</a> |
					<a href="em2020.php?action=maketipp&amp;games_art=2{$SID_ARG_2ND}">
						<b>{$lang->items['LANG_WM2018_TPL_MAKETIPP_10']}</b>
					</a>
				</span>
			</td>
		</tr>
	</table>
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder" id="maketipptabelle">
		<tr>
			<td class="tabletitle" align="center" width="10%">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_MAKETIPP_11']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center" width="20%">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_MAKETIPP_12']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center" width="20%">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_MAKETIPP_13']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center" colspan="2" width="20%">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_MAKETIPP_14']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center" colspan="2" width="20%">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_MAKETIPP_15']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center"></td>
		</tr>
		$em2020_maketipp_bit
	</table>
	<br /> $em2020_footer $footer
</body>

</html>
