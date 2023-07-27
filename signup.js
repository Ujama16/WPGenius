<script
function handleFormSubmission(event, formId, endpoint) {
  event.preventDefault();
  var form = document.getElementById(formId);
  var username = form.querySelector('input[name="username"]').value;
  var password = form.querySelector('input[name="password"]').value;

  if (username.trim() === '' || password.trim() === '') {
    alert('Please fill in all fields.');
    return;
  }

  if (password.length < 8) {
    alert('Password must be at least 8 characters long.');
    return;
  }

  fetch(endpoint, {
    method: 'POST',
    headers: {
      'Content-type': 'application/x-www-form-urlencoded',
    },
    body: 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password),
  })
    .then(function (response) {
      if (response.ok) {
        return response.text();
      } else {
        throw new Error('Network response was not ok.');
      }
    })
    .then(function (data) {
      if (data === 'success') {
        alert('Operation successful!');
        // Perform any additional actions upon successful login or signup
      } else {
        alert('Operation failed. Please check your credentials.');
        // Perform any additional actions upon failed login or signup
      }
    })
    .catch(function (error) {
      console.log('Error:', error.message);
    });
}

// Login form submission
document.getElementById('login-form').addEventListener('submit', function (event) {
  handleFormSubmission(event, 'login-form', 'login.php');
});

// Signup form submission
document.getElementById('signup-form').addEventListener('submit', function (event) {
  handleFormSubmission(event, 'signup-form', 'signup.php');
});

/script>
