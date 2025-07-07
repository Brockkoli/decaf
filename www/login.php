<?php
$db = new SQLite3('database.sqlite');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // VULNERABLE SQL (intentionally)
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $results = $db->query($query);

    if ($results->fetchArray()) {
        header("Location: restaurant.php");
        exit();
    } else {
        echo "<p style='color:red'>Invalid credentials</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Decaf Cafe Admin</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
  <style>
    body, html {
      height: 100%;
      font-family: "Inconsolata", sans-serif;
    }
    .bgimg {
      background-position: center;
      background-size: cover;
      background-image: url("https://www.w3schools.com/w3images/coffeehouse.jpg");
      min-height: 75%;
    }
    .login-form {
      max-width: 400px;
      margin: 100px auto;
    }
  </style>
</head>
<body>

<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s6">
      <a href="index.php" class="w3-button w3-block w3-black">Home</a>
    </div>
    <div class="w3-col s6">
      <a href="login.php" class="w3-button w3-block w3-black">Admin</a>
    </div>
  </div>
</div>

<header class="bgimg w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-middle w3-center">
    <span class="w3-text-white" style="font-size:60px">Admin<br>Login</span>
  </div>
</header>

<div class="w3-container login-form">
  <form method="POST" class="w3-card-4 w3-padding">
    <label class="w3-text-grey">Email:</label>
    <input class="w3-input w3-border" type="text" name="email" required>

    <label class="w3-text-grey">Password:</label>
    <input class="w3-input w3-border" type="password" name="password" required>

    <br>
    <input type="submit" class="w3-button w3-black w3-block" value="Login">
    <?= $message ?>
  </form>
</div>

<footer class="w3-center w3-light-grey w3-padding-48 w3-large">
  <p>Decaf Café Internal System</p>
</footer>

</body>
</html>
