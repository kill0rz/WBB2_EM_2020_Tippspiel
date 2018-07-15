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
		<if($wm2018_options['gk_jn']==1)>
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
		<if($wm2018_options['rk_jn']==1)>
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
		<if($wm2018_options['elfer_jn']==1)>
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
	$wm2018_tippsprogame_bit
</table>