<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $page = $_POST['page'];

  if (
    empty($_POST['id'])||
    empty($_POST['csrfToken'])
  ) {
    header('Location: index.php?page='.$page);
    die('no id and csrfToken');
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
    $csrfToken = $_COOKIE['csrfToken'];
    // get user's auth
    $auth = getAuthFromRole($user['role']);
  }

  $commentMaker = $_POST['username'];

  if ($username === $commentMaker || $auth['update_all_comments']) {
    $id = $_POST['id'];
    $sql = 'UPDATE YSKuo_comments SET is_deleted=1 WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    if (!$result) {
      die('error');
    }
  } else {
    header('Location: index.php?page='.$page);
    die('without auth');  
  }

  header('Location: index.php');
?>