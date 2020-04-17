$(document).ready(() => {

  const data = new FormData();
  const bookTitle = $('#book-title');
  const bookDescription = $('#book-description');

  $.ajax({
    url: '/getDraft',
    type: 'POST',
    contentType: 'json',
    success: response => {
      const json = JSON.parse(response);

      if (json.title) {
        bookTitle.val(json.title);
        $('#book-title-count').text(json.title.length);
      }

      if (json.description) {
        bookDescription.val(json.description);
        $('#description-book-count').text(json.description.length);
      }

      if (json.genreId) {
        const genreList = document.querySelector('.genre-list');

        for (const item of genreList.children) {
          
          if ($(item).data('id') == json.genreId) {
            $(item).addClass('uvm--selected');
            $('.current-genre').text(item.textContent.trim());
          }
        }
      }

      if (json.authorId) {
        const authorList = document.querySelector('.authors-list');

        for (const item of authorList.children) {
          
          if ($(item).data('id') == json.authorId) {
            $(item).addClass('uvm--selected');
            $('.current-author').text(item.textContent.trim());
          }
        }
      }
    }
  });

  $('.tab-item').on('click', event => {
    $('.current-tab').removeClass('current-tab');
    $(event.target).addClass('current-tab');
  });

  $('#book-title').on('input', event => {
    $('#book-title-count').text(event.target.value.length);
  });

  $('#edit-author').on('input', event => {
    $('#edit-author-name-count').text(event.target.value.length);
  });

  $('#book-description').on('input', event => {
    $('#description-book-count').text(event.target.value.length);
  });

  $('#edit-book-title').on('input', event => {
    $('#edit-book-title-count').text(event.target.value.length);
  });

  $('#edit-book-description').on('input', event => {
    $('#edit-description-book-count').text(event.target.value.length);
  });

  $('#edit-genre').on('input', event => {
    $('#edit-genre-count').text(event.target.value.length);
  });

  $('.add-book-tab').on('click', function() {
    $('.search').removeClass('active-search');
    $('.active-content').removeClass('active-content');
    $('#first-tab').addClass('active-content');
  });

  $('.all-books-tab').on('click', function() {
    $('.search').addClass('active-search');
    $('.active-content').removeClass('active-content');
    $('#second-tab').addClass('active-content');
  });

  $('#author-name').on('input', event => {
    $('#book-author-name-count').text(event.target.value.length);
  });

  $('.add-author-tab').on('click', function () {
    $('.search').removeClass('active-search');
    $('.active-content').removeClass('active-content');
    $('#third-tab').addClass('active-content');
  });

  $('#genre-title').on('input', event => {
    $('#book-genre-count').text(event.target.value.length);
  });

  $('.add-genre-tab').on('click', function () {
    $('.search').removeClass('active-search');
    $('.active-content').removeClass('active-content');
    $('#fourth-tab').addClass('active-content');
  });

  $('.archive-tab').on('click', function () {
    $('.search').removeClass('active-search');
    $('.active-content').removeClass('active-content');
    $('#fifth-tab').addClass('active-content');
  });

  const searchInput = $('#search-book');

  searchInput.on('input', () => {
     const books = $('.books .book');

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

  const doc = document.documentElement;
  const hiddenInput = $('#edit-hidden-input');

  const editAuthorInput = $('#edit-author');
  const editAuthorModal = document.querySelector('.edit-author-content');
  let authorTarget;

  $('.all-authors').on('click', '.edit-author-button', event => {
    const { target } = event;
    const text = $(target.parentNode.previousElementSibling).text();
    
    authorTarget = $(target.parentNode.previousElementSibling);
    hiddenInput.val(target.dataset.id);
    editAuthorInput.val(text);
    $('#edit-author-name-count').text(text.length);
    $(doc).addClass('edit-author-modal');
  });

  const editGenreInput = $('#edit-genre');
  const editGenreModal = document.querySelector('.edit-genre-content');
  let genreTarget; 

  $('.all-genres').on('click', '.edit-genre-button', event => {
    const { target } = event;
    const text = $(target.parentNode.previousElementSibling).text();
    
    genreTarget = $(target.parentNode.previousElementSibling);
    hiddenInput.val(target.dataset.id);
    editGenreInput.val(text);
    $('#edit-genre-count').text(text.length);
    $(doc).addClass('edit-genre-modal');
  });

  const editBookModal = document.querySelector('.edit-book-content');
  const editBookTitle = $('#edit-book-title');
  const editBookDescription = $('#edit-book-description');
  const authorCurrent = document.querySelector('.edit-author-current')
  const authorsList = document.querySelector('.edit-author-list');
  const genreCurrent = document.querySelector('.edit-genre-current');
  const genresList = document.querySelector('.edit-genre-list');
  const editedImg = $('.left-edit-side > .book-image img');

  let title;
  let description;
  let author;
  let genre;
  let photo;
  let audio;
  let pdf;
  let img;

  $('.edit-books-wrapper').on('click', '.edit-book', event => {
    const { target } = event;

    photo = $(target.parentNode.previousElementSibling);

    img = photo.attr('src');
    title = $(target.parentNode.parentNode.parentNode.
                    querySelector('.book-title'));
    description = target.parentNode.parentNode.parentNode.
                    querySelector('.book-description');
    author =  target.parentNode.parentNode.parentNode.
                    querySelector('.author-name');
    genre = target.parentNode.parentNode.parentNode.
                    querySelector('.genre-title');
    editedImg.attr('src', photo.attr('src'));
    pdf = $(target).data('pdf');
    audio = $(target).data('audio');

    for (const item of authorsList.children) {
      if (item.textContent.toLowerCase().trim() ==
          author.innerText.trim().toLowerCase()) {
        authorCurrent.textContent = item.textContent;
        item.classList.add('uvm--selected');
      }
    }

    for (const item of genresList.children) {
      if (item.textContent.toLowerCase().trim() ==
          genre.innerText.trim().toLowerCase()) {
        genreCurrent.textContent = item.textContent;
        item.classList.add('uvm--selected');
      }
    }

    $('#edit-book-title-count').text(title.text().trim().length);
    $('#edit-description-book-count').text(description
      .innerText.trim().length);
    hiddenInput.val(target.dataset.id);
    editBookTitle.val(title.text().trim());
    editBookDescription.val(description.innerText.trim());
    $(doc).addClass('edit-book-modal');
  });

  const editData = new FormData();

  $('#edit-book-preview').on('change', event => {
    const reader = new FileReader();
    const file = $('#edit-book-preview')[0].files[0];
    
    reader.onload = event => {
      editedImg.attr('src', reader.result);
    }
    reader.readAsDataURL(file);
    img = file;
  });

  $('#edit-audio-input').on('change', () => {
    audio = $('#edit-audio-input')[0].files[0];
  });

  $('#edit-pdf-button').on('change', () => {
    pdf = $('#edit-pdf-button')[0].files[0];
  });

  const errorBook = () => {
    $('.error-edit-book').addClass('active-label');
    setTimeout(() => {
      $('.error-edit-book').removeClass('active-label');  
    }, 2500);
  };

  $('.save-edit-button').on('click', () => {
    const selectedAuthor = $('.edit-author-list .uvm--selected');
    const selectedGenre = $('.edit-genre-list .uvm--selected');

    editData.set('image', img);
    editData.set('audio', audio);
    editData.set('pdf', pdf);

    if (editBookTitle.val().trim().length >= 3 &&  
        editBookTitle.val().trim().length <= 50 &&
        editBookDescription.val().trim().length >= 5 &&
        editBookDescription.val().trim().length <= 500 &&
        selectedAuthor.data('id') && selectedGenre.data('id') &&
        hiddenInput.val().trim().length) {

      editData.set('title', editBookTitle.val().trim());
      editData.set('description', editBookDescription.val().trim());
      editData.set('authorId', selectedAuthor.data('id'));
      editData.set('genreId', selectedGenre.data('id'));
      editData.set('bookId', hiddenInput.val().trim());

      $.ajax({
        url: '/editBook',
        type: 'POST',
        processData: false,
        cache: false,
        contentType: false,
        data: editData,
        success: response => {
          if (response !== 'false') {
            title.text(editData.get('title'));
            description.innerText = editData.get('description');
            $(author).text(selectedAuthor.text().trim());
            $(author).attr('data-id', selectedAuthor.data('id'));
            $(author).data('id', selectedAuthor.data('id'));
            $(genre).text(selectedGenre.text().trim());
            $(genre).attr('data-id', selectedGenre.data('id'));
            $(genre).data('id', selectedGenre.data('id'));
            photo.attr('src', editedImg.attr('src'));

            if ($(title).parent().find('.is-sounded').length < 1) {
              if (typeof editData.get('audio') === "object") {
                $(title).parent().append(`<div class="is-sounded" 
                  title="Є аудіо версія">
                    <img src="/template/images/sound.png">
                  </div>`);
              }
            }

            $(doc).removeClass('edit-book-modal');
            $('.author-edit-item.uvm--selected').removeClass('uvm--selected');
            $('.genre-edit-item.uvm--selected').removeClass('uvm--selected');
          }
          else {
            errorBook();
          }
        }
      });
    }
    else {
      errorBook();
    }
  });

  window.addEventListener('click', event => {
    if ($(doc).hasClass('edit-author-modal') && 
          !editAuthorModal.contains(event.target)) {
      $(doc).removeClass('edit-author-modal');
    }
    else if ($(doc).hasClass('edit-genre-modal') && 
              !editGenreModal.contains(event.target)) {
      $(doc).removeClass('edit-genre-modal');      
    }
    else if ($(doc).hasClass('edit-book-modal') &&
              !editBookModal.contains(event.target)) {
      $(doc).removeClass('edit-book-modal');
      $('.uvm--selected').removeClass('uvm--selected');
    }
  }, true);

  const archiveWrapper = $('.books-archived');
  const booksWrapper = $('.books');

  booksWrapper.on('click', '.to-archive', event => {
    const book = $(event.target.parentNode.
      parentNode.parentNode.parentNode);

    $.ajax({
      url: '/toArchive',
      type: 'POST',
      data: {
        bookId: $(event.target).data('id')
      },
      success: data => {
        if (data === 'true') {
          const clone = book.clone();
          const image = clone.find('.to-archive');
          book.addClass('hidden');

          image.find('img')
            .attr('src', '/template/images/back.svg');
          image.addClass('from-archive');
          image.removeClass('to-archive');
          archiveWrapper.prepend(clone);

          setTimeout(() => {
            book.remove();
          }, 500);
        }
      }
    })
  });


  archiveWrapper.on('click', '.from-archive', event => {
    const book = $(event.target.parentNode.
      parentNode.parentNode.parentNode);

    $.ajax({
      url: '/fromArchive',
      type: 'POST',
      data: {
        bookId: $(event.target).data('id')
      },
      success: data => {
        if (data === 'true') {
          const clone = book.clone();
          const image = clone.find('.from-archive');

          book.addClass('hidden');
          image.find('img')
            .attr('src', '/template/images/toArchive.svg');
          image.addClass('to-archive');
          image.removeClass('from-archive');
          booksWrapper.prepend(clone);

          setTimeout(() => {
            book.remove();
          }, 500);
        }
      }
    })
  });

  const errorAuthor = () => {
    $('.error-edit-author').addClass('active-label');
    setTimeout(() => {
      $('.error-edit-author').removeClass('active-label');  
    }, 2500);
  };

  $('.accept-editing-author').on('click', () => {
    const authorInput = $('#edit-author');

    if (authorInput.val().trim().length >= 3 && 
      authorInput.val().trim().length <= 50) {
      $.ajax({
        url: '/editAuthor',
        type: 'POST',
        data: {
          name: authorInput.val().trim(),
          authorId: hiddenInput.val()
        },
        success: data => {
          if (data === 'true') {
            authorTarget.text(authorInput.val().trim());
            $(doc).removeClass('edit-author-modal');
            const list = document.
              querySelectorAll(`.author-data[data-id="${hiddenInput.val()}"]`);

              for (const elem of list) {
                $(elem).text(authorInput.val().trim());
              }
          }
          else {
            errorAuthor();
          }
        }
      });
    }
    else {
      errorAuthor();
      }
  });

  const errorGenre = () => {
    $('.error-edit-genre').addClass('active-label');
    setTimeout(() => {
      $('.error-edit-genre').removeClass('active-label');  
    }, 2500);
  };

  $('.accept-editing-genre').on('click', () => {
    const genreInput = $('#edit-genre');

    if (genreInput.val().trim().length >= 3 &&
      genreInput.val().trim().length <= 50) {
      $.ajax({
        url: '/editGenre',
        type: 'POST',
        data: {
          title: genreInput.val().trim(),
          genreId: hiddenInput.val()
        },
        success: data => {
          if (data === 'true') {
            genreTarget.text(genreInput.val().trim());
            $(doc).removeClass('edit-genre-modal');
            const list = document.
              querySelectorAll(`.genre-data[data-id="${hiddenInput.val()}"]`);

              for (const elem of list) {
                $(elem).text(genreInput.val().trim());
              }
          }
          else {
            errorGenre();
          }
        }
      });
    }
    else {
      errorGenre();
    }
  });

  $('.accept-adding-author').on('click', () => {
    const authorInput = $('#author-name');

    if (authorInput.val().trim().length >= 3 &&
        authorInput.val().trim().length <= 50) {
      $.ajax({
        url: '/addAuthor',
        type: 'POST',
        data: {
          name: authorInput.val().trim()
        },
        success: data => {
          if (data !== 'false') {
            $('.all-authors tbody').append(`<tr>
              <td>${authorInput.val().trim()}</td>
              <td align="center">
                <button class="edit-author-button" data-id="${data}">
                  <img src="/template/images/edit.png">
                </button>
              </td>
              </tr>`);
            $('.edit-author-list').append(`<li class="uvm--option author-edit-item
              author-data" data-id="${data}">
                ${authorInput.val().trim()}
              </li>`);
            $('.authors-list').append(`<li class="uvm--option author-item
              author-data" data-id="${data}">
                ${authorInput.val().trim()}
              </li>`);
            authorInput.val('');
            $('#book-author-name-count').text('0');
          }
          else {
            errorAuthor();
          }
        }
      })
    }
    else {
      errorAuthor();
    }
  });

  $('.accept-adding-genre').on('click', () => {
    const genreInput = $('#genre-title');

    if (genreInput.val().trim().length >= 3 &&
        genreInput.val().trim().length <= 50) {
      $.ajax({
        url: '/addGenre',
        type: 'POST',
        data: {
          title: genreInput.val().trim()
        },
        success: data => {
          if (data !== 'false') {
            $('.all-genres tbody').append(`<tr>
              <td>${genreInput.val().trim()}</td>
              <td align="center">
                <button class="edit-genre-button" data-id=${data}>
                  <img src="/template/images/edit.png">
                </button>
              </td>
            </tr>`);
            $('.edit-genre-list').append(`<li class="uvm--option genre-edit-item 
            genre-data" data-id="${data}">
              ${genreInput.val().trim()}
            </li>`);
            $('.genre-list').append(`<li class="uvm--option genre-item 
            genre-data" data-id="${data}">
              ${genreInput.val().trim()}
            </li>`);
            genreInput.val('');
            $('#book-genre-count').text('0');
          }
          else {
            errorGenre();
          }
        }
      });
    }
    else {
      errorGenre();
    }
  });

  $('#add-pdf-input').on('change', () => {
    const file = document.getElementById('add-pdf-input').files[0];
    data.set('pdf', file);
    $('.book-pdf-button').addClass('added');
  });

  $('#add-preview-input').on('change', () => {
    const file = document.getElementById('add-preview-input').files[0];
    data.set('image', file);
    $('.book-preview-button').addClass('added');
  });

  $('#add-audio-input').on('change', () => {
    const file = document.getElementById('add-audio-input').files[0];
    data.set('audio', file);
    $('.book-audio-button').addClass('added');
  });

  $('.book-accept-button').on('click', () => {
    const author = $('.author-item.uvm--selected');
    const genre = $('.genre-item.uvm--selected');
    const title = bookTitle.val().trim();
    const description = bookDescription.val().trim();

    if (author.data('id') && genre.data('id') && 
      title.length >= 3 && title.length <= 50 &&
      description.length >= 5 && description.length <= 500 &&
      data.has('image') && data.has('pdf')) {

      data.set('title', title);
      data.set('description', description);
      data.set('authorId', author.data('id'));
      data.set('genreId', genre.data('id'));

      $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        url: '/addBook',
        type: 'POST',
        data: data,
        success (resp) {
          if (resp !== 'false') {
            const response = JSON.parse(resp);

            if (!data.has('audio')) {
              booksWrapper.prepend(`<div class="book flex fdc">
                <div class="book-inner-wrapper flex">
                  <div class="book-image flex jcc alic">
                    <img src="${response.Img}"
                      class="book-preview flex 
                    jcc alic" alt=""><div class="actions flex fdc jcsb">
                      <div class="edit-book" data-id="${response.Audio}" 
                      data-pdf="${response.Pdf}" data-id="${response.Id}">
                        <img src="/template/images/edit.svg" alt="">
                      </div>
                      <div class="to-archive" data-id="${response.Id}">
                        <img src="/template/images/toArchive.svg" alt="">
                        </div></div></div>
                  <div class="book-info">
                    <div class="book-title-wrapper flex alic">
                      <a class="book-title" href="/book?Id=${response.Id}">
                      ${data.get('title')}</a></div>
                    <div class="author-name author-data" data-id="${data
                      .get('authorId')}">
                    ${author.text()}</div>
                    <div class="genre-title genre-data" data-id="${data
                      .get('genreId')}">
                    ${genre.text()}</div>
                    <div class="book-description">${data
                      .get('description')}</div>
                  </div>
                </div>
                <div class="hr-line"></div>
              </div>`);
            }
            else {
              booksWrapper.prepend(`<div class="book flex fdc">
                <div class="book-inner-wrapper flex">
                  <div class="book-image flex jcc alic">
                    <img src="${response.Img}" class="book-preview 
                    flex jcc alic" alt=""><div class="actions flex fdc jcsb">
                      <div class="edit-book" data-id="${response.Audio}" 
                      data-pdf="${response.Pdf}" data-id="${response.Id}">
                        <img src="/template/images/edit.svg" alt="">
                      </div>
                      <div class="to-archive" data-id="${response.Id}">
                        <img src="/template/images/toArchive.svg" alt="">
                        </div></div></div>
                  <div class="book-info">
                    <div class="book-title-wrapper flex alic">
                      <a class="book-title" href="/book?Id=${response.Id}">
                      ${data.get('title')}</a>
                  <div class="is-sounded" title="Є аудіо версія">
                    <img src="/template/images/sound.png" alt="">
                  </div>
                  </div>
                    <div class="author-name author-data" data-id="${data
                      .get('authorId')}">
                    ${author.text()}</div>
                    <div class="genre-title genre-data" data-id="${data
                      .get('genreId')}">
                    ${genre.text()}</div>
                    <div class="book-description">${data
                      .get('description')}</div>
                  </div>
                </div>
                <div class="hr-line"></div>
              </div>`);

              $('.book-audio-button').removeClass('added');
            }

            bookTitle.val('');
            bookDescription.val('');
            $('.uvm--selected').removeClass('uvm--selected');
            $('#book-title-count').text('0');
            $('#description-book-count').text('0');
            $('.current-author').text('Автор');
            $('.current-genre').text('Жанр');
            $('.book-pdf-button').removeClass('added');
            $('.book-preview-button').removeClass('added');
            $('.success-adding').addClass('active-label');
            
            setTimeout(() => {
              $('.success-adding').removeClass('active-label');  
            }, 2500);
          }
          else {
            errorBook();
          }
        }
      });
    }
    else {
      errorBook();
    }
  });

  setInterval(() => {
    const title = $('#book-title').val().trim();
    const authorId = $('.author-item.uvm--selected').data('id');
    const genreId = $('.genre-item.uvm--selected').data('id');
    const description = $('#book-description').val().trim();

    if (title.length || description.length) {
      const draft = {
        title,
        authorId,
        genreId,
        description
      }
      
      $.ajax({
        url: '/draft',
        type: 'POST',
        data: {
          draft: JSON.stringify(draft)
        },
        success: response => {
          
        }
      });
    }

  }, 10000);

});