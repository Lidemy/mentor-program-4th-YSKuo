<?php 
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $id = $_POST['id'];

  if (empty($_POST['nickname'])) {
    header('Location: setting.php?errCode=1&id='.$id);
    die('no entered nickname');
  }

  if ($_POST['csrfToken'] !== $_COOKIE['csrfToken']) {
    header('Location: index.php?page='.$page);
    die('wrong csrfToken');
  }

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }

  $nickname = $_POST['nickname'];

  $sql = 'UPDATE YSKuo_users SET nickname=? WHERE username=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $nickname, $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header('Location: index.php');
?>