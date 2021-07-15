<?php
$filename = 'answer.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/answer.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$answer = new answer($db);

$stmt = $answer->readAll();
$num = $stmt->rowCount();
$answers = [];
echo "Dữ liệu Câu hỏi";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $answer = array(
      "id_answer" => $ID_ANSWER,
      "id_question" => $ID_QUESTION,
      "id_user" => $ID_USER,
      "mod_id" => $MOD_ID,
      "content" => $CONTENT,
      "created" => $CREATED,
      "accept_day" => $ACCEPT_DAY,
      "status" => $STATUS,
    );
    array_push($answers, $answer);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_ANSWER</th>
      <th>ID_QUESTION</th>
      <th>ID_USER</th>
      <th>MOD_ID</th>
      <th>CONTENT</th>
      <th>CREATED</th>
      <th>ACCEPT_DAY</th>
      <th>STATUS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($answers) && count($answers) > 0) {
      foreach ($answers as $answer) { ?>
        <tr>
          <td><?php echo $answer["id_answer"]; ?></td>
          <td><?php echo $answer["id_question"]; ?></td>
          <td><?php echo $answer["id_user"]; ?></td>
          <td><?php echo $answer["mod_id"]; ?></td>
          <td><?php echo $answer["content"]; ?></td>
          <td><?php echo $answer["created"]; ?></td>
          <td><?php echo $answer["accept_day"]; ?></td>
          <td><?php echo $answer["status"]; ?></td>
        </tr>
      <?php
      }
    } else { ?>
      <td>Không có dữ liệu</td>
    <?php
    }
    ?>
  </tbody>
</table>