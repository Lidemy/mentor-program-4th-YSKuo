<?php
  session_start();
  require_once('../conn.php');
  require_once('../utils.php');

  include_once('template/checkSession.php');
  include_once('template/checkAdmin.php');

  if (empty($_POST['id'])) {
    header('Location: ../admin.php');
    die('no id');
  }

  $id = $_POST['id'];

  // if ($_POST['csrfToken'] !== $_COOKIE['csrfToken']) {
  //   header('Location: ../admin.php');
  //   die('wrong csrfToken');
  // }

  $sql = 'UPDATE YSKuo_articles SET is_deleted=1 WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header('Location: ../admin.php');
?>