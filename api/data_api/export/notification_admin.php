<?php
$filename = 'notification_admin.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/notification_admin.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$notification_admin = new notification_admin($db);

$stmt = $notification_admin->readAll();
$num = $stmt->rowCount();
$notification_admins = [];
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $notification_admin = array(
      "id_na" => $ID_NA,
      "noti_id" => $NOTI_ID,
      "admin_id" => $ADMIN_ID,
      "status" => $STATUS,
    );
    array_push($notification_admins, $notification_admin);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_NA</th>
      <th>NOTI_ID</th>
      <th>ADMIN_ID</th>
      <th>STATUS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($notification_admins) && count($notification_admins) > 0) {
      foreach ($notification_admins as $notification_admin) { ?>
        <tr>
          <td><?php echo $notification_admin["id_na"]; ?></td>
          <td><?php echo $notification_admin["noti_id"]; ?></td>
          <td><?php echo $notification_admin["admin_id"]; ?></td>
          <td><?php echo $notification_admin["status"]; ?></td>
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