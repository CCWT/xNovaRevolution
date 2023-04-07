{include file="overall_header.tpl"}
{include file="overall_topnav.tpl"}
{include file="left_menu.tpl"}
<div id="content" class="content">
    <table class="table519">
        <tr>
        	<th colspan="4"><a href="#" onclick="$('.containerPlus').mb_open();$('.containerPlus').mb_centerOnWindow(false);return false;" title="{$ov_planetmenu}">{$ov_planet} "<span class="planetname">{$planetname}</span>"</a> ({$username})</th>
        </tr>
           {if $messages}
    <tr>

			<td colspan="4"><a href="?page=messages">{$messages}</a></td>
	</tr>
		{/if}
        <tr>
        	<td>{$ov_server_time}</td>
        	<td colspan="3" id="servertime"></td>
        </tr>
        {if $is_news}
		<tr>
			<td>{$ov_news}</td><td colspan="3">{$news}</td>
		</tr>
		{/if}

		<tr>
        	<td style="white-space: nowrap;">{$ov_admins_online}</td>
        	<td colspan="3">{foreach name=OnlineAdmins key=id item=Name from=$AdminsOnline}{if !$smarty.foreach.OnlineAdmins.first}&nbsp;&bull;&nbsp;{/if}<a href="#" onclick="OpenPopup('game.php?page=messages&amp;mode=write&amp;id={$id}','', 720, 300);return false;">{$Name}</a>{foreachelse}{$ov_no_admins_online}{/foreach}</td>
        </tr>
		{if $Teamspeak}
		<tr>
			<td>{$ov_teamspeak}</td><td colspan="3">{$Teamspeak}</td>
		</tr>
		{/if}
        <tr>
        	<th colspan="4">{$ov_events}</th>
        </tr>
 <tr id="fleets" style="display:none;">
         <td colspan="4">
      </tr>
	     <td colspan="4"><div align="center">
              <div style="background-image: url({$dpath}planeten/{$planetimage}.jpg);background-repeat:no-repeat;height:300px;margin:0px
auto;position:relative;width:650px;margin-bottom:0px ">
                <div style="float: right;margin:50px 100px 0px 30px;">{if $Moon}<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" style="cursor:pointer" href="javascript:void(0);" onmouseover="return overlib('{$Moon.name} ({$fcm_moon})');"
onmouseout="return nd();"><img src="{$dpath}planeten/small/s_mond.png" height="50" width="50"></a><br>{else}&nbsp;{/if}</div>
            </div></td>
        </tr>
		<tr>
		<td colspan="4">{$build}</td>
        </tr>
		<tr>
            <td>{$ov_diameter}</td>
            <td colspan="3">{$planet_diameter} {$ov_distance_unit} (<a title="{$ov_developed_fields}">{$planet_field_current}</a> / <a title="{$ov_max_developed_fields}">{$planet_field_max}</a> {$ov_fields})</td>
        </tr>
        <tr>
            <td>{$ov_temperature}</td>
            <td colspan="3">{$ov_aprox} {$planet_temp_min}{$ov_temp_unit} {$ov_to} {$planet_temp_max}{$ov_temp_unit}</td>
        </tr>
        <tr>
            <td>{$ov_position}</td>
            <td colspan="3"><a href="game.php?page=galaxy&amp;mode=0&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></td>
        </tr>
        <tr>
            <td>{$ov_points}</td>
            <td colspan="3">{$user_rank}</td>
        </tr>
   </table>

</div>
<div id="demoContainer" class="containerPlus { buttons:'c', skin:'black', width:'580', height:'200',dock:'dock',closed:'true'}" style="position:absolute;top:250px;left:400px; height:50%">
<div class="no"><div class="ne"><div class="n">{$ov_planet_rename_action}</div></div>
  <div class="o"><div class="e"><div class="c">
	<div class="mbcontainercontent">
		<form action="" method="POST" id="rename">
		<table>
		<tr>
			<th colspan="3">{$ov_your_planet}</th>
		</tr><tr>
			<td>{$ov_coords}</td>
			<td>{$ov_planet_name}</td>
			<td>{$ov_actions}</td>
		</tr><tr>
			<td>{$galaxy}:{$system}:{$planet}</td>
			<td>{$planetname}</td>
			<td><input type="button" value="{$ov_abandon_planet}" onclick="cancel();"></td>
		</tr><tr>
			<td id="label">{$ov_planet_rename}</td>
			<td><input type="text" name="newname" id="newname" size="25" maxlength="20" autocomplete="off"><input type="password" name="password" id="password" size="25" maxlength="20" style="display:none;" autocomplete="off"></td>
			<td><input type="button" onclick="checkrename();" value="{$ov_planet_rename_action}" id="submit-rename"><input type="button" onclick="checkcancel();" value="{$ov_delete_planet}" id="submit-cancel" style="display:none;"></td>
		</tr>
		</table>
		</form>
	</div>
  </div></div></div>
  <div>
	<div class="so"><div class="se"><div class="s"> </div></div></div>
  </div>
</div>
</div>
<script type="text/javascript">
buildtime	= {$buildtime} * 1000;
ov_password	= "{$ov_password}";
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}
