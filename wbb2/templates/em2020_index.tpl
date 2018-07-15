<?xml version="1.0" encoding="{$lang->items['LANG_GLOBAL_ENCODING']}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{$lang->items['LANG_GLOBAL_DIRECTION']}" lang="{$lang->items['LANG_GLOBAL_LANGCODE']}" xml:lang="{$lang->items['LANG_GLOBAL_LANGCODE']}">

<head>
	<title>$master_board_name | {$lang->items['LANG_WM2018_TPL_INDEX_1']}</title>
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
								<b><a href="index.php{$SID_ARG_1ST}">$master_board_name</a> &raquo; {$lang->items['LANG_WM2018_TPL_INDEX_1']}</b>
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

	<!-- Spiele, die noch nicht im ACP eingetragen wurden -->
	<if($em2020_nonaddedgameresults)>
		<then>
			<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
				<tr>
					<td class="tabletitle" align="center" colspan="5">
						<span class="smallfont">
							<b><u>{$lang->items['LANG_WM2018_TPL_INDEX_34']}</u></b>
						</span>
					</td>
				</tr>
				<tr>
					$em2020_nonaddedgames
				</tr>
			</table>
			<br />
		</then>
	</if><br />

	<!-- Spiele, die noch nicht im ACP eingetragen wurden -->
	<if($em2020_currentgameplaying)>
		<then>
			<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
				<tr>
					<td class="tabletitle" align="center" colspan="5">
						<span class="smallfont">
							<b><u>{$lang->items['LANG_WM2018_TPL_INDEX_35']}</u></b>
						</span>
					</td>
				</tr>
				<tr>
					$em2020_currentgames
				</tr>
			</table>
			<br />
		</then>
	</if><br />

	<table cellpadding="4" cellspacing="1" border="0" style="width:{$style['tableinwidth']}">
		<tr>
			<td align="left" width="50%" valign="top">
				<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
					<tr>
						<td class="tabletitle" align="center">
							<span class="smallfont">
								<b>
									<u>{$lang->items['LANG_WM2018_TPL_INDEX_2']}</u>
								</b>
							</span>
						</td>
					</tr>
					<tr>
						<if($wbbuserdata['userid'])>
							<then>
								<td class="tableb" align="left">
									<span class="smallfont">
										{$lang->items['LANG_WM2018_TPL_INDEX_3']}
										<b>$wbbuserdata[username]</b>,
										<br />
										<br /> {$lang->items['LANG_WM2018_TPL_INDEX_4']}
										<br />
										<if($em2020_options['gh_aktiv']==1)>
											<then>{$lang->items['LANG_WM2018_TPL_INDEX_5']}
												<b>$wbbuserdata[guthaben]</b> $waehrung
												<br />
												<br />
												<br />
											</then>
											<else>
												<br />
												<br />
												<br />
											</else>
										</if>
									</span>
								</td>
							</then>
						</if>
						<if(!$wbbuserdata['userid'])>
							<then>
								<td class="tableb" align="left">
									<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_33']},
										<br /> {$lang->items['LANG_WM2018_TPL_INDEX_6']}
										<br />
										<br />
										<br />
									</span>
								</td>
							</then>
						</if>
					</tr>
				</table>
			</td>
			<td align="right" width="50%" valign="top">
				<if($em2020_options['showrssnews']==1)>
					<then>
						<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
							<tr>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<b>
											<if($em2020_options['rssnews_showfeed']=="fifa")>
												<then>
													<u>{$lang->items['LANG_WM2018_TPL_INDEX_7']}</u>
												</then>
												<else>
													<u>{$lang->items['LANG_WM2018_TPL_INDEX_36']}</u>
												</else>
											</if>
										</b>
									</span>
								</td>
							</tr>
							<tr>
								<td class="tableb" align="left">
									<span class="smallfont">
										<b>$newsem2020total</b>
									</span>
								</td>
							</tr>
						</table>
					</then>
				</if>
			</td>
		</tr>
	</table>
	<br />
	<if($em2020_options['1st']==0)>
		<then>
			<table cellpadding="4" cellspacing="1" border="0" style="width:{$style['tableinwidth']}">
				<tr>
					<td align="left" width="50%" valign="top">
						<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
							<tr>
								<td class="tabletitle" align="center" colspan="5">
									<span class="smallfont">
										<b>
											<u>{$lang->items['LANG_WM2018_TPL_INDEX_8']}</u>
										</b>
									</span>
								</td>
							</tr>
							$em2020_nextgames
						</table>
					</td>
					<td align="right" width="50%" valign="top">
						<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
							<tr>
								<td class="tabletitle" align="center" colspan="8">
									<span class="smallfont">
										<a href="em2020.php?gruppensort=A{$SID_ARG_2ND}">
											<b>A</b>
										</a> |
										<a href="em2020.php?gruppensort=B{$SID_ARG_2ND}">
											<b>B</b>
										</a> |
										<a href="em2020.php?gruppensort=C{$SID_ARG_2ND}">
											<b>C</b>
										</a> |
										<a href="em2020.php?gruppensort=D{$SID_ARG_2ND}">
											<b>D</b>
										</a> |
										<a href="em2020.php?gruppensort=E{$SID_ARG_2ND}">
											<b>E</b>
										</a> |
										<a href="em2020.php?gruppensort=F{$SID_ARG_2ND}">
											<b>F</b>
										</a> |
										<a href="em2020.php?gruppensort=G{$SID_ARG_2ND}">
											<b>G</b>
										</a> |
										<a href="em2020.php?gruppensort=H{$SID_ARG_2ND}">
											<b>H</b>
										</a>
										</b>
									</span>
								</td>
							</tr>
							<tr>
								<td class="tablea" align="center" colspan="8">
									<span class="smallfont">
										<b>{$lang->items['LANG_WM2018_TPL_INDEX_9']} $gruppensort</b>
									</span>
								</td>
							</tr>
							<tr>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<b>Flagge</b>
									</span>
								</td>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<b>Land</b>
									</span>
								</td>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<a title="{$lang->items['LANG_WM2018_TPL_INDEX_10']}">
											<b>{$lang->items['LANG_WM2018_TPL_INDEX_11']}</b>
										</a>
									</span>
								</td>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<a title="{$lang->items['LANG_WM2018_TPL_INDEX_12']}">
											<b>{$lang->items['LANG_WM2018_TPL_INDEX_13']}</b>
										</a>
									</span>
								</td>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<a title="{$lang->items['LANG_WM2018_TPL_INDEX_14']}">
											<b>{$lang->items['LANG_WM2018_TPL_INDEX_15']}</b>
										</a>
									</span>
								</td>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<a title="{$lang->items['LANG_WM2018_TPL_INDEX_16']}">
											<b>{$lang->items['LANG_WM2018_TPL_INDEX_17']}</b>
										</a>
									</span>
								</td>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<a title="{$lang->items['LANG_WM2018_TPL_INDEX_18']}">
											<b>{$lang->items['LANG_WM2018_TPL_INDEX_19']}</b>
										</a>
									</span>
								</td>
								<td class="tabletitle" align="center">
									<span class="smallfont">
										<a title="{$lang->items['LANG_WM2018_TPL_INDEX_20']}">
											<b>{$lang->items['LANG_WM2018_TPL_INDEX_21']}</b>
										</a>
									</span>
								</td>
							</tr>
							$em2020_gruppentabelle
						</table>
					</td>
				</tr>
			</table>
		</then>
		<else>
			<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
				<tr>
					<td class="tabletitle" align="center" colspan="2">
						<span class="smallfont">
							<b>
								<u>{$lang->items['LANG_WM2018_TPL_INDEX_22']}</u>
							</b>
						</span>
					</td>
				</tr>
				<tr>
					<td class="tablea" align="center" width="25%"><img src="images/em2020/trophy.png" alt="{$lang->items['LANG_WM2018_TPL_INDEX_23']}" title="{$lang->items['LANG_WM2018_TPL_INDEX_23']}" /></td>
					<td class="tablea" align="center" width="75%">
						<span class="normalfont">
							<b><img src="images/em2020/flaggen/$result_1st[flagge]" alt="$result_1st[name]" title="$result_1st[name]" />&nbsp;$result_1st[name]&nbsp;<img src="images/em2020/flaggen/$result_1st[flagge]" alt="$result_1st[name]" title="$result_1st[name]" /></b>
						</span>
					</td>
				</tr>
				<tr>
					<td class="tablea" align="center" width="25%">
						<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_24']}</span>
					</td>
					<td class="tablea" align="center" width="75%">
						<span class="smallfont">$result_2nd[name]&nbsp;<img src="images/em2020/flaggen/$result_2nd[flagge]" alt="$result_2nd[name]" title="$result_2nd[name]" /></span>
					</td>
				</tr>
			</table>
			<br />
		</else>
	</if>
	<table cellpadding="4" cellspacing="1" border="0" style="width:{$style['tableinwidth']}">
		<tr>
			<td align="left" width="25%" valign="top">
				<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
					<tr>
						<td class="tabletitle" align="center" colspan="2">
							<span class="smallfont">
								<b>
									<u>{$lang->items['LANG_WM2018_TPL_INDEX_25']}</u>
								</b>
							</span>
						</td>
					</tr>
					$em2020_punkte
				</table>
				<br />
			</td>
			<td align="right" width="50%" valign="top">
				<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
					<tr>
						<td class="tabletitle" align="center" colspan="7">
							<span class="smallfont">
								<b>
									<u>{$lang->items['LANG_WM2018_TPL_INDEX_32']}</u>
								</b>
							</span>
						</td>
					</tr>
					$em2020_topuser
				</table>
			</td>
			<td align="center" width="25%" valign="top">
				<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
					<tr>
						<td class="tabletitle" align="center" colspan="4">
							<span class="smallfont">
								<b>
									<u>{$lang->items['LANG_WM2018_TPL_INDEX_40']}</u>
								</b>
							</span>
						</td>
					</tr>
					<tr class="tablea_fc">
						<td class="tablea" align="center">
							<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_41']}</span>
						</td>
						<td class="tablea" align="center">
							<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_42']}</span>
						</td>
						<td class="tablea" align="center">
							<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_43']}</span>
						</td>
						<td class="tablea" align="center">
							<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_44']}</span>
						</td>
					</tr>
					$em2020_meisterquote
				</table>
			</td>
			<br/>
			<if($em2020_options['gh_aktiv']==1 && $em2020_options['gh_infos']==1)>
				<then>
					<td align="center" width="50%" valign="top">
						<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
							<tr>
								<td class="tabletitle" align="center" colspan="2">
									<span class="smallfont">
										<b>
											<u>{$lang->items['LANG_WM2018_TPL_INDEX_26']}</u>
										</b>
									</span>
								</td>
							</tr>
							<tr>
								<td class="tableb" align="center">
									<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_27']}</span>
								</td>
								<td class="tableb" align="center">
									<span class="smallfont">$em2020_options[gh_ab_normtipp] $waehrung</span>
								</td>
							</tr>
							<tr>
								<td class="tableb" align="center">
									<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_28']}</span>
								</td>
								<td class="tableb" align="center">
									<span class="smallfont">$em2020_options[gh_ab_wmtipp] $waehrung</span>
								</td>
							</tr>
							<tr>
								<td class="tablea" align="center">
									<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_29']}</span>
								</td>
								<td class="tablea" align="center">
									<span class="smallfont">$em2020_options[gh_gut_normtipp_richtig] $waehrung</span>
								</td>
							</tr>
							<if($em2020_options['tendenz']==1)>
								<then>
									<tr>
										<td class="tablea" align="center">
											<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_30']}</span>
										</td>
										<td class="tablea" align="center">
											<span class="smallfont">$em2020_options[gh_gut_normtipp_tendenz] $waehrung</span>
										</td>
									</tr>
								</then>
								</if>
								<if($em2020_options['winnertipp_jn']==1)>
									<then>
										<tr>
											<td class="tablea" align="center">
												<span class="smallfont">{$lang->items['LANG_WM2018_TPL_INDEX_31']}</span>
											</td>
											<td class="tablea" align="center">
												<span class="smallfont">$em2020_options[gh_gut_wmtipp_richtig] $waehrung</span>
											</td>
										</tr>
									</then>
									</if>
						</table>
					</td>
				</then>
				</if>
		</tr>
	</table>
	<br />
	<br /> $em2020_footer $footer
</body>

</html>
