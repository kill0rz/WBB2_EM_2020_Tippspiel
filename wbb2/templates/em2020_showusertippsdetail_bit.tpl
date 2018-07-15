<tr>
	<td class="$rowclass" align="center">
		<span class="smallfont"><a href="./em2020.php?action=tippsprogame&amp;gameid=$row_game[gameid]" alt="{$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_BIT_2']}">$row_game[gameid]</a> $edittipp</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$gamedate, $gametime {$lang->items['LANG_WM2018_TPL_SHOWUSERTIPPSDETAIL_BIT_1']}</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont"><a href="em2020.php?action=showallgames&amp;teamid=$row_game[team_1_id]{$SID_ARG_2ND}">$name1</a></span>
	</td>
	<td class="$rowclass" align="center"><img src="images/em2020/flaggen/$flagge1" border="0" alt="$name1" title="$name1" /></td>
	<td class="$rowclass" align="center">
		<span class="smallfont"><a href="em2020.php?action=showallgames&amp;teamid=$row_game[team_2_id]{$SID_ARG_2ND}">$name2</a></span>
	</td>
	<td class="$rowclass" align="center"><img src="images/em2020/flaggen/$flagge2" border="0" alt="$name2" title="$name2" /></td>
	<if($em2020_options['gk_jn']==1)>
		<then>
			<td class="$rowclass" align="center">$image_gk</td>
			<td class="$rowclass" align="center">$tippright_gk</td>
		</then>
	</if>
	<if($em2020_options['rk_jn']==1)>
		<then>
			<td class="$rowclass" align="center">$image_rk</td>
			<td class="$rowclass" align="center">$tippright_rk</td>
		</then>
	</if>
	<if($em2020_options['elfer_jn']==1)>
		<then>
			<td class="$rowclass" align="center">$image_elfer</td>
			<td class="$rowclass" align="center">$tippright_elfer</td>
		</then>
	</if>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<b>$row_game[goals_1]</b>&nbsp;:&nbsp;
			<b>$row_game[goals_2]</b>
		</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row_game[game_goals_1]&nbsp;:&nbsp;$row_game[game_goals_2]&nbsp;$tippright_result$abc</span>
	</td>
</tr>
