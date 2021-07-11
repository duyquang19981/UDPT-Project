<?php
$filename = 'admin.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/admin.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$admin = new admin($db);

$stmt = $admin->readAll();
$num = $stmt->rowCount();
$admins = [];
echo "Dữ liệu quản trị viên";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $admin = array(
      "id_admin" => $ID_ADMIN,
      "name" => $NAME,
      "username" => $USERNAME,
      "pass" => $PASS,
      "role" => $ROLE,
      "notification_yes" => $NOTIFICATION_YES,
      "status" => $STATUS,
    );
    array_push($admins, $admin);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_ADMIN</th>
      <th>NAME</th>
      <th>USERNAME</th>
      <th>PASS</th>
      <th>ROLE</th>
      <th>NOTIFICATION_YES</th>
      <th>STATUS</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($admins) && count($admins) > 0) {
      foreach ($admins as $admin) { ?>
        <tr>
          <td><?php echo $admin["id_admin"]; ?></td>
          <td><?php echo $admin["name"]; ?></td>
          <td><?php echo $admin["username"]; ?></td>
          <td><?php echo $admin["pass"]; ?></td>
          <td><?php echo $admin["role"]; ?></td>
          <td><?php echo $admin["notification_yes"]; ?></td>
          <td><?php echo $admin["status"]; ?></td>
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