<?php
  $username = NULL;
  $user = NULL;

  if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = getUserFromUsername($username);
  }
?>