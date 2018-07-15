<tr>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row[gameid]</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$type</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$gamedate, $gametime {$lang->items['LANG_WM2018_TPL_SHOWALLGAMES_BIT_1']}</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row[stadion]</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$name1</span>
		<br />
		<font color=green size=1>$quote1 %</font>
	</td>
	<td class="$rowclass" align="center"><img src="images/em2020/flaggen/$flagge1" border="0" alt="$name1_alt" title="$name1_alt" /></td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$name2</span>
		<br />
		<font color=green size=1>$quote2 %</font>
	</td>
	<td class="$rowclass" align="center"><img src="images/em2020/flaggen/$flagge2" border="0" alt="$name2_alt" title="$name2_alt" /></td>
	<td class="$rowclass" align="center">
		<span class="smallfont">$row[game_goals_1]&nbsp;:&nbsp;$row[game_goals_2]</span>
	</td>
	<td class="$rowclass" align="center">
		<if($row['tipps']!=0)>
			<then>
				<a href="em2020.php?action=tippsprogame&amp;gameid=$row[gameid]{$SID_ARG_2ND}"><img src="images/em2020/info.gif" border="0"alt="{$lang->items['LANG_WM2018_PHP_42']}" title="{$lang->items['LANG_WM2018_PHP_42']}"></a>&nbsp;
			</then>
		</if>
		$gamedetails
	</td>
</tr>
