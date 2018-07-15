<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_WM2018_TPL_TIPPABGABE_1']}</title>
	$headinclude
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="em2020.php?action=index{$SID_ARG_2ND}">{$lang->items['LANG_WM2018_TPL_TIPPABGABE_2']}</a> &raquo; {$lang->items['LANG_WM2018_TPL_TIPPABGABE_3']}</b>
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
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder" id="tippabgabetable">
		<tr>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_TIPPABGABE_4']}</u>
					</b>
				</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center">
				<span class="smallfont">{$lang->items['LANG_WM2018_TPL_TIPPABGABE_5']}</span>
			</td>
		</tr>
	</table>
	$em2020_tippabgabe_wm $em2020_tippabgabe_vwm
	<hr />
	<center>$error</center>
	<form method="post" action="em2020.php?action=tippabgabe">
		<input type="hidden" name="send" value="send" />
		<input type="hidden" name="gameid" value="$_REQUEST[gameid]" />
		<input type="hidden" name="name1" value="$name1" />
		<input type="hidden" name="name2" value="$name2" />
		<input type="hidden" name="sid" value="$session[hash]" />
		<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
			<tr align="center">
				<td class="tablea" align="right" width="50%">
					<span class="normalfont">
						<b>$name1</b>&nbsp;<img src="images/em2020/flaggen/$flagge1" alt="$name1" title="$name1" /></span>&nbsp;&nbsp;
					<input type="number" min="0" class="input" name="tipp_1" size="5"/>
				</td>
				<td class="tablea" align="left" width="50%">
					<input type="number" min="0" class="input" name="tipp_2" size="5"/>&nbsp;&nbsp;<img src="images/em2020/flaggen/$flagge2" alt="$name2" title="$name2" />&nbsp;
					<span class="normalfont">
						<b>$name2</b>
					</span>
				</td>
			</tr>
		</table>
		$em2020_tippabgabe_gk $em2020_tippabgabe_rk $em2020_tippabgabe_elfer
		<p align="center">
			<input class="input" type="submit" value="{$lang->items['LANG_WM2018_GLOBAL_SAVE']}" />
			<input class="input" type="reset" value="{$lang->items['LANG_WM2018_GLOBAL_RESET']}" />
		</p>
	</form>
	<br /> $em2020_footer $footer
</body>

</html>
