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

  $id = $_POST['id'];
  $role = $_POST['role'];
  $can_comment = $_POST['can_comment'];
  $update_self_comments = $_POST['update_self_comments'];
  $update_all_comments = $_POST['update_all_comments'];
  $delete_self_comments = $_POST['delete_self_comments'];
  $delete_all_comments = $_POST['delete_all_comments'];

  $sql = '
    UPDATE YSKuo_authorization
      SET 
        role=?,
        can_comment=?,
        update_self_comments=?,
        update_all_comments=?,
        delete_self_comments=?,
        delete_all_comments=?
      WHERE id=?
  ';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('siiiiii',
    $role,
    $can_comment,
    $update_self_comments,
    $update_all_comments,
    $delete_self_comments,
    $delete_all_comments,
    $id
  );
  $result = $stmt->execute();
  
  if (!$result) {
    $code = $conn->errno;
    // the entered username already exists
    if ($code === 1062) {
      header('Location: admin_role.php?errCode=2');
    }
    die($conn->error);
  }

  header('Location: admin_role.php?page='.$page);
?>