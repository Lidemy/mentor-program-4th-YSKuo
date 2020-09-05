<?php
  session_start();
  require_once('../conn.php');
  require_once('../utils.php');

  include_once('template/checkSession.php');
  include_once('template/checkAdmin.php');

  $id = $_POST['id'];
  $page = $_POST['page'];

  if (
    empty($_POST['title']) ||
    empty($_POST['content'])
  ) {
    header('Location: ../edit.php?errCode=1&id='.$id);
    die('empty username/password');
  }

  $title = $_POST['title'];
  $content = $_POST['content'];

  $sql = 'UPDATE YSKuo_articles SET title=?, content=? WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssi', $title, $content, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header('Location: '. $page);
?>