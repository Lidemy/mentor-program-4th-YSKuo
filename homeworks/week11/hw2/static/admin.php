<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $page = 1;
  if (!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $items_per_page = 10;
  $offset = ($page - 1) * $items_per_page;

  include_once('template/checkSession.php');
  include_once('template/checkAdmin.php');
  
  $csrfToken = $_COOKIE['csrfToken'];

  $stmt = $conn->prepare('
    SELECT 
      A.id AS id, A.title AS title, A.content AS content, A.created_at AS created_at, 
      U.username AS username
    FROM YSKuo_articles AS A
    LEFT JOIN YSKuo_BlogUsers AS U ON A.username = U.username
    WHERE A.is_deleted IS NULL
    ORDER BY A.id DESC
    LIMIT ? OFFSET ?
  ');
  $stmt->bind_param('ii', $items_per_page, $offset);
  $result = $stmt->execute();
  if (!$result) {
    die('Error: ' . $conn->error);
  }

  $result = $stmt->get_result();
?>

<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">

  <title>部落格</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="normalize.css" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <?php include_once('template/header.php'); ?>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>存放技術之地</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="container">
      <div class="admin-posts">
        <?php while ($row = $result->fetch_assoc()) { ?>
          <div class="admin-post">
            <div class="admin-post__title">
                <?php echo escape($row['title']) ?>
            </div>
            <div class="admin-post__info">
              <div class="admin-post__created-at">
                <?php echo escape($row['created_at']) ?>
              </div>
              <a class="admin-post__btn" href="edit.php?id=<?php echo escape($row['id']) ?>">
                編輯
              </a>
              <form action="handle/handle_delete_article.php" method="POST">
                <input type="hidden" name="id" value="<?php echo escape($row['id']) ?>" />
                <input type="hidden" name="csrfToken" value="<?php echo escape($csrfToken) ?>" />
                <input class="admin-post__btn" type="submit" value="刪除">
              </form>
        <!--       <a class="admin-post__btn">
                刪除
              </a> -->
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php
      $stmt = $conn->prepare('
        SELECT count(id) AS count FROM YSKuo_articles WHERE is_deleted IS NULL'
      );
      $result = $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $count = $row['count'];
      $total_page = ceil($count / $items_per_page);
    ?>

    <!-- displaying pagination -->
    <div class="pagination">
      <p><?php echo escape($count) ?> articles.</p>
      <?php include_once('template/paginator.php') ?>
    </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>