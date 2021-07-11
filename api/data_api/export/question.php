<?php
$filename = 'question.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/question.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$question = new question($db);

$stmt = $question->readAll();
$num = $stmt->rowCount();
$questions = [];
echo "Dữ liệu câu hỏi";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $question = array(
      "id_question" => $ID_QUESTION,
      "owner_id" => $OWNER_ID,
      "category_id" => $CATEGORY_ID,
      "mod_id" => $MOD_ID,
      "description" => $DESCRIPTION,
      "likes" => $LIKES,
      "created" => $CREATED,
      "accept_day" => $ACCEPT_DAY,
      "status" => $STATUS,
    );
    array_push($questions, $question);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_QUESTION</th>
      <th>OWNER_ID</th>
      <th>CATEGORY_ID</th>
      <th>MOD_ID</th>
      <th>DESCRIPTION</th>
      <th>LIKES</th>
      <th>CREATED</th>
      <th>ACCEPT_DAY</th>
      <th>STATUS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($questions) && count($questions) > 0) {
      foreach ($questions as $question) { ?>
        <tr>
          <td><?php echo $question["id_question"]; ?></td>
          <td><?php echo $question["owner_id"]; ?></td>
          <td><?php echo $question["category_id"]; ?></td>
          <td><?php echo $question["mod_id"]; ?></td>
          <td><?php echo $question["description"]; ?></td>
          <td><?php echo $question["likes"]; ?></td>
          <td><?php echo $question["created"]; ?></td>
          <td><?php echo $question["accept_day"]; ?></td>
          <td><?php echo $question["status"]; ?></td>
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