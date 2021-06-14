<?php
if (isset($_POST['name'])) {
  $name = $_POST['name'];
  $name = $_POST['username'];
  $name = $_POST['password'];
}

?>


<link href="<?php echo _PUBLIC ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link href="<?php echo _PUBLIC ?>/css/sb-admin-2.css" rel="stylesheet">
<script src="<?php echo _PUBLIC ?>/js/function.js"></script>
<div class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"> <img style="width: 500px; height:auto" src="https://img.freepik.com/free-vector/male-businessman-character-sitting-office-workplace-computer-monitor-desk_80328-218.jpg?size=626&ext=jpg" alt="hinh-anh-admin"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Tạo tài khoản Admin</h1>
              </div>

              <?php
              if (isset($data["result"])) {
                echo '<hr/>';
                echo "result ben view" . $data["result"];
                if ($data["result"] == "true") {
                  echo '
                  <div class="alert alert-success" role="alert" style="color: green;">
                    Tạo tài khoản thành công
                  </div>
                  ';
                } else {
                  echo '
                  <div class="alert alert-danger" role="alert" style="color: red;">
                    Tên tài khoản đã tồn tài hoặc không hợp lệ.
                  </div>
                  ';
                }
              };
              ?>
              <form name="createAdminForm" method="POST" onsubmit="validateRegister(); return false;" action="<?php echo _WEB_ROOT ?>/Register/CreateAdmin" class="user">
                <div class="form-group ">
                  <input name="name" type="text" class="form-control form-control-user" required id="exampleFirstName" placeholder="Name">
                </div>
                <div class="form-group">
                  <input id="username" name="username" type="text" required maxlength="16" pattern="^[a-z_-][a-z0-9_-]{5,17}$" title="Username độ dài 6-16 kí tự, được bao gồm _-, không có kí tự đặc biệt, bắt đầu bằng chữ." class="form-control form-control-user" placeholder="Username">
                </div>
                <div class="form-group ">
                  <input name="password" type="password" required maxlength="16" minlength="6" title="Password độ dài 6-16 kí tự." class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                </div>
                <div class="form-group">
                  <div class="g-recaptcha" data-sitekey="6Ld4OSkaAAAAABIpETnPqXff9kketkDAmSUnCKDk"></div>
                </div>
                <button name="submitCreateAdminFormBtn" type="submit" class="btn btn-primary btn-user btn-block">
                  Tạo
                </button>
                <hr>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="/">Về trang chủ</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="<?php echo _PUBLIC ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo _PUBLIC ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="<?php echo _PUBLIC ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="js/sb-admin-2.min.js"></script>

</div>