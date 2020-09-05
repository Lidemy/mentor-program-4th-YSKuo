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
    'SELECT * FROM YSKuo_authorization WHERE is_deleted IS NULL ORDER BY id ASC'
  );
  $result = $stmt->execute();
  if (!$result) {
    die('Error: '. $conn->error);
  }
  $result = $stmt->get_result();

  // get all roles in database
  $roles = array();
  $result2 = $conn->query('SELECT role FROM YSKuo_authorization');
  while ($row = $result2->fetch_assoc()) {
    array_push($roles, $row['role']);
  }

  // get YSKuo_authorization all column name
  $auths = array();
  $sql = 'SELECT * FROM YSKuo_authorization';
  $result3 = $conn->query($sql);
  while ($finfo = $result->fetch_field()) {
    array_push($auths, $finfo->name);
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
        <h3 class="board__title">Role's Authorization</h3>

        <?php 
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = 'The information cannot be empty.';
            } else if ($code === '2') {
              $msg = 'The role already exists.';
            }
            echo '<p class="error">Error: ' . $msg . '</p>';
          }
        ?>

        <!-- creating role -->
        <div class="board__card">
          <div class="board__member-info">
            <h5>Create a new role</h5>
            <form method="POST" action="handle_add_role.php" >
              <div>
                role: <input type="text" name="role">
              </div>
              <?php for ($i=2; $i<7; $i++) { 
                $auth = $auths[$i];
              ?>
                <div>
                  <span><?php echo escape($auth) ?>: </span>
                  <label>
                    <input type="radio" name="<?php echo escape($auth) ?>" value="1" />
                    <span>Yes</span>
                  </label>
                  <label>
                    <input type="radio" name="<?php echo escape($auth) ?>" value="0" checked />
                    <span>No</span>
                  </label>
                </div>
              <?php }?>
              <input type="hidden" name="page" value="<?php echo escape($page) ?>">
              <input type="hidden" name="csrfToken" value="<?php echo $csrfToken ?>">
              <input type="submit" value="submit" />
            </form>
          </div>
        </div>

        <!-- displaying all roles -->
        <?php
          while ($row = $result->fetch_assoc()) {
        ?>
          <hr>
          <div class="board__card">
            <div class="board__member-info">              
              <span>id: </span><?php echo escape($row['id']) ?><br>
              <span>created at: </span><?php echo escape($row['created_at']) ?><br>
              <span>updated at: </span><?php echo escape($row['updated_at']) ?>

              <!-- auth setting -->
              <?php if ($row['role'] !== 'Admin') { ?>
                <form class="" method="POST" action="handle_role_auth.php">
                  <div>
                    <span>role: </span><input type="text" name="role" value="<?php echo escape($row['role']) ?>">
                  </div>
                  <?php for ($i=2; $i<7; $i++) { 
                    $auth = $auths[$i]; 
                  ?>
                    <div>
                      <span><?php echo escape($auth) ?>: </span>
                      <label>
                        <input type="radio" name="<?php echo escape($auth) ?>" value="1"
                          <?php if ($row[$auth]) { ?> checked <?php }?>
                        >
                        <span>Yes</span>
                      </label>
                      <label>
                        <input type="radio" name="<?php echo escape($auth) ?>" value="0"
                          <?php if (!$row[$auth]) { ?> checked <?php }?>
                        >
                        <span>No</span>
                      </label>
                    </div>
                  <?php }?>
                  <input type="hidden" name="id" value="<?php echo escape($row['id']) ?>">
                  <input type="hidden" name="page" value="<?php echo escape($page) ?>">
                  <input type="hidden" name="csrfToken" value="<?php echo $csrfToken ?>">
                  <input type="submit" value="submit" />
                </form>
              <?php } else { ?>
                <br>
                <span>role: </span><?php echo escape($row['role']) ?>
              <?php }?>
            </div>
          </div>
        <?php }?>

      </div>
    </section>

    <!-- count roles' number -->
    <?php
      $stmt = $conn->prepare('
        SELECT count(id) AS count FROM YSKuo_authorization WHERE is_deleted IS NULL'
      );
      $result = $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $count = $row['count'];
      $total_page = ceil($count / $items_per_page);
    ?>
    <div class="paper pagination">
      <p><?php echo escape($count)  ?> roles.</p>
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