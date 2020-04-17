document.addEventListener('DOMContentLoaded', () => {
  
  const modal = document.querySelectorAll('.pdf-modal-content')
  const doc = document.documentElement;

  window.addEventListener('click', event => {
    if (doc.classList.contains('pdf-modal-blur') &&
        !modal[0].contains(event.target)) {
      doc.classList.remove('pdf-modal-blur');
    }
  }, true);

  $('.books').on('click', '.read-book', event => {
    PDFObject.embed($(event.target).data('path'), '#pdf-content');
    doc.classList.add('pdf-modal-blur');
    $('#pdf-content').append('<div class="close flex jcc alic"></div>')
  });

  $('#pdf-content').on('click', '.close', () => {
    doc.classList.remove('pdf-modal-blur');
  });

});