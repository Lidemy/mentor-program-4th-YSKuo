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
    die('not an Admin');
  }

  if ($_POST['csrfToken'] !== $_COOKIE['csrfToken']) {
    header('Location: index.php?page='.$page);
    die('wrong csrfToken');
  }

  if (
    empty($_POST['nickname']) ||
    empty($_POST['role'])
  ) {
    header('Location: admin_member.php?errCode=1&page='.$page);
    die();
  }

  $id = $_POST['id'];
  $nickname = $_POST['nickname'];
  $role = $_POST['role'];

  $sql = 'UPDATE YSKuo_users 
    SET nickname=?, role=? WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssi', $nickname, $role, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header('Location: admin_member.php?page='.$page);
?>