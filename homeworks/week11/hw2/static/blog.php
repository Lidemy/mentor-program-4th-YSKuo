<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php'); 

  include_once('template/checkSession.php');

  if (empty($_GET['id'])) {
    header('Location: index.php');
    die('no article id');
  }

  $id = $_GET['id'];

  $sql = 'SELECT * FROM YSKuo_articles WHERE id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    header('Location index.php');
    die($conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
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
    <div class="posts">
      <article class="post">
        <div class="post__header">
          <div><?php echo escape($row['title']) ?></div>
          <?php if ($username) { ?>
            <div class="post__actions">
              <a class="post__action" href="edit.php?id=<?php echo escape($row['id']) ?>">編輯</a>
            </div>
          <?php } ?>
        </div>
        <div class="post__info">
          created at: <?php echo escape($row['created_at']) ?><br>
          updated at: <?php echo escape($row['updated_at']) ?>
        </div>
        <div class="post__content"><?php echo escape($row['content']) ?>
        </div>
      </article>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>