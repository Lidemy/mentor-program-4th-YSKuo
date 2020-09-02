<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $id = $_GET['id'];

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $auth = getAuthFromRole($user['role']);
  }

  $stmt = $conn->prepare('SELECT * FROM YSKuo_comments WHERE id=?');
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die('Error: '. $conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if (!$auth['update_self_comments'] && 
      !$auth['update_all_comments']
    ) {
    header('Location: index.php');
    die('without auth');
  }

  if (!$auth['update_self_comments']) {
    header('Location: index.php');
    die('cannot delete self-comment');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeuos.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Ordinary World</title>
</head>
<body>
  <nav class="navbar with-shadow">
    <div class="wrapper">
      <h3 class="navbar__title"><a href="index.php">Ordinary World</a></h3>
      <ul class="navbar__list">
        <?php if ($username) { ?>
          <? if ($user['role'] === 'Admin') { ?>
            <li><a href="admin.php">Admin</a></li>
          <?php }?>
          <li><a href="setting.php">Setting(@<?php echo escape($username) ?>)</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
          <li><a href="register.php">Register</a></li>
          <li><a href="login.php">Login</a></li>
        <?php }?>
      </ul>
    </div>
  </nav>

  <main class="board">
    <section class="wrapper">
      <div class="paper">
        <h3 class="board__title">Edit comment</h3>
        <div class="board_time">
          Created at: <?php echo escape($row['created_at']) ?><br>
          Updated at: <?php echo escape($row['updated_at']) ?>
        </div>
        <?php 
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = 'Please fill in the field.';
            }
            echo '<p class="error">Error: ' . $msg . '</p>';
          }
        ?>
        <form class="board__new-input-form" method="POST" action="handle_update_comment.php" >
          <textarea name="content" rows="5" placeholder=""><?php echo escape($row['content']) ?></textarea>
          <input type="hidden" name="id" value="<?php echo escape($id) ?>" />
          <input type="submit" value="submit" />
        </form>
      </div>
    </section>

  </main>
</body>
</html>