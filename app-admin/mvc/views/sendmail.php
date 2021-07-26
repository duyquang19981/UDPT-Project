<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<!-- <script src="<?php echo _PUBLIC ?>/js/admin-crud/admin-crud-sendmail.js"></script> -->




<div class="container-xl">
  <style>
    .dropbtn {
      background-color: #18a6d7ba;
      color: black;
      padding: 16px;
      font-size: 16px;
      border: none;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown:hover .dropbtn {
      background-color: #227fa0ba;
    }
  </style>
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Bảng <b>Email nhận thông báo</b></h2>
          </div>
          <div class="col-sm-6">
            <a href="#addRecord" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Record</span></a>
            <button class="btn btn-info" id="send_mail" ><span>Send mail</span></button>
          </div>
        </div>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Mã</th>
            <th style="width:1px;">Email</th>
            
            
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($data["email"]) && count($data["email"]) > 0) {
            foreach ($data["email"] as $question) { ?>
              <tr>
                <td><?php echo $question["id_email"]; ?></td>
                <td><?php echo $question["email"]; ?></td>
                
                <td>
                  <a href="#deleteRecord" class="deleteButton delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>       
                </td>
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
    </div>
  </div>
</div>
<!-- add Modal HTML -->

<div id="editRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="edit_form" method="POST" action="<?php echo _WEB_ROOT ?>/Question/Accept">
        <div class="modal-header">
          <h4 class="modal-title">Duyệt câu hỏi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Mã</label>
            <input id="edit_input_id" readonly name="id_question" type="text">
            <input id="edit_input_id_mod" style="display:none" value="<?php echo Session::get("admin-id"); ?>" name="mod_id" type="text">

          </div>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input id="saveButton" name="submitAcceptQuestion" type="submit" class="btn btn-info" value="Save">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteRecord" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form name="deleteForm" method="POST" action="<?php echo _WEB_ROOT ?>/Question/Delete">
        <div class="modal-header">
          <h4 class="modal-title">Delete Record</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p class="noti">Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input id="delete_input_id" name="id_question" type="text" style="display: none;">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input id="deleteButton" name="submitDeleteQuestion" type="submit" class="btn btn-danger" value="Delete">
        </div>
      </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  $("#send_mail").on("click", function() {
    $.ajax({
      contentType: 'application/json; charset=utf-8',
      type: "GET",
      url: "<?php echo (_API_ROOT . '/sendmail/mailCheck.php') ?>",
      success: function(result, status, xhr) {
        alert("Gửi mail thành công");
      },
      error: function(xhr, status, error) {
        $("#loadMe").modal("hide");
        alert("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
      },
      
    });
  });
});
</script>