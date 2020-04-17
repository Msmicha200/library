document.addEventListener('DOMContentLoaded', () => {
  const searchInput = $('#search-book');

  searchInput.on('input', () => {
     const books = $('.books .book');

     if (searchInput.val().length) {
      $('.city-image').slideUp(400);
     }
     else {
      $('.city-image').slideDown(400);
     }

     books.each((ind, elem) => {
      if ($(elem).find('.book-title').text().toLowerCase()
        .includes(searchInput.val().trim().toLowerCase())) {
        $(elem).css('display', 'flex');
      }
      else {
        $(elem).css('display', 'none');
      }
     });
  });
});