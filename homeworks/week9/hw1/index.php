<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  $username = NULL;
  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }

  // 自己做 token
  // if (!empty($_COOKIE['token'])) {
  //   $token = $_COOKIE['token'];
  //   $user = getUserFromToken($token);
  //   $username = $user['username'];
  // }

  $result = $conn->query('SELECT * FROM YSKuo_comments ORDER BY created_at desc;');
  if (!$result) {
    die($conn->error);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>留言板</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <div class="warning">
      <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
    </div>
    <nav class="navbar">
      <div class="wrapper">
        <?php if (!$username) { ?>
          <a href="register.php">註冊</a>
          <a href="login.php">登入</a>
        <?php } else { ?>
          <a href="logout.php">登出</a>
        <?php } ?>
      </div>
    </nav>
  </header>
  <main class="board">
    <h1 class="board__title">Comments</h1>
    <?php
      if (!empty($_GET['errCode'])) {
        $code = $_GET['errCode'];
        $msg = 'Error';
        if ($code === '1') {
          $msg = '請填入留言內容';
        }
        echo '<h2 class="error">錯誤：' . $msg . '</h2>';
      }
    ?>
    <?php if (!$username) { ?>
      <h2 class="board__msg">請登入留言</h2>
    <?php } else { ?>
      <form class="board__new-comment-form" method="POST" action="handle_add_comment.php">
        <h3>Hi! <?php echo $username;?>! Make some comments!</h3>
        <textarea name="content" rows="5"></textarea>
        <input class="board__submit-btn" type="submit" />
      </form>
    <?php } ?>
    <div class="board__hr"></div>
    <section>
      <?php while($row = $result->fetch_assoc()) { ?>
        <div class="card">
          <div class="card__avatar"></div>
          <div class="card__text">
            <div class="card__info">
              <span class="card__info-author"><?php echo $row['nickname']; ?></span>
              <span class="card__info-time"><?php echo $row['created_at']; ?></span>
            </div>
            <p class="card__content"><?php echo $row['content']; ?></p>
          </div>
        </div>
      <?php } ?>
      <div class="card">
        <div class="card__avatar"></div>
        <div class="card__text">
          <div class="card__info">
            <span class="card__info-author">Nietzsche</span>
            <span class="card__info-time">0000-00-00 00:00:00</span>
          </div>
          <p class="card__content">Was mich nicht umbringt, macht mich stärker.</p>
        </div>
      </div>
    </section>
  </main>
</body>
</html>