<tr>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<a href="em2020.php?action=showusertippsdetail&amp;userid=$row[userid]{$SID_ARG_2ND}">
				<b>$row[username]</b>
			</a>
		</span>
	</td>
	<td class="$rowclass" align="center">
		<span class="smallfont">
			<b>$row[goals_1]&nbsp;:&nbsp;$row[goals_2]</b>
		</span>
	</td>
	<if($em2020_options['gk_jn']==1)>
		<then>
			<td class="$rowclass" align="center">
				<span class="smallfont">$game_gk</span>
			</td>
		</then>
	</if>
	<if($em2020_options['rk_jn']==1)>
		<then>
			<td class="$rowclass" align="center">
				<span class="smallfont">$game_rk</span>
			</td>
		</then>
	</if>
	<if($em2020_options['elfer_jn']==1)>
		<then>
			<td class="$rowclass" align="center">
				<span class="smallfont">$game_elfer</span>
			</td>
		</then>
	</if>
</tr>
