$(document).ready(() => {

  $('#text-comment').on('input', event => {
    $('#comment-count').text(event.target.value.length);
  });

  
  const date = new Date();
  const comment = $('#text-comment');
  const commentsWrapper = $('.comments');

  const numbers = number => {
    return  parseInt(number / 10) + "" + number % 10;
  }

  $('.send-comment').on('click', () => {
    if (comment.val().trim().length < 10) {
      $('.error-label').addClass('active-label');
      setTimeout(() => {
        $('.error-label').removeClass('active-label');
      }, 2000);
      return;
    }
    const bookId = window.location.href.split('=');
    $.ajax({
      url: '/comment',
      type: 'POST',
      data: {
        comment: comment.val().trim(),
        bookId: bookId[1]
      },
      success: data => {
        if (data !== "false") {
          $('#comment-count').text('0')
          commentsWrapper.prepend(`<div class="comment">
                                    <div class="top-comment-wrapper 
                                    flex alic">
                                      <div class="name">
                                        ${data}    
                                      </div>
                                      <div class="date">
${date.getFullYear()}.${numbers(date.getMonth())}.${numbers(date.getDate())},
${numbers(date.getHours())}:${numbers(date.getMinutes())}
                                      </div>
                                    </div>
                                    <div class="comment-text">
                                      ${comment.val().trim()}
                                    </div>
                                    <div class="hr-line"></div>
                                  </div>`);
          comment.val('');
        }
      }
    })
  });

});