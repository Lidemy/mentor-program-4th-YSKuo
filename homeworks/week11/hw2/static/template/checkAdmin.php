<?php
  if (empty($username)) {
    header('Location: index.php');
    die('not an Admin');
  } 
?>