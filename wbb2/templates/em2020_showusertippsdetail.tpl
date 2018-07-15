<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_1']} $result_username[username]</title>
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="wm2018.php{$SID_ARG_1ST}">{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_2']}</a> &raquo; {$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_3']} $result_username[username]</b>
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
	<br /> $wm2018_header
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tableb" width="50%" align="center">
				<span class="smallfont">
					<b>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_12']}</b> $wmtipp_flagge $wmtipp_name$wmtipp_edit</span>
			</td>
			<td class="tableb" width="50%" align="center">
				<span class="smallfont">
					<b>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_13']}</b> $vwmtipp_flagge $vwmtipp_name$vwmtipp_edit</span>
			</td>
		</tr>
	</table>
	<br />
	<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
		<tr>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_4']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_5']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" colspan="2" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_6']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" colspan="2" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_7']}</u>
					</b>
				</span>
			</td>
			<if($wm2018_options['gk_jn']==1)>
				<then>
					<td class="tabletitle" colspan="2" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_8']}</u>
							</b>
						</span>
					</td>
				</then>
			</if>
			<if($wm2018_options['rk_jn']==1)>
				<then>
					<td class="tabletitle" colspan="2" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_9']}</u>
							</b>
						</span>
					</td>
				</then>
			</if>
			<if($wm2018_options['elfer_jn']==1)>
				<then>
					<td class="tabletitle" colspan="2" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_10']}</u>
							</b>
						</span>
					</td>
				</then>
			</if>
			<td class="tabletitle" colspan="2" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_11']}</u>
					</b>
				</span>
			</td>
		</tr>
		$wm2018_showusertippsdetail_bit
	</table>
	<br /> $wm2018_footer $footer
</body>

</html>
