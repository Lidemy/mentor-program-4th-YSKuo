<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    $csrfToken = $_COOKIE['csrfToken'];
  }

  if ($user['role'] !== 'Admin') {
    header('Location: index.php');
    die('not an Admin');
  }

  $page = 1;
  if (!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $items_per_page = 10;
  $offset = ($page - 1) * $items_per_page;

  $stmt = $conn->prepare(
    'SELECT '.
      'U.id AS id, U.nickname AS nickname, U.username AS username, '.
      'U.role AS role, U.created_at AS created_at, U.updated_at AS updated_at '.
    'FROM YSKuo_users AS U '.
    'ORDER BY U.id ASC '.
    'LIMIT ? OFFSET ?'
  );
  $stmt->bind_param('ii', $items_per_page, $offset);
  $result = $stmt->execute();
  if (!$result) {
    die('Error: '. $conn->error);
  }
  $result = $stmt->get_result();

  // get all roles in database
  $roles = array();
  $result2 = $conn->query('SELECT role FROM YSKuo_authorization WHERE is_deleted IS NULL');
  while ($row = $result2->fetch_assoc()) {
    array_push($roles, $row['role']);
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
          <li><a href="setting.php?id=<?php echo escape($user['id']) ?>">Setting(@<?php echo escape($username) ?>)</a></li>
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
        <h3 class="board__title">Edit Member Info</h3>

        <?php 
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = 'The information cannot be empty.';
            }
            echo '<p class="error">Error: ' . $msg . '</p>';
          }
        ?>

        <!-- display every member info -->
        <?php
          while ($row = $result->fetch_assoc()) {
        ?>
          <div class="board__card">
            <div class="board__member-info">              
              <span>id: </span><?php echo escape($row['id']) ?><br>
              <span>username: </span><?php echo escape($row['username']) ?><br>
              <span>created at: </span><?php echo escape($row['created_at']) ?><br>
              <span>updated at: </span><?php echo escape($row['updated_at']) ?>

              <!-- Info of Admin and God cannot be changed -->
              <?php if ($row['username'] !== 'Admin' && $row['username'] !== 'God') { ?>
                <form class="" method="POST" action="handle_update_member.php">
                    <span>nickname:</span>
                    <input type="text" name="nickname" value="<?php echo escape($row['nickname']) ?>">
                    <span>role:</span>
                    <div class="inset checktext-container">
                      <?php for ($i=0; $i < count($roles); $i++) { ?>
                        <label class="checktext">
                          <input type="radio" name="role" value="<?php echo escape($roles[$i]) ?>"
                            <?php if ($row['role'] === $roles[$i]) { ?> checked <?php }?>
                          >
                          <span><?php echo escape($roles[$i]) ?></span>
                        </label>
                      <?php }?>              
                    </div>
                  <input type="hidden" name="id" value="<?php echo escape($row['id']) ?>">
                  <input type="hidden" name="page" value="<?php echo escape($page) ?>">
                  <input type="hidden" name="csrfToken" value="<?php echo $csrfToken ?>">
                  <input type="submit" value="submit" />
                </form>
              <?php }?>
            </div>
          </div>
          <hr>
        <?php }?>

      </div>
    </section>

    <!-- count members' number -->
    <?php
      $stmt = $conn->prepare('SELECT count(id) AS count FROM YSKuo_users');
      $result = $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $count = $row['count'];
      $total_page = ceil($count / $items_per_page);
    ?>
    <div class="paper pagination">
      <p><?php echo escape($count) ?> members.</p>
      <div class="paginator">
        <div class="paginator-left">
          <?php if ($page != 1) { ?>
            <a href="index.php?page=<?php echo escape($page-1) ?>"><button class="blue-button">Previous</button></a>
          <?php }?>     
        </div>

        <div class="paginator-center">
          <?php if ($page != 1) { ?>
            <a href="index.php?page=1"><?php echo 1 ?></a>
            <span>...</span>
          <?php }?>

          <?php if ($page - 1 > 1) { ?>
            <a href="index.php?page=<?php echo escape($page-1) ?>"><?php echo escape($page-1) ?></a>
          <?php } ?>
          <span class="current-page"><?php echo escape($page) ?></span>
          <?php if ($page + 1 < $total_page) { ?>
            <a href="index.php?page=<?php echo escape($page+1) ?>"><?php echo escape($page+1) ?></a>
          <?php } ?>

          <?php if ($page != $total_page) { ?>
            <span>...</span>
            <a href="index.php?page=<?php echo escape($total_page) ?>"><?php echo escape($total_page) ?></a>
          <?php } ?>
        </div>
        <div class="paginator-right">
          <?php if ($page != $total_page) { ?>
            <a href="index.php?page=<?php echo escape($page+1) ?>"><button class="blue-button">Next</button></a>
          <?php }?>    
        </div>
      </div>
    </div>
  </main>
</body>
</html>