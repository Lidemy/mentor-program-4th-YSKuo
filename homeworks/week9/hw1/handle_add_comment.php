<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (empty($_POST['content'])) {
    header("Location: index.php?errCode=1");
    die('資料不齊全');
  }

  $content = $_POST['content'];
  
  // 自製 token
  // $token = $_COOKIE['token'];
  // $user = getUserFromToken($token);
  
  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);
  $nickname = $user['nickname'];

  $sql = sprintf(
    "INSERT INTO YSKuo_comments(nickname, content) VALUES('%s', '%s')",
    $nickname,
    $content
  );

  $result = $conn->query($sql);
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");  
?>
