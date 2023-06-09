{$cron}
<script type="text/javascript">
var serverTime = new Date({$date.0}, {$date.1 - 1}, {$date.2}, {$date.3}, {$date.4}, {$date.5});
var localTime = new Date();
localTS = localTime.getTime();
var ServerTimezoneOffset = {$date.6} + localTime.getTimezoneOffset()*60;
var Gamename	= document.title;
var Ready		= "{$ready}";
var Skin		= "{$dpath}";
var Lang		= "{$lang}";
var auth		= {$authlevel};
</script>
<script type="text/javascript" src="{$cd}scripts/base.js?v={$REV}"></script>
<script type="text/javascript" src="{$cd}scripts/global.js?v={$REV}"></script>
{foreach item=scriptname from=$scripts}
<script type="text/javascript" src="{$cd}scripts/{$scriptname}.js?v={$REV}"></script>
{/foreach}
<script type="text/javascript">
var timerHandler = new TimerHandler();
{if $topnav}
var resourceTickerMetal = {
    available: {$metal},
    limit: [0, {$js_metal_max}],
    production: {$js_metal_hr},
    valueElem: "current_metal"
};
var resourceTickerCrystal = {
    available: {$crystal},
    limit: [0, {$js_crystal_max}],
    production: {$js_crystal_hr},
    valueElem: "current_crystal"
};
var resourceTickerDeuterium = {
    available: {$deuterium},
    limit: [0, {$js_deuterium_max}],
    production: {$js_deuterium_hr},
    valueElem: "current_deuterium"
};
var resourceTickerNorio = {
    available: {$norio},
    limit: [0, {$js_norio_max}],
    production: {$js_norio_hr},
    valueElem: "current_norio"
};
initRessource();

var vacation = {$vmode};
if (!vacation) {
	new resourceTicker(resourceTickerMetal);
	new resourceTicker(resourceTickerCrystal);
	new resourceTicker(resourceTickerDeuterium);
	new resourceTicker(resourceTickerNorio);
}
{/if}

function UhrzeitAnzeigen()
{
    var Sekunden = serverTime.getSeconds();
    serverTime.setSeconds(Sekunden+1);
    if(document.getElementById("servertime"))
		document.getElementById("servertime").innerHTML = getFormatedDate(serverTime.getTime(), '[M] [D] [d] [H]:[i]:[s]');
}
UhrzeitAnzeigen();
setInterval("UhrzeitAnzeigen()", 1000);

{$execscript}

{if $ga_active}
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '{$ga_key}']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
{/if}
{if $debug == 1}
function handleErr(errMessage, url, line)
{
	error="There is an error at this page. Please view www.xnovarevolution.com.ar\n";
	error+="Error: " + errMessage+ "\n";
	error+="URL: " + url + "\n";
	error+="Line: " + line + "\n\n";
	error+="Click OK to continue viewing this page,\n";
	alert(error);
	if(typeof console == "object")
		console.log(error);

	return true;
}

onerror = handleErr;
{/if}
</script>
</body>
</html>
