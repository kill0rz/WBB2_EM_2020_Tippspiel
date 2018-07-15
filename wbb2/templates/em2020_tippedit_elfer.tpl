<br />
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:60%" class="tableinborder">
	<tr>
		<td class="tabletitle" colspan="2" align="center">
			<span class="smallfont">
				<b>
					<u>{$lang->items['LANG_EM2020_TPL_TIPPABGABE_ELFER_1']}</u>
				</b>
			</span>
		</td>
	</tr>
	<tr>
		<td class="tableb" align="center" width="70%">
			<span class="smallfont">{$lang->items['LANG_EM2020_TPL_TIPPABGABE_ELFER_2']}</span>
		</td>
		<td class="tableb" align="center" width="30%">
			<select name="tipp_elfer">
				<option value="-1">{$lang->items['LANG_EM2020_GLOBAL_CHOICE']}</option>
				<option value="1" $tipp_elfer_jn[1]>{$lang->items['LANG_EM2020_GLOBAL_YES']}</option>
				<option value="0" $tipp_elfer_jn[0]>{$lang->items['LANG_EM2020_GLOBAL_NO']}</option>
			</select>
		</td>
	</tr>
</table>
