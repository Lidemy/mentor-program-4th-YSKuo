<?php
  session_start();
  require_once('conn.php');

  if (empty($_POST['content'])) {
    header('Location: index.php?errCode=1');
    die('error');
  }

  if ($_POST['csrfToken'] !== $_COOKIE['csrfToken']) {
    header('Location: index.php?page='.$page);
    die('wrong csrfToken');
  }

  $username = $_SESSION['username'];
  $content = $_POST['content'];

  $sql = 'INSERT INTO YSKuo_comments(username, content) 
    VALUES(?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $username, $content);
  $result = $stmt->execute();
  
  if (!$result) {
    die($conn->error);
  }

  header('Location: index.php');
?>