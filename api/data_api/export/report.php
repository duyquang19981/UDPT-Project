<?php
$filename = 'report.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/report.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$report = new report($db);

$stmt = $report->readAll();
$num = $stmt->rowCount();
$reports = [];
echo "Dữ liệu Báo cáo";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $report = array(
      "id_report" => $ID_REPORT,
      "id_owner" => $ID_OWNER,
      "id_question" => $ID_QUESTION,
      "reason" => $REASON,
      "created" => $CREATED,
    );
    array_push($reports, $report);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_REPORT</th>
      <th>ID_OWNER</th>
      <th>ID_QUESTION</th>
      <th>REASON</th>
      <th>CREATED</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($reports) && count($reports) > 0) {
      foreach ($reports as $report) { ?>
        <tr>
          <td><?php echo $report["id_report"]; ?></td>
          <td><?php echo $report["id_owner"]; ?></td>
          <td><?php echo $report["id_question"]; ?></td>
          <td><?php echo $report["reason"]; ?></td>
          <td><?php echo $report["created"]; ?></td>
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