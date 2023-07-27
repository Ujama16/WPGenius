<?php
session_start();

// initialisatiob
$username = "";
$password    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'mywebsite');

// REGISTER USER
if (isset($_POST['reg_user'])) {

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }
  if ($password >=8) {
	array_push($errors, "password should be 8 character");
  }
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR password='$password' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['password'] === $password) {
      array_push($errors, "incorrect password");
    }
  }

  if (count($errors) == 0) {
  	$password = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, password) 
  			  VALUES('$username' , '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>