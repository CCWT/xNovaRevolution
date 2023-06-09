function updateVars() {
	var ID = $('#id').val();
	$('#img').attr('src', $('#img').attr('name') + ID + '.gif');
	$('#metal').text(NumberGetHumanReadable(CostInfo[ID][1] * (1 - Charge)));
	$('#crystal').text(NumberGetHumanReadable(CostInfo[ID][2] * (1 - Charge)));
	$('#deuterium').text(NumberGetHumanReadable(CostInfo[ID][3] * (1 - Charge)));
	$('#norio').text(NumberGetHumanReadable(CostInfo[ID][5] * (1 - Charge)));
	$('#darkmatter').text(NumberGetHumanReadable(CostInfo[ID][4] * (1 - Charge)));
	Reset();
}

function MaxShips() {
	$('#count').val(CostInfo[$('#id').val()][0]);
	Total();
}

function Total() {
	var Count = $('#count').val();
	if (isNaN(Count) || Count < 0) {
		$('#count').val(0);
		Count = 0;
	} else if (Count > CostInfo[$('#id').val()][0]) {
		$('#count').val(CostInfo[$('#id').val()][0]);
		Count = CostInfo[$('#id').val()][0];
	}
	var ID = $('#id').val();
	$('#total_metal').text(NumberGetHumanReadable(CostInfo[ID][1] * Count * Charge));
	$('#total_crystal').text(NumberGetHumanReadable(CostInfo[ID][2] * Count * Charge));
	$('#total_deuterium').text(NumberGetHumanReadable(CostInfo[ID][3] * Count * Charge));
	$('#total_norio').text(NumberGetHumanReadable(CostInfo[ID][5] * Count * Charge));
	$('#total_darkmatter').text(NumberGetHumanReadable(CostInfo[ID][4] * Count * Charge));
}

function Reset() {
	$('#count').val(0);
	$('#total_metal').text(0);
	$('#total_crystal').text(0);
	$('#total_deuterium').text(0);
	$('#total_norio').text(0);
	$('#total_darkmatter').text(0);
}
$(document).ready(function () {
	$('#charge').text(Math.round(Charge * 100) + "%");
});
