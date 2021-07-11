<?php
$filename = 'notification.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/notification.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$notification = new notification($db);

$stmt = $notification->readAll();
$num = $stmt->rowCount();
$notifications = [];
echo "Dữ liệu thông báo";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $notification = array(
      "id_noti" => $ID_NOTI,
      "id_question" => $ID_QUESTION,
      "id_answer" => $ID_ANSWER,
      "content" => $CONTENT,
      "created"  => $CREATED
    );
    array_push($notifications, $notification);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_NOTI</th>
      <th>ID_QUESTION</th>
      <th>ID_ANSWER</th>
      <th>CONTENT</th>
      <th>CREATED</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($notifications) && count($notifications) > 0) {
      foreach ($notifications as $notification) { ?>
        <tr>
          <td><?php echo $notification["id_noti"]; ?></td>
          <td><?php echo $notification["id_question"]; ?></td>
          <td><?php echo $notification["id_answer"]; ?></td>
          <td><?php echo $notification["content"]; ?></td>
          <td><?php echo $notification["created"]; ?></td>
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