<?php
$filename = 'label.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/label.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$label = new label($db);

$stmt = $label->readAll();
$num = $stmt->rowCount();
$labels = [];
echo "Dữ liệu nhãn";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $label = array(
      "id_label" => $ID_LABEL,
      "mod_id" => $MOD_ID,
      "description" => $DESCRIPTION,
      "status" => $STATUS,
    );
    array_push($labels, $label);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_LABEL</th>
      <th>MOD_ID</th>
      <th>DESCRIPTION</th>
      <th>STATUS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($labels) && count($labels) > 0) {
      foreach ($labels as $label) { ?>
        <tr>
          <td><?php echo $label["id_label"]; ?></td>
          <td><?php echo $label["mod_id"]; ?></td>
          <td><?php echo $label["description"]; ?></td>
          <td><?php echo $label["status"]; ?></td>
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