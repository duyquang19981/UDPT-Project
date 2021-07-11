<?php
$filename = 'rating.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/rating.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$rating = new rating($db);

$stmt = $rating->readAll();
$num = $stmt->rowCount();
$ratings = [];
echo "Dữ liệu đánh giá";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $rating = array(
      "id_rating" => $ID_RATING,
      "owner_id" => $OWNER_ID,
      "question_id" => $QUESTION_ID,
      "answer_id" => $ANSWER,
      "star" => $START,
      "created" => $CREATED,
    );
    array_push($ratings, $rating);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_RATING</th>
      <th>OWNER_ID</th>
      <th>QUESTION_ID</th>
      <th>ANSWER</th>
      <th>START</th>
      <th>CREATED</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($ratings) && count($ratings) > 0) {
      foreach ($ratings as $rating) { ?>
        <tr>
          <td><?php echo $rating["id_rating"]; ?></td>
          <td><?php echo $rating["owner_id"]; ?></td>
          <td><?php echo $rating["question_id"]; ?></td>
          <td><?php echo $rating["answer_id"]; ?></td>
          <td><?php echo $rating["star"]; ?></td>
          <td><?php echo $rating["created"]; ?></td>
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