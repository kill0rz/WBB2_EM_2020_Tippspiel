<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_EM2020_TPL_SHOWRESULTS_1']}</title>
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; <a href="em2020.php?action=index{$SID_ARG_2ND}">{$lang->items['LANG_EM2020_TPL_SHOWRESULTS_2']}</a> &raquo; {$lang->items['LANG_EM2020_TPL_SHOWRESULTS_3']}</b>
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
		<tr class="tabletitle_fc">
			<td class="tabletitle" align="center">
				<span class="smallfont">
					<b><a href="em2020.php?action=showresults&amp;auswahl=1{$SID_ARG_2ND}">{$lang->items['LANG_EM2020_TPL_SHOWRESULTS_4']}</a></b> |
					<b><a href="em2020.php?action=showresults&amp;auswahl=2{$SID_ARG_2ND}">{$lang->items['LANG_EM2020_TPL_SHOWRESULTS_5']}</a></b> |
					<b><a href="em2020.php?action=showresults&amp;auswahl=3{$SID_ARG_2ND}">{$lang->items['LANG_EM2020_TPL_SHOWRESULTS_6']}</a></b> |
					<b><a href="em2020.php?action=showresults&amp;auswahl=4{$SID_ARG_2ND}">{$lang->items['LANG_EM2020_TPL_SHOWRESULTS_7']}</a></b> |
					<b><a href="em2020.php?action=showresults&amp;auswahl=5{$SID_ARG_2ND}">{$lang->items['LANG_EM2020_TPL_SHOWRESULTS_8']}</a></b> |
					<b><a href="em2020.php?action=showresults&amp;auswahl=6{$SID_ARG_2ND}">{$lang->items['LANG_EM2020_TPL_SHOWRESULTS_9']}</a></b>
				</span>
			</td>
		</tr>
	</table>
	$em2020_showresult_bit
	<br /> $em2020_footer $footer
</body>

</html>
