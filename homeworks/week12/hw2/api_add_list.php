<?php
  require_once('conn.php');

  $sql = '
    INSERT INTO YSKuo_lists() VALUES()
  ';

  $result = $conn->query($sql);
  if (!$result) {
    $json = array(
      "ok" => false,
      "msg" => $conn->error
    );
    $response = json_encode($json);
    echo $response;
    die();
  }

  $list_id = mysqli_insert_id($conn);

  $json = array(
    "ok" => true,
    "list_id" => $list_id
  );

  $response = json_encode($json);
  echo $response;
?>