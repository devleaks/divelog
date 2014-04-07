
elgg.provide('elgg.divelog');

elgg.divelog.init = function() {
	// append the title to the url
	var title = document.title;
	var e = $('a.elgg-divelog-page');
	var link = e.attr('href') + '&title=' + encodeURIComponent(title);
	e.attr('href', link);
};

elgg.register_hook_handler('init', 'system', elgg.divelog.init);
