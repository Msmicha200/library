$(document).ready(() => {
	
	const errorLogin = () => {
		$('.admin-input').addClass('error-login');
		setTimeout(() => {
			$('.admin-input').removeClass('error-login');
		}, 2000);
	}

	$('.login-button').on('click', () => {
		const login = $('#login').val().trim();
		const password = $('#password').val().trim();

		if (login.length && password.length) {
			$.ajax({
				url: '/authAdmin',
				type: 'POST',
				data: {
					login: login,
					password: password
				},
				success: data => {
					console.log(data);
					if (data === 'true') {
						window.location.href = '/admin'
					}
					else {
						errorLogin();		
					}
				}
			})
		}
		else {
			errorLogin();
		}
	});
});