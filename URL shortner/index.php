<?php
session_start();
require_once('config.php');

function generateShortURL($length = 6)
{
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $code = '';
  for ($i = 0; $i < $length; $i++) {
    $code .= $chars[rand(0, strlen($chars) - 1)];
  }
  return $code;
}

// Handle redirection
if (isset($_GET['code'])) {
  $code = $_GET['code'];
  $stmt = $conn->prepare('SELECT long_url FROM short_url WHERE short_code = ?');
  $stmt->bind_param('s', $code);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header('Location: ' . $row['long_url']);
    exit();
  }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn'])) {
  $long_url = trim($_POST['long_url']);
  $short_code = generateShortURL();

  $stmt = $conn->prepare('INSERT INTO short_url (short_code, long_url) VALUES (?, ?)');
  $stmt->bind_param('ss', $short_code, $long_url);
  $stmt->execute();

  // Store in session and redirect
  $_SESSION['latest_code'] = $short_code;
  header("Location: index.php");
  exit();
}

// Show latest short URL once
$latest_code = null;
if (isset($_SESSION['latest_code'])) {
  $latest_code = $_SESSION['latest_code'];
  unset($_SESSION['latest_code']); // Clear so it doesn't show on refresh
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>URL Shortener</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h1>URL Shortener</h1>
    <form method="post" action="">
      <div class="input-box">
        <input class="url" type="text" name="long_url" placeholder="Write your URL" required>
        <input class="btn" type="submit" name="btn" value="Create">
      </div>
    </form>

    <ul>
      <?php
      if ($latest_code) {
        echo "<li>
                <a href='index.php?code=" . $latest_code . "'>https://localhost/" . $latest_code . "</a>
              </li>";
      }
      ?>
    </ul>
  </div>
</body>

</html>