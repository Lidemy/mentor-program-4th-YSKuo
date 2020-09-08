<?php
  require_once('conn.php');

  if (empty($_POST['listId'])) {
    $json = array(
      "ok" => false,
      "msg" => "Please input List ID",
      "errCode" => 1
    );
    $response = json_encode($json);
    echo $response;
    die();
  }

  $list_id = $_POST['listId'];

  $sql = 'SELECT * FROM YSKuo_lists WHERE list_id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $list_id);
  $result = $stmt->execute();
  if (!$result) {
    $json = array(
      "ok" => false,
      "msg" => $conn->error,
      "errCode" => 0
    );
    $response = json_encode($json);
    echo $response;
    die();
  }
  $result = $stmt->get_result();
  $row_cnt = $result->num_rows;

  if ($row_cnt == 0) {
    $json = array(
      "ok" => false,
      "msg" => "list id does not exist in database.",
      "errCode" => 2
    );
    $response = json_encode($json);
    echo $response;
    die();
  }

  $sqlTodos = '
    SELECT todo_id, content, created_at, is_completed
    FROM YSKuo_todos
    WHERE is_deleted=0 AND list_id=?
    ORDER BY todo_id ASC
  ';
  $stmt = $conn->prepare($sqlTodos);
  $stmt->bind_param('i', $list_id);
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

  $result = $stmt->get_result();
  $todos = array();
  while ($row = $result->fetch_assoc()) {
    array_push($todos, array(
      "todo_id" => $row['todo_id'],
      "content" => $row['content'],
      "created_at" => $row['created_at'],
      "is_completed" => $row['is_completed']
    ));
  }

  $json = array(
    "ok" => true,
    "todos" => $todos
  );

  $response = json_encode($json);
  echo $response;
?>