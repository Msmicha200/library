$(document).ready(() => {

  const booksWrapper = document.querySelector('.books');

  const lastBooks = () => {
    $.ajax({
      url: '/lastBooks',
      type: 'POST',
      success: data => {
        if (data !== 'false') {
          const json = JSON.parse(data);
          $('.books').html('');
          for (const book of json) {
            const bookWrapper = document.createElement('div');
            const innerWrapper = document.createElement('div');
            const bookImage = document.createElement('div');
            const bookInfo = document.createElement('div');
            const bookTitleWr = document.createElement('div');
            const bookAction = document.createElement('div');
            bookWrapper.classList.add('book', 'flex', 'fdc');
            innerWrapper.classList.add('book-inner-wrapper', 'flex');
            bookImage.classList.add('book-image', 'flex', 'jcc', 'alic');
            bookTitleWr.classList.add('book-title-wrapper', 'flex', 'alic');
            bookInfo.classList.add('book-info', 'flex', 'fdc');
            bookAction.classList.add('actions', 'flex', 'jfdc', 'jcsb');

            bookInfo.innerHTML = `<div class="author-name">${book.Name}</div>
            <div class="genre-title">${book.GenreTitle}</div>
            <div class="book-description">${book.Description}</div>`

            if (book.Auth == true) {
              if (book.Collected == true) {
                console.log('ye')
                bookImage.innerHTML = `<img src="${book.Image}" class="book-preview 
                flex jcc alic" alt="">
                  <div class="actions flex fdc jcsb">
                    <div class="read-book" data-path="${book.Pdf}">
                      <img src="/template/images/eye.svg" alt="">
                    </div>
                    <div class="download-book" data-path="${book.Pdf}">
                      <img src="/template/images/arrow.svg" alt="">
                    </div>
                  </div>`;
              }
              else if (book.Collected != true) {
                console.log("no")
                bookImage.innerHTML = `<img src="${book.Image}" class="book-preview 
                flex jcc alic" alt="">
                  <div class="actions flex fdc jcsb">
                    <div class="read-book" data-path="${book.Pdf}">
                      <img src="/template/images/eye.svg" alt="">
                    </div>
                    <div class="download-book" data-path="${book.Pdf}">
                      <img src="/template/images/arrow.svg" alt="">
                    </div>
                    <div class="like-book" data-id="${book.Id}">
                      <img src="/template/images/heart.svg" alt="">
                    </div>
                  </div>`;
              }
            }
            if (book.Audio) {
              bookTitleWr.innerHTML = `<a class="book-title" 
              href="/book?Id=${book.Id}"> ${book.Title}</a><div class="is-sounded" 
                title="Є аудіо версія">
                <img src="/template/images/sound.png" alt="">
              </div>`; 
            }
            else {
              bookTitleWr.innerHTML = `<a class="book-title" 
              href="/book?Id=${book.Id}"> ${book.Title}</a>`;
            }

            if (book.Auth != true) {
              bookImage.innerHTML = `<img src="${book.Image}" class="book-preview 
              flex jcc alic" alt="">
                <div class="actions flex fdc jcsb">
                  <div class="read-book" data-path="${book.Pdf}">
                    <img src="/template/images/eye.svg" alt="">
                  </div>
                  <div class="download-book" data-path="${book.Pdf}">
                    <img src="/template/images/arrow.svg" alt="">
                  </div>
                </div>`;
            }

            bookInfo.prepend(bookTitleWr);
            innerWrapper.append(bookImage);
            innerWrapper.append(bookInfo);
            bookWrapper.append(innerWrapper);
            booksWrapper.append(bookWrapper);
          }
        }
      }
    });
  }

  lastBooks();

  const sortBooks = event => {
    const { target } = event;
    let authorId = $('.author-item.uvm--selected').data('id') || 0;
    let genreId = $('.genre-item.uvm--selected').data('id') || 0;

    $.ajax({
      url: '/sort',
      type: 'GET',
      data: {
        authorId: authorId,
        genreId: genreId
      },
      success: data => {
        
        booksWrapper.innerHTML = '';

        if (data === "false") {
          return;
        }

        const result = JSON.parse(data);
        const userId = result.user_id || false;

        for (const book of result.result) {

          const bookWrapper = document.createElement('div');
          const innerWrapper = document.createElement('div');
          const bookImage = document.createElement('div');
          const bookInfo = document.createElement('div');
          const bookTitleWr = document.createElement('div');

          bookWrapper.classList.add('book', 'flex', 'fdc');
          innerWrapper.classList.add('book-inner-wrapper', 'flex');
          bookImage.classList.add('book-image', 'flex', 'jcc', 'alic');
          bookTitleWr.classList.add('book-title-wrapper', 'flex', 'alic');
          bookInfo.classList.add('book-info', 'flex', 'fdc');
          
          if (result.user_id) {
           if (book.Collected) {
              bookImage.innerHTML = `<div class="book-image flex jcc alic">
              <img src="${book.Image}" class="book-preview flex jcc alic" alt="">
              <div class="actions flex fdc jcsb">
                <div class="read-book" data-path="${book.Pdf}">
                  <img src="/template/images/eye.svg" alt="">
                </div>
                <div class="download-book" data-path="${book.Pdf}">
                  <img src="/template/images/arrow.svg" alt="">
                </div>
              </div>
            </div>`;       
           }
           else {
              bookImage.innerHTML = `<div class="book-image flex jcc alic">
              <img src="${book.Image}" class="book-preview flex jcc alic" alt="">
              <div class="actions flex fdc jcsb">
                <div class="read-book" data-path="${book.Pdf}">
                  <img src="/template/images/eye.svg" alt="">
                </div>
                <div class="download-book" data-path="${book.Pdf}">
                  <img src="/template/images/arrow.svg" alt="">
                </div>
                <div class="like-book" data-id="${book.Id}">
                  <img src="/template/images/heart.svg" alt="">
                </div>
              </div>
            </div>`;
           }
          }
          else {
           
            bookImage.innerHTML = `<div class="book-image flex jcc alic">
            <img src="${book.Image}" class="book-preview flex jcc alic" alt="">
            <div class="actions flex fdc jcsb">
              <div class="read-book" data-path="${book.Pdf}">
                <img src="/template/images/eye.svg" alt="">
              </div>
              <div class="download-book" data-path="${book.Pdf}">
                <img src="/template/images/arrow.svg" alt="">
              </div>
            </div>
          </div>`;
          }

          bookWrapper.innerHTML = '<div class="hr-line"></div>';

          bookInfo.innerHTML = `<div class="author-name">${book.Name}</div>
            <div class="genre-title">${book.GenreTitle}</div>
            <div class="book-description">${book.Description}</div>`;

          bookTitleWr.innerHTML = `<a class="book-title" href="/book?Id=${book.Id}">
          ${book.Title}</a>`;

          if (book.Audio) {
            $(bookTitleWr).append(`<div class="is-sounded" title="Є аудіо версія">
                <img src="/template/images/sound.png" alt="">
              </div>`);
          }

          bookInfo.prepend(bookTitleWr);

          innerWrapper.append(bookImage);
          innerWrapper.append(bookInfo);  
          bookWrapper.prepend(innerWrapper);
          booksWrapper.append(bookWrapper);
        }
      }
    });
  };

  $('.clear').on('click', () => {
    $('.uvm--selected').removeClass('uvm--selected');
    $('.current-author').text('Оберіть автора');
    $('.current-genre').text('Оберіть жанр');
    $('.active-search').removeClass('active-search');
    $('.active-search input').val('');
    $('.city-image').slideDown(400);
    $('.active-clear').removeClass('active-clear');
    lastBooks();
  });

  $('.uvm--options-list.author-items').on('click', '.author-item', sortBooks);
  $('.uvm--options-list.genre-items').on('click', '.genre-item', sortBooks);
});
