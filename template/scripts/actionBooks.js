$(document).ready(() => {
  $('.books').on('click', '.like-book', event => {
    const { target } = event;
    $.ajax({
      url: '/like',
      type: 'POST',
      data: {
        bookId: $(target).data('id')
      },
      success: data => {
        $(event.target).addClass('hidden-like');
      }
    });
  });

  $('.books').on('click', '.download-book', event => {
    window.location.href = 'download?path=' + $(event.target).data('path');
  });

});