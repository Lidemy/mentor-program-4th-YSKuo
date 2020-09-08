<?php
  require_once('conn.php');

  $data = json_decode($_POST['json'], true);

  for ($i=0; $i<count($data); $i++) {
    $todo = $data[$i];
    if (empty($todo['todo_id'])) {
      if ($todo['is_deleted'] == 0) {
        $sql = '
          INSERT INTO YSKuo_todos(list_id, content, is_completed) VALUES (?, ?, ?)
        ';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isi', $todo['list_id'], $todo['content'], $todo['is_completed']);
      }
    } else {
      $sql = '
        UPDATE YSKuo_todos 
        SET list_id=?, content=?, is_completed=?, is_deleted=?
        WHERE todo_id=?';
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('isiii', $todo['list_id'], $todo['content'], $todo['is_completed'], $todo['is_deleted'], $todo['todo_id']);
    }

    $result = $stmt->execute();
    if (!$result) {
      $json = array(
        "ok" => false,
        "msg" => $conn->error
      );
      $response = json_encode($json);
      echo $response;
      die();
    }
  }

  $json = array(
    "ok" => true,
    "todos" => "Todos saved successfully."
  );

  $response = json_encode($json);
  echo $response;
?>