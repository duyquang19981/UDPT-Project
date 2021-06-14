<div class="bg-gradient">
  <div class="container">

    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
                <img style="width: 500px; height:auto" src="https://img.freepik.com/free-vector/male-businessman-character-sitting-office-workplace-computer-monitor-desk_80328-218.jpg?size=626&ext=jpg" alt="hinh-anh-admin">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class='noti'>

                    <div class="alert alert-danger" role="alert" style="color: red;">
                      ok ok message
                    </div>

                  </div>
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>

                  <form class="user" method="POST" action="/login">
                    <div class="form-group">
                      <input name="username" value="admin" type="text" class="form-control form-control-user" id="exampleInputEmail" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input name="password" value="admin" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                    <hr>

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="/">Về trang chủ</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="/register">Tạo tài khoản</a>
                  </div>
                </div>
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

  <script src="<?php echo _PUBLIC ?>/js/sb-admin-2.min.js"></script>
</div>