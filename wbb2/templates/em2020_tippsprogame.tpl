<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_1']}</title>
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="em2020.php?action=index{$SID_ARG_2ND}">{$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_2']}</a> &raquo; {$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_3']}</b>
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
						<u>{$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_4']}</u>
					</b>
				</span>
			</td>
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b>
						<u>{$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_5']}</u>
					</b>
				</span>
			</td>
			<if($em2020_options['gk_jn']==1)>
				<then>
					<td class="tabletitle" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_6']}</u>
							</b>
						</span>
					</td>
				</then>
			</if>
			<if($em2020_options['rk_jn']==1)>
				<then>
					<td class="tabletitle" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_7']}</u>
							</b>
						</span>
					</td>
				</then>
			</if>
			<if($em2020_options['elfer_jn']==1)>
				<then>
					<td class="tabletitle" align="center">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_TIPPSPROGAME_8']}</u>
							</b>
						</span>
					</td>
				</then>
			</if>
		</tr>
		$em2020_tippsprogame_bit
	</table>
	<br /> $em2020_footer $footer
</body>

</html>
