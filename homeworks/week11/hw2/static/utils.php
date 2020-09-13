<?php

  function getUserFromUsername($username) {
    global $conn;
    $sql = sprintf(
      'SELECT * FROM YSKuo_BlogUsers WHERE username="%s"', 
      $username
    );

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
  }

  function generateToken($tokenLength) {
    $s = '';
    for ($i = 1; $i <= $tokenLength; $i++) {
      $s .= chr(rand(65, 90));
    }
    return $s;
  }

?>