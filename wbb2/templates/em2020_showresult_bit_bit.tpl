<tr>
	<td class="$rowclass" align="center" width="15%">
		<span class="smallfont">$gamedate, $gametime {$lang->items['LANG_EM2020_TPL_SHOWRESULT_BIT_BIT_1']}</span>
	</td>
	<td class="$rowclass" align="center" width="10%">
		<span class="smallfont">$row[stadion]</span>
	</td>
	<td class="$rowclass" align="center" width="25%">
		<span class="smallfont">
			<if($row['team_1_id']>=1 && $row['team_1_id'] <=64)>
					<then><a href="em2020.php?action=showallgames&amp;teamid=$row[team_1_id]{$SID_ARG_2ND}">$name1</a></then>
					<else>$name1</else>
					</if>
		</span>
		<br />
		<font color=green size=1>$quote1 %</font>
	</td>
	<td class="$rowclass" align="center" width="5%"><img src="images/em2020/flaggen/$flagge1" alt="$name1" title="$name1" /></td>
	<td class="$rowclass" align="center" width="25%">
		<span class="smallfont">
			<if($row['team_2_id']>=1 && $row['team_2_id'] <=64)>
				<then>
					<a href="em2020.php?action=showallgames&amp;teamid=$row[team_2_id]{$SID_ARG_2ND}">$name2</a>
				</then>
				<else>
					$name2
				</else>
			</if>
		</span>
		<br />
		<font color=green size=1>$quote2 %</font>
	</td>
	<td class="$rowclass" align="center" width="5%"><img src="images/em2020/flaggen/$flagge2" alt="$name2" title="$name2" /></td>
	<td class="$rowclass" align="center" width="9%">
		<span class="smallfont">$row[game_goals_1]&nbsp;:&nbsp;$row[game_goals_2]</span>
	</td>
	<td class="$rowclass" align="center" width="3%">$gamedetails</td>
	<td class="$rowclass" align="center" width="3%">
		<span class="smallfont">$spieltipps</span>
	</td>
</tr>
