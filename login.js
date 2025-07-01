const loginForm = document.getElementById('loginForm');

  loginForm.addEventListener('submit', function (e) {
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    let valid = true;

    if (usernameseruame.value.trim() === '') {
      username.classList.add('is-invalid');
      valid = false;
    } else {
      username.classList.remove('is-invalid');
    }

    if (password.value.trim() === '') {
      password.classList.add('is-invalid');
      valid = false;
    } else {
      password.classList.remove('is-invalid');
    }

    if (!valid) {
      form.submit(); // Stop form submission
    }
  });