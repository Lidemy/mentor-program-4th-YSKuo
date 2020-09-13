<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $username = NULL;
  $user = NULL;
  $member = NULL;

  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $csrfToken = $_COOKIE['csrfToken'];
  }

  if (!empty($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    $id = $user['id'];
  }

  $member = getMemberFromID($id);
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
          <li><a href="setting.php?id=<?php echo $user['id']?>">Setting(@<?php echo escape($username) ?>)</a></li>
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
        <h3 class="board__title"><?php echo escape($member['username']) ?>'s Info</h3>
        <?php 
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = 'The information cannot be empty.';
            }
            echo '<p class="error">' . $msg . '</p>';
          }
        ?>
        <?php if ($username === $member['username']) { ?>
          <div class="board_time">
            Created at: <?php echo escape($member['created_at']) ?><br>
            Updated at: <?php echo escape($member['updated_at']) ?>
          </div>
          <form class="board__login-form" method="POST" action="handle_update_account.php" >
            nickname<input type="text" name="nickname" value="<?php echo escape($user['nickname']) ?>"><br>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="csrfToken" value="<?php echo $csrfToken ?>">
            <input type="submit" value="submit" />
          </form>
        <?php } else { ?>
          <div class="member-info">
            nickname: <?php echo escape($member['nickname']) ?><br>
            username: <?php echo escape($member['username']) ?><br>
            created at: <?php echo escape($member['created_at']) ?><br>
            updated at: <?php echo escape($member['updated_at']) ?>
          </div>
        <?php } ?>

      </div>
    </section>
  </main>
</body>
</html>