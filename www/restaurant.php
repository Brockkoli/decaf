<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

$search_result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = htmlspecialchars($_POST['search']);
    $search_result = "<strong>$query</strong> not found.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Decaf Restaurant</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <style>
        body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
    </style>
</head>
<body class="w3-light-grey">

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:200px">
  <h3 class="w3-bar-item">Dashboard</h3>
  <a href="#" class="w3-bar-item w3-button">Menu Management</a>
  <a href="#" class="w3-bar-item w3-button">Reservations</a>
  <a href="#" class="w3-bar-item w3-button">Contact Messages</a>
</div>

<!-- Page Content -->
<div style="margin-left:200px">
  <div class="w3-container w3-teal">
    <h1>Welcome Admin</h1>
  </div>

  <div class="w3-container">
    <h3>Today’s Summary</h3>
    <p>📅 Date: <?= date("Y-m-d") ?></p>
    <p>🍽️ Pending Reservations: 5</p>
    <p>📬 New Contact Messages: 2</p>
  </div>

  <!-- Fake Search Bar -->
  <div class="w3-container w3-margin-top">
    <h4>Search Menu / Reservations</h4>
    <form method="POST">
        <input class="w3-input w3-border w3-round" type="text" name="search" placeholder="Search...">
        <button class="w3-button w3-dark-grey w3-margin-top" type="submit">Search</button>
    </form>

    <?php if ($search_result): ?>
        <div class="w3-panel w3-pale-red w3-leftbar w3-border-red w3-margin-top">
            <p><?= $search_result ?></p>
        </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
