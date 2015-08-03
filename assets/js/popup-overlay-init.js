jQuery(document).ready(function($){
	$('#comment-prompt-modal').popup({
		transition: 'all 0.3s',
		openelement: '.popupoverlay-open',
		closeelement: '.popupoverlay-close',
		autoopen: true
	});
});