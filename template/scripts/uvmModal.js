'use strict';

document.addEventListener('DOMContentLoaded', () => {

  if (document.querySelector('.login')) {
    const showButton = document.querySelector('.login');
    const doc = document.documentElement;
    const uvmModal = document.querySelectorAll('.uvm--modal-content');
    const closeModalBtn = document.getElementById('close-modal');
    const acceptModalBtn = document.getElementById('accept-modal');
    const modalWrapper = document.querySelector('.uvm--modal-wrapper');

    window.addEventListener('click', event => {
      if (doc.classList.contains('uvm--blur') &&
          !uvmModal[0].contains(event.target)) {
        doc.classList.remove('uvm--blur');
      }
    }, true);

    window.addEventListener('touchstart', event => {
      if (doc.classList.contains('uvm--blur') &&
          !uvmModal[0].contains(event.target)) {
        doc.classList.remove('uvm--blur');
      }
    }, true);

    showButton.addEventListener('click', () => {
        doc.classList.add("uvm--blur");
    });

    $('.remember-password').on('click', () => {
      $('.current-tab').removeClass('current-tab');
      $('#second-tab').addClass('current-tab');
    });

    $('.back-arrow').on('click', () => {
      $('.current-tab').removeClass('current-tab');
      $('#first-tab').addClass('current-tab');
    });

    $('#reg-login').on('input', event => {
      $('#login-count').text(event.target.value.length);
    });

    $('#reg-password').on('input', event => {
      $('#password-count').text(event.target.value.length);
    });

    $('#reg-mail').on('input', event => {
      $('#mail-count').text(event.target.value.length);
    });

    $('#registration').on('click', () => {
      $('.current-tab').removeClass('current-tab');
      $('#third-tab').addClass('current-tab');
    });
  }

  const isEmail = (email = null) => {
    
  const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

   return regex.test(email);   
  }

  const regError = () => {
    $('.error-reg').addClass('active-label');
    setTimeout(() => {
      $('.error-reg').removeClass('active-label');  
    }, 4500);
  };

  const regLogin = $('#reg-login');
  const regPassword = $('#reg-password');
  const regMail = $('#reg-mail');

  const authLogin = $('#login');
  const authPassword = $('#password');

  $('.accept-regestration').on('click', () => {
    const login = regLogin.val().trim();
    const password = regPassword.val();
    const email = regMail.val().trim();

    if (login.length >= 5 && password.length >= 8 && isEmail(email)) {
      $.ajax({
        url: '/register',
        type: 'POST',
        data: {
          login: login,
          password: password,
          email: email
        },
        success: data => {
          if (data === 'true') {
              window.location.href = window.location.href;
          }
          else {
            regError();
          }
        }
      })
    }
    else {
      regError();
    }
  });

  const errorAuth = () => {
    $('.error-auth').addClass('active-label');
    setTimeout(() => {
      $('.error-auth').removeClass('active-label');  
    }, 3000);
  };

  $('.log-in').on('click', () => {
    const login = authLogin.val().trim();
    const password = authPassword.val();

    if (login.length >= 5 && password.length >= 8) {
      $.ajax({
        url: '/check',
        type: 'POST',
        data: {
          login: login,
          password: password
        },
        success: data => {
          console.log(data);
          if (data === 'true') {
              window.location.href = window.location.href;
          }
          else {
            errorAuth();
          }
        }
      });
    }
    else {
      errorAuth();
    }
  });

  const rememberError = () => {
    $('.remember-error').addClass('active-label');
    setTimeout(() => {
      $('.remember-error').removeClass('active-label');  
    }, 3000);
  };

  const rememberEmail = $('#remember-mail');

  $('.accept-remember').on('click', () => {
    if (isEmail(rememberEmail.val().trim())) {
      $.ajax({
        url: '/resetIt',
        type: 'POST',
        data: {
          email: rememberEmail.val().trim()
        },
        success: data => {
          console.log(data);
          if (data === 'true') {
            $('.remember-items').html(`<div class="sended">
              Інструкцію для поновлення паролю відправлено на Ваш E-mail
              </div>`);
            setTimeout(() => {
              $('.uvm--blur').removeClass('uvm--blur');
            }, 5000);
          }
          else {
            rememberError();
          }
        }
      })
    }
    else {
      rememberError();
    }
  });

});
