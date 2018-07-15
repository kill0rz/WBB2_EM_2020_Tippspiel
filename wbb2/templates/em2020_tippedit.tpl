<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_WM2018_TPL_TIPPEDIT_1']}</title>
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="em2020.php?action=index{$SID_ARG_2ND}">{$lang->items['LANG_WM2018_TPL_TIPPEDIT_2']}</a> &raquo; {$lang->items['LANG_WM2018_TPL_TIPPEDIT_3']}</b>
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
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_TIPPEDIT_4']}</u>
					</b>
				</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center">
				<span class="smallfont">{$lang->items['LANG_WM2018_TPL_TIPPEDIT_5']}
					<br />
					<b>$name1</b> {$lang->items['LANG_WM2018_TPL_TIPPEDIT_6']}
					<b>$name2</b>
					<br />{$lang->items['LANG_WM2018_TPL_TIPPEDIT_7']}</span>
			</td>
		</tr>
	</table>
	<br />
	<form method="post" action="em2020.php?action=edittipp">
		<input type="hidden" name="send" value="send" />
		<input type="hidden" name="gameid" value="$_REQUEST[gameid]" />
		<input type="hidden" name="datetime" value="$row_game[datetime]" />
		<input type="hidden" name="sid" value="$session[hash]" />
		<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
			<tr align="center">
				<td class="tablea" align="right" width="50%">
					<span class="normalfont">
						<b>$name1</b>&nbsp;<img src="images/em2020/flaggen/$flagge1" alt="$name1" title="$name1" /></span>&nbsp;&nbsp;
					<input type="text" class="input" name="tipp_1" value="$row_game[goals_1]" size="5" maxlength="3" />
				</td>
				<td class="tablea" align="left" width="50%">
					<input type="text" class="input" name="tipp_2" value="$row_game[goals_2]" size="5" maxlength="3" />&nbsp;&nbsp;<img src="images/em2020/flaggen/$flagge2" alt="$name2" title="$name2" />&nbsp;
					<span class="normalfont">
						<b>$name2</b>
					</span>
				</td>
			</tr>
		</table>
		$em2020_tippedit_gk $em2020_tippedit_rk $em2020_tippedit_elfer
		<p align="center">
			<input class="input" type="submit" value="{$lang->items['LANG_WM2018_GLOBAL_SAVE']}" />
		</p>
	</form>
	<br /> $em2020_footer $footer
</body>

</html>
