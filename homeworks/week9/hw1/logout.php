<?php
  session_start();
  require_once('conn.php');

  // 自製 token
  // $token = $_COOKIE['token'];
  // $sql = sprintf(
  //   "DELETE FROM tokens WHERE token='%s'",
  //   $token
  // );
  // $result = $conn->query($sql);
  // if (!$result) {
  //   die($conn->error);
  // }
  // setcookie("token", '', time() - 3600);

  session_destroy();
  header("Location: index.php");
?>