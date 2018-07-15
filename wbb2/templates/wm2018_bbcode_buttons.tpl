<table cellspacing="0" cellpadding="0">
	<tr class="tablea_fc">
		<td align="left" colspan="3"><span class="smallfont">
	 <input type="radio" name="mode" id="radio_bbcodemode_1" value="0" title="{$lang->items['LANG_POSTINGS_BBCODE_MODE_0']} (alt+n)" accesskey="n" onclick="setmode(this.value)" $modechecked[0] /><label for="radio_bbcodemode_1">
	 {$lang->items['LANG_POSTINGS_BBCODE_MODE_0']}</label>
	 <input type="radio" name="mode" id="radio_bbcodemode_2" value="1" title="{$lang->items['LANG_POSTINGS_BBCODE_MODE_1']} (alt+e)" accesskey="e" onclick="setmode(this.value)" $modechecked[1] /><label for="radio_bbcodemode_2">
	 {$lang->items['LANG_POSTINGS_BBCODE_MODE_1']}</label>
	</span></td>
	</tr>
	<tr>
		<td>
			<select id="fontselect" onchange="fontformat(this.form,this.options[this.selectedIndex].value,'FONT')">
				<option value="0">FONT</option>
				$bbcode_fontbits
			</select>
			<select id="sizeselect" onchange="fontformat(this.form,this.options[this.selectedIndex].value,'SIZE')">
				<option value="0">SIZE</option>
				$bbcode_sizebits
			</select>
			<select id="colorselect" onchange="fontformat(this.form,this.options[this.selectedIndex].value,'COLOR')">
				<option value="0">COLOR</option>
				$bbcode_colorbits
			</select>
		</td>
		<td><a href="../misc.php?action=bbcode{$SID_ARG_2ND}" target="_blank"><img src="../{$style['imagefolder']}/bbcode_help.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_HELP']}" title="{$lang->items['LANG_POSTINGS_BBCODE_HELP']}" border="0" /></a>&nbsp;</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<img src="../{$style['imagefolder']}/bbcode_bold.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_BOLD']}" title="{$lang->items['LANG_POSTINGS_BBCODE_BOLD']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_BOLD']}" border="0" onclick="bbcode(document.bbform,'B','')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_italic.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_ITALIC']}" title="{$lang->items['LANG_POSTINGS_BBCODE_ITALIC']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_ITALIC']}" border="0" onclick="bbcode(document.bbform,'I','')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_underline.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_UNDERLINE']}" title="{$lang->items['LANG_POSTINGS_BBCODE_UNDERLINE']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_UNDERLINE']}" border="0" onclick="bbcode(document.bbform,'U','')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_center.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_CENTER']}" title="{$lang->items['LANG_POSTINGS_BBCODE_CENTER']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_CENTER']}" border="0" onclick="bbcode(document.bbform,'CENTER','')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_url.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_URL']}" title="{$lang->items['LANG_POSTINGS_BBCODE_URL']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_URL']}" border="0" onclick="namedlink(document.bbform,'URL')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_email.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_EMAIL']}" title="{$lang->items['LANG_POSTINGS_BBCODE_EMAIL']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_EMAIL']}" border="0" onclick="namedlink(document.bbform,'EMAIL')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_image.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_IMAGE']}" title="{$lang->items['LANG_POSTINGS_BBCODE_IMAGE']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_IMAGE']}" border="0" onclick="bbcode(document.bbform,'IMG','http://')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_quote.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_QUOTE']}" title="{$lang->items['LANG_POSTINGS_BBCODE_QUOTE']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_QUOTE']}" border="0" onclick="bbcode(document.bbform,'QUOTE','')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_list.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_LIST']}" title="{$lang->items['LANG_POSTINGS_BBCODE_LIST']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_LIST']}" border="0" onclick="dolist(document.bbform)" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_code.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_CODE']}" title="{$lang->items['LANG_POSTINGS_BBCODE_CODE']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_CODE']}" border="0" onclick="bbcode(document.bbform,'CODE','')" onmouseover="this.style.cursor='hand';" />
			<img src="../{$style['imagefolder']}/bbcode_php.gif" alt="{$lang->items['LANG_POSTINGS_BBCODE_PHP']}" title="{$lang->items['LANG_POSTINGS_BBCODE_PHP']}" alt="{$lang->items['LANG_POSTINGS_BBCODE_PHP']}" border="0" onclick="bbcode(document.bbform,'PHP','')" onmouseover="this.style.cursor='hand';" />
		</td>
	</tr>
</table>
