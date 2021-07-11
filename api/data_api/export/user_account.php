<?php
$filename = 'user_account.xls';
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/vnd-ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename="' . $filename . '"');
include_once '../../objects/user_account.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

$user_account = new user_account($db);

$stmt = $user_account->readAll();
$num = $stmt->rowCount();
$user_accounts = [];
echo "Dữ liệu người dùng";
if ($num > 0) {
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $user_account = array(
      "id_user" => $ID_USER,
      "name" => $NAME,
      "email" => $EMAIL,
      "birth" => $BIRTH,
      "phone" => $PHONE,
      // "status" => $STATUS,
      "created" => $CREATED
    );
    array_push($user_accounts, $user_account);
  }
}
?>
<table>
  <thead>
    <tr>
      <th>ID_USER</th>
      <th>NAME</th>
      <th>EMAIL</th>
      <th>BIRTH</th>
      <th>PHONE</th>
      <!-- <th>STATUS</th> -->
      <th>CREATED</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($user_accounts) && count($user_accounts) > 0) {
      foreach ($user_accounts as $user_account) { ?>
        <tr>
          <td><?php echo $user_account["id_user"]; ?></td>
          <td><?php echo $user_account["name"]; ?></td>
          <td><?php echo $user_account["email"]; ?></td>
          <td><?php echo $user_account["birth"]; ?></td>
          <td><?php echo $user_account["phone"]; ?></td>
          <td><?php echo $user_account["created"]; ?></td>
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