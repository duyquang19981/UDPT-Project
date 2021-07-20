<!DOCTYPE html>
<html lang="en">

<head>
  <title>Questions And Answers</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo _PUBLIC ?>/css/LoginSignup.css">
  <link rel="stylesheet" type="text/css" href="<?php echo _PUBLIC ?>/css/style.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

</head>

<body>
  <?php
  require_once("./app/views/header-footer/header.phtml");
  require_once   "./app/views/" . $data["View"] . ".php";
  require_once("./app/views/header-footer/footer.phtml");
  ?>
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body row" >
        <div id="loader" ></div>
        <div style="margin-left:5%; font-size: 30px;">Loading..........</div> 
      </div>
    </div>
  </div>
</div>
  <!-- Modal make a question -->
  <div class="modal fade" id="makequestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLongTitle" style="color:#000000"><b>Đặt câu hỏi</b></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: center;">
        <form method="get">
        <div class="row">
          <div class="col-md-12" style="text-align: left;">
            <div class="form-group">
              <label for="exampleFormControlTextarea1" style="font-size: 20px;">Câu hỏi</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="exampleFormControlTextarea1" rows="8"></textarea>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleFormControlSelect1" style="font-size: 20px;">Danh mục câu hỏi</label>
                <select class="form-control" id="exampleFormControlSelect1" name="exampleFormControlSelect1">
                  <?php if (isset($data["Categories"]) && count($data["Categories"]) > 0) {
                    foreach ($data["Categories"] as $categorys) {
                      if ($categorys["status"] == 1) {
                  ?>
                        <option value="<?php echo $categorys["category_id"] ?>"><?php echo $categorys["name"] ?></option>
                  <?php
                      }
                    }
                  } ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleFormControlSelect1" style="font-size: 20px;">Gắn tag</label>
                <div></div>
                <input type="text" data-role="tagsinput" placeholder="Add tags" name="tag" id="tag" />
              </div>
            </div>
          </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="createQues1">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body row">
          <div id="loader"></div>
          <div style="margin-left:5%; font-size: 30px;">Loading..........</div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function() {

    $("#createQues1").on("click", function(e) {
      $("#loadMe").modal({
        backdrop: "static", //remove ability to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
      });
      var datas = {
        "category_id": $('#exampleFormControlSelect1').val(),
        "description": $('#exampleFormControlTextarea1').val(),
        "tags": $('#tag').val(),
        "owner_id": "<?php echo $_SESSION["user_id"] ?>",
        "jwt": "<?php echo $_SESSION["jwt"] ?>"
      }
      $.ajax({
        contentType: 'application/json; charset=utf-8',
        type: "POST",
        url: "<?php echo (_API_ROOT . 'question/create.php') ?>",
        dataType: "json",
        success: function(result, status, xhr) {
          $("#loadMe").modal("hide");
          alert("Đăng câu hỏi thành công. Vào Tab Your Question để xem trại thái câu hỏi của bạn.");
          window.location = "<?php echo _WEB_ROOT . "/userProfile/" . $_SESSION['user_id']; ?>";
        },
        error: function(xhr, status, error) {
          if (xhr.status == 401) {
            $("#loadMe").modal("hide");
            alert("Phiên đăng nhập của bạn đã hết. Xin vui lòng đăng nhập lại");
            window.location = "<?php echo _WEB_ROOT . "/login/logout"; ?>";
          } else {
            $("#loadMe").modal("hide");
            alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
          }

        },
        data: JSON.stringify(datas)
      });
    });


  });
</script>
</body>

</html>