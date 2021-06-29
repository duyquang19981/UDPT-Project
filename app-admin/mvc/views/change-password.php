<h1>Thay đổi mật khẩu</h1>

<div class="container d-flex justify-content-center">

  <form method="POST" action="<?php echo _WEB_ROOT ?>/Home/SubmitChangePassword">

    <div class="form-group">
      <label for="exampleInputPassword1">Nhập mật khẩu mới</label>
      <input name="id_admin" value="<?php echo Session::get("admin-id") ?>" class="form-control" hidden="true">
      <input name="password" type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <?php
    if (isset($data["res"])) {
      $res = $data["res"];
      if ($res["result"] == "true") { ?>
        <p style="color: green; font-size:18px">Thay đổi mật khẩu thành công</p>
    <?php }
    };
    ?>
    <button name="submitChangePW" type="submit" class="btn btn-primary">Submit</button>
  </form>

</div>