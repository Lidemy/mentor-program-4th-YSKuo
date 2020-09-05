<?php
  require_once('conn.php');

  function generatrToken($tokenLength) {
    $str = '';
    for ($i = 1; $i <= $tokenLength; $i++) {
      $str .= chr(rand(65, 90));
    }
    return $str;
  }

  function getUserFromUsername($username) {
    global $conn;
    $sql = sprintf(
      'SELECT * FROM YSKuo_users WHERE username="%s"',
      $username
    );
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

  function getMemberFromID($id) {
    global $conn;
    $sql = sprintf(
      'SELECT * FROM YSKuo_users WHERE id="%d"',
      $id
    );
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

  function getAuthFromRole($role) {
    global $conn;
    $sql = sprintf(
      'SELECT * FROM YSKuo_authorization WHERE role="%s"',
      $role
    );
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
  }

  function escape($str) {
    return htmlspecialchars($str , ENT_QUOTES, 'utf-8');
  }
?>