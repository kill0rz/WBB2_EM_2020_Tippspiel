<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_EM2020_TPL_GAMEDETAILS_1']}</title>
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="em2020.php{$SID_ARG_1ST}">{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_2']}</a> &raquo; {$lang->items['LANG_EM2020_TPL_GAMEDETAILS_3']}</b>
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
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
		<tr>
			<td class="tabletitle" align="center" colspan="2">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_4']}</u>
					</b>
				</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_5']}</u>
					</b>
				</span>
			</td>
			<td class="tablea" align="center">
				<span class="smallfont">$result[gameid]</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_6']}</u>
					</b>
				</span>
			</td>
			<td class="tablea" align="center">
				<span class="smallfont">$gamedate, $gametime {$lang->items['LANG_EM2020_TPL_GAMEDETAILS_7']}</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_8']}</u>
					</b>
				</span>
			</td>
			<td class="tablea" align="center">
				<span class="smallfont">$type</span>
			</td>
		</tr>
		<tr>
			<td class="tableb" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_9']}</u>
					</b>
				</span>
			</td>
			<td class="tablea" align="center">
				<span class="smallfont">$result[stadion]</span>
			</td>
		</tr>
	</table>
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
		<tr>
			<td class="tabletitle" align="center" colspan="4">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_10']}</u>
					</b>
				</span>
			</td>
		</tr>
		<tr>
			<td class="tablea" align="center" width="40%">
				<span class="normalfont">
					<b>$name1</b>&nbsp;<img src="images/em2020/flaggen/$flagge1" alt="name1" title="name1" /></span>&nbsp;&nbsp;</td>
			<td class="tablea" align="center" width="5%">
				<span class="normalfont">$result[game_goals_1]</span>
			</td>
			<td class="tablea" align="center" width="5%">
				<span class="normalfont">$result[game_goals_2]</span>
			</td>
			<td class="tablea" align="center" width="40%">&nbsp;&nbsp;<img src="images/em2020/flaggen/$flagge2" alt="name2" title="name2" />&nbsp;
				<span class="normalfont">
					<b>$name2</b>
				</span>
			</td>
		</tr>
	</table>
	<if($em2020_options[ 'gk_jn']==1 || $em2020_options[ 'rk_jn']==1 || $em2020_options[ 'elfer_jn']==1)>
		<then>
			<br />
			<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
				<tr>
					<td class="tabletitle" align="center" colspan="4">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_11']}</u>
							</b>
						</span>
					</td>
				</tr>
				$gamed_gk
				$gamed_rk
				$gamed_elfer
				$gamed_stillrunning
			</table>
		</then>
	</if>
	<if($linkjn==1)>
		<then>
			<br />
			<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
				<tr>
					<td class="tabletitle" align="center" colspan="4">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_12']}</u>
							</b>
						</span>
					</td>
				</tr>
				$link
			</table>
		</then>
	</if>
	<if($commentjn==1)>
		<then>
			<br />
			<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
				<tr>
					<td class="tabletitle" align="center" colspan="4">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_EM2020_TPL_GAMEDETAILS_13']}</u>
							</b>
						</span>
					</td>
				</tr>
				$comment2
			</table>
		</then>
	</if>

	$em2020_tippsprogame_include
	$em2020_footer $footer
</body>

</html>
