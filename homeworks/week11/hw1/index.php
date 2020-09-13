<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $username = NULL;
  $user = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
    // get csrfToken
    $csrfToken = $_COOKIE['csrfToken'];
    // get user's auth
    $auth = getAuthFromRole($user['role']);
  }

  // identifying current page
  $page = 1;
  if (!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $items_per_page = 5;
  $offset = ($page - 1) * $items_per_page;

  // select all comments
  $stmt = $conn->prepare(
    'SELECT '.
      'C.id AS id, C.content AS content, C.created_at AS created_at, '. 
      'U.id AS memberID, U.nickname AS nickname, U.username AS username '.
    'FROM YSKuo_comments AS C '.
    'LEFT JOIN YSKuo_users AS U ON C.username = U.username '.
    'WHERE C.is_deleted IS NULL '.
    'ORDER BY C.id DESC '.
    'LIMIT ? OFFSET ?'
  );
  $stmt->bind_param('ii', $items_per_page, $offset);
  $result = $stmt->execute();
  if (!$result) {
    die('Error: '. $conn->error);
  }
  $result = $stmt->get_result();
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
        <h3 class="board__title">Comments</h3>

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

        <!-- comment input -->
        <?php if ($username && $auth['can_comment']) { ?>
          <form class="board__new-input-form" method="POST" action="handle_add_comment.php" >
            <textarea name="content" rows="5" placeholder="write something"></textarea>
            <input type="hidden" name="csrfToken" value="<?php echo $csrfToken ?>">
            <input type="submit" value="submit" />
          </form>
        <?php } else if ($username) { ?>
          <h4>You are not allowed to comment.</h4>
        <?php } else { ?>
          <h4>Login to share your thoughts!</h4>
        <?php } ?>

        <!-- all comments -->
        <?php
          while ($row = $result->fetch_assoc()) {
        ?>
          <hr>
          <div class="board__card">
            <div class="board__card-info">
              <div class="info-left">
                <div class="info-avatar with-shadow">
                  <span>
                    <?php echo escape($row['username'])[0]?>
                  </span>
                </div>
                <div class="info-text selectable">
                  <p class="info-name">
                    <span class="info-nickname"><?php echo escape($row['nickname']) ?></span>
                    <span class="info-username">(@<a href="setting.php?id=<?php echo escape($row['memberID']) ?>"><?php echo escape($row['username']) ?></a>)</span>
                  </p>
                  <p class="info-time">
                    <span class="info-time"><?php echo escape($row['created_at']) ?></span>
                  </p>
                </div>  
              </div>

              <!-- delete & edit this comment -->
              <?php if ($username) { ?>
                <div class="info-right">
                  <!-- "delete comment" button -->
                  <?php if (
                    $username === $row['username'] ||
                    $auth['delete_all_comments']
                  ) { ?> 
                    <?php if (
                      $auth['delete_self_comments']|| 
                      $auth['delete_all_comments']
                    ) { ?>
                      <form method="POST" action="delete_comment.php">
                        <input type="hidden" name="csrfToken" value="<?php echo $csrfToken ?>">
                        <input type="hidden" name="id" value="<?php echo escape($row['id']) ?>">
                        <input type="hidden" name="username" value="<?php echo escape($row['username']) ?>">
                        <input type="hidden" name="page" value="<?php echo escape($page) ?>">
                        <input class="red-button" type="submit" value="delete">
                      </form>
                    <?php } ?>
                  <?php }?>

                  <!-- "edit comment" button -->
                  <?php if (
                    $username === $row['username'] ||
                    $auth['update_all_comments']
                  ) { ?> 
                    <?php if (
                      $auth['update_self_comments'] || 
                      $auth['update_all_comments']
                    ) { ?>
                      <a href="update_comment.php?id=<?php echo escape($row['id']) ?>">
                        <button class="green-button">Edit</button>
                      </a>
                    <?php } ?>
                  <?php } ?>

                </div>
              <?php } ?>
            </div>
            <p class="board__card-content selectable"><?php echo escape($row['content']); ?></p>
          </div>
        <?php }?>
      </div>
    </section>

    <!-- count comments' number -->
    <?php
      $stmt = $conn->prepare('
        SELECT count(id) AS count FROM YSKuo_comments WHERE is_deleted IS NULL'
      );
      $result = $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $count = $row['count'];
      $total_page = ceil($count / $items_per_page);
    ?>

    <!-- displaying pagination -->
    <div class="paper pagination">
      <p><?php echo escape($count) ?> comments.</p>
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