<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (empty($_POST['content'])) {
    header('Location: index.php?errCode=1');
    die('no content');
  }

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $auth = getAuthFromRole($user['role']);
  }

  $content = $_POST['content'];
  $id = $_POST['id'];

  $stmt = $conn->prepare('SELECT * FROM YSKuo_comments WHERE id=?');
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die('Error: '. $conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if (!$auth['update_self_comments'] && 
      !$auth['update_all_comments']) 
  {
    header('Location: index.php');
    die('with auth');
  }

  $sql = 'UPDATE YSKuo_comments SET content=? WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si', $content, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header('Location: index.php');
?>