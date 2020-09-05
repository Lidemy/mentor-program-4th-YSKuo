<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  include_once('template/checkSession.php');
  include_once('template/checkAdmin.php');

  if (!empty($_GET['id'])) {
    $id = $_GET['id'];
  }

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
    <div class="container">
      <div class="edit-post">
        <?php if (!empty($id)) { ?>
          <form action="handle/handle_update_article.php" method="POST">
            <div class="edit-post__title">
              發表文章：
            </div>
            <div class="edit-post__input-wrapper">
              <input name="title" class="edit-post__input" value="<?php echo escape($row['title']) ?>" />
            </div>
            <div class="edit-post__input-wrapper">
              <textarea name="content" rows="20" class="edit-post__content"><?php echo escape($row['content']) ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo escape($id) ?>">
            <input type="hidden" name="page" value="<?php echo $_SERVER['HTTP_REFERER']?>" />
            <div class="edit-post__btn-wrapper">
              <input class="edit-post__btn" type="submit" value="送出">
            </div>
          </form>  
        <?php } else { ?>
          <form action="handle/handle_add_article.php" method="POST">
            <div class="edit-post__title">
              發表文章：
            </div>
            <div class="edit-post__input-wrapper">
              <input name="title" class="edit-post__input" placeholder="請輸入文章標題" />
            </div>
            <div class="edit-post__input-wrapper">
              <textarea name="content" rows="20" class="edit-post__content"></textarea>
            </div>
            <div class="edit-post__btn-wrapper">
              <input class="edit-post__btn" type="submit" value="送出">
            </div>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>