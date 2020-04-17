$(document).ready(() => {
	$('.books').on('click', '.download-book', event => {
		window.location.href = 'download?path=' + $(event.target).data('path');
	});
});