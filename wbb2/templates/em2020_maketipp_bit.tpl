<tr>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<b>$type</b>
		</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<b>$date $time {$lang->items['LANG_EM2020_TPL_MAKETIPP_BIT_1']}</b>
		</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<b>$date2 $time2 {$lang->items['LANG_EM2020_TPL_MAKETIPP_BIT_1']}</b>
		</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<a href="em2020.php?action=showallgames&amp;teamid=$row[team_1_id]{$SID_ARG_2ND}">
				<b>$name1</b>
			</a>
		</span>
	</td>
	<td class="$rowclass" align="center"><img src="images/em2020/flaggen/$flagge1" alt="$name1" title="$name1" /></td>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<a href="em2020.php?action=showallgames&amp;teamid=$row[team_2_id]{$SID_ARG_2ND}">
				<b>$name2</b>
			</a>
		</span>
	</td>
	<td class="$rowclass" align="center"><img src="images/em2020/flaggen/$flagge2" alt="$name2" title="$name2" /></td>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<a href="em2020.php?action=tippabgabe&amp;gameid=$row[gameid]#tippabgabetable">
				<b>{$lang->items['LANG_EM2020_TPL_MAKETIPP_BIT_2']}</b>
			</a>
		</span>
	</td>
</tr>
