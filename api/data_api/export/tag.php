<?php
$filename = 'tag.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/tag.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$tag = new tag($db);

$stmt = $tag->readAll();
$num = $stmt->rowCount();
$tags = [];
echo "Dữ liệu tag";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $tag = array(
      "id_tag" => $ID_TAG,
      "mod_id" => $MOD_ID,
      "description" => $DESCRIPTION,
      "status" => $STATUS,
    );
    array_push($tags, $tag);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_TAG</th>
      <th>MOD_ID</th>
      <th>DESCRIPTION</th>
      <th>STATUS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($tags) && count($tags) > 0) {
      foreach ($tags as $tag) { ?>
        <tr>
          <td><?php echo $tag["id_tag"]; ?></td>
          <td><?php echo $tag["mod_id"]; ?></td>
          <td><?php echo $tag["description"]; ?></td>
          <td><?php echo $tag["status"]; ?></td>
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