function submitftp() {
	$.get('install.php?mode=ajax&action=ftp&lang=' + location.search.split('&')[1].substr('-2') + '&' + $('#ftp').serialize(), function (data) {
		if (data == "")
			document.location.reload();
		else
			alert(data);
	});
}

function submitinstall() {
	$.getJSON('install.php?mode=ajax&action=install&lang=' + location.search.split('&')[2].substr('-2') + '&' + $('#install').serialize(), function (data) {
		alert(data.msg);
		if (!data.error)
			document.location.href = 'install.php?mode=ins&page=2&lang=' + location.search.split('&')[2].substr('-2');
	});
	return false;
}
