$(document).ready(() => {

  const newPassword = document.getElementById('new-password');
  const newPasswordD = document.getElementById('rep-new-password');

    $(newPassword).on('input', event => {
      $('#new-password-count').text(event.target.value.length);
    });

    $(newPasswordD).on('input', event => {
      $('#rep-pass-count').text(event.target.value.length);
    });

  const passError = () => {
    $('.error-pass').addClass('active-label');
    setTimeout(() => {
      $('.error-pass').removeClass('active-label');  
    }, 4500);
  };

    $('.accept-reset-pass').on('click', () => {
      const newPass = $(newPassword).val().trim();
      const newPasss = $(newPasswordD).val().trim();
      const token = window.location.href.split("=");

      if (newPass.length === newPasss.length &&
        newPass === newPasss && newPass.length >= 8) {
        $.ajax({
          url: '/setPassword',
          type: 'POST',
          data: {
            token: token[1],
            password: newPass
          },
          success: data => {
            if (data === 'true') {
              window.location.href = '/main';
            }
            else {
              passError();
            }
          }
        });
      }
      else {
        passError();
      }
    });

});