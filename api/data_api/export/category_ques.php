<?php
$filename = 'category_ques.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/category_ques.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$category_ques = new category_ques($db);

$stmt = $category_ques->readAll();
$num = $stmt->rowCount();
$category_quess = [];
echo "Dự liệu Danh mục câu hỏi";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $category_ques = array(
      "category_id" => $CATEGORY_ID,
      "mod_id" => $MOD_ID,
      "name" => $NAME,
      "status" => $STATUS,
      "created" => $CREATED,
    );
    array_push($category_quess, $category_ques);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>CATEGORY_ID</th>
      <th>MOD_ID</th>
      <th>NAME</th>
      <th>STATUS</th>
      <th>CREATED</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($category_quess) && count($category_quess) > 0) {
      foreach ($category_quess as $category_ques) { ?>
        <tr>
          <td><?php echo $category_ques["category_id"]; ?></td>
          <td><?php echo $category_ques["mod_id"]; ?></td>
          <td><?php echo $category_ques["name"]; ?></td>
          <td><?php echo $category_ques["status"]; ?></td>
          <td><?php echo $category_ques["created"]; ?></td>
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