<?php
  session_start();
  require_once('../conn.php');
  require_once('../utils.php');

  include_once('template/checkSession.php');
  include_once('template/checkAdmin.php');

  if (
    empty($_POST['title']) ||
    empty($_POST['content'])
  ) {
    header('Location: ../edit.php?errCode=1');
    die('empty username/password');
  }

  $title = $_POST['title'];
  $content = $_POST['content'];

  $sql = 'INSERT INTO YSKuo_articles(username, title, content) VALUES(?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $username, $title, $content);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header('Location: ../index.php');
?>