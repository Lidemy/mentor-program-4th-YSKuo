<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (
    empty($_POST['username']) ||
    empty($_POST['password'])
  ) {
    header('Location: login.php?errCode=1');
    die('no username/password');
  }

  $username = $_POST['username'];

  $sql = "SELECT * FROM YSKuo_users WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result();
  // the entered username is not in database
  if ($result->num_rows === 0) {
    header('Location: login.php?errCode=2');
    exit();
  }

  $row = $result->fetch_assoc();

  if (password_verify($_POST['password'], $row['password'])) {
    $csrfToken = generatrToken(10);
    setcookie("csrfToken", $csrfToken, time() + 3600 * 24);
    $_SESSION['username'] = $username;
    header('Location: index.php');
  } else {
    header('Location: login.php?errCode=2');
  }

?>