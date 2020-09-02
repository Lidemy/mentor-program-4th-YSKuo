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
        <li><a href="login.php">Login</a></li>
        <li><a href="index.php">Home</a></li>
      </ul>
    </div>
  </nav>

  <main class="board">
    <section class="wrapper">
      <div class="paper">
        <h3 class="board__title">Register</h3>
        <?php 
          if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
              $msg = 'Please fill in all the fields.';
            } else if ($code === '2') {
              $msg = 'The account already exists.';
            }
            echo '<p class="error">' . $msg . '</p>';
          }
        ?>
        <form class="board__login-form" method="POST" action="handle_register.php" >
          nickname<input type="text" name="nickname"><br>
          username<input type="text" name="username"><br>
          password<input type="password" name="password"><br>
          <input type="submit" value="submit" />
        </form>
      </div>
    </section>
  </main>
</body>
</html>