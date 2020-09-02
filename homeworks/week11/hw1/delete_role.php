<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $page = $_POST['page'];
  }

  if ($user['role'] !== 'Admin') {
    header('Location: index.php');
    die();
  }

  if (empty($_GET['id'])) {
    header('Location: admin_role.php?page='.$page);
    die();
  }

  $id = $_GET['id'];

  $stmt = $conn->prepare(
    'UPDATE YSKuo_authorization SET is_deleted=1 WHERE id=?
  ');
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die('error');
  }

  header('Location: admin_role.php?page='.$page);
?>